<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsersHasQualifications extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'qualification_id',
        'personal_points',
        'group_points',
        'total_points',
        'active',
    ];

    public function getQualification()
    {
        $qualification = Qualifications::find($this->qualification_id);
        if (!$qualification) {
            return new Qualifications();
        }

        return $qualification;
    }

    public static function getActivedByUser(User $user)
    {
        if (!$user) {
            throw new Exception('Usuário inválido!');
        }

        $userQualification = UsersHasQualifications::where('user_id', $user->id)->where('active', 1)->first();
        if (!$userQualification) {
            return false;
        }

        return $userQualification;
    }

    public static function generateByUser(User $user)
    {
        if (!$user) {
            throw new Exception('Usuário inválido!');
        }

        $balances = UsersHasPoints::getBalancesByUser($user);
        $qualification = Qualifications::getQualificationByBalance($balances);
        if (!$qualification) {
            $userQualificationActived = UsersHasQualifications::getActivedByUser($user);
            if ($userQualificationActived) {
                $userQualificationActived->active = 0;
                $userQualificationActived->save();
            }
            return;
        }
        // $calculation = Qualifications::getGoalCalculation($qualification, $balances['personal_balance'], $balances['group_balance']);

        $userQualificationActived = UsersHasQualifications::getActivedByUser($user);
        if (!$userQualificationActived) {
            $newUserQualification = new UsersHasQualifications([
                'user_id' => $user->id,
                'qualification_id' => $qualification->id,
                'active' => 1,
            ]);
            $newUserQualification->save();
        } else {
            if ($userQualificationActived->qualification_id != $qualification->id) {
                $userQualificationActived->active = 0;
                $userQualificationActived->save();

                $newUserQualification = new UsersHasQualifications([
                    'user_id' => $user->id,
                    'qualification_id' => $qualification->id,
                    'active' => 1,
                ]);
                $newUserQualification->save();
            }
        }


        $userQualificationActived = UsersHasQualifications::getActivedByUser($user);
        $userQualificationActived->personal_points = $balances['personal_balance'];
        $userQualificationActived->group_points = $balances['group_balance'];
        $userQualificationActived->total_points = $balances['total_balance'];
        $userQualificationActived->save();

    }

    public static function reprocess()
    {
        foreach (User::whereRaw('exists(select sa.id from users_has_points sa where sa.user_id = users.id)')->get() as $r) {
            UsersHasQualifications::generateByUser($r);
        }
    }
}
