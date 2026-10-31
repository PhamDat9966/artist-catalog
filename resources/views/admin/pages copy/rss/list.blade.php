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
                    <th class="column-title">Name</th>
                    <th class="column-title">Link</th>
                    <th class="column-title">Ordering</th>
                    <th class="column-title">Source</th>
                    <th class="column-title">Trạng thái</th>
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
                            $name               = Hightlight::show($val['name'], $params['search'] , 'name');
                            $link               = Hightlight::show($val['link'], $params['search'] , 'link');
                            $ordering           = Template::showItemOrdering( $controllerName,$val['ordering'],$id );
                            $source             = $val['source'];
                            $status             = Template::showItemStatus( $controllerName,$id,$val['status']); // $controllerName đã được share tại SliderController.php
                            $createdHistory     = Template::showItemHistory($val['created_by'],$val['created']);
                            $modifiedHistory    = Template::showItemHistoryModified($val['modified_by'],$val['modified'],$id);
                            $listButtonAction   = Template::showButtonAction($controllerName, $id);
                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td>{!! $name !!}</td>
                            <td>{!! $link !!}</td>
                            <td>{!! $ordering !!}</td>
                            <td>{{ $source }}</td>
                            <td>
                                {!!$status!!}
                            </td>
                            <td>
                                {!!$createdHistory!!} {{--Phải dùng hai dấu !! mới đọc được nội dung--}}
                            </td>
                            <td>
                                {!!$modifiedHistory!!} {{--Phải dùng hai dấu !! mới đọc được nội dung--}}
                            </td>
                            <td class="last">
                                {!!$listButtonAction!!}

                                {{-- <div class="zvn-box-btn-filter">
                                    <a href="http://proj_news.xyz/admin123/slider/form/3" type="button" class="btn btn-icon btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="http://proj_news.xyz/admin123/slider/delete/3" type="button" class="btn btn-icon btn-danger btn-delete" data-toggle="tooltip" data-placement="top" data-original-title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div> --}}
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

