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
                    <th class="column-title">Product Info</th>
                    <th class="column-title">Media</th>
                    <th class="column-title">Category Name</th>
                    <th class="column-title">Kiểu sản phẩm</th>
                    <th class="column-title">Sản phẩm mới</th>
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
                            $mediaList          = $mediasProduct[$id]['media_list'];

                            $name               = Hightlight::show($val['name'], $params['search'] , 'name');
                            $content            = Hightlight::show($val['description'], $params['search'] , 'description');
                            $slug               = Hightlight::show($val['slug'], $params['search'] , 'slug');

                            $isNew              = Template::showItemIsNew( $controllerName,$id,$val['is_new']);

                            $categoryName       = Template::select('category_product_id', $id , $categoryList , $val['category_product_id'] , ['class' => 'form-control select-ajax', 'data-url' => route("$controllerName/change-category", ['id'=>$id,'category_product_id'=>'value_new'])]);
                            $medias             = Template::showItemMediaList($controllerName,$mediaList);
                            $status             = Template::showItemStatus( $controllerName,$id,$val['status']); // $controllerName đã được share tại SliderController.php
                            $type               = Template::showItemSelect( $controllerName,$id,$val['type'], 'type');
                            $listButtonAction   = Template::showButtonAction($controllerName, $id);
                        @endphp

                        <tr class="{{$class}} pointer">
                            <td>{{ $index }}</td>
                            <td width="30%">
                                <p><strong>Name:</strong> {!! $name !!}</p>
                                <p><strong>Slug:</strong> {!! $slug !!}</p>
                                <p><strong>Content:</strong> {!! $content !!}</p>
                            </td>
                            <td width="20%">
                                {!!$medias!!}
                            </td>
                            <td width="15%">
                                {!!$categoryName!!}
                            </td>
                            <td>
                                {!!$type!!}
                            </td>
                            <td>
                                {!!$isNew!!}
                            </td>
                            <td>
                                {!!$status!!}
                            </td>
                            {{-- <td>{!!$createdHistory!!}</td>
                            <td>{!!$modifiedHistory!!} </td> --}}
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

