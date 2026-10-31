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
                    <th class="column-title">Slider Info</th>
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
                            //$description        = $val['description'];
                            $description        = Hightlight::show($val['description'], $params['search'] , 'description');
                            //$link               = $val['link'];
                            $link               = Hightlight::show($val['link'], $params['search'] , 'link');

                            $status             = Template::showItemStatus( $controllerName,$id,$val['status']); // $controllerName đã được share tại SliderController.php
                            $createdHistory     = Template::showItemHistory($val['created_by'],$val['created'],$params['filter']['created']);
                            $modifiedHistory    = Template::showItemHistoryModified($val['modified_by'],$val['modified'],$id,$params['filter']['modified']);
                            $thumb              = Template::showItemThumb($controllerName,$val['thumb'],$val['name']);
                            $listButtonAction   = Template::showButtonAction($controllerName, $id);
                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="40%">
                                <p><strong>Name:</strong> {!! $name !!}</p>
                                <p><strong>Description:</strong> {!! $description !!}</p>
                                <p><strong>Link:</strong> {!! $link !!}</p>
                                {!! $thumb !!}
                            </td>
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

