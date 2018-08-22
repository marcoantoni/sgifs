<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class PermissaoUsuario extends Model {
   	
   	protected $table = 'permissao_usuarios';
   	public $timestamps = false;

   	public static function getPermissoes($id_user, $id_permissao = NULL) {
   		$sql = "SELECT id, id_permissao FROM permissao_usuarios WHERE id_user = $id_user";

   		if ($id_permissao)
  			$sql = $sql . " AND id_permissao = $id_permissao";

  		return DB::select($sql);
   	}

   	public static function setPermissoes($id_user, $id_permissao = NULL) {
   		
   		if ($id_permissao){
  			$sql = "DELETE FROM permissao_usuarios WHERE permissao_usuarios.id_user = $id_user AND id_permissao = $id_permissao";
   		}
   			

  		return DB::select($sql);

   	}
}