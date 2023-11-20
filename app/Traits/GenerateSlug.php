<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait GenerateSlug
{

    protected static function bootGenerateSlug()
    {
        $counter = 1;
        static::creating(function ($model) use (&$counter) {
            // $model->slug = Str::slug($model->masjid_id . '-' . $model->judul);
            if (!empty($model->masjid_id) && !empty($model->judul)) {
                // Jika keduanya tersedia, set nilai slug berdasarkan masjid_id dan judul
                $model->slug = Str::slug($model->masjid_id . '-' . $model->judul);
            } elseif (!empty($model->nama)) {
                // Jika masjid_id dan judul tidak tersedia, tetapi nama tersedia,
                // set nilai slug berdasarkan nama dengan spasi diganti oleh slug
                // dd($counter++);
                $model->slug = Str::slug($model->nama . '-' . $counter++);
            }
        });
    }
}
