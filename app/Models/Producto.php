<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';
    protected $fillable = ['nombre','descripcion','precio'];
    public $timestamps = false;
    public function combos(){
        return $this->belongsToMany(Combo::class, 'combo_combo_productos', 'combo_id', 'combo_productos_id');
    }   
}
