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
                    <table class="{{ config('app.table_style') }}">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Informasi</th>
                                <th>Diinput Oleh</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($models as $data)
                                <tr>
                                    <td>{{ $data->id }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $data->judul }}</div>
                                        {{ strip_tags($data->konten) }}
                                    </td>
                                    <td>{{ $data->createdBy->name }}</td>
                                    <td>


                                        {!! Form::open([
                                            'method' => 'DELETE',
                                            'route' => ['informasi.destroy', $data->id],
                                            'style' => 'display:inline',
                                        ]) !!}
                                        @csrf

                                        <a href="{{ route('informasi.edit', $data->id) }}"
                                            class="btn btn-primary btn-sm mb-1">Edit</a>

                                        <a href="{{ route('informasi.show', $data->id) }}"
                                            class="btn btn-primary btn-sm mb-1">Detail</a>

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
