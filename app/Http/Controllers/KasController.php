<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Http\Requests\StoreKasRequest;
use App\Http\Requests\UpdateKasRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class KasController extends Controller
{
    // ...
    public function index(Request $request)
    {
        $query = Kas::userMasjid();
        if ($request->filled('q')) {
            $query = $query->where('keterangan', 'LIKE', '%' . $request->q . '%');
        }
        if ($request->filled('tanggal_mulai')) {
            $query = $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query = $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }

        $kasList = $query->latest()->paginate(50);
        $saldoAkhir = Kas::saldoAkhir();
        $pemasukkan = $kasList->where('jenis', 'masuk')->sum('jumlah');
        $pengeluaran = $kasList->where('jenis', 'keluar')->sum('jumlah');
        if (request('page') == 'laporan') {
            return view('kas_laporan', compact('kasList', 'saldoAkhir', 'pemasukkan', 'pengeluaran'));
        }
        return view('kas_index', compact('kasList', 'saldoAkhir', 'pemasukkan', 'pengeluaran'));
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

        $tanggalTransaksi = Carbon::parse($requestData['tanggal']);
        $tglTransaksi = $tanggalTransaksi->format('d-m-Y');
        $tglSekarang = Carbon::now()->format('d-m-Y');
        if ($tglTransaksi != $tglSekarang) {
            Flash('Data Kas gagal Ditambahkan. Tranksaski tidak bisa ditambah tanggal <b>' . $tglTransaksi . '</b>. Sebelum tanggal Sekarang <b>' . $tglSekarang . '</b>')->error();
            return back();
        }
        $requestData['jumlah'] = str_replace('.', '', $requestData['jumlah']);
        $kas = new Kas();
        $kas->fill($requestData);
        // Simpan model hanya jika metode creating model mengembalikan true
        if (!$kas->save()) {
            // Kembalikan respons atau arahkan kembali sesuai kebutuhan
            return back();
        }
        // $kas->save();
        return redirect()->route('kas.index')->with('success', 'Data KAS Berhasil Di Tambah');
    }
    public function edit(Kas $ka)
    {
        // dd($ka);
        // $kas = Kas::userMasjid()->findOrFail($id);
        $kas = $ka;
        $saldoAkhir = Kas::saldoAkhir();
        $disable = ['disabled' => 'disabled'];
        return view('kas_form', compact('kas', 'saldoAkhir', 'disable'));
    }

    public function update(Request $request, Kas $ka)
    {
        $validatedData = $request->validate([
            'kategori' => 'nullable',
            'keterangan' => 'required',
            'jumlah' => 'required'
        ]);

        $jumlah = str_replace('.', '', $validatedData['jumlah']);
        $kas = $ka;
        $saldoAkhir = Kas::saldoAkhir();
        if ($saldoAkhir <= -1) {
            Flash('Data Kas gagal DiKeluarkan <b>' . format_rupiah($jumlah, true) . '</b>. Saldo Akhir tidak boleh kurang dari 0 <b>' . format_rupiah($saldoAkhir, true) . '</b>')->error();
            return back();
        }
        $validatedData['jumlah'] = $jumlah;
        $kas->fill($validatedData);
        if (!$kas->save()) {
            // Kembalikan respons atau arahkan kembali sesuai kebutuhan
            return back();
        }
        return redirect()->route('kas.index')->with('success', 'Data kas Berhasil Di Update');
    }

    public function destroy(Kas $ka)
    {
        $kas = $ka;
        if ($kas->infak_id != null) {
            Flash('Data Kas Gagal dihapus, Data ini terhubung data infak, Silakan hapus di data infak')->error();
            return back();
        }
        if (!$kas->delete()) {
            // Kembalikan respons atau arahkan kembali sesuai kebutuhan
            return back();
        }
        // $kas->delete();
        return redirect()->route('kas.index')->with('success', 'Data KAS Berhasil disimpan');
    }
}
