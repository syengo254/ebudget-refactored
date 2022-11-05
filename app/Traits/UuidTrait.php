<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait UuidTrait
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            if (!$model->getKey() && $model->getTable() == "customer_orders") {
                $model->setAttribute($model->getKeyName(), Str::uuid()->toString());
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType(): string
    {
        return 'string';
    }
}
