<?php

namespace App\Http\Controllers;

use App\Charts\InfakBulananChart;
use App\Models\Kas;
use App\Models\Infak;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(InfakBulananChart $chart)
    {
        $tahun = date('Y');
        $bulan = date('m');
        for ($i = 1; $i <= $bulan; $i++) {
            $totalInfak = Infak::userMasjid()->whereYear('created_at', $tahun)->whereMonth('created_at', $i)->sum('jumlah');
            // $dataBulan[] = Carbon::create()->month($i)->format('F');
            $dataBulan[] = ubahAngkaToBulan($i);
            $dataTotalBulan[] = $totalInfak;
        }

        $data['dataBulan'] = $dataBulan;
        $data['dataTotalBulan'] = $dataTotalBulan;
        $data['chart'] = $chart->build();
        $data['saldoAkhir'] = Kas::saldoAkhir();
        $data['totalInfak'] = Infak::userMasjid()->whereDate('created_at', now()->format('Y-m-d'))->sum('jumlah');
        $data['kas'] = Kas::userMasjid()->latest()->take(7)->get();
        return view('home', $data);
    }
}
