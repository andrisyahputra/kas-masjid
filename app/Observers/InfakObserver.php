<?php

namespace App\Observers;

use Exception;
use App\Models\Kas;
use App\Models\Infak;

class InfakObserver
{
    /**
     * Handle the Infak "created" event.
     */
    public function created(Infak $infak): void
    {
        if ($infak->jenis == 'uang') {
            try {
                $kas = new Kas();
                $kas->infak_id = $infak->id;
                // $kas->tanggal = $infak->created_at;
                $kas->kategori = 'Infak- ' . $infak->sumber;
                $kas->keterangan = 'Infak- ' . $infak->sumber . ' dari ' . $infak->atas_nama;
                $kas->jenis = 'masuk';
                $kas->jumlah = $infak->jumlah;
                $kas->save();
            } catch (\Throwable $th) {
                throw new Exception("Error, " . $th->getMessage());
            }
        }
    }

    /**
     * Handle the Infak "updated" event.
     */
    public function updated(Infak $infak): void
    {
        if ($infak->jenis == 'uang') {
            try {
                $kas = $infak->kas;
                // dd($kas);
                $kas->jumlah = $infak->jumlah;
                $kas->save();
            } catch (\Throwable $th) {
                throw new Exception("Error, " . $th->getMessage());
            }
        }
    }

    /**
     * Handle the Infak "deleted" event.
     */
    public function deleted(Infak $infak): void
    {
        if ($infak->jenis == 'uang') {
            $infak->kas->delete();
        }
    }

    /**
     * Handle the Infak "restored" event.
     */
    public function restored(Infak $infak): void
    {
        //
    }

    /**
     * Handle the Infak "force deleted" event.
     */
    public function forceDeleted(Infak $infak): void
    {
        //
    }
}
