@extends('pages.partials.main')
@section('title', 'Surat Keluar')

@push('custom-css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.min.css" rel="stylesheet">
@endpush

@section('content')

<div class="d-flex justify-content-between flex-column flex-sm-row">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Transaksi Surat /</span> Surat Keluar</h4>
    <div class="py-3">
        <a href="{{route('admin.outgoingTransactionCreate')}}" class="btn btn-primary float-right">Tambah Baru</a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    {{session('success')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    {{session('error')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@forelse($letters as $letter)
<div class="col-12">
    <div class="card mb-4">
        <div class="container py-4">
            <div class="d-flex justify-content-between flex-column flex-sm-row">
                <div>
                    <div class="fw-bold display-6">{{$letter->reference_number}}</div>
                    <div><span class="fw-bold">{{$letter->to}}</span> | Nomor Agenda : {{$letter->agenda_number}} | {{$letter->classification->type}} </div>
                </div>
                <div class="d-flex justify-content-between gap-2">
                    <div class="d-flex flex-column">
                        <div style="font-size: 12px">Tanggal Surat </div>
                        <div style="font-size: 15px">{{\Carbon\Carbon::parse($letter->letter_date)->isoFormat('dddd, D MMMM YYYY')}}</div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-icon rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{route('admin.outgoingTransactionEdit', $letter->id)}}">Edit</a></li>
                            <li><a class="dropdown-item" href="{{route('admin.outgoingTransactionDetail', $letter->id)}}">Lihat Detail</a></li>
                            <li>
                                <form method="POST" action="{{route('admin.outgoingTransactionDestroy', $letter->id)}}">
                                    @csrf
                                    <input name="_method" type="hidden" value="DELETE">
                                    <button type="submit" class="btn dropdown-item show-alert-delete-box" data-toggle="tooltip" title='Delete'>Delete</button>
                                </form>

                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-12">
                <div class="row">
                    <div class="col-md-11">
                        {{$letter->description}}
                        <div class="py-2"><span class="text-muted">Keterangan</span> : {{$letter->note}} </div>
                    </div>
                    <div class="col-md-1">
                        @foreach ($letter->attachments as $attachment)
                        @if($attachment->extension === 'pdf')
                        <div class="py-2"><a href="{{asset('attachments')}}/{{$attachment->filename}}" target="_blank"><i class='bx bxs-file-pdf text-primary' style="font-size: 40px"></i></a></div>
                        @elseif($attachment->extension === 'jpg')
                        <div class="py-2"><a href="{{asset('attachments')}}/{{$attachment->filename}}" target="_blank"><i class='bx bxs-file-jpg text-primary' style="font-size: 40px"></i></a></div>
                        @elseif($attachment->extension === 'jpeg')
                        <div class="py-2"><a href="{{asset('attachments')}}/{{$attachment->filename}}" target="_blank"><i class='bx bxs-file-jpg text-primary' style="font-size: 40px"></i></a></div>
                        @elseif($attachment->extension === 'png')
                        <div class="py-2"><a href="{{asset('attachments')}}/{{$attachment->filename}}" target="_blank"><i class='bx bxs-file-png text-primary' style="font-size: 40px"></i></a></div>
                        @elseif($attachment->extension === 'docx')
                        <div class="py-2"><a href="{{asset('attachments')}}/{{$attachment->filename}}" target="_blank"><i class='bx bxs-file-doc text-primary' style="font-size: 40px"></i></a></div>
                        @elseif($attachment->extension === 'doc')
                        <div class="py-2"><a href="{{asset('attachments')}}/{{$attachment->filename}}" target="_blank"><i class='bx bxs-file-doc text-primary' style="font-size: 40px"></i></a></div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@empty
<div class="col-12">
    <div class="card mb-4">
        <div class="container py-4">
            <div class="text-center text-muted">Data Kosong</div>
        </div>
    </div>
</div>
@endforelse
<!-- Basic Pagination -->
<div class="col-12">
    {!! $letters->withQueryString()->links('pagination::bootstrap-5') !!}
</div>

@endsection

@push('custom-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script type="text/javascript">
    $('.show-alert-delete-box').click(function(event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
            title: "Apakah Anda Yakin Ingin Menghapus Data ini?"
            , text: "Jika ini terhapus, data akan hilang selamanya"
            , icon: "warning"
            , type: "warning"
            , buttons: ["Cancel", "Yes!"]
            , confirmButtonColor: '#3085d6'
            , cancelButtonColor: '#d33'
            , confirmButtonText: 'Yes, delete it!'
        }).then((willDelete) => {
            if (willDelete) {
                form.submit();
            }
        });
    });

</script>
@endpush
