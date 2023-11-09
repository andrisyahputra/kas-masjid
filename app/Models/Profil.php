<?php

namespace App\Models;

use App\Traits\HasMasjidId;
use App\Traits\GenerateSlug;
use App\Traits\HasCreatedBy;
// use App\Traits\ConvertContentImageBase64ToUrl;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profil extends Model
{
    use HasFactory;
    use HasCreatedBy, HasMasjidId, GenerateSlug;
    // use ConvertContentImageBase64ToUrl;

    protected $guarded = [];
    // protected $contentName = 'konten';

    public function scopeUserMasjid($q)
    {
        return $q->where('masjid_id', auth()->user()->masjid_id);
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
