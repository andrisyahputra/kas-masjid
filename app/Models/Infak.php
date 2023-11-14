<?php

namespace App\Models;

use App\Traits\HasMasjid;
use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Infak extends Model
{
    use HasFactory;
    use HasCreatedBy, HasMasjid;
    // use ConvertContentImageBase64ToUrl;

    protected $guarded = [];

    /**
     * Get the kas associated with the Infak
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function kas(): HasOne
    {
        return $this->hasOne(Kas::class);
    }
}
