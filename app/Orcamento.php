<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model {
   	
   	protected $table = 'orcamento';
   	public $timestamps = false;

   	protected $maps = ['id' => 'ano'];
   	
}