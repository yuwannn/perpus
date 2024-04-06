@extends('layouts.main')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                @if (session()->has('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss='alert' aria-label="Close"></button>
                    </div>
                @endif
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Data Peminjaman</h4>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                                UserId
                                            </th>
                                            <th>
                                                BukuId
                                            </th>
                                            <th>
                                                Tanggal Peminjaman
                                            </th>
                                            <th>
                                                Tanggal Pengembalian
                                            </th>
                                            <th>
                                                Status Peminjaman
                                            </th>
                                            <th>
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->userid }}</td>
                                                <td>{{ $item->bukuid }}</td>
                                                <td>{{ $item->tanggalpeminjaman }}</td>
                                                <td>{{ $item->tanggalpengembalian }}</td>
                                                <td>{{ $item->statuspeminjaman }}</td>
                                                <td>
                                                    <button class="badge badge-warning" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $item->peminjamanid }}"><i
                                                            class="bi bi-pencil-square text-warning"></i></button>
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

    {{-- Modal Edit --}}
    @foreach ($data as $item)
        <div class="modal fade" id="editModal{{ $item->peminjamanid }}" tabindex="-1" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Rubah Status Peminjaman</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('admin/peminjaman/' . $item->peminjamanid) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="mb-3">    
                                    <label for="statuspeminjaman" class="col-form-label">Status Peminjaman:</label>
                                    <select class="form-select" aria-label="Default select example" name="statuspeminjaman" id="statuspeminjaman">
                                        <option selected>Status</option>
                                        <option value="a">ACC Peminjaman</option>
                                        <option value="m">Meminjam</option>
                                        <option value="s">Sudah Dikembalikan</option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                        <button type="submit" class="btn btn-block btn-primary">Simpan</button>
                                    </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
