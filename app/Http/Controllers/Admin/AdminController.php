<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\CategoryArticleModel;
use Config;
use Illuminate\Support\Facades\Cache;
// use NunoMaduro\Collision\Provider;

class AdminController extends Controller
{
    protected $pathViewController  = '';
    protected $controllerName      = '';
    protected $params              = [];
    protected $model;

    public function __construct()
    {
      $this->params['pagination']['totalItemsPerPage']  = 10;
      // share bien $controllerName cho all view
      View::share('controllerName',$this->controllerName);
    }

    public function index(Request $request)
    {

        $this->params['filter']['status']   = $request->input('filter_status','all'); // $request->input() là do laravel định nghĩa, tương đương với $_GET
        $this->params['search']['field']    = $request->input('search_field','');
        $this->params['search']['value']    = $request->input('search_value','');

        //Params-Article
        $this->params['filter']['category']   = $request->input('filter_category','all');
        $this->params['filter']['type']       = $request->input('filter_type','all');

        //Params-Category
        $this->params['filter']['display']   = $request->input('filter_display','all');
        $this->params['filter']['is_home']   = $request->input('filter_is_home','all');

        //Params date
        $this->params['filter']['created']   = $request->input('filter_created');
        $this->params['filter']['modified']  = $request->input('filter_modified');
        $this->params['filter']['date']      = $request->input('filter_date');

        //Product Attribute Price
        $this->params['filter']['color']      = $request->input('filter_color','all');
        $this->params['filter']['material']   = $request->input('filter_material','all');

        $this->params['filter']['product_id']   = $request->input('filter_product_id','all');

        // Cách lấy request page
        $page = request()->get('page', 1);

        // Đưa vào mảng params
        $this->params['pagination']['current_page'] = $page;

        //Time load
        // Ghi lại thời điểm bắt đầu (trả về kiểu float)
        $start = microtime(true);

        $items              = $this->model->listItems($this->params,['task' => "admin-list-items"]);
        $itemsStatusCount   = $this->model->countItems($this->params,['task' => "admin-count-items-group-by-status"]);

        // Lấy toàn bộ tham số từ URL (bao gồm cả page, search, filter...)
        // Điều này giúp tự động hóa việc tạo Key Cache mà không cần khai báo từng cái
        $params = array_merge($this->params, request()->all());

        //Chuyển khai cache
        // $cacheSuffix    = $this->controllerName . '_' . md5(json_encode($params));
        // $items = Cache::remember('admin_items_' . $cacheSuffix, 3600, function () use ($params) {
        //     return $this->model->listItems($params, ['task' => "admin-list-items"]);
        // });

        // $itemsStatusCount = Cache::remember('admin_count_items_status_' . $cacheSuffix, 3600, function () use ($params) {
        //     return $this->model->countItems($this->params,['task' => "admin-count-items-group-by-status"]);
        // });

        // Tính toán khoảng thời gian đã trôi qua
        $duration = microtime(true) - $start;
        // Làm tròn và hiển thị
        $timeLoad = round($duration, 4) . ' seconds';

        return view($this->pathViewController . 'index',[
             'params'               => $this->params,
             'items'                => $items,
             'itemsStatusCount'     => $itemsStatusCount,
             'timeLoad'             => $timeLoad
        ]);
    }

    // public function form(Request $request)
    // {
    //     $item   = null;
    //     if($request->id !== null){
    //         $params['id']   = $request->id;
    //         $item = $this->model->getItem($params,['task'=>'get-item']);
    //     }

    //     $categoryModel      = new CategoryArticleModel();
    //     $itemsCategory      = $categoryModel->listItems(null,["task"=> "admin-list-items-in-selectbox"]);

    //     return view($this->pathViewController . 'form', [
    //         'item'          =>$item,
    //         'itemsCategory' =>$itemsCategory
    //     ]);
    // }

