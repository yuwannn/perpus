@extends('layouts.user')

@section('content')
    <section class="py-5">
        <div class="container px-5">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session()->has('berhasilpinjam'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('berhasilpinjam') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session()->has('gagalpinjam'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('gagalpinjam') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h2 class="fw-bolder fs-5 mb-4 ">Daftar Buku</h2>
            <div class="row gx-5">
                @foreach ($data as $item)
                    <div class="col-lg-4 mb-5 mx-auto">
                        <div class="card h-100 shadow border-0">
                            <img class="card-img-top mx-auto mt-3" src="{{ asset('asset/images/cover/' . $item->cover) }}"
                                alt="..." style="width: 250px; height:auto" />
                            <div class="card-body p-4">
                                <div class="badge bg-primary bg-gradient rounded-pill mb-2">
                                    @if ($category = $categories->where('kategoriid', $item->kategori)->first())
                                        {{ $category->namakategori }}
                                    @else
                                        Tidak Terkategori
                                    @endif
                                </div>
                                <a class="text-decoration-none link-dark stretched-link" data-bs-toggle="modal"
                                    data-bs-target="#detailModal{{ $item->bukuid }}" href="">
                                    <div class="h5 card-title mb-3">{{ $item->judul }}</div>
                                </a>
                                <p class="card-text mb-0">
                                    {{ substr($item->sinopsis, 0, 50) }}{{ strlen($item->sinopsis) > 100 ? '...' : '' }}
                                </p>
                            </div>
                            <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                <div class="d-flex align-items-end justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="small">
                                            <div class="fw-bold">{{ $item->penulis }}</div>
                                            <div class="text-muted">{{ $item->created_at }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection


@foreach ($data as $item)
    <div class="modal fade" id="detailModal{{ $item->bukuid }}" tabindex="-1" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Buku</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-5 my-auto">
                            <img class="mx-3 my-3" src="{{ asset('asset/images/cover/' . $item->cover) }}"
                                alt="" style="width: 270px; height: auto;">
                        </div>
                        <div class="col-sm-7">
                            <table class="table table-borderless">
                                <tr class="row">
                                    <td class="display-6 fw-bolder">{{ $item->judul }}</td>
                                    <td class="col-sm-2 badge bg-primary bg-gradient rounded-pill mb-2 text-white">
                                        @if ($category = $categories->where('kategoriid', $item->kategori)->first())
                                            {{ $category->namakategori }}
                                        @else
                                            Tidak Terkategori
                                        @endif
                                    </td>
                                    <td class="fs-5 mt-0">
                                        <span>{{ $item->penulis }}</span>
                                    </td>
                                    <td class="small">
                                        {{ $item->penerbit }}
                                    </td>
                                    <td class="small">
                                        {{ $item->tahunterbit }}
                                    </td>
                                    <td class="lead fs-6">
                                        {{ $item->sinopsis }}
                                    </td>
                                    <td>
                                        Stok Buku : {{ $item->stok }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-block btn-primary my-auto"
                                style="max-width: 8rem; height: 3rem" data-bs-target="#laporanModal{{ $item->bukuid }}"
                                data-bs-toggle="modal"><i class="bi bi-calendar3-range-fill"></i>
                                Pinjam
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endforeach

@foreach ($data as $item)
    <div class="modal fade" id="laporanModal{{ $item->bukuid }}" tabindex="-1" aria-labelledby="laporanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Generate Laporan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('/buku/peminjaman/'. $item->bukuid) }}" class="d-flex" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3">
                                <label for="judul" class="col-form-label">Judul:</label>
                                <input name="bukuid" type="hidden" value="{{ $item->bukuid }}">
                                <input type="text" class="form-control" name="judul" id="judul"
                                    value="{{ $item->judul }}">
                            </div>
                            <div class="modal-footer">
                                <div class="d-flex mb-3">
                                    <label for="inputQuantity" class="col-form-label mt-3 me-2">Jumlah buku
                                        :</label>
                                    <input type="num" class="form-control text-center me-5 mt-3"
                                        id="inputQuantity" value="1" name="stok" style="max-width: 3rem">
                                </div>
                                <button type="submit" class="btn btn-block btn-primary my-auto"
                                    style="max-width: 8rem; height: 3rem"><i class="bi bi-calendar3-range-fill"></i>
                                    Pinjam
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
@endforeach
