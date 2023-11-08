@extends('layouts.app_adminkit')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="card">
                    <div class="card-header">
                        <h3>Profil Masjid {{ strtoupper(auth()->user()->masjid->nama) }}</h3>
                    </div>
                    <div class="card-body">

                        {!! Form::model($profil, [
                            'route' => $route,
                            'method' => $method,
                        ]) !!}


                        <div class="mb-3 form-group">
                            {!! Form::label('kategori', 'Kategori', ['class' => 'form-label']) !!}
                            {!! Form::select('kategori', $listKategori, null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('kategori') }}</span>
                        </div>

                        <div class="mb-3 form-group">
                            {!! Form::label('judul', 'Judul', ['class' => 'form-label']) !!}
                            {!! Form::text('judul', null, ['class' => 'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('judul') }}</span>
                        </div>

                        <div class="mb-3 form-group">
                            {!! Form::label('konten', 'Konten / Isi Profil', ['class' => 'form-label']) !!}
                            {!! Form::textarea('konten', null, ['class' => 'form-control', 'placeholder' => 'Masukkan Konten Profil']) !!}
                            <span class="text-danger">{{ $errors->first('konten') }}</span>
                        </div>

                        <div class="text-center">
                            {!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
