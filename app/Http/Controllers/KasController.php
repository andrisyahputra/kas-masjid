<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Http\Requests\StoreKasRequest;
use App\Http\Requests\UpdateKasRequest;
use Illuminate\Http\Request;

class KasController extends Controller
{
    // ...
    public function index()
    {
        $kasList = Kas::all();
        return view('kas_index', compact('kasList'));
    }

    public function create()
    {
        $data = new Kas;
        return view('kas_form', compact('data'));
    }



    public function store(Request $request)
    {

        $request->validate([
            'masjid_id' => 'required',
            'tanggal' => 'required|date',
            'kategori' => 'nullable',
            'keterangan' => 'required',
            'jenis' => 'required|in:masuk,keluar',
            'jumlah' => 'required|numeric',
            'created_by' => 'require',
        ]);


        $kas = Kas::create($request->all());
        $kas->saldo_akhir = $this->calculateSaldoAkhir($kas->tanggal);
        $kas->save();
        return redirect()->route('kas.index')->with('success', 'Data KAS Berhasil Di Tambah');
    }
    public function edit($id)
    {
        $data = Kas::findOrFail($id);

        return view('kas.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'masjid_id' => 'required',
            'tanggal' => 'required|date',
            'kategori' => 'nullable',
            'keterangan' => 'required',
            'jenis' => 'required|in:masuk,keluar',
            'jumlah' => 'required|numeric',
            'created_by' => 'require',
        ]);


        $kas = Kas::findOrFail($id);
        $kas->update($request->all());
        $kas->saldo_akhir = $this->calculateSaldoAkhir($kas->tanggal);
        $kas->save();
        return redirect()->route('kas.index')->with('success', 'Data KAS Berhasil Di Update');
    }

    public function destroy($id)
    {
        Kas::findOrFail($id)->delete();
        $this->hitungSaldoAkhir(); // Panggil method hitungSaldoAkhir setelah menghapus data
        return redirect()->route('kas.index')->with('success', 'Data KAS Berhasil Dihapus');
    }

    private function calculateSaldoAkhir($tanggal)
    {
        $transactions = Kas::where('tanggal', '<=', $tanggal)
            ->orderBy('tanggal')
            ->orderBy('id')
            ->get();

        $saldo = 0;

        foreach ($transactions as $transaction) {
            if ($transaction->jenis == 'masuk') {
                $saldo += $transaction->jumlah;
            } else {
                $saldo -= $transaction->jumlah;
            }
        }

        return $saldo;
    }
}
