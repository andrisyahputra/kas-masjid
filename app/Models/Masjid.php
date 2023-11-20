<?php

namespace App\Models;

use App\Models\Profil;
use App\Traits\GenerateSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Masjid extends Model
{


    use HasFactory, GenerateSlug;
    // use HasSlug;

    protected $guarded = ['id'];

    // public function getSlugOptions(): SlugOptions
    // {
    //     return SlugOptions::create()
    //         ->generateSlugsFrom('nama')
    //         ->saveSlugsTo('slug');
    // }

    /**
     * Get all of the profils for the Masjid
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profils(): HasMany
    {
        return $this->hasMany(Profil::class);
    }

    /**
     * Get all of the kategoris for the Masjid
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kategoris(): HasMany
    {
        return $this->hasMany(Kategori::class);
    }

    /**
     * Get all of the informasis for the Masjid
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function informasis(): HasMany
    {
        return $this->hasMany(Informasi::class);
    }
}
