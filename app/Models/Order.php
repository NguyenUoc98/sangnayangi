<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'buyer_id',
        'amount',
        'date',
        'order_detail_id',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }
}
