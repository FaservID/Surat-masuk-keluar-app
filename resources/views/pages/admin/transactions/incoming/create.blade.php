@extends('pages.partials.main')
@section('title', 'Buat Surat Masuk')

@section('content')

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Transaksi Surat / Surat Masuk /</span> Tambah Baru</h4>


<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="container py-4">
                <form action="{{route("admin.incomingTransactionStore")}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="defaultFormControlInput" class="form-label">Nomor Surat</label>
                                <input type="text" value="{{ old('reference_number') }}" class="form-control @error('reference_number') is-invalid @enderror" name="reference_number" id="reference_number" {{-- placeholder="John Doe" --}} aria-describedby="defaultFormControlHelp" />
                                @error('reference_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="defaultFormControlInput" class="form-label">Pengirim</label>
                                <input type="text" value="{{ old('from') }}" class="form-control @error('from') is-invalid @enderror" name="from" id="from" {{-- placeholder="John Doe" --}} aria-describedby="defaultFormControlHelp" />
                                @error('from')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}g</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="defaultFormControlInput" class="form-label">Nomor Agenda</label>
                                <input type="text" value="{{ old('agenda_number') }}" class="form-control @error('agenda_number') is-invalid @enderror" name="agenda_number" id="agenda_number" {{-- placeholder="John Doe" --}} aria-describedby="defaultFormControlHelp" />
                                @error('agenda_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="defaultFormControlInput" class="form-label">Tanggal Surat</label>
                                <input type="date" value="{{ old('letter_date') }}" class="form-control @error('letter_date') is-invalid @enderror" name="letter_date" id="letter_date" {{-- placeholder="John Doe" --}} aria-describedby="defaultFormControlHelp" />
                                @error('letter_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="defaultFormControlInput" class="form-label">Tanggal Diterima</label>
                                <input type="date" value="{{ old('received_date') }}" class="form-control @error('received_date') is-invalid @enderror" name="received_date" id="received_date" {{-- placeholder="John Doe" --}} aria-describedby="defaultFormControlHelp" />
                                @error('received_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="defaultFormControlInput" class="form-label">Ringkasan</label>
                                <textarea name="description" value="{{ old('description') }}" class="form-control @error('description') is-invalid @enderror" id="description" cols="30" rows="5"></textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
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
                                    <option value="" selected disabled>-- Pilih Klasifikasi Kode --</option>
                                    @foreach ($classifications as $item)
                                        <option value="{{$item->code}}">{{$item->type}}</option>   
                                    @endforeach
                                </select>
                                @error('classification_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="defaultFormControlInput" class="form-label">Keterangan</label>
                                <input type="text" class="form-control" value="{{ old('note') }}" name="note" id="note" {{-- placeholder="John Doe" --}} aria-describedby="defaultFormControlHelp" />
                            </div>
                            <div class="col-md-4">
                                <label for="defaultFormControlInput" class="form-label">Lampiran</label>
                                <input type="file" class="form-control @error('attachments') is-invalid @enderror" name="attachments" id="attachments" {{-- placeholder="John Doe" --}} aria-describedby="defaultFormControlHelp" />
                                <p class="text-muted fw-bold mt-1" style="font-size: 13px">*) .pdf, .jpg, .png, word only!</p>
                                @error('attachments')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4 mb-2">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
