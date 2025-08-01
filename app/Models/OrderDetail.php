<?php

namespace App\Models;

use App\Enums\OrderDetailStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';

    protected $fillable = [
        'order_id',
        'user_id',
        'description'
    ];

    protected $casts = [
        'status' => OrderDetailStatus::class,
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function foods(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Food::class, 'order_detail_foods', 'food_id', 'order_detail_id')
            ->withPivot(['status']);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
