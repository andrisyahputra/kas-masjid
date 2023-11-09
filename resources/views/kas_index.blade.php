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
                <div class="ms-3 me-3 mt-3">
                    {!! Form::open([
                        'url' => url()->current(),
                        'method' => 'GET',
                        'class' => 'row row-cols-lg-auto align-items-center',
                    ]) !!}
                    <div class="col-auto">
                        <a href="{{ route('kas.create') }}" class="btn btn-primary">Tambah Data</a>
                    </div>
                    <div class="col-auto ms-auto">
                        <label for="autoSizingInput">Tanggal Tranksaksi</label>
                        {!! Form::date('tanggal', request('tanggal'), ['class' => 'form-control']) !!}
                    </div>

                    <div class="col-auto">
                        <label for="autoSizingSelect">Keterangan Tranksaksi</label>
                        {!! Form::text('q', request('q'), [
                            'class' => 'form-control',
                            'placeholder' => 'masukkan Tranksaksi',
                        ]) !!}
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tanggal</th>
                                    <th>Diinput Oleh</th>
                                    <th>Kategori</th>
                                    <th>Keterangan</th>
                                    <th>Pemasukkan</th>
                                    <th>Pengeluaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kasList as $kas)
                                    <tr>
                                        <td>{{ $kas->id }}</td>
                                        <td>{{ $kas->tanggal->translatedFormat('d-m-Y') }}</td>
                                        <td>{{ $kas->createdBy->name }}</td>
                                        <td>{{ $kas->kategori ?? 'Umum' }}</td>
                                        <td>{{ $kas->keterangan }}</td>
                                        <td class="text-end">
                                            {{ $kas->jenis == 'masuk' ? format_rupiah($kas->jumlah, true) : '-' }}
                                        </td>
                                        <td class="text-end">
                                            {{ $kas->jenis == 'keluar' ? format_rupiah($kas->jumlah, true) : '-' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('kas.edit', $kas->id) }}"
                                                class="btn btn-primary btn-sm">Edit</a>

                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'route' => ['kas.destroy', $kas->id],
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
                            <tfoot>
                                <td class="text-center fw-bold" colspan="5">Total</td>
                                <td class="text-end">
                                    {{ format_rupiah($pemasukkan, true) }}</td>
                                <td class="text-end">
                                    {{ format_rupiah($pengeluaran, true) }}</td>
                            </tfoot>
                        </table>
                    </div>
                    <h2>Saldo Terakhir adalah Rp. {{ format_rupiah($saldoAkhir) }} </h2>
                    {{ $kasList->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
