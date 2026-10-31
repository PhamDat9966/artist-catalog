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
                    <th class="column-title">Thông tin chung</th>
                    <th class="column-title">Tổng giá đơn hàng</th>
                    <th class="column-title">Trạng thái đơn hàng</th>
                    <th class="column-title">Ngày tạo</th>
                    <th class="column-title">Ngày cập nhật</th>
                    <th class="column-title">Hành động</th>
                </tr>
            </thead>
            <tbody>

                @if (count($data['items']) > 0)
                    @foreach ($data['items'] as $key => $val)
                        @php
                            $index              = $key+1;
                            $class              = ($index % 2 == 0)? 'even' : 'odd';

                            $id                             = $val['id'];
                            $code                           = $val['code'];
                            $username                       = $val['username'];

                            $invoiceArray                   = $val->toArray();
                            $totalPriceInvoice              = array_sum(array_column($invoiceArray['invoice_products'], 'total_price'));
                            $invoiceInfo                    = Template::showInvoiceInfo($controllerName,$val,$params);

                            $status                         = Template::showItemSelectNoRole($controllerName,$id,$val['status'],'invoiceStatus');
                            $createdHistory                 = Template::showItemHistory($val['created_by'],$val['created'], null);
                            $modifiedHistory                = Template::showItemHistoryModified($val['modified_by'],$val['modified'],$id, '');
                            $action                         = Template::showButtonAction($controllerName, $id);
                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="40%">
                                {!! $invoiceInfo !!}
                            </td>
                            <td>
                                <p><strong>{{ $totalPriceInvoice }}</strong></p>
                            </td>
                            <td width="15%">
                                {!! $status !!}
                            </td>
                            <td>
                                {!! $createdHistory !!}
                            </td>
                            <td>
                                {!! $modifiedHistory !!}
                            </td>
                            <td class="last">
                                {!!$action!!}
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

