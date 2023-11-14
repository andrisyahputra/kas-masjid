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
                        {{-- table->string('sumber')->comment('sumber infak, infak, perorang, instansi, kotak-amal, kotak-jumat');
            $table->string('atas-nama');
            $table->string('jenis')->comment('barang, uang');
            $table->bigInteger('jumlah')->comment('jumlah barang atau uang');
            $table->string('satuan'); --}}



                        <div class="mb-3 form-group">
                            {!! Form::label('sumber', 'Sumber Infak', ['class' => 'form-label']) !!}
                            {!! Form::select('sumber', $sumberList, null, [
                                'class' => 'form-control',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('sumber') }}</span>
                        </div>


                        <div class="mb-3 form-group">
                            {!! Form::label('jenis', 'Jenis Infak', ['class' => 'form-label']) !!}
                            <div class="form-check">
                                {!! Form::radio('jenis', 'uang', true, ['class' => 'form-check-input', 'id' => 'uang']) !!}
                                {!! Form::label('uang', 'Uang', ['class' => 'form-check-label']) !!}
                            </div>
                            <div class="form-check">
                                {!! Form::radio('jenis', 'barang', false, ['class' => 'form-check-input', 'id' => 'barang']) !!}
                                {!! Form::label('barang', 'Barang', ['class' => 'form-check-label']) !!}
                            </div>
                            <span class="text-danger">{{ $errors->first('jenis') }}</span>
                        </div>

                        <div class="mb-3 form-group">
                            {!! Form::label('atas_nama', 'Nama Keterangan Infak - Boleh Di Kosongkan', ['class' => 'form-label']) !!}
                            {!! Form::text('atas_nama', null, [
                                'class' => 'form-control',
                                'placeholder' => 'Atas Nama',
                                'autocomplete' => 'off',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('atas_nama') }}</span>
                        </div>


                        <div class="mb-3 form-group">
                            {!! Form::label('jumlah', 'Jumlah Infak', ['class' => 'form-label']) !!}
                            {!! Form::text('jumlah', null, [
                                'class' => 'form-control rupiah',
                                'placeholder' => 'Masukkan Jumlah Barang Atau Uang',
                                'autocomplete' => 'off',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('jumlah') }}</span>
                        </div>

                        <div class="mb-3 form-group">
                            {!! Form::label('satuan', 'Satuan Jumlah - Misalkan, kg, rupiah, atau sak(untuk semen)', [
                                'class' => 'form-label',
                            ]) !!}
                            {!! Form::text('satuan', $model->satuan ?? 'Rupiah', [
                                'class' => 'form-control',
                                'placeholder' => 'Masukkan Keterangan Satuan Barang Atau Uang',
                                'autocomplete' => 'off',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('satuan') }}</span>
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
