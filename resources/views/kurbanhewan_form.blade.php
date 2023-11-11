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
                        <div class="alert alert-secondary" role="alert">
                            <strong>Tanda * Wajib Di Isi</strong>
                        </div>


                        {!! Form::model($model, [
                            'route' => $route,
                            'method' => $method,
                        ]) !!}

                        {!! Form::hidden('kurban_id', $kurban->id, []) !!}


                        <div class="mb-3 form-group">
                            {!! Form::label('hewan', 'Jenis Hewan*', ['class' => 'form-label']) !!}
                            {!! Form::select(
                                'hewan',
                                [
                                    'sapi' => 'Sapi',
                                    'kerbau' => 'Kerbau',
                                    'kambing' => 'Kambing',
                                    'domba' => 'Domba',
                                    'onta' => 'Onta',
                                ],
                                null,
                                [
                                    'class' => 'form-control',
                                    'placeholder' => 'Pilih Hewan Kurban',
                                ],
                            ) !!}
                            <span class="text-danger">{{ $errors->first('hewan') }}</span>
                        </div>

                        <div class="mb-3 form-group">
                            {!! Form::label('kriteria', 'Kriteria Hewan (Misalkan: Kambing Super)', ['class' => 'form-label']) !!}
                            {!! Form::text('kriteria', $model->kriteria ?? 'Standar', [
                                'class' => 'form-control',
                                'placeholder' => 'Masukkan Jenis Kriteria Kurban',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('kriteria') }}</span>
                        </div>

                        <div class="mb-3 form-group">
                            {!! Form::label('harga', 'Harga Hewan Kurban', ['class' => 'form-label']) !!}
                            {!! Form::text('harga', null, [
                                'class' => 'form-control rupiah',
                                'placeholder' => 'Masukkan Harga Hewan Kurban',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('harga') }}</span>
                        </div>

                        <div class="mb-3 form-group">
                            {!! Form::label('iuran_perorang', 'Iuran Perorang*', ['class' => 'form-label']) !!}
                            {!! Form::text('iuran_perorang', null, [
                                'class' => 'form-control rupiah',
                                'placeholder' => 'Masukkan Nominal Iuran Perorang',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('iuran_perorang') }}</span>
                        </div>

                        <div class="mb-3 form-group">
                            {!! Form::label('biaya_operasional', 'Biaya Operasional', ['class' => 'form-label']) !!}
                            {!! Form::text('biaya_operasional', null, [
                                'class' => 'form-control rupiah',
                                'placeholder' => 'Masukkan Biaya Operasional',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('biaya_operasional') }}</span>
                        </div>





                        <div class="text-center">
                            {!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}
                            <a class="btn btn-secondary mx-2" href="{{ route('kurban.show', $kurban->id) }}">Kembali</a>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
