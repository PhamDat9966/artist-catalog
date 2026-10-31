<?php
namespace App\Helpers;

use App\Models\CategoryArticleModel as CategoryArticleModel;
use App\Models\ArticleModel as ArticleModel;
use App\Models\MenuModel as MenuModel;
use App\Helpers\URL;
use Illuminate\Http\Request;

use App\Models\SettingModel as SettingModel;
use Illuminate\Support\Facades\App;

class MenuNews{
    public $host = null;
    public $currentUrl = null;

    public $xhtmlMenu = '';
    public $categoryArticleModel = null;
    public $articleMenu = null;
    public $categoryIdArticle = null;
    public $ancestorCategoryIdsArticle = null;

    public $locale = null;

    public function __construct()
    {
        $request = Request::capture();
        $this->host = $request->getHost();
        $this->host = 'http://'.$this->host;
        $prefixNews     = config('zvn.url.prefix_news');
        if($prefixNews != null){
            $this->host = $this->host.'/'.$prefixNews;
        }

        $params = [];
        $this->locale             = App::getLocale();
        $params['locale']   = (isset($this->locale)) ? $this->locale : 'vi';
        $MenuModel      = new MenuModel();

        $this->categoryArticleModel;
        $this->categoryArticleModel  = new CategoryArticleModel();
        $this->categoryArticleModel   = $this->categoryArticleModel->listItems(null,['task'=>'news-list-items-navbar-menu-with-locale']);

        $this->articleMenu;
        $articleModel       = new ArticleModel();
        $this->articleMenu  = $articleModel->listItems(null,['task'=>'news-list-items-navbar-menu']);

        // Lấy giao thức (http hoặc https)
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

        // Lấy tên máy chủ (domain)
        $hostCurrent = $_SERVER['HTTP_HOST'];

        // Lấy đường dẫn (path)
        $path = $_SERVER['REQUEST_URI'];

        // Ghép lại thành URL hoàn chỉnh
        $this->currentUrl = $protocol . $hostCurrent . $path;

        // Cấu hình cho article Category
        $this->categoryIdArticle;
        $this->ancestorCategoryIdsArticle;

        $this->categoryIdArticle           = (isset($categoryId)) ? $categoryId : '';
        $this->ancestorCategoryIdsArticle  = (isset($ancestorCategoryIds)) ? $ancestorCategoryIds :'';
    }

