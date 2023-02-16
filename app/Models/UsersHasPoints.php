<?php

namespace App\Models;

use App\Helper\Pagination;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsersHasPoints extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'origin_id',
        'level',
        'description',
        'total',
        'personal_balance',
        'group_balance',
        'total_balance',
    ];


    /**
     * Undocumented function
     *
     * @param User $user
     * @param double $total
     * @param string $description
     * @return UsersHasPoints
     */
    public static function generatePoints(User $owner, $total, $description)
    {
        if (!$owner->id) {
            throw new Exception('Usuário informado é invalido!');
        }

        if (!is_numeric($total) && $total <= 0) {
            throw new Exception('Total deve ser maior que zero!');
        }

        $total = doubleval($total);

        $lastBalance = UsersHasPoints::getBalancesByUser($owner);

        $newPoint = new UsersHasPoints([
            'user_id' => $owner->id,
            'origin_id' => $owner->id,
            'level' => 0,
            'description' => $description,
            'total' => $total,
            'personal_balance' => $lastBalance['personal_balance'] + $total,
            'group_balance' => $lastBalance['group_balance'],
            'total_balance' => $lastBalance['total_balance'] + $total,
        ]);
        $newPoint->save();
        UsersHasQualifications::generateByUser($owner);

        if ($owner->id == $owner->indicador) {
            return;
        }

        $sponsor = $owner;
        $check = true;
        $level = 1;
        while ($check) {
            $sponsor = User::find($sponsor->indicador);
            if (!$sponsor) {
                $check = false;
                break;
            }

            $lastBalance = UsersHasPoints::getBalancesByUser($sponsor);

            $newPoint = new UsersHasPoints([
                'user_id' => $sponsor->id,
                'origin_id' => $owner->id,
                'level' => $level,
                'description' => $description,
                'total' => $total,
                'personal_balance' => $lastBalance['personal_balance'],
                'group_balance' => $lastBalance['group_balance'] + $total,
                'total_balance' => $lastBalance['total_balance'] + $total,
            ]);
            $newPoint->save();
            UsersHasQualifications::generateByUser($sponsor);

            if ($sponsor->id == $sponsor->indicador) {
                $check = false;
                break;
            } else {
                $level++;
            }
        }
    }

    public static function getBalancesByUser(User $user)
    {
        if (!$user || !$user->id) {
            throw new Exception('Usuário informado é invalido!');
        }
        $lastPoint = UsersHasPoints::where('user_id', $user->id)
            ->orderByDesc('id')
            ->first();

        if (!$lastPoint) {
            return [
                'personal_balance' => 0,
                'group_balance' => 0,
                'total_balance' => 0,
            ];
        }

        return [
            'personal_balance' => $lastPoint->personal_balance,
            'group_balance' => $lastPoint->group_balance,
            'total_balance' => $lastPoint->total_balance,
        ];
    }

    public function getOrigin()
    {
        $origin = User::find($this->origin_id);
        if (!$origin) {
            return new User;
        }

        return $origin;
    }

    public static function filterPagination($url, $page, $perPage = 12, array $filter = [])
    {
        $where = ' where 0 = 0';

        if (isset($filter['userId']) && trim($filter['userId']) != '') {
            $where .= ' and user_id = ' . intval($filter['userId']) . ' ';
        }

        $total = DB::select('
        select count(1) t 
        from users_has_points a 
        ' . $where);

        $total = isset($total[0]) ? $total[0]->t : 0;

        $pagination = new Pagination($total, $perPage, 'pg', $page, $url);

        $userPoints = UsersHasPoints::orderByDesc('id');

        if (isset($filter['userId']) && trim($filter['userId']) != '') {
            $userPoints = $userPoints->where('user_id', intval($filter['userId']));
        }

        $userPoints = $userPoints->limit($perPage)->offset($pagination->getOffset());

        $rows = [];
        foreach ($userPoints->get() as $r) {
            $rows[] = $r;
        }
        $pagination->setRows($rows);

        return $pagination;
    }
}
