<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Food extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;

    protected $table    = 'foods';
    protected $fillable = [
        'name',
        'price',
        'address'
    ];

    public static function booted()
    {
        self::deleting(function (Food $food) {
            $food->attachment->each->delete();
        });
    }
}
