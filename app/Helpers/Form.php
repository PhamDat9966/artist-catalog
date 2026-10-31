<?php
namespace App\Helpers;
use Config; // Ở đây nó là một đối tượng

class Form{

    public static function show( $elements ){
        $xhtml   = '';
        foreach( $elements as $element ){
            $xhtml .= self::formGroup($element);
        }
        return $xhtml;
    }

    public static function formGroup( $element , $params = null ){

        $result  = '';
        $type   = (isset($element['type'])) ? $element['type'] : 'input'; // nếu không tồn tại nếu $element không có 'type' thì maực định sẽ được đặt
                                                                          // là 'input'
        switch( $type ){
            case 'btn-submit':
                $result  =sprintf(' <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            %s
                                        </div>
                                    </div>',$element['element']);
                break;
            case 'btn-submit-edit':
                $result  =sprintf(' <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4">
                                            %s
                                        </div>
                                    </div>',$element['element']);
                break;
            case 'input':
                $result  =sprintf('<div class="form-group">
                                        %s
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            %s
                                        </div>
                                    </div>',$element['label'],$element['element']);
                break;
            case 'dropzone':
                $result  =sprintf('<div class="form-group">
                                        %s
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <div class="dropzone" id="mydropzone">
                                             </div>
                                        </div>
                                    </div>',$element['label']);
                break;
            case 'thumb':
                $result  =sprintf('<div class="form-group">
                                        %s
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            %s
                                            <p style="margin-top: 50px;">%s</p>
                                        </div>
                                    </div>',$element['label'],$element['element'],$element['thumb']);
                break;

        }
        return $result;
    }

    public static function showArticleInfo( $elements ){
        $xhtml   = '';
        foreach( $elements as $element ){
            $xhtml .= self::formGroupArticleInfo($element);
        }
        return $xhtml;
    }

    public static function formGroupArticleInfo( $element , $params = null ){

        $result  = '';
        $type   = (isset($element['type'])) ? $element['type'] : 'input'; // nếu không tồn tại nếu $element không có 'type' thì maực định sẽ được đặt
                                                                          // là 'input'
        switch( $type ){
            case 'btn-submit':
                $result  =sprintf(' <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
                                            %s
                                        </div>
                                    </div>',$element['element']);
                break;
            case 'btn-submit-edit':
                $result  =sprintf(' <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4">
                                            %s
                                        </div>
                                    </div>',$element['element']);
                break;
            case 'input':
                $result  =sprintf('<div class="form-group">
                                        %s
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            %s
                                        </div>
                                    </div>',$element['label'],$element['element']);
                break;
            case 'thumb':
                $result  =sprintf('<div class="form-group">
                                        %s
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            %s
                                            <p style="margin-top: 50px;">%s</p>
                                        </div>
                                    </div>',$element['label'],$element['element'],$element['thumb']);
                break;

        }
        return $result;
    }
    //Phương thức loại bỏ dấu tiếng việt
    public static function removeAccents($stringTV) {
        // Danh sách các ký tự có dấu
        $accents = array(
            'à', 'á', 'ạ', 'ả', 'ã', 'â', 'ầ', 'ấ', 'ậ', 'ẩ', 'ẫ', 'ă', 'ằ', 'ắ', 'ặ', 'ẳ', 'ẵ',
            'è', 'é', 'ẹ', 'ẻ', 'ẽ', 'ê', 'ề', 'ế', 'ệ', 'ể', 'ễ',
            'ì', 'í', 'ị', 'ỉ', 'ĩ',
            'ò', 'ó', 'ọ', 'ỏ', 'õ', 'ô', 'ồ', 'ố', 'ộ', 'ổ', 'ỗ', 'ơ', 'ờ', 'ớ', 'ợ', 'ở', 'ỡ',
            'ù', 'ú', 'ụ', 'ủ', 'ũ', 'ư', 'ừ', 'ứ', 'ự', 'ử', 'ữ', // Chú ý chữ 'ữ'
            'ỳ', 'ý', 'ỵ', 'ỷ', 'ỹ',
            'đ' // Chữ 'đ'
        );

        // Danh sách các ký tự không dấu tương ứng
        $noAccents = array(
            'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
            'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
            'i', 'i', 'i', 'i', 'i',
            'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
            'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
            'y', 'y', 'y', 'y', 'y',
            'd' // Thay thế chữ 'đ'
        );

        // Thay thế các ký tự có dấu thành không dấu
        // có vẻ như nó đã hoạt động không tốt ở chữ `ữ` và chữ `đ`
        return str_replace($accents, $noAccents, $stringTV);
    }

    //Phương thức cho trường hợp sử dụng chữ hoa
    function removeAccentsBK($str) {
        // Mảng chứa các ký tự tiếng Việt có dấu
        $accents = array(
            'à', 'á', 'ạ', 'ả', 'ã', 'â', 'ầ', 'ấ', 'ậ', 'ẩ', 'ẫ', 'ă', 'ằ', 'ắ', 'ặ', 'ẳ', 'ẵ',
            'è', 'é', 'ẹ', 'ẻ', 'ẽ', 'ê', 'ề', 'ế', 'ệ', 'ể', 'ễ',
            'ì', 'í', 'ị', 'ỉ', 'ĩ',
            'ò', 'ó', 'ọ', 'ỏ', 'õ', 'ô', 'ồ', 'ố', 'ộ', 'ổ', 'ỗ', 'ơ', 'ờ', 'ớ', 'ợ', 'ở', 'ỡ',
            'ù', 'ú', 'ụ', 'ủ', 'ũ', 'ư', 'ừ', 'ứ', 'ự', 'ử', 'ữ',
            'ỳ', 'ý', 'ỵ', 'ỷ', 'ỹ',
            'đ', 'Đ', // Chữ đ và Đ
            'À', 'Á', 'Ạ', 'Ả', 'Ã', 'Â', 'Ầ', 'Ấ', 'Ậ', 'Ẩ', 'Ẫ', 'Ă', 'Ằ', 'Ắ', 'Ặ', 'Ẳ', 'Ẵ',
            'È', 'É', 'Ẹ', 'Ẻ', 'Ẽ', 'Ê', 'Ề', 'Ế', 'Ệ', 'Ể', 'Ễ',
            'Ì', 'Í', 'Ị', 'Ỉ', 'Ĩ',
            'Ò', 'Ó', 'Ọ', 'Ỏ', 'Õ', 'Ô', 'Ồ', 'Ố', 'Ộ', 'Ổ', 'Ỗ', 'Ơ', 'Ờ', 'Ớ', 'Ợ', 'Ở', 'Ỡ',
            'Ù', 'Ú', 'Ụ', 'Ủ', 'Ũ', 'Ư', 'Ừ', 'Ứ', 'Ự', 'Ử', 'Ữ',
            'Ỳ', 'Ý', 'Ỵ', 'Ỷ', 'Ỹ'
        );

        // Mảng tương ứng với ký tự không dấu
        $noAccents = array(
            'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
            'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
            'i', 'i', 'i', 'i', 'i',
            'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
            'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
            'y', 'y', 'y', 'y', 'y',
            'd', 'D',
            'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A',
            'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E',
            'I', 'I', 'I', 'I', 'I',
            'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O',
            'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U',
            'Y', 'Y', 'Y', 'Y', 'Y'
        );

        return str_replace($accents, $noAccents, $str);
    }

}
