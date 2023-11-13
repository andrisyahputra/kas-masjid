<?php

namespace App\Http\Controllers;

use App\Models\Kurban;
use App\Models\KurbanHewan;
use App\Models\KurbanPeserta;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePesertaRequest;
use App\Http\Requests\StoreKurbanPesertaRequest;
use App\Http\Requests\UpdateKurbanPesertaRequest;
use App\Models\Peserta;

class KurbanPesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kurban = Kurban::userMasjid()->where('id', request('kurban_id'))->firstOrFail();
        $data['hewans'] = $kurban->kurbanHewan->pluck('nama_full', 'id');
        $data['model'] = new KurbanPeserta;
        $data['title'] = 'Tambah Data Peserta Kurban';
        $data['route'] = 'kurbanpeserta.store';
        $data['method'] = 'POST';
        $data['kurban'] = $kurban;
        return view('kurbanpeserta_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreKurbanPesertaRequest $requestKurbanPeserta,
        StorePesertaRequest $requestPeserta,
    ) {
        //
        $requestData = $requestPeserta->validated();
        DB::beginTransaction();
        $peserta = Peserta::create($requestData);
        $statusBayar = 'belum';

        if ($requestKurbanPeserta->filled('status_bayar')) {
            $statusBayar = 'lunas';
        }
        $requestKurbanPeserta = $requestKurbanPeserta->validated();
        $kurbanHewan = KurbanHewan::userMasjid()->where('id', $requestKurbanPeserta['kurban_hewan_id'])->firstOrFail();
        $requestKurbanPeserta['total_bayar'] = $requestKurbanPeserta['total_bayar'] ?? $kurbanHewan->iuran_perorang;
        $dataKurbanPeserta = [
            'kurban_id' => $kurbanHewan->kurban_id,
            'kurban_hewan_id' => $kurbanHewan->id,
            'peserta_id' => $peserta->id,
            'total_bayar' => $requestKurbanPeserta['total_bayar'],
            'tanggal_bayar' => $requestKurbanPeserta['tanggal_bayar'],
            'metode_bayar' => 'tunai',
            'bukti_bayar' => 'OK',
            'status_bayar' => strtolower($statusBayar),
        ];

        // dd($dataKurbanPeserta);
        KurbanPeserta::create($dataKurbanPeserta);

        DB::commit();

        Flash('Data Berhasil Disimpan')->success();
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(KurbanPeserta $kurbanPeserta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KurbanPeserta $kurbanPeserta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKurbanPesertaRequest $request, KurbanPeserta $kurbanPeserta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KurbanPeserta $kurbanpesertum)
    {
        // dd($kurbanpesertum);
        if ($kurbanpesertum->status_bayar == 'lunas') {
            flash('Data Tidak Berhasil Dihapus Karena Pembayaran Sudah Lunas')->success();
            return back();
        }
        $kurbanpesertum->delete();
        flash('Data Berhasil Dihapus')->success();
        return back();
    }
}
