@php
    use App\Helpers\Template as Template;
    use App\Helpers\Hightlight as Hightlight;
    $data = $items->toArray();
    $data = $data['data'];
    //dd($data);
@endphp

<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Tên sản phẩm</th>
                    <th class="column-title">Thuộc tính</th>
                    <th class="column-title">Hiện màu nếu có</th>
                    <th class="column-title">Ordering</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Sản phẩm có liên quan</th>
                    <th class="column-title">Hành động</th>
                </tr>
            </thead>
            <tbody>

                @if (count($items) > 0)
                    @foreach ($data as $key => $val)
                        @php
                            $index              = $key+1;
                            $class              = ($index % 2 == 0)? 'even' : 'odd';

                            $id                     = $val['id'];
                            $product_id             = $val['product_id'];
                            $attribute_value_id     = $val['attribute_value_id'];
                            $name                   = Hightlight::show($val['product_name'], $params['search'] , 'product_name');

                            $attribute_value_name   = Hightlight::showWithColor($val['attribute_value_name'], $params['search'] , 'attribute_value_name', $val['attribute_value_id']);
                            $ordering               = Template::showItemOrdering( $controllerName,$val['ordering'],$id );
                            $default                = Template::showItemSelect( $controllerName,$id,$val['default'], 'default');
                            $product_id_relation    = $val['product_id_relation'];

                            $color_id               = $val['attribute_value_id'];
                            $color_name             = $val['attribute_value_name'];
                            $colorDiv               = Template::colorDiv($color_id,$color_name);
                            $action                 = Template::showButtonActionProductHasAttribute($controllerName,$product_id ,$attribute_value_id);
                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="25%">
                                <p><strong>Name:</strong> {!! $name !!}</p>
                            </td>
                            <td width="10%">
                                {!!$attribute_value_name!!}
                            </td>
                            <td width="10%">
                                {!!$colorDiv!!}
                            </td>
                            <td>
                                {!!$ordering!!}
                            </td>
                            <td>
                                {!!$default!!}
                            </td>
                            <td>
                                {!!$product_id_relation!!}
                            </td>
                            <td class="last">
                                {!!$action!!}
                            </td>
                        </tr>
                    @endforeach

                @else
                    @include('admin.templates.list_empty',['colspan'=>6])
                @endif

            </tbody>
        </table>
    </div>
</div>

