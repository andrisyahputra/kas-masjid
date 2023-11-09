<?php

namespace App\Traits;

use App\Models\User;

trait HasCreatedBy
{
    protected static function bootHasCreatedBy()
    {
        static::creating(function ($model) {
            $model->created_by = auth()->user()->id;
        });
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
