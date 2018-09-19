<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Html\FormFacade;
use Illuminate\Html\HtmlFacade;
use Illuminate\Support\Facades\Auth;
use App\Orcamento;
use App\RecursosLiberados;
use App\PermissaoUsuario;
use Validator;

class RecursosLiberadosController extends Controller {

    protected $nivelPermissaoRequerida = 1;
    protected $msgSemPermissao = "Você não tem permissão para fazer isso";

    public function index() {
        
        $ano = date('Y');
        $rlibs = RecursosLiberados::where('id_orcamento', $ano)->orderBy('data', 'ASC')->get(); 
        $pgtitulo = "Recursos liberados no ano de $ano";
        return view('recursosliberados.index')->with(['rlibs' => $rlibs, 'pgtitulo' => $pgtitulo]);
    }

    public function create() {

        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return $this->msgSemPermissao;
        }

        $ano = date('Y');
        $rlibs = RecursosLiberados::where('id_orcamento', $ano)->orderBy('data', 'ASC')->get(); 

        $orcamento = Orcamento::orderBy('ano', 'DESC')->get();
        return view('recursosliberados.create')->with(['orcamento' => $orcamento, 'rlibs' => $rlibs, 'pgtitulo' => 'Liberando novo recurso']);
    }

    public function store(Request $request) {
        
        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return $this->msgSemPermissao;
        }

        $rlib = new RecursosLiberados();
        $rlib->valor = $request->input('valor');
        $rlib->data = $request->input('data');
        $rlib->id_orcamento = $request->input('id_orcamento');
        
        try {
            $rlib->save();
            return redirect('rlib')->with(['sucess' => 'Recurso liberado com sucesso']);
        } catch (\Illuminate\Database\QueryException $ex) {
            return redirect('rlib')->with('error', 'Erro: ' . $ex->getMessage());
        } 

    }

    public function show($id) {
        
        $ano = $id;
        $rlibs = RecursosLiberados::getEvolucaoValorLiberado($ano);
        $pgtitulo = "Recursos liberados no ano de $ano";
        return view('recursosliberados.show')->with(['rlibs' => $rlibs, 'pgtitulo' => $pgtitulo]);
    }

    public function edit($id) {

        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);
        
        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return $this->msgSemPermissao;
        }

        $rlib = RecursosLiberados::find($id);

        $ano = date('Y');
        $rlibs = RecursosLiberados::where('id_orcamento', $ano)->orderBy('data', 'ASC')->get(); 

        $orcamento = Orcamento::get();
        return view('recursosliberados.edit')->with(['rlib' => $rlib, 'orcamento' => $orcamento, 'rlibs' => $rlibs, 'pgtitulo' => 'Editando recurso liberado']); 
    }

    public function update(Request $request, $id) {
        
        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return $this->msgSemPermissao;
        }
        
        $rlib = RecursosLiberados::find($id);
        $rlib->valor = $request->input('valor');
        $rlib->data = $request->input('data');
        $rlib->id_orcamento = $request->input('id_orcamento');
        
        try {
            $rlib->save();
            return redirect('rlib')->with(['sucess' => 'Alteração feita com sucesso']);
        } catch (\Illuminate\Database\QueryException $ex) {
            return redirect('rlib')->with('error', 'Erro: ' . $ex->getMessage());
        }     
    }

    public function destroy($id) {
        //
    }

}
