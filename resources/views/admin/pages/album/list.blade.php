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
                    <th class="column-title">Album Info</th>
                    <th class="column-title">Thumb</th>
                    <th class="column-title">Trạng thái</th>
                    {{-- <th class="column-title">Tạo mới</th>
                    <th class="column-title">Chỉnh sửa</th> --}}
                    <th class="column-title">Hành động</th>
                </tr>
            </thead>
            <tbody>

                @if (count($items) > 0)
                    @foreach ($items as $key => $val)
                        @php
                        //    dd($val->toArray());

                            $index              = $key+1;
                            $class              = ($index % 2 == 0)? 'even' : 'odd';

                            $id                 = $val['id'];
                            $albumName          = Hightlight::show($val['name'], $params['search'] , 'name');
                            $artistName         = Hightlight::show($val['artist_name'], $params['search'] , 'artist_name');

                            $miniThumb          = $val['thumb'];
                            $thumb              = Template::showItemThumb($controllerName,$miniThumb,$val['name']);
                            $status             = Template::showItemStatus( $controllerName,$id,$val['status']); // $controllerName đã được share tại SliderController.php
                            $listButtonAction   = Template::showButtonAction($controllerName, $id);
                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="30%">
                                <p><strong>Tên album:</strong> {!! $albumName !!}</p>
                                <p><strong>Tên nghệ sĩ:</strong> {!! $artistName !!}</p>
                            </td>
                            <td width="20%">
                                {!!$thumb!!}
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

