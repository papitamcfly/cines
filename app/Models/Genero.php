<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    use HasFactory;
    
    protected $table = 'generos';
    protected $fillable = ['nombre'];
    public $timestamps = false;
    public function peliculas(){
        return $this->belongsToMany(Pelicula::class, 'pelicula_pelicula_generos', 'pelicula_id', 'genero_pelicula_id');
    }
}
