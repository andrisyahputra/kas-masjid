@extends('layouts.app_adminkit_laporan') <!-- Sesuaikan dengan layout Anda -->

@section('content')
    <div class="h3 text-center">Kas Masjid {{ ucwords(auth()->user()->masjid->nama) }}</div>
    <p class="text-center mb-3">{{ ucwords(auth()->user()->masjid->alamat) }}</p>
    <div class="row m-3">
        <div class="col">
            <div class="table-responsive">
                <h5>Kas Laporan Masjid</h5>
                <table class="{{ config('app.table_style') }}">
                    <thead>
                        <tr>
                            <th width="1%">Nomor</th>
                            <th>Diinput Oleh</th>
                            <th>Tanggal</th>
                            {{-- <th>Kategori</th> --}}
                            <th>Keterangan</th>
                            <th>Pemasukkan</th>
                            <th>Pengeluaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kasList as $kas)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kas->createdBy->name }}</td>
                                <td>{{ $kas->tanggal->translatedFormat('d-m-Y') }}</td>
                                {{-- <td>{{ $kas->kategori ?? 'Umum' }}</td> --}}
                                <td>{{ $kas->keterangan }}</td>
                                <td class="text-end">
                                    {{ $kas->jenis == 'masuk' ? format_rupiah($kas->jumlah, true) : '-' }}
                                </td>
                                <td class="text-end">
                                    {{ $kas->jenis == 'keluar' ? format_rupiah($kas->jumlah, true) : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <td class="text-center fw-bold" colspan="4">Total</td>
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
@endsection
