@php
    use App\Helpers\Template as Template;
    use App\Helpers\Hightlight as Hightlight;
    //dd($items->toArray(),$controllerName);
@endphp

<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Tên</th>
                    <th class="column-title">Phí vận chuyển</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Ngày tạo</th>
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
                            $cost               = Hightlight::show($val['cost'], $params['search'] , 'cost');

                            $status             = Template::showItemStatus( $controllerName,$id,$val['status']);
                            $createdHistory     = Template::showItemHistory($val['created_by'],$val['created'], $params['filter']['created']);
                            $modifiedHistory    = Template::showItemHistoryModified($val['modified_by'],$val['modified'],$id, $params['filter']['modified']);
                            $listButtonAction   = Template::showButtonAction($controllerName, $id);

                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="20%">
                                {!! $name !!}
                            </td>
                            <td>
                                {!! $cost !!}
                            </td>
                            <td>
                                {!!$status!!}
                            </td>
                            <td>
                                {!!$createdHistory!!}
                            </td>
                            <td>
                                {!!$modifiedHistory!!}
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

