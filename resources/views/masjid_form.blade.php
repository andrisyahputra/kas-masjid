@extends('layouts.app_adminkit')

@section('content')
    <h1 class="h3 mb-3 text-center">Form E-Mesjid</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        Silakan Isi data Pengolah
                    </h5>
                </div>
                <div class="card-body">
                    {!! Form::model($masjid, [
                        'route' => 'masjid.store',
                        'method' => 'POST',
                    ]) !!}

                    <div class="mb-3 form-group">
                        <label for="nama" class="form-label">Nama Masjid</label>
                        <div class="input-group">
                            <span class="input-group-text">Masjid</span>
                            {!! Form::text('nama', null, ['class' => 'form-control', 'placeholder' => 'Masukkan Nama']) !!}
                        </div>

                        <span class="text-danger">{!! $errors->first('nama') !!}</span>
                    </div>

                    <div class="mb-3 form-group">
                        <label for="alamat" class="form-label">Alamat Masjid</label>
                        {!! Form::text('alamat', null, ['class' => 'form-control', 'placeholder' => 'Masukkan Alamat']) !!}
                        <span class="text-danger">{!! $errors->first('alamat') !!}</span>
                    </div>

                    <div class="mb-3 form-group">
                        <label for="telp" class="form-label">No Wa/No Telp Masjid</label>
                        {!! Form::tel('telp', null, ['class' => 'form-control', 'placeholder' => 'Masukkan nomor telepon/WA']) !!}
                        <span class="text-danger">{!! $errors->first('telp') !!}</span>
                    </div>

                    <div class="mb-3 form-group">
                        <label for="email" class="form-label">Email Masjid</label>
                        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Masukkan Email']) !!}
                        <span class="text-danger">{!! $errors->first('email') !!}</span>
                    </div>

                    {!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
