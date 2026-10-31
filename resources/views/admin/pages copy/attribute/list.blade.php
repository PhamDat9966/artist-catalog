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
                    <th class="column-title">Thuộc tính</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">fieldClass</th>
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
                            $fieldClass         = $val['fieldClass'];

                            $attributeMainArrayID   = Config::get('zvn.config.lock.attribute_main_id');
                            $status                 = (in_array($val['id'],$attributeMainArrayID)) ? 'Locked': Template::showItemStatus( $controllerName,$id,$val['status']);
                            $listButtonAction       = (in_array($val['id'],$attributeMainArrayID)) ? 'Main Attribute': Template::showButtonAction($controllerName, $id);

                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="30%">
                                <p><strong>Name:</strong> {!! $name !!}</p>
                            </td>
                            <td>
                                {!!$status!!}
                            </td>
                            <td>
                                {!!$fieldClass!!}
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

