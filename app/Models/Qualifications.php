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
            $personalGoal = $r->goal * ($personalPercentage / 100);
            $groupGoal = $r->goal * ($groupPercentage / 100);

            /**
             * personal_balance = 100% dos pontos do nívels
             * 
             * ou
             * 
             * personal_balance pode ter no mínimo 10% dos pontos do nível e o resto vir dos pontos da rede
             */

            if ($balances['personal_balance'] < $personalGoal ||
            ($balances['personal_balance'] + $balances['group_balance']) < $r->goal) {
                continue;
            }

            $qualification = $r;
            break;
        }

        return $qualification;
    }

    public static function getDiffNextGoal(Qualifications $currentQualification, $personalPoints, $groupPoints)
    {
        $nextQualification = Qualifications::where('goal', '>', $currentQualification->goal)->orderBy('goal')->first();
        if (!$nextQualification) {
            return false;
        }

        $personalPercentage = $nextQualification->personal_percentage;
        $groupPercentage = $nextQualification->group_percentage;
        $personalGoal = $nextQualification->goal * ($personalPercentage / 100);
        $groupGoal = $nextQualification->goal * ($groupPercentage / 100);

        $pointsA = ($personalPoints <= $personalGoal ? $personalPoints : $personalGoal);
        $pointsB = ($groupPoints <= $groupGoal ? $groupPoints : $groupGoal);

        $goalOk = $pointsA + $pointsB;

        $personalDiff = 0;
        if ($pointsA < $personalGoal) {
            $personalDiff = ($personalGoal + floatval($personalPoints)) - $pointsA;
        }
        $groupDiff = 0;
        if ($pointsB < $groupGoal) {
            $groupDiff = $groupGoal - $pointsB;
        }
        $totalDiff = ($personalDiff + $groupDiff);

        $arr = [
            'personalPoints' => $pointsA,
            'groupPoints' => $pointsB,
            'goalOk' => $goalOk,

            'personalDiff' => $personalDiff > 0 ? $personalDiff : false,
            'groupDiff' => $groupDiff > 0 ? $groupDiff : false,
            'totalDiff' => $totalDiff > 0 ? $totalDiff : false,

            'personalGoal' => $personalGoal,
            'groupGoal' => $groupGoal,
            'goal' => $nextQualification->goal,

            'percentage' => ($goalOk / $nextQualification->goal) * 100,
        ];

        // dd($arr);

        return $arr;
    }

    public static function getGoalCalculation(Qualifications $qualification, $personalPoints, $groupPoints)
    {
        $personalPercentage = $qualification->personal_percentage;
        $groupPercentage = $qualification->group_percentage;
        $personalGoal = $qualification->goal * ($personalPercentage / 100);
        $groupGoal = $qualification->goal * ($groupPercentage / 100);

        $pointsA = ($personalPoints <= $personalGoal ? $personalPoints : $personalGoal);
        $pointsB = ($groupPoints <= $groupGoal ? $groupPoints : $groupGoal);

        return [
            'personalPoints' => $pointsA,
            'groupPoints' => $pointsB,
            'totalPoints' => ($pointsA + $pointsB),
        ];
    }
}
