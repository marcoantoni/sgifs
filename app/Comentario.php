<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Comentario extends Model {
      
      protected $table = 'comentarios';
      public $timestamps = false;

      /* 
       * cpublico = 1 comentários que são públicos - 0 só o responsável pode ver
       * respondido = variavel de controle. Ao responder o status muda para 1
      */
      public static function getComentarios($cpublico = NULL, $respondido = NULL, $id_setor){
         $sql = "SELECT comentarios.id, texto, comentarios.nome, telefone, email, resposta, responder, arquivo, assunto, arquivo, setores.nome AS nome_setor FROM comentarios, setores, assuntos WHERE respondido = $respondido "; //AND comentarios.id_assunto IS NULL

         if ($cpublico == 0 || $cpublico == 1)
            $sql = $sql . " AND cpublica = $cpublico";

         if ($id_setor == 0)
            $sql = $sql . " AND comentarios.id_assunto = assuntos.id AND assuntos.id_setor = setores.id";
         else
            $sql = $sql . " AND comentarios.id_assunto = assuntos.id AND assuntos.id_setor = setores.id AND assuntos.id_setor = $id_setor";
           

         //return $sql;
         return DB::select($sql);
      }

      // retorna apenas o comentario associado a determinado setor
      public static function getComentario($id, $id_setor){
        //$sql = "SELECT * FROM comentarios WHERE id = $id AND id_setor = $id_setor"; 
        //return $sql;
        //return DB::select($sql);
        return DB::table('comentarios')->where([['id', '=', '$id'], ['id_setor', '=', '$id_setor']])->get();
      }
}