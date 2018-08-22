<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class AgendaVeiculo extends Model {
   	
   	protected $table = 'agenda_veiculos';
   	public $timestamps = false;

   	public static function getReservas($data_inicial, $data_final = NULL){
         $sql = "SELECT agenda_veiculos.id, dia, TIME_FORMAT(inicio, '%H:%i') AS inicio, TIME_FORMAT(fim, '%H:%i') AS fim, modelo, solicitante, motorista, para_onde, observacao FROM agenda_veiculos, veiculos WHERE id_veiculo = veiculos.id AND dia >= '$data_inicial'";

         if ($data_final != NULL){
             $sql = "SELECT agenda_veiculos.id, DATE_FORMAT(dia, '%d/%m/%Y') AS dia, TIME_FORMAT(inicio, '%H:%i') AS inicio, TIME_FORMAT(fim, '%H:%i') AS fim, modelo, solicitante, motorista, para_onde, observacao FROM agenda_veiculos, veiculos WHERE dia BETWEEN '$data_inicial' AND '$data_final' AND id_veiculo = veiculos.id";
         }

         $sql = $sql . " AND excluido = 0 ORDER BY dia ASC";
   		
         return DB::select($sql);
   	}

   	public static function getReserva($id){
   		return DB::select("SELECT agenda_veiculos.id, DATE_FORMAT(dia, '%d/%m/%Y') AS dia , TIME_FORMAT(inicio, '%H:%i') AS inicio, TIME_FORMAT(fim, '%H:%i') AS fim, modelo, solicitante, motorista, para_onde, observacao FROM agenda_veiculos, veiculos WHERE id_veiculo = veiculos.id AND agenda_veiculos.id = $id AND excluido = 0 ORDER BY dia ASC");
   	}
   	
}