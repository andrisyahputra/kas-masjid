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
                            {!! Form::label('tahun_hijriah', 'Tahun Hijriah', ['class' => 'form-label']) !!}
                            {!! Form::selectRange('tahun_hijriah', 1945, 1960, null, [
                                'class' => 'form-control',
                                'placeholder' => 'Pilih Tahun Hijriah',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('judul') }}</span>
                        </div>

                        <div class="mb-3 form-group">
                            {!! Form::label('tahun_masehi', 'Tahun Masehi', ['class' => 'form-label']) !!}
                            {!! Form::selectRange('tahun_masehi', 2023, date('Y'), null, [
                                'class' => 'form-control',
                                'placeholder' => 'Pilih Tahun Masehi',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('tahun_masehi') }}</span>
                        </div>

                        <div class="mb-3 form-group">
                            {!! Form::label('tanggal_akhir_pendaftaran', 'Tanggal Akhir Pembayaran', ['class' => 'form-label']) !!}
                            {!! Form::date('tanggal_akhir_pendaftaran', now(), [
                                'class' => 'form-control',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('tanggal_akhir_pendaftaran') }}</span>
                        </div>

                        <div class="mb-3 form-group">
                            {!! Form::label('konten', 'Informasi / Pengumuman Kurban', ['class' => 'form-label']) !!}
                            {!! Form::textarea('konten', null, [
                                'class' => 'form-control',
                                'placeholder' => 'Masukkan konten Informasi Kurban',
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