    public function buildMenu($items, $parentId = null, $navLinkClass = null, $locale)
    {
        //dd($items)
        // Sử dụng global để tham chiếu đến biến toàn cục
        $xhtmlMenu              = $this->xhtmlMenu;
        $categoryArticleModel   = $this->categoryArticleModel;
        $articleMenu            = $this->articleMenu;
        $host                   = $this->host;
        $currentUrl             = $this->currentUrl;
        $locale                 = $this->locale;

        // Cấu hình cho article Category
        $categoryIdArticle          = $this->categoryIdArticle;
        $ancestorCategoryIdsArticle = $this->ancestorCategoryIdsArticle;

        foreach ($items as $item) {

            //if ($item['parent_id'] == $parentId) {
                // Kiểm tra xem có con hay không
                $hasChildren     = $this->hasChildren($items, $item['id']);

                $menuUrl = $host .'/'. $locale . $item['url'];
                $homeUrlLocale = '';
                if($item['id'] == 1){
                    $homeUrlLocale = $host . "/$locale";
                }
                // Kiểm tra trạng thái "active"
                //dd($items,'currentUrl: ' . $currentUrl,$host,$locale);
                $classActive = ($currentUrl == $menuUrl || $currentUrl == $homeUrlLocale || $this->hasActiveChild($items, $item['id'], $currentUrl, $locale)) ? 'active' : '';
                $typeOpen        = '';
                $tmpTypeOpen     = config('zvn.template.type_open');
                $typeOpen        = (array_key_exists($item['type_open'], $tmpTypeOpen)) ? $tmpTypeOpen[$item['type_open']] : '';

                if($hasChildren != 1 && $item['container'] == ''){

                    $routeString        = "/$locale". $item['url'];

                    $typeOpen           = $item['type_open'];
                    $first_character    = substr($item['url'] , 0, 1);

                    if($first_character == '/'){
                        $xhtmlMenu     .= sprintf('<li class=""><a class="%s %s" href="'.$host.'%s" target="%s">%s</a></li>',$classActive,$navLinkClass,$routeString,$typeOpen,$item['name']);
                    } else {
                        $xhtmlMenu     .= sprintf('<li %s><a class="%s" href="%s" target="%s">%s</a></li>',$classActive,$navLinkClass,$routeString,$typeOpen,$item['name']);
                    }

                }else
                // Nếu có con, gọi đệ quy để xử lý menu con
                if ($hasChildren == 1) {
                    $navChildLinkClass  = 'nav-link';

                    $xhtmlMenu      .= '<li class="dropdown">
                                            <a class="btn nav-link dropdown-toggle '.$classActive.'" href="#" id="navbarDropdown" role="button"  data-toggle="dropdown" data-delay="2000" aria-haspopup="true" aria-expanded="false">
                                                '.$item['name'].'
                                            </a>';

                    $xhtmlMenu      .=      '<ul class="dropdown-menu dropdown-submenu" role="menu">';
                    $xhtmlMenu      .=      $this->buildMenu($items, $item['id'], $navChildLinkClass,$locale);
                    $xhtmlMenu      .=      '</ul>';

                    $xhtmlMenu      .= '</li>';
                }else

                if($item['container'] != ''){
                    $parentidCurrent = $item['id'];

                        /*Tìm class active bằng việc kiểm tra phần tử con bằng cách gọi đệ quy
                          Nếu con có class active, thì cha sẽ được gắng class active */
                       $classActiveCategoryFather = $this->buildMenuCategory($categoryArticleModel, $ancestorCategoryIdsArticle, $categoryIdArticle,$locale);
                        if (strpos($classActiveCategoryFather, 'active') !== false) {
                            $classActiveCategoryFather = 'active';
                        }else{
                            $classActiveCategoryFather = '';
                        }

                        $xhtmlMenu  .= '<li class="dropdown">
                                            <a class="nav-link dropdown-toggle '.$classActiveCategoryFather.'" href="#" id="navbarDropdown" role="button" data-hover="dropdown" data-toggle="dropdown" data-delay="1000" aria-haspopup="true" aria-expanded="false">
                                                '.$item['name'].'
                                            </a>';


                        /*Nhóm lệnh để kiểm tra $item['container'] == 'category' vì $classActiveCategoryFather và  if($item['container'] == 'category') sử dụng phương thức trùng nhau
                         phải tắt $classActiveCategoryFather = buildMenuCategory($categoryArticleModel, $ancestorCategoryIdsArticle, $categoryIdArticle) đi để tránh bị trả về kết quả nhầm lẫn khi đùng dd()*/
                            // $xhtmlMenu  .= '<li class="dropdown">
                            //                     <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-hover="dropdown" data-toggle="dropdown" data-delay="1000" aria-haspopup="true" aria-expanded="false">
                            //                         '.$item['name'].'
                            //                     </a>';
                        /*End Nhóm lệnh kiểm tra*/
                        if($item['container'] == 'category'){
                            //Đây là danh mục, category.
                            $xhtmlMenu .= $this->buildMenuCategory($categoryArticleModel, $ancestorCategoryIdsArticle , $categoryIdArticle, $locale);
                        }

                        if($item['container'] == 'article'){
                            $xhtmlMenu  .= '<ul class="dropdown-menu dropdown-submenu" role="menu">';
                                foreach ($articleMenu as $keyArticle => $valArticle) {
                                    $articleLink = '';
                                    if($valArticle['slug'] != null){
                                        $articleLink     = $host . '/' . $valArticle['slug'] . '.php';
                                    }else {
                                        $articleLink     = URL::linkArticle($valArticle['id'],$valArticle['name']);
                                    }

                                    $xhtmlMenu      .= '<li><a class="nav-link '.$classActive.'" href="'.$articleLink.'">'.$valArticle['name'].'</a></li>';
                                }
                            $xhtmlMenu  .= '</ul>';
                        }

                    $xhtmlMenu  .= '</li>';
                }

            //}
        }

        return $xhtmlMenu;
    }

