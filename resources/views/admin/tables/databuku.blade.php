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
                @if (session()->has('editsuccess'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('editsuccess') }}
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
                                data-bs-target="#createModal">Tambah Buku</button>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                                Judul
                                            </th>
                                            <th>
                                                Penulis
                                            </th>
                                            <th>
                                                Penerbit
                                            </th>
                                            <th>
                                                Tahun Terbit
                                            </th>
                                            <th>
                                                Sinopsi
                                            </th>
                                            <th>
                                                Kategori
                                            </th>
                                            <th>
                                                Stok Buku
                                            </th>
                                            <th>
                                                Cover
                                            </th>
                                            <th>
                                                Aksi
                                            </th>
                                            <th>
                                                Cetak Dokumen
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->judul }}</td>
                                                <td>{{ $item->penulis }}</td>
                                                <td>{{ $item->penerbit }}</td>
                                                <td>{{ $item->tahunterbit }}</td>
                                                <td>{{ $item->sinopsis }}</td>
                                                <td>
                                                    @if ($category = $categories->where('kategoriid', $item->kategori)->first())
                                                        {{ $category->namakategori }}
                                                    @else
                                                        Kategori Tidak Ditemukan
                                                    @endif
                                                </td>
                                                <td>{{ $item->stok }}</td>
                                                <td>{{ $item->cover }}</td>
                                                <td>
                                                    <button class="badge badge-primary" data-bs-toggle="modal"
                                                        data-bs-target="#infoModal{{ $item->bukuid }}"><i
                                                            class="bi bi-info-circle text-primary"></i></button>
                                                    <button class="badge badge-warning" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $item->bukuid }}"><i
                                                            class="bi bi-pencil-square text-warning"></i></button>
                                                    <button class="badge badge-danger" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $item->bukuid }}"><i
                                                            class="bi bi-trash text-danger"></i></button>
                                                </td>
                                                <td>#</td>
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
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Buku</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('buku.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="judul" class="col-form-label">Judul:</label>
                                <input type="text" class="form-control" name="judul" id="judul" required>
                            </div>
                            <div class="mb-3">
                                <label for="penulis" class="col-form-label">Penulis:</label>
                                <input type="text" class="form-control" name="penulis" id="penulis" required>
                            </div>
                            <div class="mb-3">
                                <label for="penerbit" class="col-form-label">Penerbit:</label>
                                <input type="text" class="form-control" name="penerbit" id="penerbit" required>
                            </div>
                            <div class="mb-3">
                                <label for="tahunterbit" class="col-form-label">Tahun Terbit:</label>
                                <input type="number" class="form-control" name="tahunterbit" id="tahunterbit"
                                    min="1900" max="2100" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="sinopsis" class="col-form-label">Sinopsis:</label>
                                <input type="text" class="form-control" name="sinopsis" id="sinopsis" required>
                            </div>
                            <div class="mb-3">
                                <label for="cover" class="col-form-label">Cover:</label>
                                <input type="file" class="form-control" name="cover" id="cover" required>
                            </div>
                            <div class="mb-3">
                                <label for="kategori" class="col-form-label">Kategori:</label>
                                <select class="form-select" aria-label="Default select example" name="kategori"
                                    id="kategori">
                                    <option selected>Pilih Kategori</option>
                                    @foreach ($categories as $kategori)
                                        <option value="{{ $kategori->kategoriid }}">
                                            {{ $kategori->namakategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="inputQuantity">Stok Buku</label>
                                <input type="number" class="form-control form-control-sm-6" name="stok" id="inputQuantity" required>
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
    <div class="modal fade" id="deleteModal{{ $item->bukuid }}" tabindex="-1" aria-labelledby="deleteModalLabel"
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
                    <form action="{{ url('admin/buku/' . $item->bukuid) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="submit" class="btn btn-danger btn-icon">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

{{-- Modal Edit --}}
@foreach ($data as $item)
    <div class="modal fade" id="editModal{{ $item->bukuid }}" tabindex="-1" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data Buku</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('admin/buku/' . $item->bukuid) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="judul" class="col-form-label">Judul:</label>
                                    <input type="text" class="form-control" name="judul" id="judul"
                                        value="{{ $item->judul }}">
                                </div>
                                <div class="mb-3">
                                    <label for="penulis" class="col-form-label">Penulis:</label>
                                    <input type="text" class="form-control" name="penulis" id="penulis"
                                        value="{{ $item->penulis }}">
                                </div>
                                <div class="mb-3">
                                    <label for="penerbit" class="col-form-label">Penerbit:</label>
                                    <input type="text" class="form-control" name="penerbit" id="penerbit"
                                        value="{{ $item->penerbit }}">
                                </div>
                                <div class="mb-3">
                                    <label for="tahunterbit" class="col-form-label">Tahun Terbit:</label>
                                    <input type="number" class="form-control" name="tahunterbit" id="tahunterbit"
                                        value="{{ $item->tahunterbit }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="sinopsis" class="col-form-label">Sinopsis:</label>
                                    <input type="text" class="form-control" name="sinopsis" id="sinopsis"
                                        value="{{ $item->sinopsis }}">
                                </div>
                                <div class="mb-3">
                                    <label for="kategori" class="col-form-label">Kategori:</label>
                                    <select class="form-select" aria-label="Default select example" name="kategori"
                                        id="kategori">
                                        <option selected>Pilih Kategori</option>
                                        @foreach ($categories as $kategori)
                                            <option value="{{ $kategori->kategoriid }}">
                                                {{ $kategori->namakategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="sinopsis" class="col-form-label">Stok:</label>
                                    <input type="number" class="form-control" name="sinopsis" id="sinopsis"
                                        value="{{ $item->stok }}">
                                </div>
                                <div class="mb-3">
                                    <label for="cover" class="col-form-label">Cover :</label>
                                    <input type="file" class="form-control" name="cover" id="cover"
                                        value="">
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
@endforeach

{{-- Modal Info --}}
@foreach ($data as $item)
    <div class="modal fade" id="infoModal{{ $item->bukuid }}" tabindex="-1" aria-labelledby="infoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Data Buku</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 d-flex">
                            <label for="judul" class="col-form-label">Judul:</label>
                            <input type="text" class="form-control ms-5" name="judul" id="judul"
                                value="{{ $item->judul }}" required>
                        </div>
                        <div class="mb-3 d-flex">
                            <label for="penulis" class="col-form-label">Penulis:</label>
                            <input type="text" class="form-control ms-5" name="penulis" id="penulis"
                                value="{{ $item->penulis }}" required>
                        </div>
                        <div class="mb-3 d-flex">
                            <label for="penerbit" class="col-form-label">Penerbit:</label>
                            <input type="text" class="form-control ms-5" name="penerbit" id="penerbit"
                                value="{{ $item->penerbit }}" required>
                        </div>
                    </div>
                    <div class="mb-3 d-flex">
                        <label for="tahunterbit" class="col-form-label">Tahun Terbit:</label>
                        <input type="number" class="form-control ms-5" name="tahunterbit" id="tahunterbit"
                            value="{{ $item->tahunterbit }}" required>
                    </div>
                    <div class="mb-3 d-flex">
                        <label for="sinopsis" class="col-form-label">Sinopsis:</label>
                        <input type="text" class="form-control ms-5" name="sinopsis" id="sinopsis"
                            value="{{ $item->sinopsis }}" required>
                    </div>
                    <div class="mb-3 d-flex">
                        <label for="kategori" class="col-form-label">Kategori:</label>
                        <input type="text" class="form-control ms-5" name="kategori" id="kategori"
                            value="{{ $item->kategori }}" required>
                    </div>
                    <div class="mb-3 d-flex">
                        <label for="kategori" class="col-form-label">Stok Buku:</label>
                        <input type="number" class="form-control ms-5" name="kategori" id="kategori"
                            value="{{ $item->stok }}" required>
                    </div>
                    <div class="mb-3 d-flex">
                        <label for="cover" class="col-form-label">Cover :</label>
                        <img src="{{ asset('asset/images/cover/' . $item->cover) }}" class="card-img ms-5"
                            alt="" style="width: 120px; height:auto;">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-block btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endforeach
