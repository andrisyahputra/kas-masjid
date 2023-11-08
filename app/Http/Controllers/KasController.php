<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Http\Requests\StoreKasRequest;
use App\Http\Requests\UpdateKasRequest;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class KasController extends Controller
{
    // ...
    public function index()
    {
        $kasList = Kas::userMasjid()->latest()->paginate(50);
        return view('kas_index', compact('kasList'));
    }

    public function create()
    {
        $kas = new Kas;
        $saldoAkhir = Kas::saldoAkhir();
        $disable = [];
        return view('kas_form', compact('kas', 'saldoAkhir', 'disable'));
    }



    public function store(Request $request)
    {

        $requestData = $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'nullable',
            'keterangan' => 'required',
            'jenis' => 'required|in:masuk,keluar',
            'jumlah' => 'required',
        ]);

        $requestData['jumlah'] = str_replace('.', '', $requestData['jumlah']);

        $saldoAwal = Kas::saldoAkhir();
        $saldoAkhir = $saldoAwal;
        // @dd($saldoAkhir);

        if ($requestData['jenis'] == 'masuk') {
            $saldoAkhir += $requestData['jumlah'];
        } else {
            $saldoAkhir -= $requestData['jumlah'];
        }


        if ($saldoAkhir <= -1) {
            Flash('Data Kas gagal DiKeluarkan <b>' . format_rupiah($requestData['jumlah'], true) . '</b>. Saldo Akhir tidak boleh kurang dari 0. saldo terakhir sisa <b>' . format_rupiah($saldoAwal, true) . '</b>')->error();
            return back();
        }

        // @dd($saldoAkhir);


        $kas = new Kas();
        $kas->fill($requestData);
        // @dd($kas);
        $kas->masjid_id = auth()->user()->masjid_id;
        $kas->created_by = auth()->user()->id;
        $kas->saldo_akhir = $saldoAkhir;
        $kas->save();
        return redirect()->route('kas.index')->with('success', 'Data KAS Berhasil Di Tambah');
    }
    public function edit($id)
    {
        $kas = Kas::findOrFail($id);
        $saldoAkhir = Kas::saldoAkhir();
        $disable = ['disabled' => 'disabled'];
        return view('kas_form', compact('kas', 'saldoAkhir', 'disable'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'kategori' => 'nullable',
            'keterangan' => 'required'
        ]);


        $kas = Kas::findOrFail($id);
        $kas->fill($validatedData);
        $kas->save();
        return redirect()->route('kas.index')->with('success', 'Data kas Berhasil Di Update');
    }

    public function destroy($id)
    {
        $kas = Kas::findOrFail($id);
        $kas->keterangan = 'Dihapus Oleh ' . auth()->user()->name;
        $kas->save();

        $kasBaru = $kas->replicate();
        $kasBaru->keterangan = 'Perbaikian data';
        $saldoAkhir = Kas::saldoAkhir();
        if ($kas->jenis == 'masuk') {
            $saldoAkhir += $kas->jumlah;
        } else {
            $saldoAkhir -= $kas->jumlah;
        }
        $kasBaru->saldo_akhir = $saldoAkhir;
        $kasBaru->save();
        // $this->hitungSaldoAkhir(); // Panggil method hitungSaldoAkhir setelah menghapus data
        return redirect()->route('kas.index')->with('success', 'Data KAS Berhasil disimpan');
    }
}
