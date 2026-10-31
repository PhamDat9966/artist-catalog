@php
    use App\Helpers\Template as Template;
    use App\Helpers\Hightlight as Hightlight;
    //dd($items);
@endphp

<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Brand Info</th>
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
                            $address            = Hightlight::show($val['address'], $params['search'] , 'address');
                            $googlemap          = $val['googlemap'];
                            $googlemap          = preg_replace('/height="\d+"/', 'height="200"', $googlemap);
                            $status             = Template::showItemStatus( $controllerName,$id,$val['status']);
                            $createdHistory     = Template::showItemHistory($val['created_by'],$val['created'], $params['filter']['created']);
                            $modifiedHistory    = Template::showItemHistoryModified($val['modified_by'],$val['modified'],$id, $params['filter']['modified']);
                            $listButtonAction   = Template::showButtonAction($controllerName, $id);
                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="30%">
                                <p><strong>Tên chi nhánh:</strong> {!! $name !!}</p>
                                <p><strong>Địa chỉ:</strong> {!! $address !!}</p>
                                <p><strong>Google Map:</strong>
                                    <span class="h-10 d-inline-block">
                                        {!! $googlemap !!}
                                    </span>
                                </p>
                            </td>
                            <td>
                                {!!$status!!}
                            </td>
                            <td>{!!$createdHistory!!}</td>
                            <td>{!!$modifiedHistory!!} </td>
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

