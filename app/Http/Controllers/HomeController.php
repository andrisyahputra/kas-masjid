<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        $data['saldoAkhir'] = Kas::saldoAkhir();
        $data['totalInfak'] = Infak::userMasjid()->whereDate('created_at', now()->format('Y-m-d'))->sum('jumlah');
        $data['kas'] = Kas::userMasjid()->latest()->take(7)->get();
        return view('home', $data);
    }
}
