@extends('pages.partials.main')
@section('title', 'Kelola User')


@section('content')

<div class="d-flex justify-content-between flex-column flex-sm-row">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kelola Pengguna /</span> User</h4>
    <div class="py-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Tambah Baru
        </button>

        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{route('admin.userStore')}}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Pengguna</h1>
                            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="defaultFormControlInput" class="form-label">Nama</label>
                                        <input type="text" value="{{ old('name') }}" placeholder="Odading" class="form-control @error('name') is-invalid @enderror" name="name" id="name" {{-- placeholder="John Doe" --}} aria-describedby="defaultFormControlHelp" />
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label for="defaultFormControlInput" class="form-label">Email</label>
                                        <input type="email" value="{{ old('email') }}" placeholder="saepudin@gmail.com" class="form-control @error('email') is-invalid @enderror" name="email" id="email" {{-- placeholder="John Doe" --}} aria-describedby="defaultFormControlHelp" />
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label for="defaultFormControlInput" class="form-label">Role</label>
                                        <select name="type" class="form-select form-label">
                                            <option value="" disabled selected>-- Pilih Role --</option>
                                            <option value="0">Staff</option>
                                            <option value="1">Admin</option>
                                            <option value="2">Kabid</option>
                                        </select>
                                        @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <div class="text-muted text-sm fw-bold">* Password Default (123456)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Buat Akun</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal -->

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


<div class="col-12">
    <div class="card mb-4">
        <div class="container py-4">

            <table id="example" class="display table table-bordered py-3" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Nomor HP</th>
                        <th>dibuat Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; ?>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->type}}</td>
                        <td>{{$user->phone_number}}</td>
                        <td>{{\Carbon\Carbon::parse($user->created_at)->isoFormat('dddd, D MMMM YYYY');}}</td>
                        <td class="d-flex justify-content-center">
                            <a href="{{route('admin.userEdit', $user->id)}}" class="btn btn-warning btn-sm">Edit</a> | 
                            <form method="POST" action="{{route('admin.userDestroy', $user->id)}}">
                                @csrf
                                <input name="_method" type="hidden" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm show-alert-delete-box" data-toggle="tooltip" title='Delete'>Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Nomor HP</th>
                        <th>dibuat Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
</div>



@endsection

@push('custom-scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();
    });

</script>
@endpush

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
