@if ($paginator->hasPages())
    <style>
        .custom-pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 2rem;
            font-family: 'Inter', sans-serif; /* assuming body font */
        }
        .custom-pagination-info {
            color: #4b5563; /* tailwind gray-600 */
            font-size: 0.95rem;
        }
        .custom-pagination-info strong {
            color: #111827; /* tailwind gray-900 */
            font-weight: 600;
        }
        .custom-pagination-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: #fff;
            border: 1px solid #e5e7eb; /* tailwind gray-200 */
            border-radius: 8px;
            color: #6b7280; /* tailwind gray-500 */
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }
        .custom-pagination-btn:hover:not(.disabled) {
            border-color: #d1d5db;
            color: #374151;
            background: #f9fafb;
        }
        .custom-pagination-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .custom-pagination-btn-blue {
            background: #3b82f6; /* tailwind blue-500 */
            color: #fff;
            border-color: #3b82f6;
        }
        .custom-pagination-btn-blue:hover:not(.disabled) {
            background: #2563eb;
            border-color: #2563eb;
            color: #fff;
        }
        .custom-pagination-pages {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }
        .custom-pagination-page {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #f3f4f6; /* tailwind gray-100 */
            color: #4b5563;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            border: 1px solid transparent;
        }
        .custom-pagination-page:hover:not(.active):not(.disabled) {
            background: #e5e7eb;
            color: #111827;
        }
        .custom-pagination-page.active {
            background: #3b82f6; /* tailwind blue-500 */
            color: #fff;
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
        }
        .custom-pagination-page.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background: transparent;
        }
        
        @media (max-width: 640px) {
            .custom-pagination {
                flex-direction: column;
                justify-content: center;
            }
            .custom-pagination-info {
                order: -1;
                margin-bottom: 0.5rem;
            }
            .custom-pagination-pages {
                flex-wrap: wrap;
                justify-content: center;
            }
        }
    </style>

    <div class="custom-pagination">
        {{-- Previous Button --}}
        @if ($paginator->onFirstPage())
            <span class="custom-pagination-btn disabled">
                <i class="fa-solid fa-arrow-left"></i> Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="custom-pagination-btn">
                <i class="fa-solid fa-arrow-left"></i> Previous
            </a>
        @endif

        {{-- Info --}}
        <div class="custom-pagination-info">
            Showing 
            @if ($paginator->firstItem())
                <strong>{{ $paginator->firstItem() }}</strong> to <strong>{{ $paginator->lastItem() }}</strong>
            @else
                <strong>{{ $paginator->count() }}</strong>
            @endif
            of <strong>{{ $paginator->total() }}</strong> results
        </div>

        {{-- Pages & Next --}}
        <div class="custom-pagination-pages">
            {{-- Prev Page Arrow --}}
            @if ($paginator->onFirstPage())
                <span class="custom-pagination-page disabled"><i class="fa-solid fa-angle-left"></i></span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="custom-pagination-page"><i class="fa-solid fa-angle-left"></i></a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="custom-pagination-page disabled">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="custom-pagination-page active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="custom-pagination-page">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Arrow --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="custom-pagination-page"><i class="fa-solid fa-angle-right"></i></a>
            @else
                <span class="custom-pagination-page disabled"><i class="fa-solid fa-angle-right"></i></span>
            @endif

            {{-- Next Button --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="custom-pagination-btn custom-pagination-btn-blue" style="margin-left: 0.5rem;">
                    Next <i class="fa-solid fa-arrow-right"></i>
                </a>
            @else
                <span class="custom-pagination-btn custom-pagination-btn-blue disabled" style="margin-left: 0.5rem;">
                    Next <i class="fa-solid fa-arrow-right"></i>
                </span>
            @endif
        </div>
    </div>
@endif
