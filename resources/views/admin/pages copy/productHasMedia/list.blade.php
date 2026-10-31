@php
    use App\Helpers\Template as Template;
    use App\Helpers\Hightlight as Hightlight;
@endphp

<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Thông tin chung</th>
                    <th class="column-title">Media thu nhỏ</th>
                    <th class="column-title">Gán hiển thị media vào thuộc tính màu sắc của sản phẩm</th>
                    <th class="column-title">Miêu tả</th>
                    <th class="column-title">Video</th>
                    <th class="column-title">Hành động</th>
                </tr>
            </thead>
            <tbody>

                @if (count($itemsHasAttributes) > 0)
                    @foreach ($itemsHasAttributes as $key => $val)
                        @php
                            //dd($val);
                            $index              = $key+1;
                            $class              = ($index % 2 == 0)? 'even' : 'odd';

                            $id                             = $val['id'];
                            $product_id                     = $val['product_id'];
                            $attribute_value_id             = $val['attribute_value_id'];
                            $nameProduct                    = $val['product_name'];
                            $mediaContent                   = json_decode($val['content']);
                            $mediaName                      = $mediaContent->name;
                            $mediaAlt                       = $mediaContent->alt;
                            $mediaSize                      = $mediaContent->size;

                            $nameProduct                      = (request()->has('filter_product_id')) ? '<strong style="color: red;">'.$nameProduct.'</strong>': $nameProduct;

                            $isVideo                        = $val['is_video'];
                            $description                    = "";

                            $mediaShow                      = Template::showItemMediaModal('product',$val);
                            $selectAttributeValueForMedia   = Template::showMediaSelectAttributeWithArray($controllerName,$id,$attribute_value_id,'changeAttribute',$val['productHasAttributes']);

                            //$action                         = Template::showButtonActionMedia($controllerName,$id,$mediaName);
                            $action                          = "Locked";
                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="25%">
                                <p><strong>Tên Media: </strong> {!! $mediaName !!}</p>
                                <p><strong>Thuộc sản phẩm: </strong> {!! $nameProduct !!}</p>
                                <p>Alt: {!! $mediaAlt !!}</p>
                                <p>Size: {!! $mediaSize !!}</p>
                            </td>
                            <td width="10%">
                                {!!$mediaShow!!}
                            </td>
                            <td width="30%">
                                {!!$selectAttributeValueForMedia!!}
                            </td>
                            <td>
                                {!!$description!!}
                            </td>
                            <td>
                                {!!$isVideo!!}
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

