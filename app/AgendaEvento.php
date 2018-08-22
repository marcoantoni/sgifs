<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AgendaEvento extends Model {
   	
   	protected $table = 'agenda_eventos';
   	public $timestamps = false;

   	public static function getReservas($data_inicio){
   		return DB::select("SELECT agenda_eventos.id, nome_evento, responsavel, data_inicio, data_fim, TIME_FORMAT(hora_inicio, '%H:%i') AS hora_inicio, salas.nome, alvo, observacao, link, nomelink, id_user FROM agenda_eventos, salas WHERE id_sala = salas.id AND data_inicio >= '$data_inicio' ORDER BY data_inicio ASC");
   	}
}