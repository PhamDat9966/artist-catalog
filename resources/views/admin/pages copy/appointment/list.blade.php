@php
    use App\Helpers\Template as Template;
    use App\Helpers\Hightlight as Hightlight;
    //  dd($params);
@endphp

<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Thông tin</th>
                    <th class="column-title">Tin nhắn</th>
                    <th class="column-title">Chi nhánh</th>
                    <th class="column-title">Thời gian đặt</th>
                    <th class="column-title">Trạng thái</th>
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
                            $email              = Hightlight::show($val['email'], $params['search'] , 'email');

                            $sex                = $val['sex'];
                            $paramsTemp         = [];
                            if(isset($params['filter']['sex'])){
                                $paramsTemp['search']['field'] = 'sex';
                                $paramsTemp['search']['value'] =  $sex ;
                                $sex                = Hightlight::show($val['sex'], $paramsTemp['search'] , 'sex');
                            }

                            $phone              = Hightlight::show($val['phonenumber'], $params['search'] , 'phonenumber');
                            $note               = $val['note'];
                            $branch             = $val['branch_info'];
                            $timeMeet           = $val['timeMeet'];
                            $status             = Template::showItemStatusAppointment( $controllerName,$id,$val['status']);
                            $listButtonAction   = Template::showButtonAction($controllerName, $id);

                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="25%">
                                <p><strong>Tên:</strong> {!! $name !!}</p>
                                <p><strong>Giới tính:</strong> {!! $sex !!}</p>
                                <p><strong>SĐT:</strong> {!! $phone !!}</p>
                                <p><strong>Email:</strong> {!! $email !!}</p>
                            </td>
                            <td>
                                {!!$note!!}
                            </td>
                            <td>
                                {!!$branch!!}
                            </td>
                            <td>
                                {!!$timeMeet!!}
                            </td>
                            <td>
                                {!!$status!!}
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

