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
                    <th class="column-title">Thông tin</th>
                    <th class="column-title">Tin nhắn</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Thời gian</th>
                    <th class="column-title">IP Address</th>
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
                            $phone              = Hightlight::show($val['phone'], $params['search'] , 'phone');

                            $message            = $val['message'];
                            $time               = $val['time'];

                            $status             = Template::showItemStatusAppointment( $controllerName,$id,$val['status']);
                            $ip_address         = $val['ip_address'];

                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="25%">
                                <p><strong>Tên:</strong> {!! $name !!}</p>
                                <p><strong>SĐT:</strong> {!! $phone !!}</p>
                                <p><strong>Email:</strong> {!! $email !!}</p>
                            </td>
                            <td>
                                {!!$message!!}
                            </td>
                            <td>
                                {!!$status!!}
                            </td>
                            <td>
                                {!!$time!!}
                            </td>
                            <td class="last">
                                {!!$ip_address!!}
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