    public function status(Request $request)
    {
        // Xóa sạch các cache liên quan đến controller này khi có thay đổi dữ liệu
        $this->clearCache();

        $params['currentStatus']    = $request->status;
        $params['id']               = $request->id;
        $status = $request->status == 'active' ? 'inactive' : 'active';

        $returnModified                 = $this->model->saveItem($params,['task' => 'change-status']);

        $userIcon   = config('zvn.template.font_awesome.user');
        $clockIcon  = config('zvn.template.font_awesome.clock');

        $returnModified['modified_by']  = $userIcon.' '.$returnModified['modified_by'];
        $returnModified['modified']     = $clockIcon.' '.$returnModified['modified'];

        //Class của bootstrap và class khi status thay đổi trạng thái sẽ được quyết định tại đây
        $infomationStatus           =   config('zvn.template.status')[$status];
        $infomationStatus['class']  =   'btn btn-round status-ajax '. $infomationStatus['class'];

        $link = route($this->controllerName . '/status',['status'=>$status, 'id'=>$request->id]);

        return response()->json([
            'status'        =>  $infomationStatus,
            'link'          =>  $link,
            'modified'      =>  $returnModified['modified'],
            'modified_by'   =>  $returnModified['modified_by'],
        ]);

    }

    public function type(Request $request) // Ajax
    {
        // Xóa sạch các cache liên quan đến controller này khi có thay đổi dữ liệu
        $this->clearCache();
        $params['currentType']      = $request->type;
        $params['id']               = $request->id;

        $this->model->saveItem($params,['task' => 'change-type']);
        echo "Success";
    }

    public function display(Request $request)
    {
        // Xóa sạch các cache liên quan đến controller này khi có thay đổi dữ liệu
        $this->clearCache();

        $params['id']       = $request->id;
        $params['display']  = $request->display;
        $lastDisplay        = '"Lưới"';
        $currentDisplay     = '"Danh sách"';
        if($params['display'] == 'grid'){
            $lastDisplay = '"Danh sách"';
            $currentDisplay = '"Lưới"';
        }
        $returnModified = $this->model->saveItem($params,['task' => 'change-display']);

        $userIcon   = config('zvn.template.font_awesome.user');
        $clockIcon  = config('zvn.template.font_awesome.clock');

        $returnModified['modified_by']  = $userIcon.' '.$returnModified['modified_by'];
        $returnModified['modified']     = $clockIcon.' '.$returnModified['modified'];

        return response()->json([
            'modified'      =>$returnModified['modified'],
            'modified_by'   =>$returnModified['modified_by'],
        ]);

    }

    public function displayFilter(Request $request)
    {
       $displayFilter   = $request->display;

       echo "<h3 style='color:red'>displayFilter</h3>";

    }

    public function delete(Request $request)
    {
        // Xóa sạch các cache liên quan đến controller này khi có thay đổi dữ liệu
       $this->clearCache();
        $params['id']               = $request->id;
        $this->model->deleteItem($params,['task' => 'delete-item']);
        return redirect()->route($this->controllerName)->with('zvn_notily','Phần tử ID = ' .$params['id'] .' đã được xóa!');
    }

    public function ordering(Request $request){
        // Xóa sạch các cache liên quan đến controller này khi có thay đổi dữ liệu
        $this->clearCache();;

        $params['id']       = $request->id;
        $params['ordering']    = $request->ordering;

        $returnModified = $this->model->saveItem($params,['task' => 'change-ordering']);

        $userIcon   = config('zvn.template.font_awesome.user');
        $clockIcon  = config('zvn.template.font_awesome.clock');

        $returnModified['modified_by']  = $userIcon.' '.$returnModified['modified_by'];
        $returnModified['modified']     = $clockIcon.' '.$returnModified['modified'];

        //trả về là chuỗi json mà Ajax không cần chuyển đổi
        return response()->json([
            'modified'      =>$returnModified['modified'],
            'modified_by'   =>$returnModified['modified_by'],
        ]);
    }

    protected function clearCache() {
        //Tác vụ xoa cache dùng cho cập nhật
        // Cache::flush();
    }

}

