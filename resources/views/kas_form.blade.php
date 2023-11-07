@extends('layouts.app_adminkit')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="card">
                    <div class="card-header">Tambah Data Kas</div>
                    <div class="card-body">
                        {!! Form::open(['route' => 'kas.store', 'method' => 'post']) !!}
                        <div class="mb-3">
                            {!! Form::label('masjid_id', 'Masjid ID', ['class' => 'form-label']) !!}
                            {!! Form::text('masjid_id', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="mb-3">
                            {!! Form::label('tanggal', 'Tanggal', ['class' => 'form-label']) !!}
                            {!! Form::date('tanggal', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="mb-3">
                            {!! Form::label('kategori', 'Kategori', ['class' => 'form-label']) !!}
                            {!! Form::text('kategori', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="mb-3">
                            {!! Form::label('keterangan', 'Keterangan', ['class' => 'form-label']) !!}
                            {!! Form::textarea('keterangan', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="mb-3">
                            {!! Form::label('jenis', 'Jenis', ['class' => 'form-label']) !!}
                            <div class="form-check">
                                {!! Form::radio('jenis', 'masuk', true, ['class' => 'form-check-input', 'id' => 'jenisMasuk']) !!}
                                {!! Form::label('jenisMasuk', 'Masuk', ['class' => 'form-check-label']) !!}
                            </div>
                            <div class="form-check">
                                {!! Form::radio('jenis', 'keluar', false, ['class' => 'form-check-input', 'id' => 'jenisKeluar']) !!}
                                {!! Form::label('jenisKeluar', 'Keluar', ['class' => 'form-check-label']) !!}
                            </div>
                        </div>
                        <div class="mb-3">
                            {!! Form::label('jumlah', 'Jumlah', ['class' => 'form-label']) !!}
                            {!! Form::text('jumlah', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="mb-3">
                            {!! Form::label('created_by', 'Dibuat oleh', ['class' => 'form-label']) !!}
                            {!! Form::text('created_by', null, ['class' => 'form-control']) !!}
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
