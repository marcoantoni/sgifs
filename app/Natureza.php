<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Natureza extends Model {
   	
   	protected $table = 'natureza';
   	public $timestamps = false;
   	
   	public static function getTodas(){
         return Natureza::all();
      }
}