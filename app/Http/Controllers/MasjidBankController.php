<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\MasjidBank;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMasjidBankRequest;
use App\Http\Requests\UpdateMasjidBankRequest;

class MasjidBankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = MasjidBank::userMasjid()->latest()->paginate(50);
        $title = "Data Bank Masjid";
        return view('masjidbank_index', compact('models', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['model'] = new MasjidBank;
        $data['title'] = 'Tambah Bank Baru Masjid';
        $data['route'] = 'masjidbank.store';
        $data['method'] = 'POST';
        $data['listBank'] = Bank::pluck('nama_bank', 'id');
        return view('masjidbank_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'bank_id' => 'required|exists:banks,id',
            'nama_rekening' => 'required',
            'nomor_rekening' => 'required',
        ]);
        // $requestData['slug'] = Str::slug($request->judul);
        $bank = Bank::findorfail($requestData['bank_id']);
        unset($requestData['bank_id']);
        $requestData['kode_bank'] = $bank->sandi_bank;
        $requestData['nama_bank'] = $bank->nama_bank;
        MasjidBank::create($requestData);
        flash('Data Berhasil Disimpan');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(MasjidBank $masjidBank)
    {
        // $data['model'] = $masjidBank;
        // $data['title'] = 'Detail Data Bank Masjid';
        // return view('masjidbank_show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasjidBank $masjidbank)
    {
        $data['model'] = $masjidbank;
        $data['id_bank'] = Bank::where('nama_bank', $masjidbank->nama_bank)->value('id');
        // dd($data['id_bank']);
        $data['title'] = 'Edit Data Bank Masjid';
        $data['route'] = ['masjidbank.update', $masjidbank->id];
        $data['method'] = 'PUT';
        $data['listBank'] = Bank::pluck('nama_bank', 'id');
        return view('masjidbank_form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasjidBank $masjidBank)
    {
        $requestData = $request->validate([
            'bank_id' => 'required|exists:banks,id',
            'nama_rekening' => 'required',
            'nomor_rekening' => 'required',
        ]);
        // $requestData['slug'] = Str::slug($request->judul);
        $bank = Bank::findorfail($requestData['bank_id']);
        unset($requestData['bank_id']);
        $requestData['kode_bank'] = $bank->sandi_bank;
        $requestData['nama_bank'] = $bank->nama_bank;

        $masjidBank->update($requestData);
        flash('Data Berhasil Diubah');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasjidBank $masjidbank)
    {
        $masjidbank->delete();
        flash('Data Berhasil Dihapus');
        return back();
    }
}
