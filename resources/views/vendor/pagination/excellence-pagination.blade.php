@if ($paginator->hasPages())
    <nav class="excellence-pagination" aria-label="Navigation des pages">
        <div class="pagination-wrapper d-flex justify-content-center align-items-center">
            <div class="pagination-info me-4">
                <span>
                    Page {{ $paginator->currentPage() }} sur {{ $paginator->lastPage() }}
                    ({{ $paginator->total() }} {{ $paginator->total() > 1 ? 'articles' : 'article' }})
                </span>
            </div>
            
            <ul class="pagination excellence-pagination-list mb-0">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link excellence-page-link disabled">
                            <i class="fas fa-chevron-left"></i>
                            <span class="d-none d-sm-inline ms-1">Précédent</span>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link excellence-page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                            <i class="fas fa-chevron-left"></i>
                            <span class="d-none d-sm-inline ms-1">Précédent</span>
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled d-none d-md-block">
                            <span class="page-link excellence-page-link">{{ $element }}</span>
                        </li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active d-none d-md-block">
                                    <span class="page-link excellence-page-link active">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item d-none d-md-block">
                                    <a class="page-link excellence-page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link excellence-page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                            <span class="d-none d-sm-inline me-1">Suivant</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link excellence-page-link disabled">
                            <span class="d-none d-sm-inline me-1">Suivant</span>
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </li>
                @endif
            </ul>
        </div>
    </nav>

    <style>
    .excellence-pagination {
        margin: 2.5rem 0;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .pagination-info {
        font-size: 0.875rem; /* 14px */
        color: #495057;
        background-color: #f1f3f5;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-weight: 500;
    }

    .excellence-pagination-list {
        display: flex;
        align-items: center;
        gap: 0.5rem; /* Use gap for spacing */
    }

    .excellence-page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: #333;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem; /* 6px */
        min-width: 42px;
        height: 42px;
        padding: 0.5rem 0.75rem;
        font-weight: 500;
        transition: all 0.2s ease-in-out;
    }

    .excellence-page-link:hover:not(.disabled) {
        background-color: #f8f9fa;
        border-color: #c1933e;
        color: #c1933e;
    }

    /* Active state styling */
    .page-item.active .excellence-page-link {
        background-color: #000000; /* Black */
        border-color: #000000;
        color: #ffffff;
        font-weight: 700;
    }

    /* Disabled state styling */
    .excellence-page-link.disabled {
        color: #adb5bd;
        background-color: #e9ecef;
        border-color: #dee2e6;
        cursor: not-allowed;
    }

    /* Remove default page-item styling */
    .page-item {
        list-style: none;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .pagination-wrapper {
            flex-direction: column;
            gap: 1rem;
        }
    }
    </style>
@endif
