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
                                                'route' => ['kurbanhewan.destroy', [$model->id, 'kurban_id' => $model->id]],
                                                'style' => 'display:inline',
                                            ]) !!}
                                            @csrf

                                            <a href="{{ route('kurbanhewan.edit', [$model->id, 'kurban_id' => $model->id]) }}"
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
                </div>
            </div>
        </div>
    </div>
@endsection
