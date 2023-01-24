@extends('pages.partials.main')
@section('title', 'Profile')

@push('custom-css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.min.css" rel="stylesheet">
@endpush

@section('content')

<div class="d-flex justify-content-between flex-column flex-sm-row">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Profile /</span> Akun</h4>
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

<div class="card">
    <h5 class="card-header">Profile Details</h5>
    <!-- Account -->
    <div class="card-body">
        @if(auth()->user()->type === "admin")
        <form action="{{route('admin.profileUploadPicture')}}" method="POST" enctype="multipart/form-data">
            @elseif(auth()->user()->type === "kabid")
            <form action="{{route('kabid.profileUploadPicture')}}" method="POST" enctype="multipart/form-data">
                @else
                <form action="{{route('staff.profileUploadPicture')}}" method="POST" enctype="multipart/form-data">
                    @endif
                    @csrf
                    @method('POST')
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <input type="hidden" name="id" value="{{auth()->user()->id}}">
                        <img src="{{asset('profile-picture')}}/{{auth()->user()->profile_picture}}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                        <div class="button-wrapper">
                            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Upload new photo</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input type="file" id="upload" name="picture" class="account-file-input" hidden accept="image/png, image/jpeg" />
                            </label>
                            <button type="submit" class="btn btn-primary account-image-reset mb-4">
                                <i class="bx bx-reset d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Simpan</span>
                            </button>
                            <p class="text-muted mb-0">Allowed JPG or PNG. Max size of 800K</p>
                        </div>
                    </div>
                </form>
    </div>
    <hr class="my-0" />
    <div class="card-body">
        @if(auth()->user()->type === "admin")
        <form id="formAccountSettings" method="POST" action="{{route('admin.profileDataUpdate', auth()->user()->id)}}">
            @elseif(auth()->user()->type === "kabid")
            <form id="formAccountSettings" method="POST" action="{{route('kabid.profileDataUpdate', auth()->user()->id)}}">
                @else
                <form id="formAccountSettings" method="POST" action="{{route('staff.profileDataUpdate', auth()->user()->id)}}">
                    @endif
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{auth()->user()->name}}" autofocus />
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" id="email" value="{{auth()->user()->email}}" />
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="phoneNumber">Phone Number</label>
                            <div class="input-group input-group-merge  @error('phone_number') is-invalid @enderror">
                                <span class="input-group-text">ID (+62)</span>
                                <input type="text" id="phone_number" name="phone_number" class="form-control" placeholder="82111112222" value="{{auth()->user()->phone_number}}" />
                            </div>
                            @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">dibuat Tanggal</label>
                            <input class="form-control" type="text" disabled id="email" name="email" value="{{\Carbon\Carbon::parse(auth()->user()->created_at)->isoFormat('dddd, D MMMM YYYY');}}" placeholder="john.doe@example.com" />
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                        <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                    </div>
                </form>
    </div>
    <hr class="my-0" />
    <h5 class="card-header">Ganti Password</h5>
    <div class="card-body">
        @if(auth()->user()->type === "admin")
        <form action="{{route('admin.profilePasswordUpdate')}}" method="POST">
            @elseif(auth()->user()->type === "kabid")
            <form action="{{route('kabid.profilePasswordUpdate')}}" method="POST">
                @else
                <form action="{{route('staff.profilePasswordUpdate')}}" method="POST">
                    @endif
                    @csrf
                    @method('POST')
                    <input type="hidden" name="id" value="{{auth()->user()->id}}">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="password1" class="form-label">Password</label>
                            <input class="form-control @error('password1') is-invalid @enderror" type="password" id="password1" name="password1" placeholder="****" autofocus />
                            @error('password1')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="password2" class="form-label">Konfirmasi Password</label>
                            <input class="form-control @error('password2') is-invalid @enderror" type="password" name="password2" id="password2" placeholder="****" />
                            @error('password2')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-warning me-2">Save changes</button>
                    </div>
                </form>
    </div>
    <!-- /Account -->
</div>

@endsection
