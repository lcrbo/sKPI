<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Mensualkpi
 *
 * @property $id
 * @property $formato
 * @property $local
 * @property $valor
 * @property $mes
 * @property $indicadorkpi_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Indicadorkpi $indicadorkpi
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Mensualkpi extends Model
{
    
    static $rules = [
		'formato' => 'required',
		'local' => 'required',
		'valor' => 'required',
		'mes' => 'required',
		'indicadorkpi_id' => 'required',
    ];

    protected $perPage = 10;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['formato','local','valor','mes','indicadorkpi_id'];


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

    
    public function scopeRangoFecha($query, $startDate, $endDate) 
    {
      if ($startDate)
        return $query->where('mes', '>=', $startDate)
                     ->where('mes', '<=', $endDate);
    }

}
