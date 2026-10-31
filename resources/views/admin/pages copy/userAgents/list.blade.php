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
                    <th class="column-title">Agent</th>
                    <th class="column-title">Tên Bài Viết</th>
                    <th class="column-title">Id Bài Viết</th>
                    <th class="column-title">Timestamps</th>
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

                            $id                  = $val['id'];
                            $agent               = Hightlight::show($val['agent'], $params['search'] , 'agent');
                            $timestampsHistory   = Template::showItemHistory('',$val['timestamps']);
                            $article_name        = Hightlight::show($val['article_name'], $params['search'] , 'article_name');
                            $article_id          = $val['article_id'];
                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="30%">
                                <p><strong>Agent:</strong> {!! $agent !!}</p>
                            </td>
                            <td>
                                {!!$article_name!!}
                            </td>
                            <td>
                                {!!$article_id!!}
                            </td>
                            <td>
                                {!!$timestampsHistory!!}
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

