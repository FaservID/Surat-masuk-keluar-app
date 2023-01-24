@extends('pages.partials.main')
@section('title', 'Ubah Data Pengguna')

@section('content')

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kelola Pengguna /</span> Ubah Data</h4>


<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="container py-4">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <form method="POST" action="{{route('admin.userReset')}}">
                                @csrf
                                <input type="hidden" name="id" value="{{$user->id}}">
                                <button type="submit" class="btn btn-warning btn-sm show-alert-delete-box" data-toggle="tooltip" title='Delete'>Reset Password</button>
                            </form>
                        </div>
                    </div>
                    <form action="{{route('admin.userUpdate', $user->id)}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <label for="defaultFormControlInput" class="form-label">Nama</label>
                                <input type="text" value="{{ $user->name }}" class="form-control @error('name') is-invalid @enderror" name="name" id="name" {{-- placeholder="John Doe" --}} aria-describedby="defaultFormControlHelp" />
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}/strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <label for="defaultFormControlInput" class="form-label">Email</label>
                                <input type="email" value="{{ $user->email }}" class="form-control @error('email') is-invalid @enderror" name="email" id="email" {{-- placeholder="John Doe" --}} aria-describedby="defaultFormControlHelp" />
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}/strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <label for="defaultFormControlInput" class="form-label">Role</label>
                                <select name="type" class="form-select form-label">
                                    {{-- <option value="" disabled selected>-- Pilih Role --</option> --}}
                                    <option value="0" {{$user->type === 'staff' ? 'selected' : ''}}>Staff</option>
                                    <option value="1" {{$user->type === 'admin' ? 'selected' : ''}}>Admin</option>
                                    <option value="2" {{$user->type === 'kabid' ? 'selected' : ''}}>Kabid</option>
                                </select>
                                @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                </div>
                <div class="mt-4 mb-2">
                    <a href="{{route('admin.userIndex')}}" class="btn btn-primary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
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
            title: "Apakah Anda Yakin Ingin Mereset Akun Ini?"
            , text: "Jika ini tereset, password akan kembali secara default"
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
