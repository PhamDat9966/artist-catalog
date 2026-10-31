@php
    use App\Helpers\Template as Template;
    use App\Helpers\Hightlight as Hightlight;
    use App\Models\MenuSmartPhoneModel as MenuSmartPhoneModel;

    $menuModel      = new MenuSmartPhoneModel();
    $tempArray      = $menuModel->listItems(null,["task"=> "news-list-items-parent"]);
    $parentArray    = array();
    $parentArray[0] = 'Không';
    foreach ($tempArray as $key => $value) {
        $parentArray[$value['id']] = $value['name'];
    }

@endphp

<div class="x_content">
    <div class="title">
        <h2>Menu</h2>
        <div class="clearfix"></div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Name</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">url</th>
                    <th class="column-title">Id cha</th>
                    <th class="column-title">Ordering</th>
                    <th class="column-title">Type menu</th>
                    <th class="column-title">Type open</th>
                    <th class="column-title">Container</th>
                    <th class="column-title">Ghi chú</th>
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
                            $content            = Hightlight::show($val['content'], $params['search'] , 'content');
                            $status             = Template::showItemStatus( $controllerName,$id,$val['status']);
                            $url                = $val['url'];
                            $ordering           = Template::showItemOrdering( $controllerName,$val['ordering'],$id );
                            $type_menu          = Template::showItemSelect( $controllerName,$id,$val['type_menu'],'type_menu');
                            $type_open          = Template::showItemSelect( $controllerName,$id,$val['type_open'],'type_open');

                            $parent_id          = $val['parent_id'];
                            $parent_id          = Template::showItemSelectWithArray($controllerName,$id,$val['parent_id'],'parent_id',$parentArray);
                            $container          = $val['container'];
                            $note               = $val['note'];
                            $listButtonAction   = Template::showButtonAction($controllerName, $id);
                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="12%">
                                <p><strong>Name:</strong> {!! $name !!}</p>
                            </td>
                            <td>
                                {!!$status!!}
                            </td>
                            <td>
                                {!!$url!!}
                            </td>
                            <td>
                                {!!$parent_id!!}
                            </td>
                            <td>
                                {!!$ordering!!}
                            </td>
                            <td>
                                {!!$type_menu!!}
                            </td>
                            <td>
                                {!!$type_open!!}
                            </td>
                            <td>
                                {!!$container!!}
                            </td>
                            <td width="10%">
                                {!!$note!!}
                            </td>
                            <td>
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

