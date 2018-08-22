<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Html\FormFacade;
use Illuminate\Html\HtmlFacade;
use Illuminate\Support\Facades\Auth;

use App\AgendaEvento;
use App\Sala;
use App\PermissaoUsuario;

class AgendaEventoController extends Controller {
    
    protected $msgSemPermissao = "Você não tem permissão para fazer isso";
    protected $nivelPermissaoRequerida = 7;

    public function index() {

        $data_inicial = date('Y-m-d');
        $eventos = AgendaEvento::getReservas($data_inicial); //'dia', '>=', $data_inicial)->get();
        $pgtitulo = "Cronograma de eventos do campus";
        return view('agenda_evento.index')->with(['eventos' => $eventos, 'pgtitulo' => $pgtitulo]);
    }

    public function create() {

    	$temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

  		if (!Auth::check()) {
	    	return redirect('login');
      } else if (!$temPermissao) {
      	return redirect('eventos')->with(['error' => $this->msgSemPermissao]);
      }

      $salas = Sala::orderBy('nome', 'ASC')->get();

      return view('agenda_evento.create')->with(['salas' => $salas, 'pgtitulo' => 'Agendamento novo evento']);
    }

   
    public function store(Request $request) {

    	$temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

  		if (!Auth::check()) {
	    	return redirect('login');
      } else if (!$temPermissao) {
          return redirect('eventos')->with('error', 'Agendamento criado com sucesso!');
	    }
     
      try {
        $evento = new AgendaEvento();
        $evento->nome_evento = $request->input('nome_evento');
        $evento->responsavel = $request->input('responsavel');
        $evento->data_inicio = $request->input('data_inicio');
        $evento->data_fim = $request->input('data_fim');
        $evento->hora_inicio = $request->input('hora_inicio');
        $evento->id_sala = $request->input('id_sala');
        $evento->alvo = $request->input('alvo');
        $evento->observacao = $request->input('observacao');
        $evento->link = $request->input('link');
        $evento->nomelink = $request->input('nomelink');

//        $evento->id_user = Auth::User()->id;
        $evento->save();

        return redirect('eventos')->with('sucess', 'Evento criado com sucesso!');

      } catch (\Illuminate\Database\QueryException $ex) {
        return back()->withInput()->with('error', 'Verifique se o laboratório/sala foi selecionado! <br/>Erro: ' . $ex->getMessage());
      }       
    }

    public function show($id) {
      //$agendamento = AgendaVeiculo::getReserva($id);
      return $agendamento;
    }

    public function edit($id) {
       
    	$temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

  		if (!Auth::check()) {
	    	return redirect('login');
      } else if (!$temPermissao) {
          return redirect('eventos')->with('error', $this->msgSemPermissao); 
	    }
      
      $evento = AgendaEvento::find($id);
      
      //if ($agenda->id_user == Auth::User()->id){
        $salas = Sala::orderBy('nome', 'ASC')->get();
        return view('agenda_evento.edit')->with(['evento' => $evento, 'salas' => $salas, 'pgtitulo' => 'Editando agendamento de evento']); 
      //} else {
        //return redirect('agenda')->with('error', 'Somente quem criou esse agendamento pode editá-lo!');
      //}
    }

    public function update(Request $request, $id) {
       
    	$temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

  		if (!Auth::check()) {
	    	return redirect('login');
      } else if (!$temPermissao) {
          return $this->msgSemPermissao;
	    }

      try {
        $evento = AgendaEvento::find($id);
        $evento->nome_evento = $request->input('nome_evento');
        $evento->responsavel = $request->input('responsavel');
        $evento->data_inicio = $request->input('data_inicio');
        $evento->data_fim = $request->input('data_fim');
        $evento->hora_inicio = $request->input('hora_inicio');
        $evento->id_sala = $request->input('id_sala');
        $evento->alvo = $request->input('alvo');
        $evento->observacao = $request->input('observacao');
        $evento->link = $request->input('link');
        $evento->nomelink = $request->input('nomelink');

        $evento->save();
        return redirect('eventos')->with('sucess', 'Agendamento alterado com sucesso!');
      } catch (\Illuminate\Database\QueryException $ex) {
        return back()->withInput()->with('error', 'Verifique se o laboratório/sala foi selecionado! <br/>Erro: ' . $ex->getMessage());
      }       
    }

    public function destroy($id) {
    	//
    }

}
