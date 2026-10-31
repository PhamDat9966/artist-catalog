@php
    use App\Helpers\Template as Template;
    use App\Helpers\Hightlight as Hightlight;
    // dd($items);
@endphp

<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Số điện thoại</th>
                    <th class="column-title">Thời gian yêu cầu</th>
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
                            $phonenumber        = Hightlight::show($val['phonenumber'], $params['search'] , 'phonenumber');
                            $contact            = Template::showItemContact( $controllerName,$id,$val['status']); // $controllerName đã được share tại SliderController.php
                            $created            = $val['created'];
                            $listButtonAction   = Template::showButtonAction($controllerName, $id);
                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="30%">
                                {!! $phonenumber !!}
                            </td>
                            <td>
                                {!!$created!!}
                            </td>
                            <td>
                                {!!$contact!!}
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

