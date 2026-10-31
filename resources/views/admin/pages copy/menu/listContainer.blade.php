@php
    use App\Helpers\Template as Template;
    use App\Helpers\Hightlight as Hightlight;
@endphp

<div class="x_content">
    <div class="title">
        <h2>Category Container Plus</h2>
        <div class="clearfix"></div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Category Info</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Hiển thị Home</th>
                    <th class="column-title">Kiểu hiển thị</th>
                    <th class="column-title">Tạo mới</th>
                    <th class="column-title">Chỉnh sửa</th>
                    <th class="column-title">Hành động</th>
                </tr>
            </thead>
            <tbody>

                @if (count($categoryList) > 0)
                    @foreach ($categoryList as $key => $val)
                        @php
                            $index              = $key+1;
                            $class              = ($index % 2 == 0)? 'even' : 'odd';

                            $id                 = $val['id'];
                            $name               = Hightlight::show($val['name'], $params['search'] , 'name');

                            $status             = Template::showItemStatus( 'category',$id,$val['status']); // $controllerName đã được share tại SliderController.php
                            $isHome             = Template::showItemIsHome( 'category',$id,$val['is_home']);
                            $display            = Template::showItemDisplay( 'category',$id,$val['display']);
                            $createdHistory     = Template::showItemHistory($val['created_by'],$val['created']);
                            $modifiedHistory    = Template::showItemHistory($val['modified_by'],$val['modified']);
                            $listButtonAction   = Template::showButtonAction('category', $id);
                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="40%">
                                <p><strong>Name:</strong> {!! $name !!}</p>
                            </td>
                            <td>
                                {!!$status!!}
                            </td>
                            <td>
                                {!!$isHome!!}
                            </td>
                            <td>
                                {!!$display!!}
                            </td>
                            <td>
                                {!!$createdHistory!!} {{--Phải dùng hai dấu !! mới đọc được nội dung--}}
                            </td>
                            <td>
                                {!!$modifiedHistory!!} {{--Phải dùng hai dấu !! mới đọc được nội dung--}}
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

