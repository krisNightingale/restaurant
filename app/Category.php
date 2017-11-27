<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';
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
    protected $fillable = ['name', 'is_main'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public static function getIds()
    {
        $items = Category::all()->all();
        $ids = [];
        foreach ($items as $item){
            $ids[$item->id] = ['value' => $item->id];
        }
        return $ids;
    }

    public static function getNames()
    {
        $items = Category::all()->all();
        $names = [];
        foreach ($items as $item){
            $names[$item->id] = $item->name;
        }
        return $names;
    }
}
