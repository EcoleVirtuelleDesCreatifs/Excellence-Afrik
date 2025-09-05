@if ($paginator->hasPages())
    <nav class="excellence-pagination" aria-label="Navigation des pages">
        <div class="pagination-wrapper d-flex justify-content-center align-items-center">
            <div class="pagination-info me-4">
                <span class="text-muted">
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
        margin: 2rem 0;
    }
    
    .excellence-pagination-list {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .excellence-page-link {
        border: none;
        background: #ffffff;
        color: #2563eb;
        padding: 12px 16px;
        font-weight: 500;
        transition: all 0.3s ease;
        border-right: 1px solid #e5e7eb;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 48px;
    }
    
    .excellence-page-link:hover:not(.disabled) {
        background: linear-gradient(135deg, #D4AF37 0%, #F2CB05 100%);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
    }
    
    .excellence-page-link.active {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff;
        font-weight: 600;
    }
    
    .excellence-page-link.disabled {
        background: #f8fafc;
        color: #9ca3af;
        cursor: not-allowed;
    }
    
    .page-item:first-child .excellence-page-link {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }
    
    .page-item:last-child .excellence-page-link {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
        border-right: none;
    }
    
    .pagination-info {
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    @media (max-width: 768px) {
        .pagination-wrapper {
            flex-direction: column;
            gap: 1rem;
        }
        
        .pagination-info {
            margin: 0 !important;
            text-align: center;
        }
        
        .excellence-page-link {
            padding: 10px 14px;
            font-size: 0.9rem;
        }
    }
    </style>
@endif
