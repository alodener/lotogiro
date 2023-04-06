<?php

namespace App\Models;

use App\Helper\Pagination;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Lab404\Impersonate\Models\Impersonate;

class User extends Authenticatable
{
    use HasRoles, HasFactory, Notifiable, Impersonate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'indicador',
        'pixSaque',
        'link',
        'type_client',
        'is_active',
        'contact_made'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function client()
    {
        return $this->hasOne(Client::class, 'id', 'type_client');
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function customer()
    {
        return Client::where('email', $this->email)->first();
    }

    public function bet()
    {
        return $this->hasMany(Bet::class);
    }

    public function extracts()
    {
        return $this->hasMany(Extract::class);
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'indicador', 'id');
    }

    public function getUserQualification()
    {
        $actived = UsersHasQualifications::getActivedByUser($this);
        if (!$actived) {
            return new UsersHasQualifications;
        }

        return $actived;
    }


    public static function listRankingPagination($url, $page, $perPage = 12)
    {

        $total = DB::select('
        select count(1) t
        from users a
        join users_has_qualifications b on b.user_id = a.id and b.active = 1
        join qualifications c on c.id = b.qualification_id');

        $total = isset($total[0]) ? $total[0]->t : 0;

        $pagination = new Pagination($total, $perPage, 'pg', $page, $url);

        $users = User::select('users.*')
            ->join('users_has_qualifications', 'users_has_qualifications.user_id', '=', 'users.id')
            ->join('qualifications', 'qualifications.id', '=', 'users_has_qualifications.qualification_id')
            ->where('users_has_qualifications.active', 1)
            ->orderByDesc('qualifications.goal')
            ->orderBy('users.name')
            ->limit($perPage)
            ->offset($pagination->getOffset())
            ->get();

        $rows = [];
        foreach($users as $r){
            $rows[] = $r;
        }

        $pagination->setRows($rows);

        return $pagination;
    }
}
