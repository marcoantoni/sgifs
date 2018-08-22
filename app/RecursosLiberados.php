<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RecursosLiberados extends Model {
   	
   	protected $table = 'recursos_liberados';
   	public $timestamps = false;
   	
   	public static function getValorLiberado($ano){
   		return DB::table('recursos_liberados')->where('id_orcamento', $ano)->sum('valor');
   	}

   	public static function getEvolucaoValorLiberado($ano){
   		return DB::select("SELECT id, valor, DATE_FORMAT(data,'%d/%m/%Y') AS data, id_orcamento FROM recursos_liberados WHERE id_orcamento = $ano ORDER BY data ASC");
   	}
}