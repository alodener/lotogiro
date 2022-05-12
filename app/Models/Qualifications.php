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

    public static function getDiffNextGoal(Qualifications $currentQualification, $personalPoints, $groupPoints)
    {
        $nextQualification = Qualifications::where('goal', '>', $currentQualification->goal)->orderBy('goal')->first();
        if (!$nextQualification) {
            return false;
        }

        $personalPercentage = $nextQualification->personal_percentage;
        $groupPercentage = $nextQualification->group_percentage;

        $pointsA = ($personalPoints * ($personalPercentage / 100));
        $pointsB = ($groupPoints * ($groupPercentage / 100));
        $goal = $pointsA + $pointsB;
        $diff = $nextQualification->goal - $goal;

        return [
            'personalPoints' => $pointsA,
            'groupPoints' => $pointsB,
            'diff' => $diff,
            'goal' => $nextQualification->goal,
            'percentage' => ($goal / $nextQualification->goal)*100,
        ];
    }

    public static function getGoalCalculation(Qualifications $qualification, $personalPoints, $groupPoints)
    {
        $personalPercentage = $qualification->personal_percentage;
        $groupPercentage = $qualification->group_percentage;

        $pointsA = ($personalPoints * ($personalPercentage / 100));
        $pointsB = ($groupPoints * ($groupPercentage / 100));

        return [
            'personalPoints' => $pointsA,
            'groupPoints' => $pointsB,
        ];
    }
}
