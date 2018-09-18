<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Html\FormFacade;
use Illuminate\Html\HtmlFacade;
use Illuminate\Support\Facades\Auth;

use App\AgendaEvento;
use App\Sala;
use App\PermissaoUsuario;
use \Carbon\Carbon;

class AgendaEventoController extends Controller {
    
    protected $msgSemPermissao = "Você não tem permissão para fazer isso";
    protected $nivelPermissaoRequerida = 7;

    public function index() {

        $data_inicial = date('Y-m-d');
        $eventos = AgendaEvento::getReservas($data_inicial); 
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

      $eventos = AgendaEvento::distinct('nome_evento')->orderBy('nome_evento', 'ASC')->get(['nome_evento']);
      $responsavel = AgendaEvento::distinct('responsavel')->orderBy('responsavel', 'ASC')->get(['responsavel']);
      $salas = Sala::orderBy('nome', 'ASC')->get();
      $publico_alvo = AgendaEvento::distinct('alvo')->orderBy('alvo', 'ASC')->get(['alvo']);

      return view('agenda_evento.create')->with([
        'eventos' => $eventos,
        'responsavel' => $responsavel,
        'salas' => $salas,
        'publico_alvo' => $publico_alvo,
        'pgtitulo' => 'Agendamento novo evento']);
    }

   
    public function store(Request $request) {

    	$temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

  		if (!Auth::check()) {
	    	return redirect('login');
      } else if (!$temPermissao) {
          return redirect('eventos')->with('error', 'Agendamento criado com sucesso!');
	    }
     
      try {
        // criação de evento repetido - extrair a diferença entre data inicial e final
        $carbon = new Carbon();
        $data_inicio = carbon::createFromFormat('Y-m-d', $request->input('data_inicio'));
        $data_fim = carbon::createFromFormat('Y-m-d', $request->input('data_fim'));
        $diff = $data_fim->diffInDays($data_inicio);

        // criar o evento n vezes de acordo com a $diff
        for ($i=0; $i <= $diff; $i++){
          $evento = new AgendaEvento();
          // grava o link e o nome da inscrição apenas na primeira vez
          if ($i == 0) {
            $evento->link = $request->input('link');
            $evento->nomelink = $request->input('nomelink');
          }

          $evento->nome_evento = $request->input('nome_evento');
          $evento->responsavel = $request->input('responsavel');
          $evento->data_inicio = carbon::createFromFormat('Y-m-d', $request->input('data_inicio'))->addDays($i);
          $evento->hora_inicio = $request->input('hora_inicio');
          $evento->id_sala = $request->input('id_sala');
          $evento->alvo = $request->input('alvo');
          $evento->observacao = $request->input('observacao');
          $evento->id_user = Auth::User()->id;
          $evento->save();
        }

        return redirect('eventos')->with('sucess', 'Evento criado com sucesso!');

      } catch (\Illuminate\Database\QueryException $ex) {
        return back()->withInput()->with('error', 'Verifique se o laboratório/sala foi selecionado! <br/>Erro: ' . $ex->getMessage());
      }       
    }

    //public function show($id) {

    //}

    public function edit($id) {
       
    	$temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

  		if (!Auth::check()) {
	    	return redirect('login');
      } else if (!$temPermissao) {
          return redirect('eventos')->with('error', $this->msgSemPermissao); 
	    }
      
      $evento = AgendaEvento::find($id);
      
      if ($evento->id_user == Auth::User()->id){
        $eventos = AgendaEvento::distinct('nome_evento')->orderBy('nome_evento', 'ASC')->get(['nome_evento']);
        $responsavel = AgendaEvento::distinct('responsavel')->orderBy('responsavel', 'ASC')->get(['responsavel']);
        $salas = Sala::orderBy('nome', 'ASC')->get();
        $publico_alvo = AgendaEvento::distinct('alvo')->orderBy('alvo', 'ASC')->get(['alvo']);
        
        return view('agenda_evento.edit')->with([
          'evento' => $evento, 'salas' => $salas, 
          'eventos' => $eventos,
          'responsavel' => $responsavel,
          'salas' => $salas,
          'publico_alvo' => $publico_alvo,
          'pgtitulo' => 'Editando agendamento de evento'
        ]);
         
      } else {
        return redirect('eventos')->with('error', 'Somente quem criou esse agendamento pode editá-lo!');
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

    //public function destroy($id) {
    	//
    //}

}
