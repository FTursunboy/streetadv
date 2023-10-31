@if ($paginator->hasPages())
    <ul class="pag">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="pag__item"><span class="pag__link-arrow"><i class="fa fa-long-arrow-left"></i></span></li>
        @else
            <li class="pag__item"><a class="pag__link-arrow" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa fa-long-arrow-left"></i></a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="pag__item"><span class="pag__link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="pag__item"><span class="pag__link pag__link--active">{{ $page }}</span></li>
                    @else
                        <li class="pag__item"><a class="pag__link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="pag__item"><a class="pag__link-arrow" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa fa-long-arrow-right"></i></a></li>
        @else
            <li class="pag__item"><span class="pag__link-arrow"><i class="fa fa-long-arrow-right"></i></span></li>
        @endif
    </ul>
@endif