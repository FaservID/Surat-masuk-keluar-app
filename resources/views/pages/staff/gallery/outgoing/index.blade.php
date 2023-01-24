@extends('pages.partials.main')
@section('title', 'Gallery Surat Keluar')

@push('custom-css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.min.css" rel="stylesheet">
@endpush

@section('content')

<div class="d-flex justify-content-between flex-column flex-sm-row">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Galeri Surat /</span> Surat Keluar</h4>
</div>

<div class="col-12">
    <div class="row">
        @forelse ($letters as $letter)
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="container py-3">
                    <div class="col-md-12 d-flex">
                        <div class="col-md-8">
                            <div class="fw-bold text-uppercase">
                                @foreach ($letter->attachments as $attachment)
                                {{$attachment->extension}}
                                @endforeach
                            </div>
                            <div><a href="{{route('staff.outgoingTransactionDetail', $letter->id)}}">{{$letter->reference_number}}</a></div>
                            <div class="text-muted" style="font-size: 10px">{{\Carbon\Carbon::parse($letter->letter_date)->isoFormat('dddd, D MMMM YYYY');}}</div>
                        </div>
                        <div class="col-md-4 d-flex justify-content-end">
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
        @empty
        <div class="col-12">
            <div class="card py-4">
                <div class="text-center">Data Kosong</div>
            </div>
        </div>
        @endforelse
    </div>
    <div class="mt-3">
        {!! $letters->withQueryString()->links('pagination::bootstrap-5') !!}
    </div>
</div>


@endsection
