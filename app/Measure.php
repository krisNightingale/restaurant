<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Measure extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'measures';
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
    protected $fillable = ['name', 'value'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public static function getIds()
    {
        $measures = Measure::all()->all();
        $ids = [];
        foreach ($measures as $measure){
            $ids[$measure->id] = ['value' => $measure->id];
        }
        return $ids;
    }

    public static function getNames()
    {
        $measures = Measure::all()->all();
        $names = [];
        foreach ($measures as $measure){
            $names[$measure->id] = $measure->name;
        }
        return $names;
    }
}
