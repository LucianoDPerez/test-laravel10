<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Entity extends Model
{
    use HasFactory;
    protected $fillable = [
        'api',
        'description',
        'link',
        'category_id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
