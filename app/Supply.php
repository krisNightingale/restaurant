<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'supply';
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
    protected $fillable = ['time', 'price', 'supplier_id', 'is_paid'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_supply')->withPivot('amount');
    }

}