    public function hasChildren($items, $parentId)
    {
        foreach ($items as $item) {
            if ($item['parent_id'] == $parentId) {
                return true;
            }
        }
        return false;
    }

    // Hàm kiểm tra xem có con active hay không
    public function hasActiveChild($items, $parentId, $currentUrl, $locale)
    {

        $host = $this->host;
        foreach ($items as $item) {
            if ($item['parent_id'] == $parentId) {
                $menuUrl = $host .'/'. $locale .  $item['slug'] . '.php';
                if ($menuUrl == $currentUrl || hasActiveChildCategory($items, $item['id'], $currentUrl)) {
                    return true;
                }
            }
        }
        return false;
    }

    public function hasActiveChildCategory($items, $parentId, $currentUrl)
    {

        foreach ($items as $item) {
            if ($item['parent_id'] == $parentId) {
                $menuUrl = $this->host .'/'. $this->locale .  $item['slug'] . '.php';
                if ($menuUrl == $currentUrl || hasActiveChildCategory($items, $item['id'], $currentUrl)) {
                    return true;
                }
            }
        }
        return false;
    }

    // Hàm đệ quy build Category ra menu
    public function buildMenuCategory($itemsCategory,$ancestorCategoryIds, $categoryId, $locale)
    {
        $host = $this->host;
        $currentUrl = $this->currentUrl;
        $xhtmlCategory = '<ul class="dropdown-menu dropdown-submenu" role="menu">';
        foreach ($itemsCategory as $keyCategory => $valueCategory) {
            $menuUrl = $host."/$locale/";
            if(!empty($valueCategory['slug'])){
                $menuUrl = $host . "/$locale/" . $valueCategory['slug'] . '.php';
            }
            // Kiểm tra URL của phần tử cha có khớp không
            $classActive = ($currentUrl == $menuUrl) ? 'active' : '';
            // Class active cho trường hợp truy vấn đến article
            if($ancestorCategoryIds != null || $categoryId != null){
                 // Kiểm tra xem danh mục hiện tại có nằm trong danh sách cha của category_id hay không
                $classActive = (in_array($valueCategory['id'], $ancestorCategoryIds) || $valueCategory['id'] == $categoryId) ? 'active' : '';
            }

            // Kiểm tra nếu bất kỳ phần tử con nào có class active
            if ($valueCategory['children'] != null) {
                $childActive = $this->buildMenuCategory($valueCategory['children'], $ancestorCategoryIds, $categoryId, $locale);

                //Hàm strpos sẽ tìm xem, trong phép đệ quy menu con được return dưới dạng xhtml có chuỗi 'active' không
                // Nếu trong xhtml của phần tử con có class active, thì cha sẽ được gán class active
                if (strpos($childActive, 'active') !== false) {
                    $classActive = 'active';
                }

                $xhtmlCategory .= '<li><a class="nav-link ' . $classActive . '" href="' . $menuUrl . '">' . $valueCategory['name'] . '</a>';
                $xhtmlCategory .= $childActive;  // Gắn menu con
                $xhtmlCategory .= '</li>';
            } else {
                $xhtmlCategory .= '<li><a class="nav-link ' . $classActive . '" href="' . $menuUrl . '">' . $valueCategory['name'] . '</a></li>';
            }
        }

        $xhtmlCategory .= '</ul>';
        return $xhtmlCategory;
    }

}
