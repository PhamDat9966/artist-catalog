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
                    <th class="column-title">Tên hàng</th>
                    <th class="column-title">Màu sắc</th>
                    <th class="column-title">Dung lượng</th>
                    <th class="column-title">Số lượng</th>
                    <th class="column-title">Đơn giá</th>
                    <th class="column-title">Hành động</th>
                </tr>
            </thead>
            <tbody>

                @if (count($cart) > 0)
                    @foreach ($cart as $key => $val)
                        @php
                            $index              = $key+1;
                            $class              = ($index % 2 == 0)? 'even' : 'odd';

                            $id                 = $val['id'];
                            $name               = $val['name'];
                            $color_name         = $val['color_name'];
                            $color_id           = $val['color'];

                            $colorDiv           = Template::colorDiv($color_id,$color_name);

                            $material_name      = $val['material_name'];
                            $quantity           = Template::showItemQuantity($controllerName,$val['quantity'],$id);
                            $urlDeleteOneCart   = route($controllerName . '/deleteOneCart',['id' => $id,'color'=>$val['color'],'material'=>$val['material']]);

                            $price              = '<span class="price" id="price-'.$id.'">'.$val['price'].'</span>';
                            $listButtonAction   = '<a href="'.$urlDeleteOneCart.'"
                                                      type="button" class="btn btn-icon btn-danger btn-delete"
                                                      data-toggle="tooltip" data-placement="top"
                                                      data-original-title="Delete">
                                                            <i class="fa fa-remove"></i>
                                                    </a>';
                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="30%">
                                <p><strong>name:</strong> {!! $name !!}</p>
                            </td>
                            <td width="10%">
                                {!! $colorDiv !!}
                            </td>
                            <td width="10%">
                                {!! $material_name !!}
                            </td>
                            <td>
                                {!! $quantity !!}
                            </td>
                            <td>
                                {!! $price !!}
                            </td>
                            <td class="last">
                                {!!$listButtonAction!!}
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

