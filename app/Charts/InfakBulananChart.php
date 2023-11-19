<?php

namespace App\Charts;

use Carbon\Carbon;
use App\Models\Infak;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class InfakBulananChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $tahun = date('Y');
        $bulan = date('m');
        for ($i = 1; $i <= $bulan; $i++) {
            $totalInfak = Infak::userMasjid()->whereYear('created_at', $tahun)->whereMonth('created_at', $i)->sum('jumlah');
            // $dataBulan[] = Carbon::create()->month($i)->format('F');
            $dataBulan[] = ubahAngkaToBulan($i);
            $dataTotalBulan[] = $totalInfak;
        }
        // dd($dataTotalBulan);
        return $this->chart->lineChart()
            ->setTitle('Data Infak Bulanan')
            ->setSubtitle('Total Penerimaan Infak Setiap Bulan')
            ->addData('Total Infak', $dataTotalBulan)
            ->setHeight(280)
            ->setXAxis($dataBulan);
    }
}
