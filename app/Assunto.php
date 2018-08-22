<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Assunto extends Model {
   	
   	protected $table = 'assuntos';
   	public $timestamps = false;

   	public static function getAll($id_setor){
   		$sql = "SELECT assuntos.id, assunto, setores.nome AS nome_setor FROM assuntos, setores WHERE setores.id = assuntos.id_setor";

        	if ($id_setor == 0) {
            $sql = "SELECT assuntos.id, assunto FROM assuntos WHERE assuntos.id_setor IS NULL";
         }
         else
         	$sql = $sql . " AND assuntos.id_setor = $id_setor";
      		
      		//return $sql;
      		return DB::select($sql);
      	}
   	
}