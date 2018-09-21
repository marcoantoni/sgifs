<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Html\FormFacade;
use Illuminate\Html\HtmlFacade;
use Illuminate\Support\Facades\Auth;
use Storage;

use App\Abastecimento;
use App\Veiculo;
use App\PermissaoUsuario;
use App\User;

class AbastecimentoController extends Controller {
    
  protected $msgSemPermissao = "Você não tem permissão para fazer isso";
  protected $nivelPermissaoRequerida = 6;

  public function index() {

    $veiculos = Veiculo::orderBy('modelo', 'ASC')->get();

    $pgtitulo = "Relatório de abastecimento dos veículos";
    return view('abastecimento.index')->with(['veiculos' => $veiculos, 'pgtitulo' => $pgtitulo]);
  }

  public function create() {

  	$temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

		if (!Auth::check()) {
    	return redirect('login');
    } else if (!$temPermissao) {
    	return redirect('abastecimento')->with(['error' => $this->msgSemPermissao]);
    }

    $veiculos = Veiculo::orderBy('modelo', 'ASC')->get();
    $usuarios = User::orderBy('name', 'ASC')->get();

    return view('abastecimento.create')->with(['veiculos' => $veiculos, 'usuarios' => $usuarios, 'pgtitulo' => 'Novo abastecimento']);
  }

   
  public function store(Request $request) {

  	$temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

		if (!Auth::check()) {
    	return redirect('login');
    } else if (!$temPermissao) {
        return redirect('abastecimento')->with('error', 'Agendamento criado com sucesso!');
    }
   
    try {
      $abastecimento = new Abastecimento();
      $abastecimento->valor = $request->input('valor');
      $abastecimento->data = $request->input('data');
      $abastecimento->km = $request->input('km');
      $abastecimento->id_veiculo = $request->input('id_veiculo');
      $abastecimento->litros = $request->input('litros');
      $abastecimento->id_user = $request->input('id_user');
     
      $abastecimento->media = $this->calcularMedia($request->input('id_veiculo'), $request->input('km'), $request->input('litros'));

      // upload do arquivo
      if ($request->hasFile('arquivo')) {
        $nome = $request->file('arquivo')->getClientOriginalName();
        $upload = $request->file('arquivo')->storeAs('nfabastecimentos', $nome);
        $abastecimento->arquivo = $nome;
      }
      $abastecimento->save();
      return redirect('abastecimento')->with('success', 'Abastecimento criado com sucesso!');
      
    } catch (\Illuminate\Database\QueryException $ex) {
      return back()->withInput()->with('error', 'Verifique se todos os campos foram preenchidos corretamente! <br/>Erro: ' . $ex->getMessage());
    }       
  }

  // $id do veículo a ser pesquisado
  // retorna todos os abastecimentos do veiculo
  public function show($id) {
    $abastecimentos = Abastecimento::orderBy('data', 'DESC')->where('id_veiculo', $id)->get();
    $veiculos = Veiculo::orderBy('modelo', 'ASC')->get();
    $pgtitulo = "Lista de abastecimentos";
    return view('abastecimento.show')->with(['abastecimentos' => $abastecimentos, 'veiculos' => $veiculos, 'pgtitulo' => $pgtitulo]);       
  }

  public function edit($id) {
     
  	$temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

		if (!Auth::check()) {
    	return redirect('login');
    } else if (!$temPermissao) {
        return $this->msgSemPermissao;
    }
    
    $veiculos = Veiculo::orderBy('modelo', 'ASC')->get();
    $usuarios = User::orderBy('name', 'ASC')->get();
    $pgtitulo = "Editando abastecimento";

    $abastecimento = Abastecimento::find($id);
    return view('abastecimento.edit')->with(['abastecimento' => $abastecimento, 'usuarios' => $usuarios, 'veiculos' => $veiculos, 'pgtitulo' => $pgtitulo]); 
  }

  public function update(Request $request, $id) {
     
  	$temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

		if (!Auth::check()) {
    	return redirect('login');
    } else if (!$temPermissao) {
        return $this->msgSemPermissao;
    }
    
    try {
      $abastecimento = Abastecimento::find($id);
      $abastecimento->valor = $request->input('valor');
      $abastecimento->data = $request->input('data');
      $abastecimento->km = $request->input('km');
      $abastecimento->id_veiculo = $request->input('id_veiculo');
      $abastecimento->litros = $request->input('litros');

      // ao editar a media deve ser inserida manualmente
      $abastecimento->media = $request->input('media');
      $abastecimento->id_user = $request->input('id_user');

      // upload do arquivo
      if ($request->hasFile('arquivo')) {
          $nome = $request->file('arquivo')->getClientOriginalName();
          $upload = $request->file('arquivo')->storeAs('nfabastecimentos', $nome);
          $abastecimento->arquivo = $nome;
      }
      $abastecimento->save();
      return redirect()->action('AbastecimentoController@show', ['id' => $request->input('id_veiculo')])->with(['success' => 'Abastecimento editado com sucesso!']);

    } catch (\Illuminate\Database\QueryException $ex) {
      return back()->withInput()->with('error', 'Verifique se todos os campos foram preenchidos corretamente! <br/>Erro: ' . $ex->getMessage());
    }            
  }

  public function destroy($id) {
  	$abastecimento = Abastecimento::find($id);
    Storage::delete('/storage/nfabastecimento/' . $abastecimento->arquivo);
    $abastecimento->delete();
    return response()->json(['status' => 'successo']);
  }

  private function calcularMedia($id_veiculo, $kmatual, $qtd_litros){
    
    $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

    if (!Auth::check()) {
      return redirect('login');
    } else if (!$temPermissao) {
      return redirect('abastecimento')->with(['error' => $this->msgSemPermissao]);
    }

    // calcular o consumo médio 
    $ultimoabastecimento = Abastecimento::where('id_veiculo', $id_veiculo)->orderBy('id', 'DESC')->first();
    if ($ultimoabastecimento){
      $kmrodada = $kmatual - $ultimoabastecimento->km;
      $media = $kmrodada / $qtd_litros;
    } else {
      $media = 0;
    }
    return $media;
  }
}
