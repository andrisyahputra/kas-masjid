@extends('layouts.app_adminkit') <!-- Sesuaikan dengan layout Anda -->

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h1 class="h3 mb-3">{{ $title }}</h1>



    <div class="row">
        <div class="col">
            <div class="card">
                <div class="text-right m-3">
                    <a href="{{ route('informasi.create') }}" class="btn btn-primary">Tambah Data</a>
                </div>
                <div class="card-body">
                    <h3>Tahun Kurban {{ $model->tahun_hijriah . '/' . $model->tahun_masehi }}</h3>
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

                    @if ($model->kurbanHewan->count() >= 1)
                        <div class="text-center"><a class="btn btn-success mb-3"
                                href="{{ route('kurbanhewan.create', [
                                    'kurban_id' => $model->id,
                                ]) }}">Buat
                                Baru</a></div>
                    @endif


                    @if ($model->kurbanHewan->count() == 0)
                        <div class="text-center">Belum Ada Data Kurban <a
                                href="{{ route('kurbanhewan.create', [
                                    'kurban_id' => $model->id,
                                ]) }}">Buat
                                Baru</a></div>
                    @else
                        <table class="{{ config('app.table_style') }}">
                            <thead>
                                <tr>
                                    <td width="1%">No</td>
                                    <td>HEWAN</td>
                                    <td>IURAN</td>
                                    <td>HARGA</td>
                                    <td>BIAYA OPS</td>
                                    <td>AKSI</td>
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
                                        <td>
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'route' => ['kurbanhewan.destroy', [$item->id, 'kurban_id' => $item->kurban_id]],
                                                'style' => 'display:inline',
                                            ]) !!}
                                            @csrf

                                            <a href="{{ route('kurbanhewan.edit', [$item->id, 'kurban_id' => $item->kurban_id]) }}"
                                                class="btn btn-primary btn-sm mb-1">Edit</a>

                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    <hr>
                    <h3>Data Peserta Hewan Kurban</h3>
                    {{-- modul peserta kurban --}}
                    @if ($model->kurbanPeserta->count() >= 1)
                        <div class="text-center"><a class="btn btn-success mb-3"
                                href="{{ route('kurbanpeserta.create', [
                                    'kurban_id' => $model->id,
                                ]) }}">Pendaftaran
                                Baru</a></div>
                    @endif

                    @if ($model->kurbanPeserta->count() == 0)
                        <div class="text-center">Belum Ada Peserta Kurban<a
                                href="{{ route('kurbanpeserta.create', [
                                    'kurban_id' => $model->id,
                                ]) }}">Buat
                                Baru</a></div>
                    @else
                        <table class="{{ config('app.table_style') }}">
                            <thead>
                                <tr>
                                    <td width="1%">No</td>
                                    <td>NAMA</td>
                                    <td>NO HP/WA</td>
                                    <td>ALAMAT</td>
                                    <td>JENIS HEWAN</td>
                                    <td>STATUS PEMBAYARAN</td>
                                    <td>AKSI</td>
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
                                        <td>
                                            {{ $item->status }}
                                            @if ($item->status_bayar == 'lunas')
                                                <span class="badge bg-success">{{ $item->getStatusTeks() }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $item->getStatusTeks() }}</span>
                                            @endif
                                        </td>
                                        <td>{{ ucwords($item->kurbanHewan->hewan) . ' - ' . $item->kurbanHewan->kriteria . ' - ' . format_rupiah($item->kurbanHewan->iuran_perorang) }}
                                        </td>
                                        <td>
                                            @if ($item->status_bayar != 'lunas')
                                                {!! Form::open([
                                                    'method' => 'DELETE',
                                                    'route' => ['kurbanpeserta.destroy', [$item->id, 'kurban_id' => $item->kurban_id]],
                                                    'style' => 'display:inline',
                                                ]) !!}
                                                @csrf

                                                <a href="{{ route('kurbanpeserta.edit', [$item->id, 'kurban_id' => $item->kurban_id]) }}"
                                                    class="btn btn-primary btn-sm mb-1">Pembayaran Kurban</a>

                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                                                {!! Form::close() !!}
                                            @else
                                                Sudah Lunas
                                            @endif
                                            {{-- {{ dd($model->id) }} --}}

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- modul peserta kurban --}}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
