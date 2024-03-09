<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    use HasFactory;

    protected $table = 'peliculas';
    protected $fillable = ['titulo','sinopsis','duracion','clasificacion'];
    public $timestamps= false;
    public function generos(){
        return $this->belongsToMany(Genero::class, 'pelicula_pelicula_generos', 'pelicula_id', 'genero_pelicula_id');
    }   
    public function funciones()
    {
        return $this->hasMany(Funcion::class);
    }
}
