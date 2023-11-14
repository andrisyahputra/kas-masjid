@extends('layouts.app_adminkit_laporan') <!-- Sesuaikan dengan layout Anda -->

@section('content')
    <h2 class="text-center m-5">LAPORAN DATA KURBAN TAHUN {{ $model->tahun_hijriah . 'H/' . $model->tahun_masehi }}</h2>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h3>Tahun Kurban {{ $model->tahun_hijriah . '/' . $model->tahun_masehi }}</h3>
                    </div>
                    <h6>
                        <i class="align-middle" data-feather="calendar"></i>
                        Tanggal Akhir Pendaftaran:
                        <b>{!! $model->tanggal_akhir_pendaftaran->format('d-m-Y') !!}</b>
                    </h6>
                    <h6>
                        <i class="align-middle" data-feather="user"></i>
                        Dibuat Oleh:
                        <b>{{ $model->createdBy->name }}</b>
                    </h6>
                    <p>Informasi :
                        {!! $model->konten !!}</p>
                    <hr>
                    <h3>Data Hewan Kurban</h3>


                    @if ($model->kurbanHewan->count() == 0)
                        <div class="text-center">Belum Ada Data Kurban</div>
                    @else
                        <table class="{{ config('app.table_style') }}">
                            <thead class="table-dark">
                                <tr>
                                    <td width="1%">No</td>
                                    <td>HEWAN</td>
                                    <td>IURAN</td>
                                    <td>HARGA</td>
                                    <td>BIAYA OPS</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($model->kurbanHewan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ ucfirst($item->hewan) }} ({{ $item->kriteria }})</td>
                                        <td>{{ format_rupiah($item->iuran_perorang, true) }}</td>
                                        <td>{{ $item->harga ? format_rupiah($item->harga, true) : '-' }}</td>
                                        <td>{{ format_rupiah($item->biaya_operasional, true) }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    <hr>
                    <h3>Data Peserta Hewan Kurban</h3>
                    {{-- modul peserta kurban --}}

                    @if ($model->kurbanPeserta->count() == 0)
                        <div class="text-center">Belum Ada Peserta Kurban</div>
                    @else
                        <table class="{{ config('app.table_style') }}">
                            <thead class="table-dark">
                                <tr>
                                    <td width="1%">No</td>
                                    <td>NAMA</td>
                                    <td>NO HP/WA</td>
                                    <td>ALAMAT</td>
                                    <td>JENIS HEWAN</td>
                                    <td>STATUS PEMBAYARAN</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($model->kurbanPeserta as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $item->peserta->nama }}
                                            <div>({{ $item->peserta->nama_tampilan }})</div>
                                        </td>
                                        <td>{{ $item->peserta->nohp }}</td>
                                        <td>{{ $item->peserta->alamat }}</td>
                                        <td>{{ ucwords($item->kurbanHewan->hewan) . ' - ' . $item->kurbanHewan->kriteria . ' - ' . format_rupiah($item->kurbanHewan->iuran_perorang) }}
                                        </td>
                                        <td>
                                            {{ $item->status }}
                                            @if ($item->status_bayar == 'lunas')
                                                <span class="badge bg-success">{{ $item->getStatusTeks() }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $item->getStatusTeks() }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="h4">Jumlah Peserta : {{ $model->kurbanPeserta->count() }}</div>
                        <div class="h4">Jumlah Peserta Sudah Baya :
                            {{ $model->kurbanPeserta->where('status_bayar', 'lunas')->count() }}</div>

                        <div class="h4">Total Iuran Peserta Sudah bayar Kurban =
                            {{ format_rupiah($model->kurbanPeserta->where('status_bayar', 'lunas')->sum('total_bayar'), true) }}
                        </div>
                        <div class="h4">Total Iuran Peserta Belum bayar Kurban =
                            {{ format_rupiah($model->kurbanPeserta->where('status_bayar', '!=', 'lunas')->sum('total_bayar'), true) }}
                        </div>
                        <div class="h4">Total Iuran Seluruh Peserta Kurban =
                            {{ format_rupiah($model->kurbanPeserta->sum('total_bayar'), true) }}</div>
                        {{-- modul peserta kurban --}}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
