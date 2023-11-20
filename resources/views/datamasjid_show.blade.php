@extends('layouts.app_front')
@section('content')
    <main class="container">
        <div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
            <img class="me-3" src="{{ asset('images/logo.svg') }}" alt="" width="50" height="50" />
            <div class="lh-1">
                <h1 class="h6 mb-0 text-white lh-1">{{ $model->nama }}</h1>
                <small>{{ $model->alamat }}</small>
            </div>
        </div>

        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h6 class="border-bottom pb-2 mb-0">Informasi KAS Masjid</h6>
            <div class="table-responsive">
                <table class="table table-primary table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" width="1%">No</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col" class="text-center">Jenis</th>
                            <th scope="col" class="text-end">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kas as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tanggal->translatedFormat('d F Y') }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td class="text-center">
                                    @if ($item->jenis == 'masuk')
                                        <span class="badge bg-success">Masuk</span>
                                    @else
                                        <span class="badge bg-warning">Keluar</span>
                                    @endif
                                </td>
                                <td class="text-end">{{ format_rupiah($item->jumlah, true) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Data TIDAK ADA</td>
                            </tr>
                        @endforelse


                    </tbody>
                </table>
                <h4 class="text-end">Saldo Akhir: {{ format_rupiah($model->saldo_akhir, true) }}</h4>
            </div>



            <small class="d-block text-end mt-3">
                <a href="{{ route('login') }}">Login Sebagai Pengurus</a>
            </small>
        </div>
    </main>
@endsection
