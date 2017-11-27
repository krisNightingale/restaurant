<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clients';
    public $timestamps = false;

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'phone', 'email', 'birthday'];

    public static function getIds()
    {
        $items = Client::all()->all();
        $ids = [];
        foreach ($items as $item){
            $ids[$item->id] = ['value' => $item->id];
        }
        return $ids;
    }

    public static function getNames()
    {
        $items = Client::all()->all();
        $names = [];
        foreach ($items as $item){
            $names[$item->id] = $item->first_name." ".$item->last_name;
        }
        return $names;
    }
}
