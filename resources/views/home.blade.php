@extends('layouts.app_adminkit')

@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">
            <strong>Analytics</strong> Dashboard
        </h1>

        <div class="row">
            <div class="col-xl-6 col-xxl-5 d-flex">
                <div class="w-100">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">
                                                Saldo Terakhir
                                            </h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <i class="align-middle" data-feather="truck"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">
                                        {{ format_rupiah($saldoAkhir, true) }}
                                    </h1>
                                    <div class="mb-0">
                                        <span class="text-danger">
                                            <i class="mdi mdi-arrow-bottom-right"></i>
                                            -3.65%
                                        </span>
                                        <span class="text-muted">Since last
                                            week</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">
                                                Infak Hari ini
                                            </h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <i class="align-middle" data-feather="users"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">
                                        {{ format_rupiah($totalInfak, true) }}
                                    </h1>
                                    <div class="mb-0">
                                        <span class="text-success">
                                            <i class="mdi mdi-arrow-bottom-right"></i>
                                            5.25%
                                        </span>
                                        <span class="text-muted">Since last
                                            week</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-xxl-7">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            Grafik Infak Bulanan
                        </h5>
                    </div>
                    <div class="card-body py-3">
                        <div class="chart chart-sm">
                            <canvas id="chartjs-dashboard-line"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8 col-xxl-9 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            Transaksi Kas Terbaru
                        </h5>
                    </div>
                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Keterangan</th>
                                <th class="d-none d-xl-table-cell">
                                    TGL Transaksi
                                </th>
                                <th class="d-none d-xl-table-cell">
                                    Jenis
                                </th>
                                <th class="d-none d-md-table-cell">
                                    Jumlah
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kas as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td class="d-none d-xl-table-cell">
                                        {{ $item->tanggal->format('d-m-Y') }}
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $item->jenis }}</span>
                                    </td>
                                    <td class="d-none d-xl-table-cell">
                                        {{ format_rupiah($item->jumlah, true) }}
                                    </td>
                                </tr>
                            @empty
                                <td class="text-center" colspan="5">Tidak Ada Data Kas</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-lg-4 col-xxl-3 d-flex">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            Monthly Sales
                        </h5>
                    </div>
                    <div class="card-body d-flex w-100">
                        <div class="align-self-center chart chart-lg">
                            <canvas id="chartjs-dashboard-bar"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
