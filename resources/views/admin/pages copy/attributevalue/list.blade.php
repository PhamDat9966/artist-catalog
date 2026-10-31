@php
    use App\Helpers\Template as Template;
    use App\Helpers\Hightlight as Hightlight;
    //dd($items->toArray());
@endphp

<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Giá trị thuộc tính</th>
                    <th class="column-title">Loại thuộc tính</th>
                    <th class="column-title">Mã nhận diện màu sắc - click để chọn</th>
                    <th class="column-title">Ordering</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">fieldClass</th>
                    <th class="column-title">Hành động</th>
                </tr>
            </thead>
            <tbody>

                @if (count($items) > 0)
                    @foreach ($items as $key => $val)
                        @php
                            //dd($val->toArray());
                            $index              = $key+1;
                            $class              = ($index % 2 == 0)? 'even' : 'odd';

                            $id                 = $val['id'];
                            $name               = Hightlight::show($val['name'], $params['search'] , 'name');
                            $nameAttribute      = Hightlight::show($val['attribute_name'], $params['search'] , 'attribute_name');
                            $fieldClass         = $val['fieldClass'];

                            $color              = $val['color'];
                            $attribute_id       = $val['attribute_id'];
                            $color_input        = '';
                            $url                = route($controllerName). '/change-color';
                            $ordering           = Template::showItemOrdering( $controllerName,$val['ordering'],$id );

                            if($attribute_id == 1){
                                $color          = $color ?? '#000000';
                                $color_input    = '<input
                                                        type="color"
                                                        class="color-picker"
                                                        id="color_'.$id.'"
                                                        name="favcolor"
                                                        value="'.$color.'"
                                                        data-id="'.$id.'"
                                                        data-url="'.$url.'"
                                                        >';
                            }

                            $status             = Template::showItemStatus( $controllerName,$id,$val['status']);
                            $listButtonAction   = Template::showButtonAction($controllerName, $id);

                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="30%">
                                <p><strong>Name:</strong> {!! $name !!}</p>
                            </td>
                            <td>
                                {!!$nameAttribute!!}
                            </td>
                            <td>
                                {!!$color_input!!}
                            </td>
                            <td>
                                {!!$ordering!!}
                            </td>
                            <td>
                                {!!$status!!}
                            </td>
                            <td>
                                {!!$fieldClass!!}
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

@section('after_script')
<script>
    $(document).ready(function () {
        /*Ajax cho input color*/
        $('.color-picker').on('change', function () {
            const colorCode = $(this).val(); // Lấy mã màu đã chọn
            const attributeValueId = $(this).data('id'); // Lấy ID của attribute_value
            console.log("js color");
            $.ajax({
                url: 'http://proj_news.xyz/admin96/attributevalue/change-color', // Đường dẫn đến controller
                method: 'GET',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), // Laravel CSRF token
                    id: attributeValueId,
                    color: colorCode,
                },
                success: function (response) {
                    alert('Mã màu đã được cập nhật thành công!');
                    console.log(response);
                },
                error: function (error) {
                    alert('Đã xảy ra lỗi khi cập nhật mã màu!');
                },
            });
        });
    });
</script>
@endsection
