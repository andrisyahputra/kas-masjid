@extends('layouts.app_adminkit')
@section('js')
    <script>
        $(document).ready(function() {
            $('.pembayaran').hide()
            $('#status_bayar').change(function(e) {
                if ($(this).is(':checked')) {
                    $('.pembayaran').show()
                } else {
                    $('.pembayaran').hide()
                }
            });
        });
    </script>
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
                            {!! Form::label('nama', 'Nama Lengkap Peserta Kurban*', ['class' => 'form-label']) !!}
                            {!! Form::text('nama', null, [
                                'class' => 'form-control',
                                'placeholder' => 'Masukkan Nama Lengkap',
                                'autocomplete' => 'off',
                                'autofocus',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('nama') }}</span>
                        </div>


                        <div class="mb-3 form-group">
                            {!! Form::label('nama_tampilan', 'Nama Yang Ditampilkan Di Pengumuman*', ['class' => 'form-label']) !!}
                            {!! Form::text('nama_tampilan', $model->nama_tampilan ?? 'Hamba Allah', [
                                'class' => 'form-control',
                                'autocomplete' => 'off',
                                'placeholder' => 'Masukkan Nama Ditampilkan Di Pengumuman',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('nama_tampilan') }}</span>
                        </div>

                        <div class="mb-3 form-group">
                            {!! Form::label('nohp', 'Nama Yang Ditampilkan Di Pengumuman*', ['class' => 'form-label']) !!}
                            {!! Form::tel('nohp', null, [
                                'class' => 'form-control',
                                'placeholder' => 'Masukkan Nomor HP Atau WA',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('nohp') }}</span>
                        </div>

                        <div class="mb-3 form-group">
                            {!! Form::label('alamat', 'Alamat Peserta Hewan Kurban', ['class' => 'form-label']) !!}
                            {!! Form::textarea('alamat', null, [
                                'class' => 'form-control',
                                'rows' => 3,
                                'placeholder' => 'Masukkan Alamat Peserta',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('alamat') }}</span>
                        </div>
                        <div class="mb-3 form-group">
                            {!! Form::label('kurban_hewan_id', 'Pilih Hewan Kurban*', ['class' => 'form-label']) !!}
                            {!! Form::select('kurban_hewan_id', $hewans, null, [
                                'class' => 'form-control',
                                'placeholder' => 'Pilih Hewan Kurban',
                            ]) !!}
                            <span class="text-danger">{{ $errors->first('kurban_hewan_id') }}</span>
                        </div>

                        <div class="mb-3 form-group">
                            <div class="form-check">
                                {!! Form::checkbox('status_bayar', true, $model->status_bayar ?? false, [
                                    'class' => 'form-check-input',
                                    'id' => 'status_bayar',
                                ]) !!}
                                {!! Form::label('status_bayar', 'Sudah Melakukan Pembayaran', [
                                    'class' => 'form-check-label',
                                ]) !!}
                            </div>
                            <span class="text-danger">{{ $errors->first('status_bayar') }}</span>
                        </div>

                        <div class="pembayaran">
                            <h3>Data Pembayaran</h3>

                            <div class="alert alert-secondary" role="alert">
                                Jika Total Bayar Kosong, Maka Akan Automatis Iuran Perorang
                            </div>

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
