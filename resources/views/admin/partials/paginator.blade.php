
@if ($paginator->hasPages())
    <ul class="pagination">
        @if ($paginator->onFirstPage())
        <li class="page-item disabled">
            <a class="page-link " href="#" aria-label="Next">
                <span aria-hidden="true" class="mdi mdi-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
        </li>
            
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true" class="mdi mdi-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
        @endif

        @foreach ($elements as $element)

            @if (is_string($element))
                <li class="page-item active">
                    <a class="page-link" href="#">{{ $element }}</a>
                </li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><a class="page-link" href="#">{{ $page }}</a></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach


        <!-- <li class="page-item"><a class="page-link dot" href="#">...</a></li> -->

        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true" class="mdi mdi-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        @else
            <li class="page-item disabled">
                <a class="page-link " href="#" aria-label="Next">
                    <span aria-hidden="true" class="mdi mdi-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        @endif
    </ul>
       
@endif