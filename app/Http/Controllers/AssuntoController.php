<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Html\FormFacade;
use Illuminate\Html\HtmlFacade;
use Illuminate\Support\Facades\Auth;

use App\Assunto;
use App\Setor;
use App\PermissaoUsuario;

class AssuntoController extends Controller {

  protected $msgSemPermissao = "Você não tem permissão para fazer isso";
  protected $nivelPermissaoRequerida = 3;

  public function index() {
      
      if (! Auth::check()) {
          return redirect('login');
      }

      $assuntos = Assunto::getAll(Auth::User()->id_setor);
      return view('assunto.index')->with(['assuntos' => $assuntos, 'pgtitulo' => 'Lista de assuntos relacionados ao meu setor']);
  }


  public function create() {

    $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

    if (!Auth::check()) {
      return redirect('login');
    } else if (!$temPermissao) {
      return redirect('assunto')->with(['error' => $this->msgSemPermissao]);
    }

    $setores = Setor::get();
    return view('assunto.create')->with(['setores' => $setores, 'pgtitulo' => 'Adicionando novo assunto para as sugestões']);
  }

  public function store(Request $request) {

    $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

    if (!Auth::check()) {
      return redirect('login');
    } else if (!$temPermissao) {
      return redirect('assunto')->with(['error' => $this->msgSemPermissao]);
    }

    $assunto = new Assunto();
    $assunto->assunto = $request->input('assunto');

    if ($request->input('id_setor') != 0)
      $assunto->id_setor = $request->input('id_setor'); 

    try {
  	  $assunto->save();
      return redirect('assunto/')->with('sucess', 'Assunto criado com sucesso!');
    } catch (\Illuminate\Database\QueryException $ex) {
      return back()->withInput()->with('error', 'Verifique se o setor está preenchido corretamente. <br/>Erro: ' . $ex->getMessage());
    }
  }

  public function show($id) {
      
  }

  public function edit($id) {
     
  }

  public function update(Request $request, $id) {

    $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

    if (!Auth::check()) {
      return redirect('login');
    } else if (!$temPermissao) {
      return redirect('assunto')->with(['error' => $this->msgSemPermissao]);
    }

  }

  public function destroy($id) {
   //   if (! Auth::check()) {
     //     return redirect('login');
     // }
  }

  public function getAssuntos($id_setor) {
    $assuntos = Assunto::getAll($id_setor);
    return response()->json($assuntos);
  }
}
