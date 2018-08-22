<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
  //  return view('orcamento.index');
//});

//Route::get('/', 'OrcamentoController@index');
Route::get('/empenho/graficos/', 'EmpenhoController@graficos');
Route::get('/comentario/admin', 'ComentarioController@indexAdmin');

Route::get('/orcamento', 'OrcamentoController@index');
Route::get('/', 'OrcamentoController@index');

Route::resource('abastecimento', 'AbastecimentoController');
Route::resource('agendaveiculos', 'AgendaVeiculosController');
Route::resource('eventos', 'AgendaEventoController');
Route::resource('agenda', 'AgendaSalaController');
Route::resource('assunto', 'AssuntoController');
Route::resource('comentario', 'ComentarioController');
Route::resource('empenho', 'EmpenhoController');
Route::resource('empresa', 'EmpresaController');
Route::resource('item', 'ItemController');
Route::resource('detalheempenho', 'DetalheEmpenhoController');
Route::resource('natureza', 'NaturezaController');
Route::resource('orcamento', 'OrcamentoController');
Route::resource('rlib', 'RecursosLiberadosController');
Route::resource('usuario', 'UsuarioController');


//Auth::routes();
 // Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//Route::get('register', 'UsuarioController@create')->name('register');
Route::post('register', 'Auth\RegisterController@register');


Route::get('alterar-senha', 'UsuarioController@alterarSenha');
Route::PATCH('alterar-senha', 'UsuarioController@alterarSenha');
Route::get('obter-assuntos/{id_setor}', 'AssuntoController@getAssuntos');
Route::get('agendaveiculos/obter-reservas/{d1}/{d2}', 'AgendaVeiculosController@getReservas');
Route::get('ocultar-notificacao/{id}', 'UsuarioController@ocultarNotificacao');

//Route::get('detalheempenho/salvar/{id_empenho}/{id_item}', 'DetalheEmpenhoController@salvar');

