@extends('layouts.app_adminkit')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
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
                            {!! Form::label('nama', 'Nama Kategori', ['class' => 'form-label']) !!}
                            {!! Form::text('nama', null, [
                                'class' => 'form-control',
                                'placeholder' => 'Misalnya, Agenda, Informasi Pengajian dan Kategori Lainya ',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('nama') }}</span>
                        </div>

                        <div class="mb-3 form-group">
                            {!! Form::label('keterangan', 'Keterangan Kategori Profil', ['class' => 'form-label']) !!}
                            {!! Form::textarea('keterangan', null, [
                                'class' => 'form-control',
                                'placeholder' => 'Masukkan keterangan Masjid',
                                'id' => 'summernote',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('keterangan') }}</span>
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
