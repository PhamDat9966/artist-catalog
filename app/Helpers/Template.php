<?php
namespace App\Helpers;

use Attribute;
use Carbon\Carbon;
use App\Models\AttributevalueModel;
use DB;
use Illuminate\Support\Facades\App;
class Template{

    public static function showItemHistory($by, $time, $filterValue = null){
        $filterValue = ($filterValue == null) ? $by : $filterValue;
        $pubDate = Carbon::parse($time);
        $pubDate = $pubDate->toDateString();

        $stringtime = date(config('zvn.format.short_time'),strtotime($time));
        if($filterValue == $pubDate ){
            $stringtime = '<span class="highlight">'. $stringtime .'</span>';
        }

        $xhtml  = sprintf('
            <p><i class="fa fa-user"></i> %s</p>
            <p><i class="fa fa-clock-o"></i> %s</p>', $by,$stringtime);
        return  $xhtml;
    }

    public static function showItemHistoryModified($by, $time, $id, $filterValue = null){
        $pubDate = Carbon::parse($time);
        $pubDate = $pubDate->toDateString();

        $stringtime = date(config('zvn.format.short_time'),strtotime($time));

        if($filterValue == $pubDate ){
            $stringtime = '<span class="highlight">'. $stringtime .'</span>';
        }

        $xhtml  = sprintf('
            <p class="modified-by-'.$id.'"><i class="fa fa-user"></i> %s</p>
            <p class="modified-'.$id.'"><i class="fa fa-clock-o"></i> %s</p>', $by,$stringtime);
        return  $xhtml;
    }

    public static function showButtonFilter($controllerName,$itemsStatusCount,$currentFilterStatus,$paramsSearch,$currentParams = null){

        $xhtml          = '';
        $tmplStatus     = config('zvn.template.status');

        if(count($itemsStatusCount) > 0){

            array_unshift($itemsStatusCount,[
                'count' =>array_sum(array_column($itemsStatusCount,'count')),
                'status'=>'all'
            ]);

            foreach($itemsStatusCount as $item){
                $statusValue    = $item['status'];
                $statusValue    =  array_key_exists($statusValue,$tmplStatus) ? $statusValue:'default';

                $currentTemplateStatus  = $tmplStatus[$statusValue];
                   //$value['status'] active inactive block
                $link    = route($controllerName) . "?filter_status=" . $statusValue;

                if($paramsSearch['value'] != ''){
                    $link .= '&search_field='.$paramsSearch['field'] . '&search_value=' . $paramsSearch['value'];
                }

                foreach (['display', 'is_home', 'category', 'type','date'] as $filterKey) {
                    if (isset($currentParams['filter'][$filterKey]) && $currentParams['filter'][$filterKey] != '') {
                        $link .= "&filter_$filterKey=" . $currentParams['filter'][$filterKey];
                    }
                }

                // /*category*/
                // if(isset($currentParams['filter']['display'])){
                //     if($currentParams['filter']['display'] != ''){
                //         $link .= '&filter_display='. $currentParams['filter']['display'];
                //     }
                // }
                // if(isset($currentParams['filter']['is_home'])){
                //     if($currentParams['filter']['is_home'] != ''){
                //         $link .= '&filter_is_home='. $currentParams['filter']['is_home'];
                //     }
                // }

                // /*article*/
                // if(isset($currentParams['filter']['category'])){
                //     if($currentParams['filter']['category'] != ''){
                //         $link .= '&filter_category='. $currentParams['filter']['category'];
                //     }
                // }
                // if(isset($currentParams['filter']['type'])){
                //     if($currentParams['filter']['type'] != ''){
                //         $link .= '&filter_type='. $currentParams['filter']['type'];
                //     }
                // }

                $class   = ($currentFilterStatus == $statusValue) ? 'btn-danger' : 'btn-primary';
                $xhtml  .= sprintf('<a href="%s" type="button" class="btn %s"> %s <span class="badge bg-white">%s</span></a>',
                                    $link,$class,$currentTemplateStatus['name'],$item['count']
                                );
            }
        }

        return $xhtml;
        // <a href="?filter_status=all" type="button"
        //     class="btn btn-primary">
        // All <span class="badge bg-white">4</span>
        // </a>
        // <a href="?filter_status=active"
        //     type="button" class="btn btn-success">
        // Active <span class="badge bg-white">2</span>
        // </a>
        // <a href="?filter_status=inactive"
        //     type="button" class="btn btn-success">
        // Inactive <span class="badge bg-white">2</span>
        // </a>
    }

    public static function showAppointmentButtonFilter($controllerName,$itemsStatusCount,$currentFilterStatus,$paramsSearch,$currentParams = null){

        $xhtml          = '';
        $tmplStatus     = config('zvn.template.statusAppointment');

        if(count($itemsStatusCount) > 0){

            array_unshift($itemsStatusCount,[
                'count' =>array_sum(array_column($itemsStatusCount,'count')),
                'status'=>'all'
            ]);

            foreach($itemsStatusCount as $item){
                $statusValue    = $item['status'];
                $statusValue    =  array_key_exists($statusValue,$tmplStatus) ? $statusValue:'default';

                $currentTemplateStatus  = $tmplStatus[$statusValue];
                   //$value['status'] active inactive block
                $link    = route($controllerName) . "?filter_status=" . $statusValue;

                if($paramsSearch['value'] != ''){
                    $link .= '&search_field='.$paramsSearch['field'] . '&search_value=' . $paramsSearch['value'];
                }

                foreach (['display', 'is_home', 'category', 'type','date'] as $filterKey) {
                    if (isset($currentParams['filter'][$filterKey]) && $currentParams['filter'][$filterKey] != '') {
                        $link .= "&filter_$filterKey=" . $currentParams['filter'][$filterKey];
                    }
                }

                $class   = ($currentFilterStatus == $statusValue) ? 'btn-danger' : 'btn-primary';
                $xhtml  .= sprintf('<a href="%s" type="button" class="btn %s"> %s <span class="badge bg-white">%s</span></a>',
                                    $link,$class,$currentTemplateStatus['name'],$item['count']
                                );
            }
        }

        return $xhtml;
    }

    public static function showAreaSearch($controllerName, $paramsSearch){

        $xhtml              = null;
        $tmplField          = config('zvn.template.search');
        $fieldInController  = config('zvn.config.search');
        $controllerName     = (array_key_exists($controllerName,$fieldInController)) ? $controllerName : 'default';
        $xhtmlField         = null;

        foreach($fieldInController[$controllerName] as $field){ // all id
            $xhtmlField     .= sprintf('<li><a href="#" class="select-field" data-field="%s">%s</a></li>', $field , $tmplField[$field]['name'] );//Thanh <li></li>
        }

        $searchValue    = $paramsSearch['value'];
        $searchFiel     = ($paramsSearch['field'] !=='') ? $paramsSearch['field'] : 'all';

        $xhtml  .= sprintf('
        <div class="input-group">
            <div class="input-group-btn">
                <button type="button"
                        class="btn btn-default dropdown-toggle btn-active-field"
                        data-toggle="dropdown" aria-expanded="false">
                    %s <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                    %s
                </ul>
            </div>
            <input type="text" class="form-control" name="search_value" value="%s">
            <input type="hidden" class="form-control" name="search_field" value="%s">
            <span class="input-group-btn">
            <button id="btn-clear-search" type="button" class="btn btn-success"
                    style="margin-right: 0px">Xóa tìm kiếm</button>
            <button id="btn-search" type="button" class="btn btn-primary">Tìm kiếm</button>
            </span>
        </div>', $tmplField[$searchFiel]['name'] ,$xhtmlField , $paramsSearch['value'] ,$searchFiel);

        return $xhtml;
    }

    public static function showItemStatus($controllerName , $id , $status){
        $tmplStatus     = config('zvn.template.status');

        $statusValue    =  array_key_exists($status,$tmplStatus) ? $status:'default';
        $currentStatus  = $tmplStatus[$statusValue];
        $link           = route($controllerName. '/status',['status'=>$status, 'id'=>$id]);
        $xhtml          = '';
        $xhtml  = sprintf('
            <button id="status-%s" data-url="%s" data-class="%s" class="btn btn-round %s status-ajax">%s</button>',
                        $id ,$link ,$currentStatus['class'] ,$currentStatus['class'], $currentStatus['name']
        );
        return  $xhtml;
    }

    public static function showUserStatus($controllerName , $id , $status,$fieldID){
        $tmplStatus     = config('zvn.template.status');
        $primeID        = config('zvn.config.lock.prime_id');
        $lockFlag       = ($fieldID == $primeID) ? true : false;

        $statusValue    =  array_key_exists($status,$tmplStatus) ? $status:'default';
        $currentStatus  = $tmplStatus[$statusValue];
        $link           = route($controllerName. '/status',['status'=>$status, 'id'=>$id]);
        $xhtml          = '';
        if($lockFlag == false){
            $xhtml  = sprintf('
                <button id="status-%s" data-url="%s" data-class="%s" class="btn btn-round %s status-ajax">%s</button>',
                            $id ,$link ,$currentStatus['class'] ,$currentStatus['class'], $currentStatus['name']
            );
        }else{
            $xhtml  = '<strong style="color:blue">Locked</strong>';
        }
        return  $xhtml;
    }

    public static function showItemStatusAppointment($controllerName , $id , $status){
        // status       class           name
        // active       btn-success     Kich hoat
        // inactive     btn-info        Chua duoc kich hoat

        $tmplStatus     =   config('zvn.template.statusAppointment');

        // $statusValue    =  array_key_exists($statusValue,$tmplStatus) ? $statusValue:'default';
        // $currentTemplateStatus  = $tmplStatus[$statusValue];    //$value['status'] active inactive block

        $statusValue    =  array_key_exists($status,$tmplStatus) ? $status:'default';
        $currentStatus  = $tmplStatus[$statusValue];
        $link           = route($controllerName. '/status',['status'=>$status, 'id'=>$id]);

        $xhtml  = sprintf('
            <button id="status-%s" data-url="%s" data-class="%s" class="btn btn-round %s status-ajax">%s</button>',$id ,$link ,$currentStatus['class'] ,$currentStatus['class'], $currentStatus['name']);
        // $xhtml  = sprintf('
        //     <a href="%s" type="button" class="btn btn-round %s">%s</a>', $link , $currentStatus['class'], $currentStatus['name']);
        return  $xhtml;
    }

    public static function showItemContact($controllerName , $id , $status){
        // status       class           name
        // active       btn-success     Kich hoat
        // inactive     btn-info        Chua duoc kich hoat

        $tmplStatus     =   config('zvn.template.contact');

        // $statusValue    =  array_key_exists($statusValue,$tmplStatus) ? $statusValue:'default';
        // $currentTemplateStatus  = $tmplStatus[$statusValue];    //$value['status'] active inactive block

        $statusValue    =  array_key_exists($status,$tmplStatus) ? $status:'default';
        $currentStatus  = $tmplStatus[$statusValue];
        $link           = route($controllerName. '/status',['status'=>$status, 'id'=>$id]);

        $xhtml  = sprintf('
            <button id="status-%s" data-url="%s" data-class="%s" class="btn btn-round %s status-ajax">%s</button>',$id ,$link ,$currentStatus['class'] ,$currentStatus['class'], $currentStatus['name']);
        return  $xhtml;
    }

    public static function showItemSelect($controllerName , $id , $displayValue , $fieldName){

        $tmplDisplay     = config('zvn.template.' . $fieldName);
        $link            = route($controllerName. '/' .$fieldName ,[$fieldName=>'value_new', 'id'=>$id]);
        $primeUser       = config('zvn.config.lock.prime');
        $lockFlag     = ($displayValue == $primeUser) ? true : false;
        $xhtml = '';
        if($lockFlag == false){
            $xhtml   =sprintf('<select id="select-change-%s" name="select_change_attr_ajax" data-url=%s class="form-control input-sm">',$id,$link);
            foreach($tmplDisplay as $key => $value){
                $xhtmlSelect = '';
                if($key == $displayValue) $xhtmlSelect = 'selected="selected"';
                $xhtml  .=sprintf('<option value="%s" %s>%s</option>', $key , $xhtmlSelect,$value['name']);
            }
            $xhtml  .='</select>';
        }else{
            $primeUser = ucfirst($primeUser);
            $xhtml = '<strong style="color:red">'.$primeUser.'</strong>';
        }

        return  $xhtml;
    }

    public static function showItemSelectNoRole($controllerName , $id , $displayValue , $fieldName){

        $tmplDisplay     = config('zvn.template.' . $fieldName);
        $link            = route($controllerName. '/' .$fieldName ,[$fieldName=>'value_new', 'id'=>$id]);
        $xhtml = '';
        $xhtml   =sprintf('<select id="select-change-%s" name="select_change_attr_ajax" data-url=%s class="form-control input-sm">',$id,$link);
        foreach($tmplDisplay as $key => $value){
            $xhtmlSelect = '';
            if($key == $displayValue) $xhtmlSelect = 'selected="selected"';
            $xhtml  .=sprintf('<option value="%s" %s>%s</option>', $key , $xhtmlSelect,$value['name']);
        }
        $xhtml  .='</select>';

        return  $xhtml;
    }


    public static function showRoleSelect($controllerName , $id ,$fieldName ,$rolesID, $tmpRoleList){

        $link            = route($controllerName. '/' .$fieldName ,[$fieldName=>'value_new', 'id'=>$id]);

        $primeID         = config('zvn.config.lock.prime_id');
        $primeUser       = config('zvn.config.lock.prime_name');
        $lockFlag        = ($rolesID == $primeID) ? true : false;
        $xhtml = '';
        if($lockFlag == false){
            $xhtml   =sprintf('<select id="select-change-%s" name="select_change_attr_ajax" data-url=%s class="form-control input-sm">',$id,$link);
            foreach($tmpRoleList as $key => $value){
                $xhtmlSelect = '';
                if($value['id'] == $rolesID) $xhtmlSelect = 'selected="selected"';
                $roleName = (config('zvn.template.role.'.$value['name'].'.name')) ?  (config('zvn.template.role.'.$value['name'].'.name')): $value['name'];

                $xhtml   .= sprintf('<option value="%s" %s>%s</option>', $value['id'] , $xhtmlSelect,$roleName);
            }
            $xhtml  .='</select>';
        }else{
            $primeUser = ucfirst($primeUser);
            $xhtml     = Template::blueLockText($primeUser);
        }

        return  $xhtml;
    }


    public static function select($fieldName , $idItem ,  $arraySelectList , $idCategory , $field ){
        // $link            = route($controllerName. '/' .$fieldName ,[$fieldName=>'value_new', 'id'=>$id]);
        $link   = $field['data-url'];
        $class  = $field['class'];

        $xhtml   =sprintf('<select id="select-change-%s" name="select_change_attr_ajax" data-url=%s class="%s">',$idItem,$link,$class);
        foreach($arraySelectList as $key => $value){
            $xhtmlSelect = '';
            if($key == $idCategory) $xhtmlSelect = 'selected="selected"';
            $xhtml  .=sprintf('<option value="%s" %s>%s</option>', $key , $xhtmlSelect , $value );
        }
        $xhtml  .='</select>';
        return  $xhtml;
    }

    public static function showItemSelectWithArray($controllerName , $id , $displayValue , $fieldName, $array){

        $tmplDisplay     = $array;
        $link            = route($controllerName. '/' .$fieldName ,[$fieldName=>'value_new', 'id'=>$id]);

        $xhtml   =sprintf('<select id="select-change-%s" name="select_change_attr_ajax" data-url=%s class="form-control input-sm">',$id,$link);
        foreach($tmplDisplay as $key => $value){
            $xhtmlSelect = '';
            if($key == $displayValue) $xhtmlSelect = 'selected="selected"';
            $xhtml  .=sprintf('<option value="%s" %s>%s</option>', $key , $xhtmlSelect,$value);
        }
        $xhtml  .='</select>';
        return  $xhtml;
    }

    public static function showMediaSelectAttributeWithArray($controllerName , $id , $displayValue , $fieldName, $array){
        // dd($controllerName , $id , $displayValue , $fieldName, $array);
        $tmplDisplay     = $array;
        $link            = route($controllerName. '/' .$fieldName ,['attributeId'=>'value_new', 'id'=>$id]);

        $xhtml   =sprintf('<select id="select-change-%s" name="select_change_attr_ajax" data-url=%s class="form-control input-sm">',$id,$link);
        $xhtml  .=  sprintf('<option value="%s">%s</option>', 0,'Ảnh phụ - Không gán thuộc tính màu sắc');
        foreach($tmplDisplay as $key => $value){
            $xhtmlSelect = '';
            if($value['attribute_value_id']  == $displayValue) $xhtmlSelect = 'selected="selected"';
            $xhtml  .=sprintf('<option value="%s" %s>%s</option>', $value['attribute_value_id'] , $xhtmlSelect,$value['attribute_value_name']);
        }
        $xhtml  .='</select>';
        return  $xhtml;
    }


    public static function showItemIsHome($controllerName , $id , $isHomeValue){
        $tmplIsHome             = config('zvn.template.is_home');

        $isHomeValue            = array_key_exists($isHomeValue,$tmplIsHome) ? $isHomeValue:true;
        $currentTemplateIsHome  = $tmplIsHome[$isHomeValue];
        $link                   = route( $controllerName. '/isHome',['isHome'=>$isHomeValue, 'id'=>$id]);
        $xhtml  = sprintf('
            <button id="isHome-%s" data-url="%s" data-class=%s class="btn btn-round %s is-home-ajax">%s</button>',$id ,$link , $currentTemplateIsHome['class'] ,$currentTemplateIsHome['class'], $currentTemplateIsHome['name']);
        return  $xhtml;
    }

    public static function showItemIsNew($controllerName , $id , $isNewValue){
        $tmplIsNew             = config('zvn.template.is_new');

        if($isNewValue != null){
            $isNewValue     = array_key_exists($isNewValue,$tmplIsNew) ? $isNewValue:0;
        } else{
            $isNewValue     = 0;
        }

        $currentTemplateIsNew  = $tmplIsNew[$isNewValue];
        $link                   = route( $controllerName. '/isNew',['isNew'=>$isNewValue, 'id'=>$id]);
        $xhtml  = sprintf('
            <button id="isNew-%s" data-url="%s" data-class=%s class="btn btn-round %s is-new-ajax">%s</button>',$id ,$link , $currentTemplateIsNew['class'] ,$currentTemplateIsNew['class'], $currentTemplateIsNew['name']);
        return  $xhtml;
    }

    public static function showItemIsPhoneCategoryFeature($controllerName , $id , $isPhoneCategoryValue){
        $tmpIsPhoneCategory    = config('zvn.template.is_phone_category_feature');
        //dd($tmpIsPhoneCategory,$isPhoneCategoryValue);
        $isPhoneCategoryValue            = array_key_exists($isPhoneCategoryValue,$tmpIsPhoneCategory) ? $isPhoneCategoryValue:0;
        $currentTemplateIsPhoneCategory  = $tmpIsPhoneCategory[$isPhoneCategoryValue];
        $link                   = route( $controllerName. '/isPhoneCategory',['isPhoneCategory'=>$isPhoneCategoryValue, 'id'=>$id]);
        $xhtml  = sprintf('
            <button id="isPhoneCategory-%s" data-url="%s" data-class=%s class="btn btn-round %s is-phone-category-ajax">%s</button>',$id ,$link , $currentTemplateIsPhoneCategory['class'] ,$currentTemplateIsPhoneCategory['class'], $currentTemplateIsPhoneCategory['name']);
        return  $xhtml;
    }

    public static function showItemOrdering($controllerName , $orderingValue , $id){

        $link   = route( $controllerName. '/ordering',['ordering'=>'value_new', 'id'=>$id]);
        $xhtml  = sprintf('
        <input type="number" class="form-control ordering" id="ordering-%s" data-url="%s" min="1" max="999"  value="%s" style="width: 60px">', $id , $link ,$orderingValue);
        return  $xhtml;
    }

    public static function showItemPrice($controllerName , $priceValue , $id){

        $link   = route( $controllerName. '/price',['price'=>'value_new', 'id'=>$id]);
        $xhtml  = sprintf('
        <input type="number" class="form-control price-product" id="price-%s" data-url="%s" min="1"  value="%s" style="width: 200px">', $id , $link ,$priceValue);
        return  $xhtml;
    }

    public static function showItemQuantity($controllerName , $quantityValue , $id){

        $link   = route( $controllerName. '/cartQuantity',['quantity'=>'value_new', 'id'=>$id]);
        $xhtml  = sprintf('
        <input type="number" class="form-control quantity-cart" id="quantity-%s" data-url="%s" min="1"  value="%s" style="width: 200px">', $id , $link ,$quantityValue);
        return  $xhtml;
    }

    public static function showItemDisplay($controllerName , $id , $displayValue){
        $tmplDisplay    = config('zvn.template.display');

        $link           = route($controllerName. '/display',['display'=>'value_new', 'id'=>$id]);

        $xhtml   =sprintf('<select id="select-change-%s" name="select_change_attr_ajax" data-url=%s class="form-control input-sm">',$id,$link);
        foreach($tmplDisplay as $key => $value){
            $xhtmlSelect = '';
            if($key == $displayValue) $xhtmlSelect = 'selected="selected"';
            $xhtml  .=sprintf('<option value="%s" %s>%s</option>', $key , $xhtmlSelect,$value['name']);
        }
        $xhtml  .='</select>';
        return  $xhtml;
    }

    public static function showItemThumb($controllerName , $thumbName , $thumbAlt){
        //$linkThumb = asset("images/$controllerName/$thumbName");
        $linkThumb = ($thumbName)? asset("images/$controllerName/$thumbName") : '';
        $xhtml  = sprintf('
            <p><img id="thumb-preview" src="%s" alt="%s" class="zvn-thumb" /></p>', $linkThumb , $thumbAlt);
        return  $xhtml;
    }

    public static function showItemAudio($controllerName, $audioName){
        if (empty($audioName)) {
            return '';   // không có file thì không in player
        }

        $linkAudio = asset("audio/$controllerName/" . rawurlencode($audioName));
        return sprintf(
            '<audio controls preload="none"><source src="%s" type="audio/mpeg"></audio>',
            e($linkAudio)
        );
    }



    public static function showProductThumb($controllerName , $thumbName , $thumbAlt){
        //$linkThumb = asset("images/$controllerName/$thumbName");
        $linkThumb = ($thumbName)? asset("images/$controllerName/$thumbName") : '';
        $xhtml  = sprintf('
            <img id="thumb-preview" src="%s" alt="%s" />', $linkThumb , $thumbAlt);
        return  $xhtml;
    }

    public static function showItemMediaList($controllerName , $mediaList){
        $xhtml  = '';
        foreach($mediaList as $media){
            $mediaContent   = json_decode($media['content']);

            $linkMedia      = (!empty($mediaContent->name))
                                    ? asset("images/$controllerName/" . $mediaContent->name)
                                    : '';
            $mediaAlt       = (!empty($content['alt']))
                                    ? asset("images/$controllerName/" . $mediaContent->alt)
                                    : '';
            $xhtml  .= sprintf('
                            <img id="thumb-preview" src="%s" alt="%s" class="zvn-media" style="margin:auto" />', $linkMedia , $mediaAlt);
        }
        return  $xhtml;
    }

    public static function showItemMediaModal($controllerName , $media){
        $xhtml  = '';
        $mediaContent   = json_decode($media['content']);

        $linkMedia      = (!empty($mediaContent->name))
                                ? asset("images/$controllerName/" . $mediaContent->name)
                                : '';
        $mediaAlt       = (!empty($content['alt']))
                                ? asset("images/$controllerName/" . $mediaContent->alt)
                                : '';
        $xhtml  .= sprintf('
                        <img id="thumb-preview" src="%s" alt="%s" data-full="%s" class="zvn-media-100 product-thumb" style="margin:auto" />', $linkMedia , $mediaAlt, $linkMedia);
        return  $xhtml;
    }

    public static function showAvatar($thumbName , $thumbAlt){

        $xhtml  = sprintf('
                <img src="%s" alt="%s" class="zvn-thumb" />', asset("images/user/$thumbName"), $thumbAlt);
        return  $xhtml;
    }
    public static function showAvatarSmartPhone($thumbName , $thumbAlt){

        $xhtml  = sprintf('
                <img src="%s" alt="%s" class="zvn-thumb" width="35" height="35" />', asset("images/user/$thumbName"), $thumbAlt);
        return  $xhtml;
    }

    public static function showSliderSmartPhone($controllerName , $thumbName , $thumbAlt){
        //$linkThumb = asset("images/$controllerName/$thumbName");
        $linkThumb = ($thumbName)? asset("images/$controllerName/$thumbName") : '';
        $xhtml  = sprintf('
            <img src="%s" alt="%s" class="bg-img blur-up lazyload">', $linkThumb , $thumbAlt);
        return  $xhtml;
    }


    public static function showButtonAction($controllerName, $id){
        $tmplButton     = config('zvn.template.button');
        $buttonInArea   = config('zvn.config.button');

        $controllerName = (array_key_exists($controllerName, $buttonInArea)) ? $controllerName : 'default';
        $listButtons    = $buttonInArea[$controllerName];

        $xhtml   ='<div class="zvn-box-btn-filter">';
        foreach($listButtons as $btn){
            $currentButton  = $tmplButton[$btn];
            $link           = route($controllerName . $currentButton['route-name'], ['id'=>$id]);

            $xhtml         .= sprintf('<a href="%s" type="button" class="btn btn-icon %s" data-toggle="tooltip" data-placement="top" data-original-title="%s">
                                        <i class="fa %s"></i>
                                </a>',$link, $currentButton['class'],$currentButton['title'],$currentButton['icon']);
        }
        $xhtml  .='</div>';
        return  $xhtml;
    }
    public static function showButtonUserAction($controllerName, $id, $rolesID){
        $tmplButton     = config('zvn.template.button');
        $buttonInArea   = config('zvn.config.button');

        $controllerName = (array_key_exists($controllerName, $buttonInArea)) ? $controllerName : 'default';
        $listButtons    = $buttonInArea[$controllerName];

        $primeID = config('zvn.config.lock.prime_id');
        $xhtml   = '<div class="zvn-box-btn-filter">';
        if($rolesID != $primeID){
            foreach($listButtons as $btn){
                $currentButton  = $tmplButton[$btn];
                $link           = route($controllerName . $currentButton['route-name'], ['id'=>$id]);

                $xhtml         .= sprintf('<a href="%s" type="button" class="btn btn-icon %s" data-toggle="tooltip" data-placement="top" data-original-title="%s">
                                            <i class="fa %s"></i>
                                    </a>',$link, $currentButton['class'],$currentButton['title'],$currentButton['icon']);
            }

        }else{
            $xhtml .= Template::blueLockText('Locked');
        }
        $xhtml  .='</div>';

        return  $xhtml;
    }

    public static function showButtonActionRoleHasPermission($controllerName, $roleID, $permissionID){
        $tmplButton     = config('zvn.template.button');
        $buttonInArea   = config('zvn.config.button');

        $controllerName = (array_key_exists($controllerName, $buttonInArea)) ? $controllerName : 'default';
        $listButtons    = $buttonInArea[$controllerName];

        $xhtml   ='<div class="zvn-box-btn-filter">';
        foreach($listButtons as $btn){
            $currentButton  = $tmplButton[$btn];
            $link           = route($controllerName . $currentButton['route-name'], ['roleID'=>$roleID,'permissionID'=>$permissionID]);

            $xhtml         .= sprintf('<a href="%s" type="button" class="btn btn-icon %s" data-toggle="tooltip" data-placement="top" data-original-title="%s">
                                        <i class="fa %s"></i>
                                </a>',$link, $currentButton['class'],$currentButton['title'],$currentButton['icon']);
        }
        $xhtml  .='</div>';
        return  $xhtml;
    }

    public static function showButtonActionModelHasPermission($controllerName, $modelID, $permissionID){
        $tmplButton     = config('zvn.template.button');
        $buttonInArea   = config('zvn.config.button');
        $controllerName = (array_key_exists($controllerName, $buttonInArea)) ? $controllerName : 'default';
        $listButtons    = $buttonInArea[$controllerName];

        $xhtml   ='<div class="zvn-box-btn-filter">';
        foreach($listButtons as $btn){
            $currentButton  = $tmplButton[$btn];
            $link           = route($controllerName . $currentButton['route-name'], ['modelID'=>$modelID,'permissionID'=>$permissionID]);

            $xhtml         .= sprintf('<a href="%s" type="button" class="btn btn-icon %s" data-toggle="tooltip" data-placement="top" data-original-title="%s">
                                        <i class="fa %s"></i>
                                </a>',$link, $currentButton['class'],$currentButton['title'],$currentButton['icon']);
        }
        $xhtml  .='</div>';
        return  $xhtml;
    }
    public static function showButtonActionProductAttributePrice($controllerName, $product_id, $color_id, $material_id){
        $tmplButton     = config('zvn.template.button');
        $buttonInArea   = config('zvn.config.button');

        $controllerName = (array_key_exists($controllerName, $buttonInArea)) ? $controllerName : 'default';
        $listButtons    = $buttonInArea[$controllerName];

        $xhtml   ='<div class="zvn-box-btn-filter"><i class="fa %s"></i>';

        // foreach($listButtons as $btn){
        //     $currentButton  = $tmplButton[$btn];
        //     $link           = route($controllerName . $currentButton['route-name'], ['product_id'=>$product_id,'color_id'=>$color_id,'material_id'=>$material_id]);

        //     $xhtml         .= sprintf('<a href="%s" type="button" class="btn btn-icon %s" data-toggle="tooltip" data-placement="top" data-original-title="%s">
        //                                 <i class="fa %s"></i>
        //                         </a>',$link, $currentButton['class'],$currentButton['title'],$currentButton['icon']);
        // }
        $xhtml  .='</div>';
        return  $xhtml;
    }
    public static function showButtonActionProductHasAttribute($controllerName, $product_id, $attribute_value_id){
        $tmplButton     = config('zvn.template.button');
        $buttonInArea   = config('zvn.config.button');

        $controllerName = (array_key_exists($controllerName, $buttonInArea)) ? $controllerName : 'default';
        $listButtons    = $buttonInArea[$controllerName];

        $xhtml   ='<div class="zvn-box-btn-filter">';
        foreach($listButtons as $btn){
            $currentButton  = $tmplButton[$btn];
            $link           = route($controllerName . $currentButton['route-name'], ['product_id'=>$product_id,'attribute_value_id'=>$attribute_value_id]);

            $xhtml         .= sprintf('<a href="%s" type="button" class="btn btn-icon %s" data-toggle="tooltip" data-placement="top" data-original-title="%s">
                                        <i class="fa %s"></i>
                                </a>',$link, $currentButton['class'],$currentButton['title'],$currentButton['icon']);
        }
        $xhtml  .='</div>';
        return  $xhtml;
    }

    public static function showButtonActionMedia($controllerName, $id,$fileName){
        $tmplButton     = config('zvn.template.button');
        $buttonInArea   = config('zvn.config.button');

        $controllerName = (array_key_exists($controllerName, $buttonInArea)) ? $controllerName : 'default';
        $listButtons    = $buttonInArea[$controllerName];

        $xhtml   ='<div class="zvn-box-btn-filter">';
        foreach($listButtons as $btn){
            $currentButton  = $tmplButton[$btn];
            $link           = route($controllerName . $currentButton['route-name'], ['file_name'=>$fileName,'id'=>$id]);

            $xhtml         .= sprintf('<a href="%s" type="button" class="btn btn-icon %s" data-toggle="tooltip" data-placement="top" data-original-title="%s">
                                        <i class="fa %s"></i>
                                </a>',$link, $currentButton['class'],$currentButton['title'],$currentButton['icon']);
        }
        $xhtml  .='</div>';
        return  $xhtml;
    }
    /* Filter Selectbox */
    public static function showItemDisplayFilter($controllerName , $displayFilterValue = null){
        $tmplDisplay    = config('zvn.template.display_filter');

        // $link           = route($controllerName. '/displayFilter',['display'=>$isHomeFilterValue]);
        $link           = route($controllerName);

        $xhtml   =sprintf('<select name="select_change_display_filter" data-url=%s class="form-control input-sm">',$link);
        foreach($tmplDisplay as $key => $value){
            $xhtmlSelect = '';
            if($key == $displayFilterValue) $xhtmlSelect = 'selected="selected"';
            $xhtml  .=sprintf('<option value="%s" %s>%s</option>', $key , $xhtmlSelect,$value['name']);
        }
        $xhtml  .='</select>';
        return  $xhtml;
    }

    public static function showItemIsHomeFilter($controllerName , $isHomeFilterValue){
        $tmplDisplay    = config('zvn.template.is_home_filter');

        // $link           = route($controllerName. '/displayFilter',['display'=>$isHomeFilterValue]);
        $link           = route($controllerName);

        $xhtml   =sprintf('<select name="select_change_is_home_filter" data-url=%s class="form-control input-sm">',$link);
        foreach($tmplDisplay as $key => $value){
            $xhtmlSelect = '';
            if(strval($key) == strval($isHomeFilterValue)) $xhtmlSelect = 'selected="selected"';
            $xhtml  .=sprintf('<option value="%s" %s>%s</option>', $key , $xhtmlSelect,$value['name']);
        }
        $xhtml  .='</select>';
        return  $xhtml;
    }

    public static function showItemTypeFilter($controllerName , $typeFilterValue){
        $tmplDisplay    = config('zvn.template.type_filter');

        // $link           = route($controllerName. '/displayFilter',['display'=>$isHomeFilterValue]);
        $link           = route($controllerName);

        $xhtml   =sprintf('<select name="select_change_type_filter" data-url=%s class="form-control input-sm">',$link);
        foreach($tmplDisplay as $key => $value){
            $xhtmlSelect = '';
            if(strval($key) == strval($typeFilterValue)) $xhtmlSelect = 'selected="selected"';
            $xhtml  .=sprintf('<option value="%s" %s>%s</option>', $key , $xhtmlSelect,$value['name']);
        }
        $xhtml  .='</select>';
        return  $xhtml;
    }

    public static function showItemTypeCouponFilter($controllerName , $typeFilterValue){
        $tmplDisplay    = config('zvn.template.type_coupon_filter');

        // $link           = route($controllerName. '/displayFilter',['display'=>$isHomeFilterValue]);
        $link           = route($controllerName);

        $xhtml   =sprintf('<select name="select_change_type_filter" data-url=%s class="form-control input-sm">',$link);
        foreach($tmplDisplay as $key => $value){
            $xhtmlSelect = '';
            if(strval($key) == strval($typeFilterValue)) $xhtmlSelect = 'selected="selected"';
            $xhtml  .=sprintf('<option value="%s" %s>%s</option>', $key , $xhtmlSelect,$value['name']);
        }
        $xhtml  .='</select>';
        return  $xhtml;
    }

    // public static function showItemCategoryFilter($controllerName , $categoryFilterValue = null, $categoryList = null){
    //     $tmplCategory   = $categoryList;
    //     $link           = route($controllerName);

    //     $xhtml   =sprintf('<select name="select_change_is_category_filter" data-url=%s class="form-control input-sm">',$link);
    //     foreach($tmplCategory as $key => $value){
    //         $xhtmlSelect = '';
    //         if(strval($value['id']) == strval($categoryFilterValue)) $xhtmlSelect = 'selected="selected"';
    //         $xhtml  .=sprintf('<option value="%s" %s>%s</option>', $value['id'] , $xhtmlSelect , $value['name']);
    //     }
    //     $xhtml  .='</select>';
    //     return  $xhtml;
    // }

    public static function showItemCategoryFilter($controllerName , $categoryFilterValue = null, $categoryList = null){
        $tmplCategory   = $categoryList;
        $link           = route($controllerName);
        $xhtml   =sprintf('<select name="select_change_is_category_filter" data-url=%s class="form-control input-sm">',$link);
        foreach($tmplCategory as $key => $value){
            $xhtmlSelect = '';
            if(strval($key) == strval($categoryFilterValue)) $xhtmlSelect = 'selected="selected"';
            $xhtml  .=sprintf('<option value="%s" %s>%s</option>', $key , $xhtmlSelect , $value);
        }
        $xhtml  .='</select>';
        return  $xhtml;
    }

    public static function showItemSexFilter($controllerName , $typeFilterValue){
        $tmplDisplay    = config('zvn.template.type_sex');

        // $link           = route($controllerName. '/displayFilter',['display'=>$isHomeFilterValue]);
        $link           = route($controllerName);

        $xhtml   =sprintf('<select name="select_change_sex_filter" data-url=%s class="form-control input-sm">',$link);
        foreach($tmplDisplay as $key => $value){
            $xhtmlSelect = '';
            if(strval($key) == strval($typeFilterValue)) $xhtmlSelect = 'selected="selected"';
            $xhtml  .=sprintf('<option value="%s" %s>%s</option>', $key , $xhtmlSelect,$value['name']);
        }
        $xhtml  .='</select>';
        return  $xhtml;
    }

    public static function showItemFilterSimpleFrontend($filterValue, $firstElement){
        // $firstElement có value là rỗng trong select box, nó sẽ ko tham gia vào quá trình gửi dữ liệu với $_GET hoặc $_POST
        $tmpList = __('zvn.template.'.$filterValue);
        $xhtml       ='<select class="form-control" name="'.$filterValue.'">';
        $xhtml      .=   '<option selected value="">'.$firstElement.'</option>';
        foreach ($tmpList as $key=>$value) {
                $xhtml  .=    '<option value="'.$key.'">'.$value.'</option>';
        }
        $xhtml      .= '</select>';
        return $xhtml;
    }

    public static function showItemFilterSimpleFrontendWithArray($arrayList, $filterName ,$firstElement){

        $xhtml        ='<select class="form-control" name="'.$filterName.'">';
        $xhtml       .=   '<option selected value="">'.$firstElement.'</option>';
        foreach ($arrayList as $value) {
            $xhtml   .=    '<option value="'.$value['id'].'">'.$value['address'].'</option>';
        }
        $xhtml       .= '</select>';

        return $xhtml;
    }

    public static function showBranchGoogleMapSelect($controllerName,$arrayList, $name, $itemGooglemap,$locale){

        $link         = route($controllerName, ['locale' => $locale]);
        $xhtml        = sprintf('<select name=%s data-url=%s class="form-control">',$name,$link);

        foreach ($arrayList as $value) {
            if(isset($itemGooglemap) && !empty($itemGooglemap) && ($value['id'] == $itemGooglemap['id'])){
                $xhtml       .=   '<option selected value="">'.$itemGooglemap['address'].'</option>';
            }else{
                $xhtml   .=    '<option value="'.$value['id'].'">'.$value['address'].'</option>';
            }
        }
        $xhtml       .= '</select>';

        return $xhtml;
    }

    public static function showDataFrontEnd($datatime){
        return date_format(date_create($datatime), config('zvn.format.short_time'));
    }

    public static function showContent($content,$lenght,$prefix = '...'){
        $content = str_replace(['<p>','</p>'], '', $content);
        return preg_replace('/\s+?(\S+)?$/','', substr($content,0, $lenght)).$prefix;
    }

    public static function showCreatedFilter($creadedFilter){
        $xhtml  =  '<div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Created: </span>
                        <input type="text" id="datepicker" name="created" class="form-control" placeholder="Choose a date" value="'.$creadedFilter.'">
                    </div>';
        return $xhtml;
    }

    public static function showModifiedFilter($modifiedFilter){
        $xhtml  =  '<div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Modified: </span>
                        <input type="text" class="datepicker" name="modified" class="form-control" placeholder="Choose a date" value="'.$modifiedFilter.'">
                    </div>';
        return $xhtml;
    }

    public static function showTimeMeet($timeMeetFilter){
        $xhtml  =  '<div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">TimeMeet: </span>
                        <input type="text" id="datepicker" name="timeMeet" class="form-control" placeholder="Choose a date" value="'.$timeMeetFilter.'">
                    </div>';
        return $xhtml;
    }

    public static function showDateFilter($dateFilter){
        $xhtml = '<div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Lọc theo ngày-tháng-năm: </span>
                    <input type="text" id="datepicker" name="date" class="form-control" placeholder="Choose a date" value="'.$dateFilter.'">
                 </div>';
       return $xhtml;
    }

    public static function showNestedSetName($name,$level){
        $xhtml  = str_repeat('|------ ',$level - 1);
        $xhtml .= sprintf('<span class="badge badge-dange p-1">%s</span><strong>%s</strong>',$level,$name);
        return $xhtml;
    }

    public static function showNestedSetUpDown($controllerName,$id){
        $upButton   = sprintf(
        '<a href="%s" type="button" class="btn btn-primary mb-0" data-toggle="tooltip" title="" data-original-title="Up">
                    <i class="fa fa-long-arrow-up"></i>
                </a>', route("$controllerName/move",['id' => $id, 'type' => 'up']));

        $downButton = sprintf(
        '<a href="%s" type="button" class="btn btn-primary mb-0" data-toggle="tooltip" title="" data-original-title="Down">
                    <i class="fa fa-long-arrow-down"></i>
                </a>', route("$controllerName/move",['id' => $id, 'type' => 'down']));

        $module = 'App\\Models\\' . ucfirst($controllerName) . 'Model';
        $node   = $module::find($id);
        /* việc sử dụng biến động để gọi tên một model như $module::find($id) không trực tiếp tìm được model vì PHP không tự động nhận diện
        nó là một class hợp lệ, cần xây dựng đầy đủ tên không gian tên (namespace) của model*/

        if(empty($node->getPrevSibling()) || empty($node->getPrevSibling()->parent_id)) $upButton = '';
        if(empty($node->getNextSibling())) $downButton = '';

        $xhtml = '
        <span style="width:36px,display:inline-block">'.$upButton.'</span>
        <span style="width:36px,display:inline-block">'.$downButton.'</span>
        ';

        return $xhtml;
    }

    public static function showItemColorFilter($controllerName , $typeFilterValue, $colorList){
        $tmplDisplay    = $colorList;
        $firstElement   = [
                            'id'    =>'all',
                            'name'  =>'Tất cả màu',
                            'color' =>''
                          ];
        array_unshift($tmplDisplay , $firstElement);
        $link           = route($controllerName);

        $xhtml   =sprintf('<select name="select_change_color_filter" data-url=%s class="form-control input-sm">',$link);
        foreach($tmplDisplay as $key => $value){
            $xhtmlSelect = '';
            if(strval($value['id']) == strval($typeFilterValue)) $xhtmlSelect = 'selected="selected"';
            $xhtml  .=sprintf('<option value="%s" %s>%s</option>', $value['id'] , $xhtmlSelect,$value['name']);
        }
        $xhtml  .='</select>';
        return  $xhtml;
    }

    public static function showItemMaterialFilter($controllerName , $typeFilterValue, $materialList){
        $tmplDisplay    = $materialList;
        $firstElement   = [
                            'id'    =>'all',
                            'name'  =>'Tất cả dung lượng',
                          ];
        array_unshift($tmplDisplay , $firstElement);
        $link           = route($controllerName);

        $xhtml   =sprintf('<select name="select_change_material_filter" data-url=%s class="form-control input-sm">',$link);
        foreach($tmplDisplay as $key => $value){
            $xhtmlSelect = '';
            if(strval($value['id']) == strval($typeFilterValue)) $xhtmlSelect = 'selected="selected"';
            $xhtml  .=sprintf('<option value="%s" %s>%s</option>', $value['id'] , $xhtmlSelect,$value['name']);
        }
        $xhtml  .='</select>';
        return  $xhtml;
    }

    public static function showCheckBoxWrapper8($controllerName,$val,$id){

        $flagDefault            = '';
        if($val['default'] == null || $val['default'] == 0){
            $val['default'] = 0; //Đặt lại giá trị cho tình huống null
        }else{
            $flagDefault    = 'checked';
        }

        $urlDefault = route($controllerName) . '/default';
        /*
            checkbox-wrapper-8
            -Thẻ <label....> chính là "khung nhìn của button on off": với for="$id" nó sẽ target đến input có id bằng với giá trị for là $id để thay đổi checked
        */
        $xhtml  = '';
        $xhtml .= '<div style="position: relative;margin:5px;">';
        $xhtml .=     '<div class="checkbox checkbox-wrapper-8 product-attribute-price-default" style="position: relative;">';
        $xhtml .=         '<input name="default" style="margin-left:0px;margin:0px" class="tgl tgl-skewed"
                                            type="checkbox"
                                            value="'.$val['default'].'"
                                            id="'.$id.'"
                                            data-id="'.$id.'"
                                            data-url="'.$urlDefault.'"
                                            '.$flagDefault.'
                            >';
        $xhtml .=         '<label class="tgl-btn" data-tg-off="OFF" data-tg-on="ON" for="'.$id.'"></label>';
        $xhtml .=     '</div>';
        $xhtml .='</div>';
        return $xhtml;
    }

    public static function showCheckRadioPriceDefault($controllerName,$val,$id){

        $flagDefault            = '';
        if($val['default'] == null || $val['default'] == 0){
            $val['default'] = 0; //Đặt lại giá trị cho tình huống null
            $flagDefault    = '';
        }else{
            $flagDefault    = 'checked';
        }

        $urlDefault = route($controllerName . "/defaultRadio");

        $xhtml  = '';
        $xhtml .= '<div style="position: relative;margin:5px;">';
        $xhtml .=     '<div class="form-check product-attribute-price-default-radio">';
        $xhtml .=         '<input name="productId-'.$val['product_id'].'"
                                type="radio"
                                value="'.$val['default'].'"
                                id="'.$id.'"
                                data-product-id="'.$val['product_id'].'"
                                data-id="'.$id.'"
                                data-url="'.$urlDefault.'"
                                '.$flagDefault.'
                            >';
        $xhtml .=     '</div>';
        $xhtml .='</div>';

        return $xhtml;
    }

    public static function showCartItem(){
        $urlCartView    = Route('user/cartView');
        $xtml = '<li class="nav-item">
                                <div class="text-center">
                                <a href="'.$urlCartView.'" class="dropdown-item">
                                    <strong>Xem danh sách</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                                </div>
                            </li>';
        return $xtml;
    }

    public static function getColorHex($color_id){
        $attributeValue = new AttributevalueModel();
        $params['color_id'] = $color_id;
        $color_Hex      = $attributeValue->getItem($params,['task'=>'get-color-hex']);
        return $color_Hex;
    }

    //Hàm lấy màu (color) ngược với mã màu sẵn có.
    public static function getComplementaryColor($hexColor) {
            // Loại bỏ ký tự # nếu có
            $hexColor = ltrim($hexColor, '#');

            // Chuyển mã hex thành giá trị RGB
            $r = hexdec(substr($hexColor, 0, 2));
            $g = hexdec(substr($hexColor, 2, 2));
            $b = hexdec(substr($hexColor, 4, 2));

            // Tính giá trị ngược lại
            $rComplement = 255 - $r;
            $gComplement = 255 - $g;
            $bComplement = 255 - $b;

            // Chuyển lại sang dạng hex
            $complementaryColor = sprintf("#%02x%02x%02x", $rComplement, $gComplement, $bComplement);

            return $complementaryColor;
        }

    public static function colorDiv($color_id,$color_name){
        $color_Hex          = Template::getColorHex($color_id);
        $color_opposite     = Template::getComplementaryColor($color_Hex['color']);

        $colorDiv           = '<div class="color-box text-center padding-color"
                                    style="background: '.$color_Hex['color'].';display: flex; justify-content: center;">
                                        <span style="color: '.$color_opposite.';display: block; width: fit-content; margin: 0 auto;line-height: 20px;">'.$color_name.'</span>
                               </div>';
        return $colorDiv;
    }

    public static function colorDivSmartPhone($color_id,$color_name){
        $color_Hex          = Template::getColorHex($color_id);
        $color_opposite     = Template::getComplementaryColor($color_Hex['color']);

        $colorDiv           = '<div class="color-box text-center padding-color border border-dark mb-1"
                                    style="background: '.$color_Hex['color'].';display: flex; justify-content: center;width:100px;">
                                        <span class="" style="color: '.$color_opposite.';display: block; margin: 0 auto;line-height: 20px;">'.$color_name.'</span>
                               </div>';
        return $colorDiv;
    }


    public static function blueLockText($name){
        $name = ($name != null) ? $name : 'Locked';
        $xhtml = '<strong style="color:blue">'.$name.'</strong>';
        return $xhtml;
    }

    //Smart Phone Site:
    public static function showProductThumbInPhone($controllerName = 'product' , $thumbName , $thumbAlt){
        //$linkThumb = asset("images/$controllerName/$thumbName");
        $linkThumb = ($thumbName)? asset("images/$controllerName/$thumbName") : '';
        $xhtml  = sprintf('
            <img src="%s" class="img-fluid blur-up lazyload bg-img" alt="%s">', $linkThumb , $thumbAlt);
        return  $xhtml;
    }

    public static function showProductThumbInOrderHistory($controllerName = 'product' , $thumbName , $thumbAlt){
        //$linkThumb = asset("images/$controllerName/$thumbName");
        $linkThumb = ($thumbName != '')? asset("images/$controllerName/$thumbName") :  asset("images/$controllerName/product.jpg");
        $xhtml  = sprintf('
            <img src="%s" alt="%s" style="width: 80px">', $linkThumb , $thumbAlt);
        return  $xhtml;
    }

    public static function showProductThumbInPhoneItem($controllerName = 'product' , $thumbName , $thumbAlt){
        //$linkThumb = asset("images/$controllerName/$thumbName");
        $linkThumb = ($thumbName)? asset("images/$controllerName/$thumbName") : '';
        $xhtml  = sprintf('
            <img src="%s" class="img-fluid w-100 blur-up lazyload image_zoom_cls-0" alt="%s">', $linkThumb , $thumbAlt);
        return  $xhtml;
    }

    public static function showInvoiceInfo($controllerName = 'product' , $invoice , $params){

        $userName =  Hightlight::show($invoice['username'], $params['search'] , 'username');
        $code     =  Hightlight::show($invoice['code'], $params['search'] , 'code');
        $xhtml  = ' <p><strong>Mã đơn hàng (code): </strong>'.$code.'</p>
                    <p><strong>Tên khách hàng: </strong>'.$userName.'</p>
                    <p><strong>Các sản phẩm thuộc đơn hàng: </strong></p>';
        foreach($invoice['invoice_products'] as $key=>$invoiceProduct){
                $xhtml .= '<p> - Tên:'.$invoiceProduct['product_name'].' - Màu:'.$invoiceProduct['color_name'].' - DL:'.$invoiceProduct['material_name'].' -giá:'.$invoiceProduct['quantity'].' -Sl:'.$invoiceProduct['quantity'].' -Tổng:<strong>'.$invoiceProduct['total_price'].'</strong></p> ';
        }
        return  $xhtml;
    }

}
