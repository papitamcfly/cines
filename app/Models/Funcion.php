<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sala_id',
        'pelicula_id',
        'fecha',
        'hora_inicio',
    ];

    /**
     * Get the sala that owns the funcion.
     */
    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }

    /**
     * Get the pelicula that owns the funcion.
     */
    public function pelicula()
    {
        return $this->belongsTo(Pelicula::class);
    }

    public function boletos()
    {
        return $this->hasMany(Boleto::class, 'id_funcion');
    }

    /* A;adir este metodo en el modelo de Pelicula
    public function funciones()
    {
        return $this->hasMany(Funcion::class);
    }
    */
}
