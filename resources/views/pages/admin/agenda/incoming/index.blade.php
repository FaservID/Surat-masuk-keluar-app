@extends('pages.partials.main')
@section('title', 'Agenda Surat Masuk')

@push('custom-css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.min.css" rel="stylesheet">
@endpush

@section('content')

<div class="d-flex justify-content-between flex-column flex-sm-row">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Buku Agenda /</span> Surat Masuk</h4>
</div>

@if(session('from'))
<div class="alert alert-info alert-dismissible" role="alert">
    Pencarian Dari Tanggal
    <span class="fw-bold">{{\Carbon\Carbon::parse(session('from'))->isoFormat('dddd, D MMMM YYYY')}}</span> Sampai
    <span class="fw-bold">{{\Carbon\Carbon::parse(session('to'))->isoFormat('dddd, D MMMM YYYY')}}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="col-12">
    <div class="card mb-4">
        <div class="container py-4">

            <div class="col-12">
                <form action="{{route('admin.incomingAgendaSearchDate')}}" method="GET">
                    {{-- @method('GET') --}}
                    <div class="row">
                        <div class="col-md-3">
                            <label for="defaultFormControlInput" class="form-label">Dari Tanggal</label>
                            <input type="date" class="form-control @error('from') is-invalid @enderror" name="from" id="from" {{-- placeholder="John Doe" --}} aria-describedby="defaultFormControlHelp" />
                            @error('from')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="defaultFormControlInput" class="form-label">Sampai Tanggal</label>
                            <input type="date" class="form-control @error('to') is-invalid @enderror" name="to" id="to" {{-- placeholder="John Doe" --}} aria-describedby="defaultFormControlHelp" />
                            @error('to')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="defaultFormControlInput" class="form-label">Dari Tanggal</label>
                            <select name="sortby" id="sortby" class="form-control form-select">
                                <option value="1">Tanggal Surat</option>
                                <option value="2">Tanggal Diterima</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="defaultFormControlInput" class="form-label">Aksi</label>
                            <div>
                                <button type="submit" class="btn btn-primary">Saring</button>
                                <button formtarget="_blank" formaction="{{route('admin.incomingAgendaExport')}}" class="btn btn-primary">Cetak</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive text-nowrap mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nomor Agenda</th>
                            <th>Nomor Surat</th>
                            <th>Pengirim</th>
                            <th>Tanggal Surat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($letters as $letter)
                        <tr>
                            <td>{{$letter->agenda_number}}</td>
                            <td><a href="{{route('admin.incomingTransactionDetail', $letter->id)}}">{{$letter->reference_number}}</a></td>
                            <td>{{$letter->from}}</td>
                            <td>{{\Carbon\Carbon::parse($letter->letter_date)->isoFormat('dddd, D MMMM YYYY');}}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">Data Kosong</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-border-bottom-0">
                        <tr>
                            <th>Nomor Agenda</th>
                            <th>Nomor Surat</th>
                            <th>Pengirim</th>
                            <th>Tanggal Surat</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="mt-3">
                {!! $letters->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>

</div>
<!-- Basic Pagination -->
<div class="col-12">
   
</div>
@endsection
