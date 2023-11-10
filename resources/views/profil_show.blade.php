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
                    <a href="{{ route('profil.create') }}" class="btn btn-primary">Tambah Data</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-light">
                            <tr>
                                <td width="15%">Judul :</td>
                                <td>{{ $profil->judul }}</td>
                            </tr>
                            <tr>
                                <td>Konten :</td>
                                <td>{!! $profil->konten !!}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Posting :</td>
                                <td>{{ $profil->created_at->translatedFormat('H:s. l, d F Y') }}</td>
                            </tr>
                            <tr>
                                <td>Dibuat Oleh :</td>
                                <td>{{ $profil->createdBy->name }}</td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
