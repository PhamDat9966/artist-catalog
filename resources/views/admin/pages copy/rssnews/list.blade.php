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
                    <th class="column-title">Rss News Info</th>
                    <th class="column-title">Thumb</th>
                    <th class="column-title">Domain</th>
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

                            $index              = $key+1;
                            $class              = ($index % 2 == 0)? 'even' : 'odd';

                            $id                 = $val['id'];
                            $title              = Hightlight::show($val['title'], $params['search'] , 'title');
                            $description        = Hightlight::show($val['description'], $params['search'] , 'description');
                            $pubDate            = $val['pubDate'];

                            $link               = $val['link'];
                            $miniThumb          = $val['thumb'];
                            $thumb              = '<img src="'.$miniThumb.'" alt="'.$title.'" class="zvn-thumb">';
                            $status             = Template::showItemStatus( $controllerName,$id,$val['status']); // $controllerName đã được share tại SliderController.php
                            $domain             = $val['domain'];
                            $listButtonAction   = Template::showButtonAction($controllerName, $id);
                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="30%">
                                <p><strong>title:</strong> {!! $title !!}</p>
                                <p><strong>description:</strong> {!! $description !!}</p>
                                <p><strong>link:</strong> {!! $link !!}</p>
                            </td>
                            <td width="20%">
                                {!!$thumb!!}
                            </td>
                            <td width="10%">
                                {!!$domain!!}
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

