@if ($paginator->hasPages())
    <nav>
        <ul class="pagination2">
            {{-- Lien vers la page précédente --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&lsaquo;</a>
                </li>
            @endif

            {{-- Affichage des pages dynamiquement --}}
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                @if ($i == 1 || $i == $paginator->lastPage() || ($i >= $paginator->currentPage() - 1 && $i <= $paginator->currentPage() + 1))
                    <li class="page-item {{ $i == $paginator->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    </li>
                @elseif ($i == 2 || $i == $paginator->lastPage() - 1)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
            @endfor

            {{-- Lien vers la page suivante --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
            @endif
        </ul>
    </nav>
@endif
