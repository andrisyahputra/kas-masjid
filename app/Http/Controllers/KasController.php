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
        $kasList = Kas::latest()->paginate(50);
        return view('kas_index', compact('kasList'));
    }

    public function create()
    {
        $kas = new Kas;
        $saldoAkhir = Kas::saldoAkhir();
        return view('kas_form', compact('kas', 'saldoAkhir'));
    }



    public function store(Request $request)
    {

        $requestData = $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'nullable',
            'keterangan' => 'required',
            'jenis' => 'required|in:masuk,keluar',
            'jumlah' => 'required|numeric',
        ]);

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
        // $this->hitungSaldoAkhir(); // Panggil method hitungSaldoAkhir setelah menghapus data
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
