<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Item extends Model {
   	
   	protected $table = 'itens';
   	public $timestamps = false;
}