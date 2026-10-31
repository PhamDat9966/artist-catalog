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
                    <th class="column-title">Role Name</th>
                    <th class="column-title">guard Name</th>
                    <th class="column-title">Tạo mới</th>
                    <th class="column-title">Chỉnh sửa</th>
                    <th class="column-title">Hành động</th>
                </tr>
            </thead>
            <tbody>

                @if (count($items) > 0)
                    @foreach ($items as $key => $val)
                        @php
                            $primeID            = config('zvn.config.lock.prime_id');
                            $userImpID          = config('zvn.config.lock.permission_id');
                            $index              = $key+1;
                            $class              = ($index % 2 == 0)? 'even' : 'odd';

                            $id                 = $val['id'];
                            $name               = $val['name'];
                            $guardName          = $val['guard_name'];
                            $createdHistory     = Template::showItemHistory('',$val['created_at'], null);
                            $modifiedHistory    = Template::showItemHistoryModified('',$val['updated_at'],$id,null);
                            $listButtonAction   = ($id == $primeID || in_array($id,$userImpID))? Template::blueLockText(null) :Template::showButtonAction($controllerName, $id);
                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="30%">
                                <p><strong>{!! $name !!}</strong> </p>
                            </td>
                            <td width="30%">
                                 {!! $guardName !!}</p>
                            </td>
                            <td>
                                 {!! $createdHistory !!}</p>
                            </td>
                            <td>
                                 {!! $modifiedHistory !!}</p>
                            </td>
                            <td class="last">
                                {!!$listButtonAction!!}
                            </td>
                        </tr>
                    @endforeach
                @endif

            </tbody>
        </table>
    </div>
</div>
