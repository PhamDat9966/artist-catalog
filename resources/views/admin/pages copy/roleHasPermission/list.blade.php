@php
    use App\Helpers\Template as Template;
    use App\Helpers\Hightlight as Hightlight;
    $urlPermissionSearch    = Route($controllerName) . '/permission-search';
@endphp

<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Role Id</th>
                    <th class="column-title">Permission Id</th>
                    <th class="column-title">Role Name</th>
                    <th class="column-title">Permission Name</th>
                    <th class="column-title">Hành động</th>
                </tr>
            </thead>
            <tbody>

                @if (count($items) > 0)
                    @foreach ($items as $key => $val)
                        @php

                            $index              = $key+1;
                            $class              = ($index % 2 == 0)? 'even' : 'odd';

                            $permissionId       = $val['permission_id'];
                            $roleId             = $val['role_id'];
                            $permissionName     = Hightlight::show($val['permission_name'], $params['search'] , 'name');
                            $roleName           = Hightlight::show($val['role_name'], $params['search'] , 'name');
                            $listButtonAction   = Template::showButtonActionRoleHasPermission($controllerName, $roleId,$permissionId);

                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="20%">
                                 {!! $roleId !!}</p>
                            </td>
                            <td width="20%">
                                <p>{!! $permissionId !!}</p>
                            </td>
                            <td>
                                 {!! $roleName !!}</p>
                            </td>
                            <td>
                                 {!! $permissionName !!}</p>
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

@section('popup')
<!-- Modal -->
<div class="modal fade" id="popupForm" tabindex="-1" aria-labelledby="popupFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="popupFormLabel">Gán quyền có sẵn cho một vai trò</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route($controllerName.'/save')}}" method="POST">
                    @csrf
                    <label for="role">Vai trò - Role:</label>
                    <select name="role_id" id="role" class="form-control">
                        @foreach ($roleList as $keyR=>$role)
                            <option value="{{$role['id']}}">{{$role['name']}}</option>
                        @endforeach
                    </select>

                    <label for="model">Quyền - Permission:</label>
                    <select name="permission_id" id="permission_search" class="form-control" style="width: 100%" data-url="{{$urlPermissionSearch}}">
                        <option value="">Nhập hoặc chọn permission...</option>
                    </select>

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
