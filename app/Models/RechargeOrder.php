<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RechargeOrder extends Model
{
    use HasFactory;

    public $table = 'recharge_order';
    protected $fillable = [
        'reference',
        'user_id',
        'value',
        'link',
        'status',
        'gateway'
    ];

    public function scopeReference(Builder $query, $reference) : void
    {
        $query->where('reference', $reference);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
