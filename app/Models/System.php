<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory;

    protected $table = 'system';

    protected $guarded = [];

    protected $fillable = [
        'nome_config',
        'value',
        'image',
    ];

    public function scopeConfig($query, $configuration)
    {
        $query->where('nome_config', $configuration);
    }
}
