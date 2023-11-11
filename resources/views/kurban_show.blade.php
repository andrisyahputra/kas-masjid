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
                    @if ($model->kurbanHewan->count() == 0)
                        <div class="text-center">Belum Ada Data Kurban <a
                                href="{{ route('kurbanhewan.create', [
                                    'kurban._id' => $model->id,
                                ]) }}">Buat
                                Baru</a></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
