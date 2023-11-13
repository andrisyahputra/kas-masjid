@extends('layouts.app_adminkit')
@section('js')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-md-offset-2">
                <div class="card">
                    <div class="card-header text-center">
                        <h3> {{ $title . ' ' . ucwords(auth()->user()->masjid->nama) }}</h3>
                    </div>
                    <div class="card-body">
                        <h4>Status Pembayaran :
                            {{ $model->getStatusTeks() }}
                        </h4>
                        <div class="alert alert-secondary" role="alert">
                            <strong>Tanda * Wajib Di Isi</strong>
                        </div>




                        {!! Form::model($model, [
                            'route' => $route,
                            'method' => $method,
                        ]) !!}
                        {{-- $table->foreignId('masjid_id')->index();
            $table->foreignId('created_by')->index();
            $table->string('nama');
            $table->string('nama_tampilan')->nullable();
            $table->string('nohp');
            $table->text('alamat'); --}}

                        {!! Form::hidden('kurban_id', $kurban->id, []) !!}

                        <div class="mb-3 form-group">
                            {!! Form::label('kurban_hewan_id', 'Pilih Hewan Kurban*', ['class' => 'form-label']) !!}
                            {!! Form::select('kurban_hewan_id', $hewans, null, [
                                'class' => 'form-control',
                                'placeholder' => 'Pilih Hewan Kurban',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('kurban_hewan_id') }}</span>
                        </div>


                        <div class="pembayaran">

                            <div class="mb-3 form-group">
                                {!! Form::label('total_bayar', 'Total Pembayaran', ['class' => 'form-label']) !!}
                                {!! Form::text('total_bayar', null, [
                                    'class' => 'form-control rupiah',
                                    'placeholder' => 'Masukkan Total Pembayaran',
                                ]) !!}
                                <span class="text-danger">{{ $errors->first('total_bayar') }}</span>
                            </div>

                            <div class="mb-3 form-group">
                                {!! Form::label('tanggal_bayar', 'Tanggal Pembayaran*', ['class' => 'form-label']) !!}
                                {!! Form::date('tanggal_bayar', $model->tanggal_bayar ?? now(), [
                                    'class' => 'form-control',
                                ]) !!}
                                <span class="text-danger">{{ $errors->first('tanggal_bayar') }}</span>
                            </div>
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
