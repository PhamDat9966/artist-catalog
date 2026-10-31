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
                    <th class="column-title">Article</th>
                    <th class="column-title">Số Lượt Xem</th>
                    <th class="column-title">Ngày Bắt Đầu Đếm</th>
                    <th class="column-title">Lượt Xem Gần Nhất</th>
                    {{-- <th class="column-title">Tạo mới</th>
                    <th class="column-title">Chỉnh sửa</th> --}}

                </tr>
            </thead>
            <tbody>

                @if (count($items) > 0)
                    @foreach ($items as $key => $val)
                        @php


                            $index              = $key+1;
                            $class              = ($index % 2 == 0)? 'even' : 'odd';

                            $id                 = $val['id'];
                            $name               = Hightlight::show($val['article_name'], $params['search'] , 'article_name');
                            $name               = ($name != '') ? $name : '<strong style="color:red;">Bài viết đã bị xóa</strong>';
                            $views              = $val['views'];
                            $createdHistory     = Template::showItemHistory('',$val['created']);
                            $modifiedHistory    = Template::showItemHistory('',$val['modified']);
                            // $createdHistory     = Template::showItemHistory($val['created_by'],$val['created']);
                            // $modifiedHistory    = Template::showItemHistory($val['modified_by'],$val['modified']);
                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="30%">
                                <p><strong>Name:</strong> {!! $name !!}</p>
                            </td>
                            <td>
                                {!!$views!!}
                            </td>
                            <td>
                                {!!$createdHistory!!}
                            </td>
                            <td>
                                {!!$modifiedHistory!!}
                            </td>
                            {{-- <td>{!!$createdHistory!!}</td>
                            <td>{!!$modifiedHistory!!} </td> --}}
                        </tr>
                    @endforeach

                @else
                    @include('admin.templates.list_empty',['colspan'=>6])
                @endif

            </tbody>
        </table>
    </div>
</div>

