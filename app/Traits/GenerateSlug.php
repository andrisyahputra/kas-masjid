<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait GenerateSlug
{
    protected static function bootGenerateSlug()
    {
        static::creating(function ($model) {
            $model->slug = Str::slug($model->masjid_id . '-' . $model->judul);
        });
    }
}
