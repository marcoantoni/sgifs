<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Empresa extends Model {
   	
   	protected $table = 'empresas';
   	public $timestamps = false;
   	
   	public static function getTodas(){
         return Empresa::all();
      }
}