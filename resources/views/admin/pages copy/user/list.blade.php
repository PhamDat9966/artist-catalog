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
                    <th class="column-title">Username</th>
                    <th class="column-title">Email</th>
                    <th class="column-title">Fullname</th>
                    <th class="column-title">Avatar</th>
                    <th class="column-title">Level</th>
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
                            $username           = Hightlight::show($val['username'], $params['search'] , 'username');
                            $email              = Hightlight::show($val['email'], $params['search'] , 'email');
                            $fullname           = Hightlight::show($val['fullname'], $params['search'] , 'fullname');
                            $role               = Template::showRoleSelect( $controllerName,$id,'role',$val['roles_id'],$roleList);
                            $status             = Template::showUserStatus( $controllerName,$id,$val['status'],$val['roles_id']); // $controllerName đã được share tại SliderController.php
                            $createdHistory     = Template::showItemHistory($val['created_by'],$val['created'], $params['filter']['created']);
                            $modifiedHistory    = Template::showItemHistoryModified($val['modified_by'],$val['modified'],$id, $params['filter']['modified']);
                            $avatar             = Template::showItemThumb($controllerName,$val['avatar'],$val['username']);
                            $listButtonAction   = Template::showButtonUserAction($controllerName, $id,$val['roles_id']);
                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="10%">
                                <p><strong>Username:</strong> {!! $username !!}</p>
                            </td>
                            <td width="10%">
                                <p><strong>Email:</strong> {!! $email !!}</p>
                            </td>
                            <td width="10%">
                                <p><strong>Fullname:</strong> {!! $fullname !!}</p>
                            </td>
                            <td width="5%">
                                {!!$avatar!!}
                            </td>
                            <td>
                                {!!$role!!}
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

