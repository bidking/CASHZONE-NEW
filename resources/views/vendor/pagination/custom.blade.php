<style>
	/* Mengatur warna latar belakang dan teks ketika tombol halaman aktif */
.pagination .page-item.active .page-link {
    background-color: #0d6efd; /* Biru */
    color: white; /* Warna teks putih */
    border-color: #0d6efd; /* Border biru */
}

/* Mengatur warna latar belakang dan teks untuk tombol biasa */
.pagination .page-item .page-link {
    color: #007bff; /* Biru muda */
    border-color: #007bff; /* Border biru */
}

.pagination .page-item:hover .page-link {
    background-color: #0056b3; /* Biru gelap saat hover */
    color: white;
    border-color: #0056b3;
}

.pagination-info .p {
    color: white; /* Warna teks "Showing" dan "of results" menjadi putih */
}

.pagination-info .fw-semibold {
    color: #435ebe; /* Warna angka tetap #435ebe */
}

</style>
@if ($paginator->hasPages()) 
<nav aria-label="Page navigation example"> 
    <div class=" d-sm-flex align-items-center justify-content-between">
        <div>
		<p class="small text-muted pagination-info">
     <span class="p">Showing</span>
    <span class="fw-semibold">{{ ($paginator->currentPage() - 1) * $paginator->perPage() + 1 }} </span>
     <span class="p">to</span>
    <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
     <span class="p">of</span>
    <span class="fw-semibold">{{ $paginator->total() }}</span>
     <span class="p">results</span>
</p>


        </div>

        <div>
            <ul class="pagination justify-content-center"> 
                @if ($paginator->onFirstPage()) 
                <li class="page-item disabled"> 
                    <a class="page-link" href="#" tabindex="-1">Previous</a> 
                </li> 
                @else 
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">Previous</a></li> 
                @endif 

                @foreach ($elements as $element) 
                    @if (is_string($element)) 
                    <li class="page-item disabled">{{ $element }}</li> 
                    @endif

                    @if (is_array($element)) 
                    @foreach ($element as $page => $url) 
                        @if ($page == $paginator->currentPage()) 
                        <li class="page-item active"> 
                            <a class="page-link">{{ $page }}</a> 
                        </li> 
                        @else 
                        <li class="page-item"> 
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a> 
                        </li> 
                        @endif 
                    @endforeach 
                    @endif 
                @endforeach 

                @if ($paginator->hasMorePages()) 
                <li class="page-item"> 
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a> 
                </li> 
                @else 
                <li class="page-item disabled"> 
                    <a class="page-link" href="#">Next</a> 
                </li> 
                @endif 
            </ul> 
        </div>
    </div>
</nav> 
@endif
