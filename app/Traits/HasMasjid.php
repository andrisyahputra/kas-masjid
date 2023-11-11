<?php

namespace App\Traits;

use App\Models\Masjid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasMasjid
{
    protected static function bootHasMasjid()
    {
        static::creating(function ($model) {
            $model->masjid_id = auth()->user()->masjid_id;
        });
    }

    public function scopeUserMasjid($q)
    {
        return $q->where('masjid_id', auth()->user()->masjid_id);
    }

    /**
     * Get the masjid that owns the HasMasjid
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function masjid(): BelongsTo
    {
        return $this->belongsTo(Masjid::class);
    }
    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('masjid_id', auth()->user()->masjid_id)
            ->where('id', $value)
            ->firstOrFail();
    }
}
