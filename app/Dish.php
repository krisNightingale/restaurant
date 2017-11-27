<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dishes';
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
    protected $fillable = ['name', 'price', 'weight', 'category_id', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'dish_product')->withPivot('amount');
    }

    public static function getIds()
    {
        $items = Dish::all()->all();
        $ids = [];
        foreach ($items as $item){
            $ids[$item->id] = ['value' => $item->id];
        }
        return $ids;
    }

    public static function getNames()
    {
        $items = Dish::all()->all();
        $names = [];
        foreach ($items as $item){
            $names[$item->id] = $item->name;
        }
        return $names;
    }
}
