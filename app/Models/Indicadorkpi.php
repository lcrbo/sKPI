<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Indicadorkpi
 *
 * @property $id
 * @property $imagen
 * @property $nombre
 * @property $descripcion
 * @property $formato
 * @property $umbral1
 * @property $umbral2
 * @property $umbral3
 * @property $umbral4
 * @property $activo
 * @property $created_at
 * @property $updated_at
 *
 * @property Datoskpi[] $datoskpis
 * @property Diariokpi[] $diariokpis
 * @property Historicokpi[] $historicokpis
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Indicadorkpi extends Model
{
    use HasFactory;
    
    static $rules = [
		'nombre' => 'required',
        'descripcion' => 'required',
		'formato' => 'required',
		'umbral1' => 'required',
		'umbral2' => 'required',
		'umbral3' => 'required',
		'umbral4' => 'required',
        'errorsindata' => 'required',

    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [ 'nombre','descripcion','formato','descripcionsyb','diasmax','horasmax', 'mesesmax','umbral1','umbral2','umbral3','umbral4','errorsindata'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function datoskpis()
    {
        return $this->hasMany('App\Models\Datoskpi', 'indicadorkpi_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function diariokpis()
    {
        return $this->hasMany('App\Models\Diariokpi', 'indicadorkpi_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historicokpis()
    {
        return $this->hasMany('App\Models\Historicokpi', 'indicadorkpi_id', 'id');
    }
    

    public function scopeIndicador($query, $nombre)
    {
        if ($nombre)
            return $query->where('nombre', 'LIKE', "%$nombre%")
                         ->orwhere('descripcion', 'LIKE', "%$nombre%");
    }

}
