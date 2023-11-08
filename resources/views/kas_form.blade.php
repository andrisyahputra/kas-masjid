@extends('layouts.app_adminkit')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="card">
                    <div class="card-header">Form Transaksi Kas</div>
                    <div class="card-body">
                        <h4>Saldo Akhir Tersisa Saat ini : {{ format_rupiah($saldoAkhir, true) }}</h4>
                        {!! Form::model($kas, [
                            'route' => isset($kas->id) ? ['kas.update', $kas->id] : 'kas.store',
                            'method' => isset($kas->id) ? 'PUT' : 'POST',
                        ]) !!}

                        <div class="mb-3 form-group">
                            {!! Form::label('tanggal', 'Tanggal', ['class' => 'form-label']) !!}
                            {!! Form::date('tanggal', $kas->tanggal ?? now(), [
                                'class' => 'form-control',
                                'placeholder' => 'Masukkan Tanngal',
                            ]) !!}

                        </div>
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
                            {!! Form::text('jumlah', null, ['class' => 'form-control rupiah', 'placeholder' => 'Masukkan Nominal']) !!}
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
