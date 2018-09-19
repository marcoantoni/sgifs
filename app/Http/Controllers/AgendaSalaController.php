<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Html\FormFacade;
use Illuminate\Html\HtmlFacade;
use Illuminate\Support\Facades\Auth;

use App\AgendaSala;
use App\Sala;
use App\PermissaoUsuario;

class AgendaSalaController extends Controller {
    
  protected $msgSemPermissao = "Você não tem permissão para fazer isso";
  protected $nivelPermissaoRequerida = 5;

  public function index() {
    $data_inicial = date('Y-m-d');
    $agendamentos = AgendaSala::getReservas($data_inicial); 
    $pgtitulo = "Cronograma de agendamento dos laboratórios";
    return view('agenda_sala.index')->with(['agendamentos' => $agendamentos, 'pgtitulo' => $pgtitulo]);
  }

  public function create() {

  	$temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

		if (!Auth::check()) {
    	return redirect('login');
    } else if (!$temPermissao) {
    	return redirect('agenda')->with(['error' => $this->msgSemPermissao]);
    }

    $salas = Sala::orderBy('nome', 'ASC')->get();
    $solicitantes = AgendaSala::distinct('solicitante')->orderBy('solicitante', 'ASC')->get(['solicitante']);

    return view('agenda_sala.create')->with([
    	'salas' => $salas, 
    	'solicitantes' => $solicitantes,
    	'pgtitulo' => 'Novo agendamento de sala']
    );
  }

   
  public function store(Request $request) {

  	$temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

		if (!Auth::check()) {
    	return redirect('login');
    } else if (!$temPermissao) {
        return redirect('agenda_espaco')->with('error', 'Agendamento criado com sucesso!');
    }
   
    try {
      $agendamento = new AgendaSala();
      $agendamento->dia = $request->input('dia');
      $agendamento->inicio = $request->input('inicio');
      $agendamento->fim = $request->input('fim');
      $agendamento->solicitante = $request->input('solicitante');
      $agendamento->observacao = $request->input('observacao');
      $agendamento->id_sala = $request->input('id_sala');
      $agendamento->id_user = Auth::User()->id;
      $agendamento->save();

      return redirect('agenda')->with('sucess', 'Agendamento criado com sucesso!');

    } catch (\Illuminate\Database\QueryException $ex) {
      return back()->withInput()->with('error', 'Verifique se o laboratório/sala foi selecionado! <br/>Erro: ' . $ex->getMessage());
    }       
  }

  /*public function show($id) {
    $agendamento = AgendaVeiculo::getReserva($id);
    return $agendamento;
  }*/

  public function edit($id) {
     
  	$temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

		if (!Auth::check()) {
    	return redirect('login');
    } else if (!$temPermissao) {
        return $this->msgSemPermissao;
    }
    
    $agenda = AgendaSala::find($id);
    
    if ($agenda->id_user == Auth::User()->id){
      $salas = Sala::orderBy('nome', 'ASC')->get();
      $solicitantes = AgendaSala::distinct('solicitante')->orderBy('solicitante', 'ASC')->get(['solicitante']);
      
      return view('agenda_sala.edit')->with([
      	'agenda' => $agenda, 'salas' => $salas,
      	'solicitantes' => $solicitantes,
      	'pgtitulo' => 'Editando agendamento de sala/laboratório'
      ]); 
      
    } else {
      return redirect('agenda')->with('error', 'Somente quem criou esse agendamento pode editá-lo!');
    }
  }

  public function update(Request $request, $id) {
     
  	$temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

		if (!Auth::check()) {
    	return redirect('login');
    } else if (!$temPermissao) {
        return $this->msgSemPermissao;
    }

    try {
      $agendamento = AgendaSala::find($id);
      $agendamento->dia = $request->input('dia');
      $agendamento->inicio = $request->input('inicio');
      $agendamento->fim = $request->input('fim');
      $agendamento->solicitante = $request->input('solicitante');
      $agendamento->observacao = $request->input('observacao');
      $agendamento->id_sala = $request->input('id_sala'); 
      $agendamento->save();
      return redirect('agenda')->with('sucess', 'Agendamento criado com sucesso!');
    } catch (\Illuminate\Database\QueryException $ex) {
      return back()->withInput()->with('error', 'Verifique se o laboratório/sala foi selecionado! <br/>Erro: ' . $ex->getMessage());
    }       
  }

  public function destroy($id) {
  	$agendamento = AgendaSala::find($id);

    if ($agendamento->id_user == Auth::User()->id){ 
      $agendamento->delete();
      $resp = ['status' => 'successo'];
    } else {
      $resp = ['msg' => 'Somente quem criou esse agendamento pode excluí-lo!', 'status' => 'erro'];
    }
    // retorna um json pois a exclusão é feita via ajax
    return response()->json($resp);
  } 
}
