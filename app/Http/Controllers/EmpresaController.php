<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Html\FormFacade;
use Illuminate\Html\HtmlFacade;
use Illuminate\Support\Facades\Auth;
use App\Empresa;
use Validator;
use App\PermissaoUsuario;

class EmpresaController extends Controller {
    
    protected $msgSemPermissao = "Você não tem permissão para fazer isso";
    protected $nivelPermissaoRequerida = 1;

    public function index() {
       $emp = Empresa::orderBy('nome_fantasia')->get();
       return view('empresa.index')->with(['empresas' => $emp, 'pgtitulo' => 'Lista de todas empresas']);
    }

    public function create() {
      
        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('orcamento')->with(['error' => $this->msgSemPermissao]);
        }
        
        return view('empresa.create')->with(['pgtitulo' => 'Adicionando nova empresa']);
    }

    public function store(Request $request) {
       
        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('orcamento')->with(['error' => $this->msgSemPermissao]);
        }

        $emp = new Empresa();

        $emp->nome_fantasia = $request->input('nome_fantasia');
        $emp->cnpj = $request->input('cnpj');
        $emp->telefone = $request->input('telefone');
        $emp->email = $request->input('email');
        $emp->endereco = $request->input('endereco');
        $emp->observacao = $request->input('observacao');
        $emp->save();
        return redirect('empresa')->with(['success' => 'Empresa criada com sucesso!']); 

    }

    public function show($id) {
        //
    }

    public function edit($id) {
        
        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('orcamento')->with(['error' => $this->msgSemPermissao]);
        }
        
        $emp = Empresa::find($id);
        return view('empresa.edit')->with(['emp' => $emp, 'pgtitulo' => 'Editando empresa']);
    }

    public function update(Request $request, $id) {

        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('orcamento')->with(['error' => $this->msgSemPermissao]);
        }
        
        $emp = Empresa::find($id);
        $emp->nome_fantasia = $request->input('nome_fantasia');
        $emp->cnpj = $request->input('cnpj');
        $emp->telefone = $request->input('telefone');
        $emp->email = $request->input('email');
        $emp->endereco = $request->input('endereco');
        $emp->observacao = $request->input('observacao');
        $emp->save();
        return redirect('empresa')->with(['success' => 'Empresa alterada com sucesso!']); 
  
    }

    public function destroy($id) {
        //
    }

}
