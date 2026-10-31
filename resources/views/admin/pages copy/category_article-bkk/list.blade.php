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
                    <th class="column-title">Category Info</th>
                    <th class="column-title">Hiện tại navbar</th>
                    <th class="column-title">Sắp xếp</th>
                    <th class="column-title">Hiển thị Home</th>
                    <th class="column-title">Kiểu hiển thị</th>
                    <th class="column-title">Tạo mới</th>
                    <th class="column-title">Chỉnh sửa</th>
                    <th class="column-title">Hành động</th>
                </tr>
            </thead>
            <tbody>

                @if (count($items) > 0)
                    @foreach ($items as $key => $val)
                        @php
                            $index              = $key+1;
                            $class              = ($index % 2 == 0)? 'even' : 'odd';

                            $id                 = $val['id'];
                            $name               = Template::showNestedSetName($val['name'],$val['depth']);
                            $status             = Template::showItemStatus( $controllerName,$id,$val['status']); // $controllerName đã được share tại SliderController.php
                            $move               = Template::showNestedSetUpDown($controllerName, $id);
                            $isHome             = Template::showItemIsHome( $controllerName,$id,$val['is_home']);
                            $display            = Template::showItemDisplay( $controllerName,$id,$val['display']);
                            $createdHistory     = Template::showItemHistory($val['created_by'],$val['created'],'');
                            $modifiedHistory    = Template::showItemHistoryModified($val['modified_by'],$val['modified'],$id,'');
                            $listButtonAction   = Template::showButtonAction($controllerName, $id);

                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="20%">
                                <p> {!! $name !!}</p>
                            </td>
                            <td>
                                {!!$status!!}
                            </td>
                            <td>
                                {!!$move!!}
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

