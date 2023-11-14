@extends('layouts.app_adminkit') <!-- Sesuaikan dengan layout Anda -->
@section('js')
    <script>
        $(document).ready(function() {
            $('#cetak').click(function(e) {
                var tanggal_mulai = $('#tanggal_mulai').val();
                var tanggal_selesai = $('#tanggal_selesai').val();
                var q = $('#q').val();
                // alert(tanggal_mulai + ' ' + tanggal_selesai + ' ' + q);
                params = "?page=laporan&tanggal_mulai=" + tanggal_mulai + "&tanggal_selesai=" +
                    tanggal_selesai + "&q=" +
                    q;

                window.open("/item" + params, "_blank")
            });
        });
    </script>
@endsection
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h1 class="h3 mb-3">Infak Masjid</h1>



    <div class="row">
        <div class="col">
            <div class="card">
                <div class="ms-3 me-3 mt-3">
                    {!! Form::open([
                        'url' => url()->current(),
                        'method' => 'GET',
                    ]) !!}

                    <div class="d-flex align-items-center mb-3">
                        <div class="me-auto p-2">
                            <a href="{{ route('infak.create') }}" class="btn btn-primary">Tambah
                                Data</a>
                        </div>
                        <div class="p-2">
                            <label for="autoSizingInput">Tanggal Mulai Tranksaksi</label>
                            {!! Form::date('tanggal_mulai', request('tanggal_mulai') ?? now(), [
                                'class' => 'form-control',
                                'id' => 'tanggal_mulai',
                            ]) !!}
                        </div>
                        <div class="p-2">
                            <label for="autoSizingInput">Tanggal Selesai Tranksaksi</label>
                            {!! Form::date('tanggal_selesai', request('tanggal_selesai'), [
                                'class' => 'form-control',
                                'id' => 'tanggal_selesai',
                            ]) !!}
                        </div>
                        <div class="p-2">
                            <label for="autoSizingSelect">Keterangan Tranksaksi</label>
                            {!! Form::text('q', request('q'), [
                                'class' => 'form-control',
                                'placeholder' => 'masukkan Tranksaksi',
                                'id' => 'q',
                            ]) !!}
                        </div>
                        <div class="p-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button target="blank" type="button" class="btn btn-primary" id="cetak">Cetak
                                Laporan</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="{{ config('app.table_style') }}">
                            <thead>
                                {{-- table->string('sumber')->comment('sumber infak, infak, perorang, instansi, kotak-amal, kotak-jumat');
            $table->string('atas-nama');
            $table->string('jenis')->comment('barang, uang');
            $table->bigInteger('jumlah')->comment('jumlah barang atau uang');
            $table->string('satuan'); --}}
                                <tr>
                                    <th width="1%">Nomor</th>
                                    <th>Diinput Oleh</th>
                                    <th>Tanggal</th>
                                    <th>Sumber</th>
                                    <th>Jenis</th>
                                    {{-- <th>Kategori</th> --}}
                                    <th>Keterangan</th>
                                    <th>Jumlah</th>
                                    {{-- <th>Satuan</th> --}}
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($model as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->createdBy->name }}</td>
                                        <td>{{ $item->created_at->translatedFormat('d-m-Y') }}</td>
                                        {{-- <td>{{ $item->kategori ?? 'Umum' }}</td> --}}
                                        <td>{{ $item->sumber }}</td>
                                        <td>{{ $item->jenis }}</td>
                                        <td>{{ $item->atas_nama }}</td>
                                        <td class="text-end">
                                            @if ($item->jenis == 'uang')
                                                {{ format_rupiah($item->jumlah, true) }}
                                            @else
                                                {{ $item->jumlah }} {{ $item->satuan }}
                                            @endif
                                        </td>
                                        <td>

                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'route' => ['infak.destroy', $item->id],
                                                'style' => 'display:inline',
                                            ]) !!}
                                            @csrf

                                            <a href="{{ route('infak.edit', $item->id) }}"
                                                class="btn btn-primary btn-sm mb-1">Edit</a>

                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                {{-- <td class="text-center fw-bold" colspan="4">Total</td>
                                <td class="text-end">
                                    {{ format_rupiah($pemasukkan, true) }}</td>
                                <td class="text-end">
                                    {{ format_rupiah($pengeluaran, true) }}</td> --}}
                            </tfoot>
                        </table>
                    </div>
                    {{-- <h2>Saldo Terakhir adalah Rp. {{ format_rupiah($saldoAkhir) }} </h2> --}}
                    {{ $model->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
