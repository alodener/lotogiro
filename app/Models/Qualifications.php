<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class Qualifications extends Model
{
    protected $fillable = [
        'description',
        'image',
        'goal',
        'personal_percentage',
        'group_percentage',
    ];

    public static function getQualificationByBalance(array $balances)
    {
        if (!isset($balances['personal_balance']) || !isset($balances['group_balance'])) {
            throw new Exception('Saldos informados são inválidos!');
        }

        $qualification = false;
        foreach (Qualifications::select()->orderByDesc('goal')->get() as $r) {
            $personalPercentage = $r->personal_percentage;
            $groupPercentage = $r->group_percentage;
            $goal = ($balances['personal_balance'] * ($personalPercentage / 100)) + ($balances['group_balance'] * ($groupPercentage / 100));
            if ($goal < $r->goal) {
                continue;
            }

            $qualification = $r;
            break;
        }

        return $qualification;
    }
}
