<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Html\FormFacade;
use Illuminate\Html\HtmlFacade;
use Illuminate\Support\Facades\Auth;
use App\Empresa;
use App\PermissaoUsuario;
use Validator;

class EmpresaController extends Controller {

    protected $nivelPermissaoRequerida = 1;
    protected $msgSemPermissao = "Você não tem permissão para fazer isso";

    public function index() {
      
    }

    public function create() {

        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return $this->msgSemPermissao;
        }
    }

    public function store(Request $request) {

        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return $this->msgSemPermissao;
        }

    }

    public function show($id) {
        //
    }

    public function edit($id) {

        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return $this->msgSemPermissao;
        }
    }

    public function update(Request $request, $id) {

        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return $this->msgSemPermissao;
        }
    }

    public function destroy($id) {
        //
    }
}
