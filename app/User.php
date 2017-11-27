<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function getIds()
    {
        $items = User::all()->all();
        $ids = [];
        foreach ($items as $item){
            $ids[$item->id] = ['value' => $item->id];
        }
        return $ids;
    }

    public static function getNames()
    {
        $items = User::all()->all();
        $names = [];
        foreach ($items as $item){
            $names[$item->id] = $item->name;
        }
        return $names;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
