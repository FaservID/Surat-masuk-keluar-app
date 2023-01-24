@extends('pages.partials.main')
@section('title', 'Klasifikasi')

@push('custom-css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.min.css" rel="stylesheet">
@endpush

@section('content')

<div class="d-flex justify-content-between flex-column flex-sm-row">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Klasifikasi /</span> Klasifikasi Surat</h4>
    <div class="py-3">
        <a href="{{route('admin.classificationCreate')}}" class="btn btn-primary float-right">Tambah Baru</a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    {{session('success')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="col-12">
    <div class="card mb-4">
        <div class="container py-4">

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Klasifikasi</th>
                            <th>Uraian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($classifications as $classification)
                        <tr>
                            <td>{{$classification->code}}</td>
                            <td>{{$classification->type}}</td>
                            <td>{{$classification->description}}</td>
                            <td class="d-flex justify-content-start">
                                <div>
                                    <a href="{{route('admin.classificationEdit', $classification->code)}}" class="btn btn-sm btn-warning">Edit</a>
                                </div>
                                |
                                <div>
                                    <form method="POST" action="{{route('admin.classificationDestroy', $classification->code)}}">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm show-alert-delete-box" data-toggle="tooltip" title='Delete'>Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Data Kosong</td>
                        </tr>
                        @endforelse

                    </tbody>
                    <tfoot class="table-border-bottom-0">
                        <tr>
                            <th>Kode</th>
                            <th>Klasifikasi</th>
                            <th>Uraian</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                </table>
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
