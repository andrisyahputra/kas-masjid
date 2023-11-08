@extends('layouts.app_adminkit') <!-- Sesuaikan dengan layout Anda -->

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h1 class="h3 mb-3">Profil Masjid</h1>



    <div class="row">
        <div class="col">
            <div class="card">
                <div class="text-right m-3">
                    <a href="{{ route('profil.create') }}" class="btn btn-primary">Tambah Data</a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Keterangan</th>
                                <th>Pemasukkan</th>
                                <th>Pengeluaran</th>
                                <th>Saldo Akhir</th>
                                <th>Diinput Oleh</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($profils as $profil)
                                <tr>
                                    <td>{{ $profil->id }}</td>
                                    <td>{{ $profil->tanggal->translatedFormat('d-m-Y') }}</td>
                                    <td>{{ $profil->kategori ?? 'Umum' }}</td>
                                    <td>{{ $profil->keterangan }}</td>
                                    <td>
                                        {{ $profil->jenis == 'masuk' ? format_rupiah($profil->jumlah, true) : '-' }}
                                    </td>
                                    <td>
                                        {{ $profil->jenis == 'keluar' ? format_rupiah($profil->jumlah, true) : '-' }}
                                    </td>
                                    <td>{{ format_rupiah($profil->saldo_akhir, true) }}</td>
                                    <td>{{ $profil->createdBy->name }}</td>
                                    <td>
                                        <a href="{{ route('profil.edit', $profil->id) }}"
                                            class="btn btn-primary btn-sm">Edit</a>

                                        {!! Form::open([
                                            'method' => 'DELETE',
                                            'route' => ['profil.destroy', $profil->id],
                                            'style' => 'display:inline',
                                        ]) !!}
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
