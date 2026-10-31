<?php
namespace App\Helpers;

use Illuminate\Support\Str;

class  MenuSmartPhoneHelper{
    public static function buildMenuSmartPhone($itemsMenu,$host,$currentUrl,$categoryProductNav,$ancestorCategoryIdsProduct,$categoryIdProduct )
    {
        $xhtmlMenu = '';
        foreach($itemsMenu as $keyM=>$item){
            //dd($item);
            //$id  = $item['id'];
            //dd($item['id']);
            $hasChildren     = self::hasChildren($itemsMenu, number_format($item['id']));

            $menuUrl = $host . $item['url'];
            $homeUrlLocale = '';
            // Kiểm tra trạng thái "active"
            $classActive = ($currentUrl == $menuUrl || $currentUrl == $homeUrlLocale || self::hasActiveChild($itemsMenu, $item['id'], $currentUrl)) ? 'active' : '';

            $typeOpen        = '';
            $tmpTypeOpen     = config('zvn.template.type_open');
            $typeOpen        = (array_key_exists($item['type_open'], $tmpTypeOpen)) ? $tmpTypeOpen[$item['type_open']] : '';

            if($hasChildren != 1 && $item['container'] == ''){

                $routeString        = $item['url'];
                $url                = route('phoneCategory', ['id' => $item['id']]);
                $typeOpen           = $item['type_open'];
                $first_character    = substr($item['url'] , 0, 1);

                // Kiểm tra trạng thái "active"
                $classActive = ($currentUrl == $menuUrl || $currentUrl == $homeUrlLocale || self::hasActiveChild($itemsMenu, $item['id'], $currentUrl)) ? 'active' : '';

                if($first_character == '/'){
                    $xhtmlMenu     .= sprintf('<li class=""><a class="%s my-menu-link" href="'.$host.'%s" target="%s">%s</a></li>',$classActive,$routeString,$typeOpen,$item['name']);
                } else {
                    $xhtmlMenu     .= sprintf('<li><a class="%s my-menu-link" href="%s" target="%s">%s</a></li>',$classActive,$url,$typeOpen,$item['name']);
                }

            }else
            // Nếu có con, gọi đệ quy để xử lý menu con
            if ($hasChildren == 1) {
                $navChildLinkClass  = 'nav-link';

                $xhtmlMenu      .= '<li>
                                        <a class="'.$classActive.'" href="#">
                                            '.$item['name'].'
                                        </a>';

                $xhtmlMenu      .=      '<ul>';
                $xhtmlMenu      .=      self::buildMenuSmartPhone($item, $host, $currentUrl,$categoryProductNav,$ancestorCategoryIdsProduct,$categoryIdProduct);
                $xhtmlMenu      .=      '</ul>';

                $xhtmlMenu      .= '</li>';

            }else

            if($item['container'] != ''){
                $parentidCurrent = $item['id'];

                /*Tìm class active bằng việc kiểm tra phần tử con bằng cách gọi đệ quy
                    Nếu con có class active, thì cha sẽ được gắng class active */
                $classActiveCategoryFather = self::buildMenuCategory($categoryProductNav, $ancestorCategoryIdsProduct, $categoryIdProduct);
                if (strpos($classActiveCategoryFather, 'active') !== false) {
                    $classActiveCategoryFather = 'active';
                }else{
                    $classActiveCategoryFather = '';
                }

                $xhtmlMenu  .= '<li>
                                    <a class="'.$classActiveCategoryFather.'" href="#" id="navbarDropdown">
                                        '.$item['name'].'
                                    </a>';


                /*Nhóm lệnh để kiểm tra $item['container'] == 'category' vì $classActiveCategoryFather và  if($item['container'] == 'category') sử dụng phương thức trùng nhau
                    phải tắt $classActiveCategoryFather = buildMenuCategory($categoryProductNav, $ancestorCategoryIdsArticle, $categoryIdArticle) đi để tránh bị trả về kết quả nhầm lẫn khi đùng dd()*/
                /*End Nhóm lệnh kiểm tra*/
                if($item['container'] == 'category'){
                    //Đây là danh mục, category. Menu đa cấp của product sẽ đổ vào đây.
                    $xhtmlMenu .= self::buildMenuCategory($categoryProductNav, $ancestorCategoryIdsProduct , $categoryIdProduct);
                }

                // if($item['container'] == 'article'){
                //     $xhtmlMenu  .= '<ul class="dropdown-menu dropdown-submenu" role="menu">';
                //         foreach ($articleMenu as $keyArticle => $valArticle) {
                //             $articleLink = '';
                //             if($valArticle['slug'] != null){
                //                 $articleLink     = $host . '/' . $valArticle['slug'] . '.php';
                //             }else {
                //                 $articleLink     = URL::linkArticle($valArticle['id'],$valArticle['name']);
                //             }

                //             $xhtmlMenu      .= '<li><a class="nav-link '.$classActive.'" href="'.$articleLink.'">'.$valArticle['name'].'</a></li>';
                //         }
                //     $xhtmlMenu  .= '</ul>';
                // }

                $xhtmlMenu  .= '</li>';

            }
        }

        return $xhtmlMenu;
    }

    public static function hasChildren($items, $parentId)
    {
        foreach ($items as $item) {
            if ($item['parent_id'] == $parentId) {
                return true;
            }
        }
        return false;
    }

    // Hàm kiểm tra xem có con active hay không
    public static function hasActiveChild($items, $parentId, $currentUrl)
    {
        //dd($items);
        global $host;
        foreach ($items as $item) {
            if ($item['parent_id'] == $parentId) {
                $menuUrl = $host . $item['url'];
                if($item['id'] == 1){
                    $menuUrl = $host ;
                }

                if ($menuUrl == $currentUrl || self::hasActiveChild($items, $item['id'], $currentUrl)) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function hasActiveChildCategory($items, $parentId, $currentUrl)
    {
        // dd($items);
        global $host;
        foreach ($items as $item) {
            if ($item['parent_id'] == $parentId) {
                $menuUrl = $host .'/'.  $item['slug'] . '.php';
                if ($menuUrl == $currentUrl || hasActiveChildCategory($items, $item['id'], $currentUrl)) {
                    return true;
                }
            }
        }
        return false;
    }

    // Hàm đệ quy build Category ra menu
    public static function buildMenuCategory($itemsCategory,$ancestorCategoryIds, $categoryId)
    {
        //dd($itemsCategory);
        global $host;
        global $currentUrl;
        $xhtmlCategory = '<ul class="dropdown-menu dropdown-submenu" role="menu">';
        foreach ($itemsCategory as $keyCategory => $valueCategory) {
            // $menuUrl = $host;
            // if(!empty($valueCategory['slug'])){
            //     $menuUrl = $host . $valueCategory['slug'] . '.php';
            // }
            $menuUrl     = route('phoneCategory',['id'=>$valueCategory['id']]);
            // Kiểm tra URL của phần tử cha có khớp không
            $classActive = ($currentUrl == $menuUrl) ? 'active' : '';
            // Class active cho trường hợp truy vấn đến article
            if($ancestorCategoryIds != null || $categoryId != null){
                 // Kiểm tra xem danh mục hiện tại có nằm trong danh sách cha của category_id hay không
                $classActive = (in_array($valueCategory['id'], $ancestorCategoryIds) || $valueCategory['id'] == $categoryId) ? 'active' : '';
            }

            // Kiểm tra nếu bất kỳ phần tử con nào có class active
            if ($valueCategory['children'] != null) {
                $childActive = self::buildMenuCategory($valueCategory['children'], $ancestorCategoryIds, $categoryId);

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
