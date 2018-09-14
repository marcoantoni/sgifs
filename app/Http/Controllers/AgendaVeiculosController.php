<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Html\FormFacade;
use Illuminate\Html\HtmlFacade;
use Illuminate\Support\Facades\Auth;
use App\AgendaVeiculo;
use App\Veiculo;
use App\PermissaoUsuario;

class AgendaVeiculosController extends Controller {
    
    protected $id_setor = 1; //id setor que pode mexer na parte orçamentaria
    protected $msgSemPermissao = "Você não tem permissão para fazer isso";
    protected $nivelPermissaoRequerida = 2;

    public function index() {

        $hoje = date('Y-m-d');
        $agendamentos = AgendaVeiculo::getReservas($hoje, NULL);
        $pgtitulo = "Cronograma de agendamento dos veículos oficiais";
        return view('agenda_veiculo.index')->with(['agendamentos' => $agendamentos, 'pgtitulo' => $pgtitulo]);
    }

    public function create() {

    	$temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

  		if (!Auth::check()) {
	    	return redirect('login');
      } else if (!$temPermissao) {
      	return redirect('agendaveiculos')->with(['error' => $this->msgSemPermissao]);
      }

      $motoristas = AgendaVeiculo::distinct('motorista')->orderBy('motorista', 'ASC')->get(['motorista']);
      $solicitantes = AgendaVeiculo::distinct('solicitante')->orderBy('solicitante', 'ASC')->get(['solicitante']);
      $destinos = AgendaVeiculo::distinct('para_onde')->orderBy('para_onde', 'ASC')->get(['para_onde']);
      $veiculos = Veiculo::get();
      
      return view('agenda_veiculo.create')->with([
        'motoristas' => $motoristas,
        'solicitantes' => $solicitantes,
        'destinos' => $destinos,
        'veiculos' => $veiculos,
        'pgtitulo' => 'Novo agendamento de veículo'
      ]);
    }

   
    public function store(Request $request) {

    	$temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

  		if (!Auth::check()) {
	    	return redirect('login');
      } else if ((Auth::User()->id_setor != $this->id_setor) || !$temPermissao) {
          return $this->msgSemPermissao;
	    }

      $agendamento = new AgendaVeiculo();
      $agendamento->dia = $request->input('dia');
      $agendamento->inicio = $request->input('inicio');
      $agendamento->fim = $request->input('fim');
      $agendamento->id_veiculo = $request->input('id_veiculo');
      $agendamento->solicitante = $request->input('solicitante');
      $agendamento->motorista = $request->input('motorista');
      $agendamento->para_onde = $request->input('para_onde');
      $agendamento->observacao = $request->input('observacao');
     
      try {
        $agendamento->save();
        return redirect('agendaveiculos')->with('sucess', 'Agendamento criado com sucesso!');
      } catch (\Illuminate\Database\QueryException $ex) {
        //return redirect('agendaveiculos.create')->with('error', 'Erro: ' . $ex->getMessage());
        return back()->withInput()->with('error', 'Verifique se o veículo está selecionado! <br/>Erro: ' . $ex->getMessage());
      }       
    }

    public function show($id) {
      $agendamento = AgendaVeiculo::getReserva($id);
      return $agendamento;
    }

    public function edit($id) {
       
    	$temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

  		if (!Auth::check()) {
	    	return redirect('login');
      } else if ((Auth::User()->id_setor != $this->id_setor) || !$temPermissao) {
          return $this->msgSemPermissao;
	    }

      $agendamento = AgendaVeiculo::find($id);
      $motoristas = AgendaVeiculo::distinct('motorista')->orderBy('motorista', 'ASC')->get(['motorista']);
      $solicitantes = AgendaVeiculo::distinct('solicitante')->orderBy('solicitante', 'ASC')->get(['solicitante']);
      $destinos = AgendaVeiculo::distinct('para_onde')->orderBy('para_onde', 'ASC')->get(['para_onde']);
      $veiculos = Veiculo::get();

      return view('agenda_veiculo.edit')->with([
        'agendamento' => $agendamento, 
        'motoristas' => $motoristas,
        'solicitantes' => $solicitantes,
        'destinos' => $destinos,
        'veiculos' => $veiculos,
        'pgtitulo' => 'Editando agendamento de veículo']); 
    }

    public function update(Request $request, $id) {
       
    	$temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

  		if (!Auth::check()) {
	    	return redirect('login');
      } else if ((Auth::User()->id_setor != $this->id_setor) || !$temPermissao) {
          return $this->msgSemPermissao;
	    }

      $agendamento = AgendaVeiculo::find($id);
      $agendamento->dia = $request->input('dia');
      $agendamento->inicio = $request->input('inicio');
      $agendamento->fim = $request->input('fim');
      $agendamento->id_veiculo = $request->input('id_veiculo');
      $agendamento->solicitante = $request->input('solicitante');
      $agendamento->motorista = $request->input('motorista');
      $agendamento->para_onde = $request->input('para_onde');
      $agendamento->observacao = $request->input('observacao');
      $agendamento->excluido = $request->input('excluido');
      
      $agendamento->save();
      
      return redirect('agendaveiculos');  
    }

    public function destroy($id) {
    	//
    }

    public function getReservas($d1, $d2) {
      return $agendamentos = AgendaVeiculo::getReservas($d1, $d2);
    }

}
