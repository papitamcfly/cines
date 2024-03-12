<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
    use HasFactory;
    
    protected $table = 'combos';
    
    protected $fillable = ['nombre','descripcion','precio'];
    public $timestamps= false;
    public function productos(){
        return $this->belongsToMany(Producto::class, 'combo_combo_productos', 'combo_id', 'combo_productos_id');
    }   
}
