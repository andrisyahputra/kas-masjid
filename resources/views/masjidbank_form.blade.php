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
                            {!! Form::label('nama_bank', 'Nama Bank', ['class' => 'form-label']) !!}
                            {!! Form::select('bank_id', $listBank, $id_bank ?? null, [
                                'class' => 'form-control select2',
                                'placeholder' => 'Pilih Bank',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('nama_bank') }}</span>
                        </div>

                        <div class="mb-3 form-group">
                            {!! Form::label('nama_rekening', 'Nama Pemilik Rekening', ['class' => 'form-label']) !!}
                            {!! Form::text('nama_rekening', null, [
                                'class' => 'form-control',
                                'placeholder' => 'Masukkan Nama Rekening',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('nama_rekening') }}</span>
                        </div>

                        <div class="mb-3 form-group">
                            {!! Form::label('nomor_rekening', 'Nomor Rekening', ['class' => 'form-label']) !!}
                            {!! Form::text('nomor_rekening', null, [
                                'class' => 'form-control',
                                'placeholder' => 'Masukkan No Rekening',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('nomor_rekening') }}</span>
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
