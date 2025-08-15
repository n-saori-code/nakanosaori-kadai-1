@if ($paginator->hasPages())
<nav>
    <ul class="pagination">
        {{-- 前へボタン --}}
        @if ($paginator->onFirstPage())
        <li class="disabled"><span>&lsaquo;</span></li>
        @else
        <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&lsaquo;</a></li>
        @endif

        {{-- ページ番号 --}}
        @foreach ($elements as $element)
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li class="active"><span>{{ $page }}</span></li>
        @else
        <li><a href="{{ $url }}">{{ $page }}</a></li>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- 次へボタン --}}
        @if ($paginator->hasMorePages())
        <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&rsaquo;</a></li>
        @else
        <li class="disabled"><span>&rsaquo;</span></li>
        @endif
    </ul>
</nav>
@endif