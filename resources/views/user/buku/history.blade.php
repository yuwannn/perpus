@extends('layouts.user')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <!-- Tampilkan notifikasi jika ada -->
                @if (session()->has('notification'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('notification') }}
                        <button type="button" class="btn-close" data-bs-dismiss='alert' aria-label="Close"></button>
                    </div>
                @endif
                <div class="col-lg-10 grid-margin stretch-card mx-auto mt-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Koleksi Pribadi {{ Auth::user()->namalengkap }}</h4>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                                User
                                            </th>
                                            <th>
                                                Buku
                                            </th>
                                            <th>
                                                Jumlah yang Dipinjam
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
                                                <td>
                                                    @if ($username = $user->where('id', $item->userid)->first())
                                                        {{ $username->username }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($coverbuku = $buku->where('bukuid', $item->bukuid)->first())
                                                        <img class="ms-1 mt-1"
                                                            src="{{ asset('asset/images/cover/' . $coverbuku->cover) }}"
                                                            alt="" style="width: 70px; height: auto;">
                                                    @endif
                                                </td>
                                                <td>{{ $item->tanggalpeminjaman }}</td>
                                                <td>{{ $item->tanggalpengembalian }}</td>
                                                <td>
                                                    @if ($item->statuspeminjaman == 'p')
                                                        <div class="alert alert-info alert-dismissible fade show"
                                                            role="alert">
                                                            <h4>Buku Sedang Diproses</h4>
                                                            <p>Tunggu Hingga Admin MengACC</p>
                                                        </div>
                                                    @else
                                                        @if ($item->statuspeminjaman == 'a')
                                                            <div class="alert alert-success alert-dismissible fade show"
                                                                role="alert">
                                                                <h4>ACC Admin</h4>
                                                                <p>Buku Sudah Bisa Diambil</p>
                                                            </div>
                                                        @elseif ($item->statuspeminjaman == 'm')
                                                            <div class="alert alert-warning alert-dismissible fade show"
                                                                role="alert">
                                                                <h4>Selamat Membaca</h4>
                                                                <p>Jangan Lupa Mengembalikan</p>
                                                            </div>
                                                        @elseif ($item->statuspeminjaman == 's')
                                                            <div class="alert alert-primary alert-dismissible fade show"
                                                                role="alert">
                                                                <h4>Terimakasih</h4>
                                                                <p>Telah Menggunakan Jasa Kami</p>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->statuspeminjaman == 'a')
                                                        {{-- <a href="{{ route('generate.pdf') }}" class="btn btn-success">Cetak Dokumen</a> --}}
                                                        <form action="{{ route('generate.pdf') }}" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            @if ($namabuku = $buku->where('bukuid', $item->bukuid)->first())
                                                                <input type="hidden" name="judul" value="{{ $namabuku->judul }}">
                                                            @endif
                                                            <input type="hidden" name="tanggalpeminjaman" value="{{ $item->tanggalpeminjaman }}"> 
                                                            <input type="hidden" name="tanggalpengembalian" value="{{ $item->tanggalpengembalian }}">
                                                            <button type="submit" class="btn btn-success">Cetak Dokumen</button>
                                                        </form>
                                                    @endif
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
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tampilkan notifikasi jika ada
            var notification = document.getElementById('notification');
            if (notification.innerText.trim() !== '') {
                notification.style.display = 'block';
            }

            // Tangani peristiwa tombol tutup notifikasi
            document.getElementById('close-notification').addEventListener('click', function() {
                document.getElementById('notification').style.display = 'none';
            });
        });
    </script>
@endsection
