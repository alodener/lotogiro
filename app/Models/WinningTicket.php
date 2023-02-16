<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinningTicket extends Model
{
    use HasFactory;

    public $table = 'winning_ticket';
    protected $fillable = [
        'user_id',
        'game_id',
        'draw_id',
        'drawed_at',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function game()
    {
        return $this->hasOne(Game::class, 'id', 'game_id');
    }

    public function draw()
    {
        return $this->hasOne(Draw::class, 'id', 'draw_id');
    }
}
