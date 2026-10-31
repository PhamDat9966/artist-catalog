@php
    use App\Helpers\Template as Template;
    /*
        Nếu có default thì mặc định sẽ chon phần tử đầu tiên tức là $itemPriceDefault[0]
        khi nhiều hơn 1 phần tử trong $itemPriceDefault
    */
    $id             = (isset($item['id']))? $item['id'] : '';
    $name           = (isset($item['name']))? $item->name : '';
    $slug           = (isset($item['slug']))? $item->slug : '';
    $status         = (isset($item['status']))? $item->status : '';
    $category       = (isset($item['category_product_id']))? $item->category_product_id : '';
    $description    = (isset($item['description']))? $item->description : '';

    /*Hình ảnh*/
    $thumbContent       = json_decode($item['media'][0]['content']);
    $thumbName          = $thumbContent->name;
    $thumb              = Template::showProductThumb($controllerName,$thumbName,$name);
    $xhtmlMedia         = '';
    foreach($item['media'] as $key=>$media){
        $mediaContent   = json_decode($media['content']);
        $mediaName      = $mediaContent->name;
        $xhtmlMedia    .= '<a>' .Template::showProductThumb($controllerName,$mediaName,$name). '</a>';
    }

    /*Màu sắc và dung lượng*/
    $xhtmlColors         = '<ul class="list-inline prod_color display-layout">';
    $xhtmlStorage        = '<ul class="list-inline prod_size display-layout">';
    $colorTextList       = '';
    foreach($item['attributes'] as $attkey=>$attribute){

        if($attribute['color-picker']){
            $flagCheckColorDefault = '';
            if(!empty($itemPriceDefault)){
                if($attribute['attribute_value_id'] == $itemPriceDefault[0]['color_id']){
                    $flagCheckColorDefault = 'checked';
                }
            }
            $xhtmlColors    .=  '<li style="width:100px;">
                                    <p style="display: inline;">'.$attribute['attribute_value_name'].'</p>
                                    <div>
                                        <div class="text-center">
                                            <p class="color" style="background:'.$attribute['color-picker'].';color:#ffffff;">
                                            </p>
                                        </div>
                                        <div style="padding-left:7px;">
                                            <input  type="radio"
                                                    name="color"
                                                    id="color_'.$attribute['attribute_value_id'].'"
                                                    value="'.$attribute['attribute_value_id'].'"
                                                    '.$flagCheckColorDefault.'
                                            >
                                        </div>
                                    </div>
                                </li>';
        }

        //Sử dụng id định danh của dung lượng là 2 'material', để xác định những nội dung nào cần xuất ra ở storage
        if($attribute['attribute_id'] == 2){
            $flagCheckMaterialDefault = '';
            if(!empty($itemPriceDefault)){
                if($attribute['attribute_value_id'] == $itemPriceDefault[0]['material_id']){
                    $flagCheckMaterialDefault = 'selected btn-primary';
                }
            }

            $url    = route($controllerName. '/price');
            $xhtmlStorage   .=' <li>
                                    <button type="button" class="btn btn-default btn-lg btn-material '.$flagCheckMaterialDefault.'"
                                            data-id="'.$attribute['attribute_value_id'].'"
                                            data-item="'.'itemId-'.$id.'"
                                            data-url="'.$url.'"
                                            >'.$attribute['attribute_value_name'].'</button>
                                </li>';
        }
    }
    $xhtmlColors        .= '</ul>';
    $xhtmlStorage       .= '</ul>';


    //$urlUser             = route('user/order');
    $urlUser        = route('user/addCart');
    $linkThumb      = ($thumbName)? asset("images/$controllerName/$thumbName") : '';
    $buttonAddCard  = ' <button type="button"
                                id="order-cart"
                                class="btn btn-default btn-lg"
                                data-id="'.$id.'"
                                data-name="'.$name.'"
                                data-url="'.$urlUser.'"
                                data-thumb="'.$linkThumb.'"
                                >Add to Cart
                        </button>';

    //Price
    $price = (!empty($itemPriceDefault[0]['price'])) ? $itemPriceDefault[0]['price'] . " đồng":'Hãy chọn màu sắc, dung lượng';

@endphp

<div class="row">
    <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
        <h2>Thông tin sản phẩm</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li class="dropdown">
                <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
        </div>
        <div class="x_content">

        <div class="col-md-7 col-sm-7 ">
            <div class="product-image">
                {!! $thumb !!}
            </div>
            <div class="product_gallery">
                {!! $xhtmlMedia !!}
            </div>
        </div>

        <div class="col-md-5 col-sm-5 " style="border:0px solid #e5e5e5;">

            <h3 class="prod_title">{!!ucfirst($name)!!}</h3>
                {!! $description !!}
            <br />

            <div class="">
                <h2>Màu sắc</h2>
                {!!$colorTextList!!}
                {!! $xhtmlColors !!}

            </div>
            <br />

            <div class="">
            <h2>Dung lượng <small>Hãy chọn một thuộc tính</small></h2>
                {!! $xhtmlStorage !!}
            </div>
            <br />

            <div class="">
            <div class="product_price">
                <h1 class="price">{{ $price }}</h1>
                <span class="price-tax">Ex Tax: Chưa có</span>
                <br>
            </div>
            </div>

            <div class="">
                {!! $buttonAddCard !!}
            </div>

        </div>
        </div>
    </div>
    </div>
</div>

@section('popup')
<!-- Modal -->
<div id="cartModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="cartModalLabel">Thông báo</h4>
      </div>
      <div class="modal-body">
        Sản phẩm đã được thêm vào giỏ hàng!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>
@endsection
