<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait HashUuid
{
    protected static function bootHashUuid() {

        static::creating(function($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid();
            }
        });
    }
}
