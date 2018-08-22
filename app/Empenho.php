<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Empenho extends Model {
   	
   	protected $table = 'empenhos';
   	public $timestamps = false;
   	
   	public static function getTotalGasto($ano){
   		return DB::table('empenhos')->where('id_orcamento', $ano)->where('cancelado', 0)->sum('valor');
         //return DB::select("SELECT sum(valor) AS valor FROM empenhos WHERE id_orcamento = 2018 AND cancelado = 0");
   	}

   	public static function getEmpenhos($ano){
   		return DB::select("SELECT empenhos.id, numero, empenhos.valor, natureza.nome AS natureza, empresas.nome_fantasia, empresas.cnpj, cancelado, arquivo FROM empenhos, natureza, empresas WHERE empenhos.id_orcamento = $ano AND empenhos.id_natureza = natureza.id AND empresas.id = empenhos.id_empresa");
   	}

      public static function getGastosNatureza($ano){
         return DB::select("SELECT sum(empenhos.valor) AS soma, natureza.nome AS natureza FROM empenhos, natureza WHERE empenhos.id_orcamento = $ano AND empenhos.id_natureza = natureza.id GROUP BY empenhos.id_natureza");
      }
}