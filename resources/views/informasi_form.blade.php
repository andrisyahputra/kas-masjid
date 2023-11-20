@extends('layouts.app_adminkit')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-md-offset-2">
                <div class="card">
                    <div class="card-header text-center">
                        <h3> {{ $title . ' ' . ucwords(auth()->user()->masjid->nama) }}</h3>
                    </div>
                    <div class="card-body">

                        {!! Form::model($model, [
                            'route' => $route,
                            'method' => $method,
                        ]) !!}

                        <div class="mb-3 form-group">
                            {!! Form::label('kategori_id', 'Kategori Informasi', ['class' => 'form-label']) !!}
                            {!! Form::select('kategori_id', $kategoris, null, [
                                'class' => 'form-control',
                                'placeholder' => 'Pilih Kategori Informasi Masjid',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('kategori_id') }}</span>
                        </div>

                        <div class="mb-3 form-group">
                            {!! Form::label('judul', 'Judul Kategori', ['class' => 'form-label']) !!}
                            {!! Form::text('judul', null, [
                                'class' => 'form-control',
                                'placeholder' => 'Misalnya, Agenda, Informasi Pengajian dan Kategori Lainya ',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('judul') }}</span>
                        </div>

                        <div class="mb-3 form-group">
                            {!! Form::label('konten', 'Konten Kategori Profil', ['class' => 'form-label']) !!}
                            {!! Form::textarea('konten', null, [
                                'class' => 'form-control',
                                'placeholder' => 'Masukkan konten Masjid',
                                'id' => 'summernote',
                            ]) !!}
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
