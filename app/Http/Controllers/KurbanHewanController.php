<?php

namespace App\Http\Controllers;

use App\Models\KurbanHewan;
use App\Http\Requests\StoreKurbanHewanRequest;
use App\Http\Requests\UpdateKurbanHewanRequest;
use App\Models\Kurban;

class KurbanHewanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kurban = Kurban::userMasjid()->where('id', request('kurban_id'))->firstOrFail();
        $data['model'] = new KurbanHewan;
        $data['title'] = 'Tambah Data Hewan Kurban';
        $data['route'] = 'kurbanhewan.store';
        $data['method'] = 'POST';
        $data['kurban'] = $kurban;
        return view('kurbanhewan_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKurbanHewanRequest $request)
    {
        // dd($request->validated());
        KurbanHewan::create($request->validated());
        flash('Data Berhasil Disimpan');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(KurbanHewan $kurbanHewan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KurbanHewan $kurbanhewan)
    {
        $kurban = Kurban::userMasjid()->where('id', request('kurban_id'))->firstOrFail();
        $data['model'] = $kurbanhewan;
        $data['title'] = 'Ubah Data Hewan Kurban';
        $data['route'] = ['kurbanhewan.update', $kurbanhewan->id];
        $data['method'] = 'PUT';
        $data['kurban'] = $kurban;
        return view('kurbanhewan_form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKurbanHewanRequest $request, KurbanHewan $kurbanhewan)
    {
        $kurbanhewan->update($request->validated());
        flash('Data Berhasil Disimpan');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KurbanHewan $kurbanhewan)
    {
        // dd($kurbanhewan);
        Kurban::userMasjid()->where('id', request('kurban_id'))->firstOrFail();
        // dd($kurbanhewan->kurbanPeserta->count());
        if ($kurbanhewan->kurbanPeserta->count() == 0) {
            $kurbanhewan->delete();
            flash('Data Hewan Kurban Berhasil Dihapus');
            return back();
        }
        flash('Data Hewan Kurban Tidak Berhasil Dihapus, Karena Hewan Kurban dipakai Peserta Lain');
        return back();
    }
}
