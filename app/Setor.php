<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Setor extends Model {
   	
   	protected $table = 'setores';
   	public $timestamps = false;

   	//public static function getReservas($data_inicial){
   		//return DB::select("SELECT agenda_veiculos.id, DATE_FORMAT(dia,'%d/%m/%Y') AS dia, inicio, fim, modelo, solicitante, motorista, para_onde, observacao FROM agenda_veiculos, veiculos WHERE id_veiculo = veiculos.id AND dia >= '$data_inicial' AND excluido = 0 ORDER BY dia ASC");
   	//}
   	
}