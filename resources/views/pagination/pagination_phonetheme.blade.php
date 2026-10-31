@php
    //Tiến 2 trang lùi 2 trang:
    $currentPage = $paginator->currentPage();
    $totalPage =   $paginator->lastPage();

    $next2Page = ($currentPage + 2 > $totalPage) ? $totalPage : $currentPage + 2;
    $prev2Page = ($currentPage - 2 < 1) ? 1 : $currentPage - 2;

@endphp
@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <nav>
            <ul class="pagination">
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <a href="" class="page-link"><i class="fa fa-angle-double-left"></i></a>
                    </li>
                    <li class="page-item disabled">
                        <a href="" class="page-link"><i class="fa fa-angle-left"></i></a>
                    </li>
                @else
                    <li class="page-item">
                        <a href="{{ $paginator->url($prev2Page) }}" class="page-link"><i class="fa fa-angle-double-left"></i></a>
                    </li>
                    <li class="page-item">
                        <a href="{{ $paginator->previousPageUrl() }}" class="page-link"><i class="fa fa-angle-left"></i></a>
                    </li>
                @endif
                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li><span class="pagination-ellipsis">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            {{-- @if ($page == $paginator->currentPage())
                                <li class="page-item active"><span class="page-item active">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a href="{{ $url }}" class="page-item">{{ $page }}</a></li>
                            @endif --}}

                            @if ($page == $paginator->currentPage())
                                <li class="page-item active">
                                    <a class="page-link">{{$page}}</a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{$url}}">{{$page}}</a>
                                </li>
                            @endif


                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                         <a class="page-link" href="{{ $paginator->nextPageUrl() }}"><i class="fa fa-angle-right"></i></a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{$paginator->url($next2Page)}}"><i class="fa fa-angle-double-right"></i></a>
                    </li>
                @else
                    <li class="page-item disabled">
                         <a class="page-link" href="#"><i class="fa fa-angle-right"></i></a>
                    </li>
                    <li class="page-item disabled">
                         <a class="page-link" href="#"><i class="fa fa-angle-double-right"></i></a>
                    </li>
                @endif
            </ul>
        </nav>
    </nav>
@endif


{{-- <nav aria-label="Page navigation">
    <nav>
        <ul class="pagination">
            <li class="page-item disabled">
                <a href="" class="page-link"><i class="fa fa-angle-double-left"></i></a>
            </li>
            <li class="page-item disabled">
                <a href="" class="page-link"><i class="fa fa-angle-left"></i></a>
            </li>
            <li class="page-item active">
                <a class="page-link">1</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">2</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">3</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#"><i class="fa fa-angle-right"></i></a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#"><i class="fa fa-angle-double-right"></i></a>
            </li>
        </ul>
    </nav>
</nav> --}}
