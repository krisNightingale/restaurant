<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'suppliers';
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
    protected $fillable = ['name', 'phone', 'email'];

    public function supply()
    {
        return $this->hasMany(Supply::class);
    }

    public static function getIds()
    {
        $suppliers = Supplier::all()->all();
        $ids = [];
        foreach ($suppliers as $supplier){
            $ids[$supplier->id] = ['value' => $supplier->id];
        }
        return $ids;
    }

    public static function getNames()
    {
        $suppliers = Supplier::all()->all();
        $names = [];
        foreach ($suppliers as $supplier){
            $names[$supplier->id] = $supplier->name;
        }
        return $names;
    }

    public static function getNameAttributes()
    {
        $suppliers = Supplier::all()->all();
        return collect($suppliers)
            ->mapWithKeys(function ($item) {
                return [$item->id => ['value' => $item->id]];
            })->all();
    }
}
