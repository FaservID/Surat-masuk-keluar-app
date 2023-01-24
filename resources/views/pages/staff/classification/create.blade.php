@extends('pages.partials.main')
@section('title', 'Buat Klasifikasi Surat')

@section('content')

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Klasifikasi / Klasifikasi Surat /</span> Tambah Baru</h4>


<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="container py-4">
                <form action="{{route('staff.classificationStore')}}" method="post">
                    @csrf
                    @method('POST')
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="defaultFormControlInput" class="form-label">Kode</label>
                                <input type="text" value="{{ old('code') }}" class="form-control @error('code') is-invalid @enderror" name="code" id="code" {{-- placeholder="John Doe" --}} aria-describedby="defaultFormControlHelp" />
                                @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}/strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <label for="defaultFormControlInput" class="form-label">Klasifikasi</label>
                                <input type="text" value="{{ old('type') }}" class="form-control @error('type') is-invalid @enderror" name="type" id="type" {{-- placeholder="John Doe" --}} aria-describedby="defaultFormControlHelp" />
                                @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}/strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <label for="defaultFormControlInput" class="form-label">Uraian</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" cols="5" rows="5" name="description"></textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 mb-2">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
