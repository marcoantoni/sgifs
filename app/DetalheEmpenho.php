<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetalheEmpenho extends Model {
   	
   	protected $table = 'detalhe_empenho';
   	public $timestamps = false;

   	public static function getDetalhes($id_empenho){
   		return DB::select("SELECT detalhe_empenho.id, id_empenho, id_item, itens.nome, quantidade, previsao_entrega, entregue, cancelado FROM detalhe_empenho, itens WHERE id_empenho = $id_empenho AND detalhe_empenho.id_item = itens.id ");
   	}
}