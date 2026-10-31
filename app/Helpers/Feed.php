<?php
namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class Feed{
    public static function read($itemRss){
        $result = [];

        foreach ($itemRss as $value) {
            switch (Feed::checkSourceLink($value['source'], $value['link'])) {
                case 'vnexpress':
                    $data   = Feed::readVNExpress($value['link']);
                    $result = array_merge_recursive($result,$data);
                    break;
                case 'thanhnien':
                    $data   = Feed::readThanhnien($value['link']);
                    $result = array_merge_recursive($result,$data);
                    break;
                case 'tuoitre':
                    $data = Feed::readTuoiTre($value['link']);
                    $result = array_merge_recursive($result,$data);
                    break;
            }

        }

        return $result;
    }

    public static function checkSourceLink($source, $link)
    {
        $sourceFromLink = explode('.', parse_url($link, PHP_URL_HOST))[0];
        $source = ($source == $sourceFromLink) ? $source :'';
        return $source;
    }

    public static function readVNExpress($link){

        try {
            $context = stream_context_create([
                'http' => [
                    'protocol_version' => '1.1',
                    'header' => 'Upgrade: HTTP/1.1'
                ]
            ]);

            $xmlString = file_get_contents($link, false, $context);

            $data = simplexml_load_string($xmlString, 'SimpleXMLElement', LIBXML_NOCDATA);
            $data = json_encode($data);
            $data = json_decode($data, TRUE);
            $data = $data['channel']['item'];

            foreach ($data as $key => $value) {
                unset($data[$key]['guid']);
                $tmp1 = [];
                $tmp2 = [];

                preg_match('/src="([^"]*)"/i',$value['description'], $tmp1);
                $pattern = '.*br>(.*)';
                preg_match('/' .$pattern. '/',$value['description'], $tmp2);

                $data[$key]['description']  = $tmp2[1] ?? $value['description'];
                $data[$key]['thumb']        = $tmp1[1] ?? '';
                $data[$key]['created_by']    = 'VNExpress';
            }
            return $data;
        } catch (\Throwable $th) {
            return [];
        }

    }

    public static function readTuoiTre($link) // name
    {
        try {
            $data = simplexml_load_file($link, "SimpleXMLElement", LIBXML_NOCDATA);
            $data = json_encode($data);
            $data = json_decode($data, TRUE);
            $data = $data['channel']['item'];

            foreach ($data as $key => $value) {
                unset($data[$key]['guid']);
                $tmp1 = [];
                $tmp2 = [];

                preg_match('/src="([^"]*)"/i', $value['description'], $tmp1);
                preg_match('/.*<\/a>(.*)/', $value['description'], $tmp2);

                $data[$key]['description'] = $tmp2[1] ?? $value['description'];
                $data[$key]['thumb'] = $tmp1[1] ?? '';

                $data[$key]['created_by']    = 'Tuổi trẻ';
            }

            return $data;
        } catch (\Throwable $th) {
            return [];
        }
    }

    public static function readThanhnien($link){

        try {
            $context = stream_context_create([
                'http' => [
                    'protocol_version' => '1.1',
                    'header' => 'Upgrade: HTTP/1.1'
                ]
            ]);

            $xmlString = file_get_contents($link, false, $context);

            $data = simplexml_load_string($xmlString, 'SimpleXMLElement', LIBXML_NOCDATA);
            $data = json_encode($data);
            $data = json_decode($data, TRUE);
            $data = $data['channel']['item'];

            foreach ($data as $key => $value) {
                unset($data[$key]['guid']);
                $tmp1 = [];
                $tmp2 = [];

                $pattern = '/<img[^>]*\s*src=["\']([^"\']*)["\']/i';
                preg_match($pattern,$value['description'], $tmp1);

                $tmp2[1] = preg_replace('/<[^>]*>/', '', $value['description']);

                $data[$key]['description']  = $tmp2[1];
                $data[$key]['thumb']        = $tmp1[1] ?? '';

                $data[$key]['created_by']    = 'Thanh niên';
            }

            return $data;
        } catch (\Throwable $th) {
            return [];
        }

    }

    // public static function getGold(){
    //     $link = 'https://sjc.com.vn/xml/tygiavang.xml';
    //     $context = stream_context_create([
    //         'http' => [
    //             'protocol_version' => '1.1',
    //             'header' => 'Upgrade: HTTP/1.1'
    //         ]
    //     ]);

    //     $xmlString = file_get_contents($link, false, $context);

    //     $data = simplexml_load_string($xmlString, 'SimpleXMLElement', LIBXML_NOCDATA);
    //     $data = json_encode($data);
    //     $data = json_decode($data, TRUE);
    //     $data = $data['ratelist']['city'][0]['item']; // Chỉ lấy giá vàng tại tpHCM
    //     $data = array_column($data,'@attributes');
    //     return $data;
    // }

    // public static function getGold()
    // {
    //     $html = file_get_contents('https://sjc.com.vn/');

    //     libxml_use_internal_errors(true);
    //     $dom = new \DOMDocument();
    //     $dom->loadHTML($html);
    //     $xpath = new \DOMXPath($dom);

    //     $rows = $xpath->query("//table[contains(@class, 'sjc-table-show-price')]/tbody/tr");

    //     $location = '';
    //     $data = [];

    //     foreach ($rows as $row) {
    //         $cols = $row->getElementsByTagName('td');
    //         if ($cols->length === 1) {
    //             // Đây là dòng tiêu đề khu vực (colspan="3")
    //             $location = trim($cols[0]->textContent);
    //             $data[$location] = [];
    //         } elseif ($cols->length === 3) {
    //             // Đây là dòng có loại vàng và giá
    //             $type = trim($cols[0]->textContent);
    //             $buy = trim($cols[1]->textContent);
    //             $sell = trim($cols[2]->textContent);
    //             $data[$location][] = [
    //                 'loai_vang' => $type,
    //                 'mua_vao' => $buy,
    //                 'ban_ra' => $sell
    //             ];
    //         }
    //     }
    // }

    public static function getGold()
    {
        $data = [];
        /*
            Lấy giá vàng tại webgia.com với DOMDocument
            -Do việc lấy dữ liệu thông qua dom từ trang  `https://webgia.com/gia-vang/sjc/'`
            Nên cần giải pháp: Thêm giới hạn thời gian bằng microtime(true).
        */
        $start = microtime(true);

        try {
            $html = @file_get_contents('https://webgia.com/gia-vang/sjc/');
            // Kiểm tra thời gian giữa vòng lặp nếu cần
            if ((microtime(true) - $start) > 6) {
                throw new \Exception("Quá thời gian xử lý 6 giây cho việc `file_get_contents` tại địa url.");
            }

            libxml_use_internal_errors(true);
            $dom = new \DOMDocument();
            $dom->loadHTML($html);
            $xpath = new \DOMXPath($dom);
            $rows = $xpath->query('//table[contains(@class, "table")]/tbody/tr');

            $data = [];

            foreach ($rows as $key => $row) {
                $cells = $row->getElementsByTagName('td');
                $values = [];

                foreach ($cells as $cell) {
                    $values[] = trim($cell->textContent);
                }

                if (count($values) == 1) {
                    $data[] = "Khu vực: " . $values[0] . "\n";
                } elseif (count($values) == 3) {
                    $data[$key]['type'] = $values[0];
                    $data[$key]['buy'] = $values[1];
                    $data[$key]['sell'] = $values[2];
                }

            }

            $data = array_slice($data, 0, 5);

        } catch (\Exception $e) {
            // Quá thời gian hoặc lỗi xử lý
            $data = [];
            // Ghi log nếu cần
            \Log::warning("Lỗi lấy DOM Webgia: " . $e->getMessage());
        }

        /* Lấy giá vàng theo API getGoldFromPNJ */
        // $keyMap = [
        //     'buy_nhan_24k' => 'Mua nhẫn 24K',
        //     'sell_nhan_24k' => 'Bán nhẫn 24K',
        //     'buy_nt_24k' => 'Mua nữ trang 24K',
        //     'sell_nt_24k' => 'Bán nữ trang 24K',
        //     'buy_nt_18k' => 'Mua nữ trang 18K',
        //     'sell_nt_18k' => 'Bán nữ trang 18K',
        //     'buy_nt_14k' => 'Mua nữ trang 14K',
        //     'sell_nt_14k' => 'Bán nữ trang 14K',
        //     'buy_nt_10k' => 'Mua nữ trang 10K',
        //     'sell_nt_10k' => 'Bán nữ trang 10K'
        // ];

        $keyMap = config('zvn.getGold.keyMap.pnj');

        $responsePNJ = self::getGoldFromPNJ();

        $dataPNG  = $responsePNJ['results'][0];
        unset($dataPNG['datetime']);

        $grouped = [];
        foreach ($dataPNG as $keyPNJ=>$valuePNG) {
            $base = Str::after($keyPNJ, '_'); // vidu 'nhan_24k'
            $deal = Str::before($keyPNJ, '_');

            $grouped[$base]['type'] = $keyPNJ;

            //Kiểm tra keyPNG có trong keyMap không? Nếu có thì gán tên tiếng việt từ keymap vào.
            if (isset($keyMap[$keyPNJ])) {
                $grouped[$base]['type'] = $keyMap[$keyPNJ];
            }

            // Giá cả sẽ bỏ phần thập phân đi, phần nguyên cách 3 chữ số sẽ thêm 1 dâu "."
            $valuePNG = (int)$valuePNG;
            $valuePNG = number_format($valuePNG, 0, '', '.');

            switch ($deal) {
                case 'buy':
                $grouped[$base]['buy'] = $valuePNG;
                  break;
                case 'sell':
                    $grouped[$base]['sell'] = $valuePNG;
                  break;
            }
        }

        $result = array_merge($data, $grouped);

        //dd('end getgold');
        return $result;
    }

    // public static function getGoldFromSJC()
    // {

    //     $apiKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE3NDc2MjU5ODQsImlhdCI6MTc0NjMyOTk4NCwic2NvcGUiOiJnb2xkIiwicGVybWlzc2lvbiI6MH0.ClcNhDUQMyODLtPbEjMvWEkR1ypz1QieuUt5w7vlxr4';
    //     $ch = curl_init();

    //     curl_setopt($ch, CURLOPT_URL, 'https://api.vnappmob.com/api/v2/gold/sjc');
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //         'Authorization: Bearer ' . $apiKey,
    //         'Accept: application/json'
    //     ]);

    //     $response = curl_exec($ch);
    //     curl_close($ch);

    //     $data = json_decode($response, true);
    //     return $data;
    // }
    public static function createStorageApiKeyGold(){
        $response = Http::get('https://api.vnappmob.com/api/request_api_key?scope=gold');
        if ($response->successful()) {
            // Phân tích JSON, lấy API key từ kết quả
            $dataApiKey = $response->json();
            $apiKey = $dataApiKey['results']; // Chuỗi key, không phải mảng con

            // Lưu API key vào file trong storage/app
            Storage::put('gold_api_key.txt', $apiKey);
            $apiKey = Storage::get('gold_api_key.txt');
        }
        return $apiKey;
    }

    public static function getGoldFromPNJ()
    {
        $apiKey = ''; //Lấy API key từ storage

        if (Storage::exists('gold_api_key.txt')) {
            $apiKey = Storage::get('gold_api_key.txt');
        } else {
            // File chưa tồn tại, xử lý trường hợp này phải tạo gold_api_key trực tiếp từ storage.
            $apiKey = self::createStorageApiKeyGold();
        }

        //Cập nhật key mới thông qua việc tính trên số ngày chia hết cho 5, tức là 5 ngày cập nhật key mới 1 lần.
        if (Carbon::now()->day % 5 === 0) {
            Storage::delete('gold_api_key.txt'); //Xóa key cũ
            $apiKey = self::createStorageApiKeyGold();  //Cập nhật lại key mới
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.vnappmob.com/api/v2/gold/pnj');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,
            'Accept: application/json'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        return $data;
    }


    public static function getCoin(){
        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
        $parameters = [
            'start' => '1',
            'limit' => '10',
            'convert' => 'USD'
        ];

        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: 84b32e46-6c02-4395-8388-f46e78352653'
        ];
        $qs = http_build_query($parameters); // query string encode the parameters
        $request = "{$url}?{$qs}"; // create the request URL


        $curl = curl_init(); // Get cURL resource
        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request,            // set the request URL
            CURLOPT_HTTPHEADER => $headers,     // set the headers
            CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
        $data = json_decode($response,TRUE); // print json decoded response
        $data = $data['data'];
        curl_close($curl); // Close request

        $resulf = [];
        foreach($data as $key=>$value){
            $resulf[$key]['name']           = $value['name'];
            $resulf[$key]['price']          = $value['quote']['USD']['price'];
            $resulf[$key]['percent_change_24h']     = $value['quote']['USD']['percent_change_24h'];
        }

        return $resulf;
    }
}
