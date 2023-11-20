<?php

namespace App\Models;

use App\Traits\HasMasjid;
use App\Traits\GenerateSlug;
use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;
    use HasCreatedBy, HasMasjid, GenerateSlug;
    // use ConvertContentImageBase64ToUrl;

    protected $guarded = [];


    /**
     * Get all of the informasis for the Kategori
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function informasis(): HasMany
    {
        return $this->hasMany(Informasi::class);
    }
}
