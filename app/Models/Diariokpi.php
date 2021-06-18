<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Diariokpi
 *
 * @property $id
 * @property $formato
 * @property $local
 * @property $valor
 * @property $hora
 * @property $indicadorkpi_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Indicadorkpi $indicadorkpi
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Diariokpi extends Model
{
    
    static $rules = [
		'formato' => 'required',
		'local' => 'required',
		'valor' => 'required',
		'hora' => 'required',
		'indicadorkpi_id' => 'required',
    ];

    protected $perPage = 10;

    protected $casts = [
      'valor' => 'numeric'
    ];
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['formato','local','valor','hora','indicadorkpi_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function indicadorkpi()
    {
        return $this->hasOne('App\Models\Indicadorkpi', 'id', 'indicadorkpi_id');
    }
    
//query scope
    public function scopeFormato($query,$formato)
    {
       if ($formato)
          return $query->where('formato', 'LIKE', "%$formato%");
    }

    public function scopeUmbral($query,$umbralC,$umbral2,$umbralM,$umbralB)
    {
      if ($umbralC  && ($umbralM == null) && ($umbralB === null))    
        return $query->where('valor', '<=', $umbralC); 
      if (($umbralC ===null) && $umbralM && ($umbralB === null))
        return $query->where('valor', '<=', $umbralM)
                     ->orwhere('valor', '>', $umbral2);
      if (($umbralC === null)  && ($umbralM == null) && $umbralB )    
        return $query->where('valor', '>', $umbralB);               
      
      if ($umbralC && $umbralM  && ($umbralB === null))
          return $query->where('valor', '<=', $umbralM);
      if (($umbralC === null)  && $umbralM && $umbralB )    
          return $query->where('valor', '>', $umbral2);   
      if ($umbralC  && ($umbralM == null) && $umbralB )  
          return $query->where('valor', '<=', $umbralC)
                      ->orwhere('valor', '>', $umbralB); 
    }

    public function scopeLocal($query, $local) 
    {
      if ($local)
        return $query->where('local', 'LIKE', "%$local%");
    }

  

    public function scopeUmbralCritico($query,$umbral)
    {
       if ($umbral)
          return $query->orwhere('valor', '<=', $umbral);
    }
    public function scopeSoloUmbralCritico($query,$umbral)
    {
       if ($umbral)
          return $query->where('valor', '<=', $umbral);
    }
    public function scopeUmbralMedio($query,$umbral,$umbral1)
    {
       if ($umbral1)
          return $query->where('valor', '>', $umbral)
                      ->where('valor', '<=', $umbral1) ;
    }
    public function scopeUmbralBajo($query,$umbral)
    {
       if ($umbral)
          return $query->orwhere('valor', '>', $umbral);
    }
    public function scopeSoloUmbralBajo($query,$umbral)
    {
       if ($umbral)
          return $query->where('valor', '>', $umbral);
    }

}
