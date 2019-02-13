<style>
    .controls-below-table .table-records-pages ul{display: block}
</style>
@if ($paginator->hasPages())

<div class="controls-below-table controls-pagination-cnt row">

    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="table-records-info">
            Showing records <label id="numberofbox">3</label> of {{$paginator->total()}}
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="table-records-pages align-rit">
            <ul class="pagination">
        @if ($paginator->onFirstPage())
        <li class="disabled"><span>Previous</span></li>
       @else
        <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a></li>
        @endif
               
        @foreach ($elements as $element)
        @if (is_string($element))
            <li class="disabled"><span>{{ $element }}</span></li>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="active my-active"><span>{{ $page }}</span></li>
                @else
                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach

             @if ($paginator->hasMorePages())
             <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a></li>
             @else
            <li class="disabled"><span>Next</span></li>
             @endif
               
            </ul>
        </div>
    </div>
</div> 

@endif