<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Html\FormFacade;
use Illuminate\Html\HtmlFacade;
use Illuminate\Support\Facades\Auth;

use App\Natureza;
use App\PermissaoUsuario;


class NaturezaController extends Controller {
    
    protected $nivelPermissaoRequerida = 1;
    protected $msgSemPermissao = "Você não tem permissão para fazer isso";

    public function index() {
        $naturezas = Natureza::orderBy('nome', 'ASC')->get();
        return view('natureza.index')->with(['naturezas' => $naturezas, 'pgtitulo' => 'Lista de naturezas de gasto']);
    }

    public function create() {

        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('orcamento')->with(['error' => $this->msgSemPermissao]);
        }

        return view('natureza.create')->with(['pgtitulo' => 'Adicionando nova natureza de gasto']);
    }

    public function store(Request $request) {

        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('orcamento')->with(['error' => $this->msgSemPermissao]);
        }

        $nat = new Natureza();
        $nat->nome = $request->input('nome');
        $nat->save();
        
        return redirect('natureza')->with(['sucess' => 'Natureza adicionada com sucesso']);  

    }

    public function show($id) {
        $empenho = Empenho::find($id);
        return view('empenho.show')->with(['empenho' => $empenho, 'pgtitulo' => 'Exibindo natureza de gasto']);
    }

    public function edit($id) {
        
        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('natureza')->with(['error' => $this->msgSemPermissao]);
        }

        $natureza = Natureza::find($id);
        return view('natureza.edit')->with(['natureza' => $natureza, 'pgtitulo' => 'Editando natureza de gasto']);
    }

    public function update(Request $request, $id) {
        
        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('orcamento')->with(['error' => $this->msgSemPermissao]);
        }

        $nat = Natureza::find($id);
        $nat->nome = $request->input('nome');
        $nat->save();
        return redirect('natureza')->with(['sucess' => 'Natureza adicionada com sucesso']);  
    }

    //public function destroy($id)
    //{
     //   if (! Auth::check()) {
       //     return redirect('login');
       // }
   // }
}
