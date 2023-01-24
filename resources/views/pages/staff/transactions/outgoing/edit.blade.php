@extends('pages.partials.main')
@section('title', 'Edit Surat Keluar')

@section('content')

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Transaksi Surat / Surat Keluar /</span> Ubah Data</h4>


<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="container py-4">
                <form action="{{route("staff.outgoingTransactionUpdate", $letter->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="defaultFormControlInput" class="form-label">Nomor Surat</label>
                                <input type="text" value="{{$letter->reference_number}}" class="form-control @error('reference_number') is-invalid @enderror" name="reference_number" id="reference_number" {{-- placeholder="John Doe" --}} aria-describedby="defaultFormControlHelp" />
                                @error('reference_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="defaultFormControlInput" class="form-label">Penerima</label>
                                <input type="text" value="{{$letter->to}}" class="form-control @error('to') is-invalid @enderror" name="to" id="to" {{-- placeholder="John Doe" --}} aria-describedby="defaultFormControlHelp" />
                                @error('to')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>                                
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="defaultFormControlInput" class="form-label">Nomor Agenda</label>
                                <input type="text" value="{{$letter->agenda_number}}" class="form-control @error('agenda_number') is-invalid @enderror" name="agenda_number" id="agenda_number" {{-- placeholder="John Doe" --}} aria-describedby="defaultFormControlHelp" />
                                @error('agenda_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Nomor Agenda Tidak Boleh Kosong</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="defaultFormControlInput" class="form-label">Tanggal Surat</label>
                                <input type="date" value="{{\Carbon\Carbon::parse($letter->letter_date)->isoFormat('YYYY-MM-D');}}" class="form-control @error('letter_date') is-invalid @enderror" name="letter_date" id="letter_date" {{-- placeholder="John Doe" --}} aria-describedby="defaultFormControlHelp" />
                                @error('letter_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Tanggal Surat Tidak Boleh Kosong</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="defaultFormControlInput" class="form-label">Ringkasan</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" cols="30" rows="5">{{$letter->description}}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Ringkasan Tidak Boleh Kosong</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="defaultFormControlInput" class="form-label">Kode Klasifikasi</label>
                                <select name="classification_code" id="classification_code" class="form-control form-select @error('classification_code') is-invalid @enderror">
                                    @foreach ($classifications as $item)
                                        <option value="{{$item->code}}">{{$item->type}}</option>   
                                    @endforeach
                                </select>
                                @error('classification_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Klasifikasi Kode Tidak Boleh Kosong</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="defaultFormControlInput" class="form-label">Keterangan</label>
                                <input type="text" value="{{$letter->note}}" class="form-control" name="note" id="note" {{-- placeholder="John Doe" --}} aria-describedby="defaultFormControlHelp" />
                            </div>
                            <div class="col-md-4">
                                <label for="defaultFormControlInput" class="form-label">Lampiran</label>
                                <input type="file" class="form-control @error('attachments') is-invalid @enderror" name="attachments" id="attachments" {{-- placeholder="John Doe" --}} aria-describedby="defaultFormControlHelp" />
                                <div class="text-muted fw-bold mt-1" style="font-size: 13px">*) .pdf, .jpg, .png, word only!</div>
                                @foreach ($letter->attachments as $attachment)
                                    @if($attachment->extension === 'pdf')
                                     <div class="py-2"><a href="{{asset('attachments')}}/{{$attachment->filename}}" target="_blank"><i class='bx bxs-file-pdf text-primary' style="font-size: 40px"></i></a></div>
                                    @elseif($attachment->extension === 'jpg')
                                     <div class="py-2"><a href="{{asset('attachments')}}/{{$attachment->filename}}" target="_blank"><i class='bx bxs-file-jpg text-primary' style="font-size: 40px"></i></a></div>
                                    @endif
                                @endforeach
                                @error('attachments')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4 mb-2">
                            <a href="{{route('staff.outgoingTransactionIndex')}}" class="btn btn-primary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
