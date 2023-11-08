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
                            'route' => isset($profil->id) ? ['profil.update', $profil->id] : 'profil.store',
                            'method' => isset($profil->id) ? 'PUT' : 'POST',
                        ]) !!}


                        <div class="mb-3 form-group">
                            {!! Form::label('kategori', 'Kategori', ['class' => 'form-label']) !!}
                            {!! Form::text('kategori', null, ['class' => 'form-control', 'placeholder' => 'Masukkan Kategori']) !!}
                            <span class="text-danger">{{ $errors->first('kategori') }}</span>
                        </div>
                        <div class="mb-3 form-group">
                            {!! Form::label('keterangan', 'Keterangan', ['class' => 'form-label']) !!}
                            {!! Form::textarea('keterangan', null, ['class' => 'form-control', 'placeholder' => 'Masukkan Keterangan']) !!}
                            <span class="text-danger">{{ $errors->first('keterangan') }}</span>
                        </div>
                        <div class="mb-3 form-group">
                            {!! Form::label('jenis', 'Jenis', ['class' => 'form-label']) !!}
                            <div class="form-check">
                                {!! Form::radio('jenis', 'masuk', true, ['class' => 'form-check-input', 'id' => 'jenisMasuk']) !!}
                                {!! Form::label('jenisMasuk', 'Pemasukkan', ['class' => 'form-check-label']) !!}
                            </div>
                            <div class="form-check">
                                {!! Form::radio('jenis', 'keluar', false, ['class' => 'form-check-input', 'id' => 'jenisKeluar']) !!}
                                {!! Form::label('jenisKeluar', 'Pengeluaran', ['class' => 'form-check-label']) !!}
                            </div>
                            <span class="text-danger">{{ $errors->first('jenis') }}</span>
                        </div>
                        <div class="mb-3 form-group">
                            {!! Form::label('jumlah', 'Jumlah Tranksaksi', ['class' => 'form-label']) !!}
                            {!! Form::text('jumlah', null, [
                                'class' => 'form-control rupiah',
                                'placeholder' => 'Masukkan Nominal',
                                'autocomplete' => 'off',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('jumlah') }}</span>
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
