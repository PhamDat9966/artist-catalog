@php
    use App\Helpers\Template as Template;
    use App\Helpers\Hightlight as Hightlight;
    $data = $items->toArray();
    $data = $data['data'];

    $stt_col        = 'col-xs-1';
    $name_col       = 'col-xs-3';
    $color_col      = 'col-xs-2';
    $material_col   = 'col-xs-1';
    $price_col      = 'col-xs-3';
    $default_col    = 'col-xs-1';
    $action_col     = 'col-xs-1';

    $urlUpdateOrdering = Route($controllerName.'/updateOrdering',
                                [
                                                'filter_color'=>($params['filter']['color']) ? ($params['filter']['color']) : 'all',
                                                'filter_material'=>($params['filter']['material']) ? $params['filter']['material'] : 'all',
                                                'search_value'=>($params['search']['value']) ? ($params['search']['value']) : 'all',
                                                'search_field'=>($params['search']['field']) ? $params['search']['field'] : 'product_name',
                                             ]);
    $urlProductSearch = Route($controllerName) . '/product-search';
    //dd($materialList);

@endphp
<div class="x_content">
            <thead>
                <ul class="row headings">
                    <li class="column-title {{$stt_col}}">#</th>
                    <li class="column-title {{$name_col}}">Tên sản phẩm</th>
                    <li class="column-title {{$color_col}}">Màu sắc</th>
                    <li class="column-title {{$material_col}}">Dung lượng</th>
                    <li class="column-title {{$price_col}}">Giá</th>
                    <li class="column-title {{$default_col}}">default</th>
                    <li class="column-title {{$action_col}}">Hành động</th>
                </ul>
            </thead>
            <tbody>

                @if (count($items) > 0)
                <ul id="sortable" style="list-style: none; padding: 0;" data-url="{{$urlUpdateOrdering}}">
                    @foreach ($data as $key => $val)
                        @php
                            //dd($val);
                            $index              = $val['ordering'];
                            $dataId             = $val['ordering'];
                            $class              = ($index % 2 == 0)? 'even' : 'odd';

                            $id                     = $val['id'];
                            $name                   = Hightlight::show($val['product_name'], $params['search'] , 'product_name');
                            $product_id             = $val['product_id'];
                            $color_id               = $val['color_id'];
                            $color_name             = $val['color_name'];
                            $material_id            = $val['material_id'];
                            $material_name          = $val['material_name'];

                            $colorDiv               = Template::colorDiv($color_id,$color_name);

                            $material               = Hightlight::show($material_name, $params['search'] , 'material_name');
                            $price                  = Template::showItemPrice($controllerName,$val['price'],$id);
                            //$default                = Template::showCheckBoxWrapper8($controllerName,$val,$id);
                            $default                = Template::showCheckRadioPriceDefault($controllerName,$val,$id);
                            $action                 = Template::showButtonActionProductAttributePrice($controllerName,$product_id ,$color_id,$material_id) . '<i class="fa fa-arrows"></i>';

                        @endphp
                        <li data-id="{{ $id  }}" value={{ $dataId }}>
                            <ul class="row double" style="list-style: none; padding: 0;">
                                <li class="{{$stt_col}}">{{ $index }}</li>
                                <li class="{{$name_col}}">{!! $name !!}</li>
                                <li class="{{$color_col}}">{!!$colorDiv!!}</p></li>
                                <li class="{{$material_col}}">{!!$material!!}</li>
                                <li class="{{$price_col}}">{!!$price!!}</li>
                                <li class="{{$default_col}}">{!!$default!!}</li>
                                <li class="{{$action_col}}">{!!$action!!}</li>
                            </ul>
                        </li>
                    @endforeach
                </ul>
                @else
                    @include('admin.templates.list_empty',['colspan'=>6])
                @endif

            </tbody>
</div>

@section('popup')
<!-- Modal -->
<div class="modal fade" id="popupForm" tabindex="-1" aria-labelledby="popupFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="popupFormLabel">Thêm Thẻ Giá Cho Sản Phẩm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route($controllerName.'/save')}}" method="POST">
                    @csrf
                    <label for="product-price">Chọn sản phẩm:</label>
                    <select name="product-id" id="product-price" class="form-control" style="width: 100%" data-url="{{$urlProductSearch}}">
                        <option value="">Nhập hoặc chọn sản phẩm...</option>
                    </select>

                    <label for="color">Chọn màu sắc:</label>
                    <select name="color-id" id="color" class="form-control">
                        @foreach ($colorList as $keyC=>$color)
                            <option value="{{$color['id']}}">{{$color['name']}}</option>
                        @endforeach
                    </select>

                    <label for="material">Chọn dung lượng:</label>
                    <select name="material-id" id="material" class="form-control">
                        @foreach ($materialList as $keyM=>$material)
                            <option value="{{$material['id']}}">{{$material['name']}}</option>
                        @endforeach
                    </select>

                    <label for="price">Đặt giá:</label>
                    <input name="price" type="number" id="price" class="form-control" placeholder="Nhập giá">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


