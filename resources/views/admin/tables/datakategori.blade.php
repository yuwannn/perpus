@extends('layouts.main')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                @if (session()->has('Success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('Success') }}
                        <button type="button" class="btn-close" data-bs-dismiss='alert' aria-label="Close"></button>
                    </div>
                @endif
                @if (session()->has('delete'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('delete') }}
                        <button type="button" class="btn-close" data-bs-dismiss='alert' aria-label="Close"></button>
                    </div>
                @endif
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Data Buku</h4>
                            <button class="badge badge-success text-success mb-3" data-bs-toggle="modal"
                                data-bs-target="#createModal">Tambah Kategori</button>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                                Kategori ID
                                            </th>
                                            <th>
                                                Nama Kategori
                                            </th>
                                            <th>
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->kategoriid }}</td>
                                                <td>{{ $item->namakategori }}</td>
                                                <td>
                                                    <button class="badge badge-danger" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $item->kategoriid }}"><i
                                                            class="bi bi-trash text-danger"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

{{-- Create Modal  --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Kategori</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('kategori.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label for="namakategori" class="col-form-label">Nama Kategori:</label>
                                <input type="text" class="form-control" name="namakategori" id="namakategori" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-block btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach ($data as $item)
    <!-- modal delete -->
    <div class="modal fade" id="deleteModal{{ $item->kategoriid }}" tabindex="-1" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Apakah anda yakin menghapus data Buku?</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Klik Hapus Jika Sudah Yakin</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form action="{{ url('admin/kategori/' . $item->kategoriid) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="submit" class="btn btn-danger btn-icon">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach