<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';
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
    protected $fillable = ['name', 'price', 'measure_id', 'category_id'];

    public function measure()
    {
        return $this->belongsTo(Measure::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function dishes()
    {
        return $this->belongsToMany(Product::class, 'dish_product')->withPivot('amount');
    }

    public static function getIds()
    {
        $products = Product::all()->all();
        $ids = [];
        foreach ($products as $product){
            $ids[$product->id] = ['value' => $product->id];
        }
        $ids[0] = ['value' => 0];
        return $ids;
    }

    public static function getNames()
    {
        $measures = Product::all()->all();
        $names = [];
        foreach ($measures as $measure){
            $names[$measure->id] = $measure->name;
        }
        $names[0] = 'Не выбран';
        return $names;
    }
}
