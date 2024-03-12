<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cine_id',
        'numero_sala',
        'capacidad',
    ];
    public $timestamps= false;
    /**
     * Get the cine that owns the sala.
     */
    public function cine()
    {
        return $this->belongsTo(Cine::class);
    }

    public function funciones()
    {
        return $this->hasMany(Funcion::class);
    }
    
}