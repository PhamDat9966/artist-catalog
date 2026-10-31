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
                    <th class="column-title">Code Info</th>
                    <th class="column-title">Thời gian áp dụng</th>
                    <th class="column-title">Khoảng giá</th>
                    <th class="column-title">Số lượng</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Hành động</th>
                </tr>
            </thead>
            <tbody>

                @if (count($items) > 0)
                    @foreach ($items as $key => $val)
                        @php
                            //dd($val->toArray(),$controllerName);
                            $index              = $key+1;
                            $class              = ($index % 2 == 0)? 'even' : 'odd';

                            $id                 = $val['id'];
                            $type               = ($val['type'] === 'percent') ? 'Giảm giá theo phần trăm' : 'Giảm giá trực tiếp';
                            $code               = Hightlight::show($val['code'], $params['search'] , 'code');
                            $value              = Hightlight::show($val['value'], $params['search'] , 'value');

                            $start_time         = date("d/m/Y h:i:s a", strtotime($val['start_time']));
                            $end_time           = date("d/m/Y h:i:s a", strtotime($val['end_time']));

                            $start_price        = $val['start_price'] . 'đ';
                            $end_price          = $val['end_price'] . 'đ';

                            $total              = $val['total'];
                            $total_use          = $val['total_use'];

                            $status             = Template::showItemStatus( $controllerName,$id,$val['status']);
                            $listButtonAction   = Template::showButtonAction($controllerName, $id);
                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="20%">
                                <p><strong>Code:</strong> {!! $code !!}</p>
                                <p><strong>Hình thức:</strong> {!! $type !!}</p>
                                <p><strong>Giá trị:</strong> {!! $value !!}</p>
                            </td>
                            <td width="15%">
                                <p><strong>Từ:</strong> {!! $start_time !!}</p>
                                <p><strong>Đến:</strong> {!! $end_time !!}</p>
                            </td>
                            <td width="15%">
                                <p><strong>Từ:</strong> {!! $start_price !!}</p>
                                <p><strong>Đến:</strong> {!! $end_price !!}</p>
                            </td>
                            <td width="15%">
                                <p><strong>Tổng:</strong> {!! $total !!}</p>
                                <p><strong>Đã sử dụng:</strong> {!! $total_use !!}</p>
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

