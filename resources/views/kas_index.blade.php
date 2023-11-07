@extends('layouts.app_adminkit') <!-- Sesuaikan dengan layout Anda -->

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h1 class="h3 mb-3">Kas Masjid</h1>



    <div class="row">
        <div class="col">
            <div class="card">
                <div class="text-right m-3">
                    <a href="{{ route('kas.create') }}" class="btn btn-primary">Tambah Data</a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Keterangan</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th>Saldo Akhir</th>
                                <th>Diinput Oleh</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kasList as $kas)
                                <tr>
                                    <td>{{ $kas->id }}</td>
                                    <td>{{ $kas->tanggal->translatedFormat('d-m-Y') }}</td>
                                    <td>{{ $kas->kategori ?? 'Umum' }}</td>
                                    <td>{{ $kas->keterangan }}</td>
                                    <td>{{ $kas->jenis }}</td>
                                    <td>{{ format_rupiah($kas->jumlah, true) }}</td>
                                    <td>{{ format_rupiah($kas->saldo_akhir, true) }}</td>
                                    <td>{{ $kas->createdBy->name }}</td>
                                    <td>
                                        <a href="{{ route('kas.edit', $kas->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                        <form action="{{ route('kas.destroy', $kas->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $kasList->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
