<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Html\FormFacade;
use Illuminate\Html\HtmlFacade;
use Illuminate\Support\Facades\Auth;

use App\Orcamento;
use App\RecursosLiberados;
use App\Empenho;
use App\Empresa;
use App\Natureza;
use App\PermissaoUsuario;



class EmpenhoController extends Controller {
   
    protected $nivelPermissaoRequerida = 1;
    protected $msgSemPermissao = "Você não tem permissão para fazer isso";

    public function index() {
        $ano = date('Y');
        $todosEmp = Empenho::getEmpenhos($ano);
        $orc = Orcamento::orderBy('ano', 'DESC')->get();
        $pgtitulo = "Todos empenhos de $ano";
        return view('empenho.index')->with(['empenhos' => $todosEmp, 'orcamento' => $orc, 'pgtitulo' => $pgtitulo]);
    }


    public function create() {

        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('orcamento')->with(['error' => $this->msgSemPermissao]);
        }

        $emp = Empresa::getTodas();
        $nat = Natureza::getTodas();
        $orc = Orcamento::orderBy('ano', 'DESC')->get();
        $pgtitulo = "Adicionando novo empenho";
        return view('empenho.create')->with(['empresas' => $emp, 'natureza' => $nat, 'orcamento' => $orc, 'pgtitulo' => $pgtitulo]);
    }

   
    public function store(Request $request) {

        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('orcamento')->with(['error' => $this->msgSemPermissao]);
        }

        $emp = new Empenho();

        $emp->numero = strtoupper($request->input('numero'));
        $emp->valor = $request->input('valor');
        $emp->id_natureza = $request->input('id_natureza');
        $emp->id_empresa = $request->input('id_empresa');
        $emp->id_orcamento = $request->input('id_orcamento');
        $emp->data = $request->input('data');
        
        // upload do arquivo
        if ($request->hasFile('arquivo')) {
            $nome = $request->file('arquivo')->getClientOriginalName();
            $upload = $request->file('arquivo')->storeAs('empenhos', $nome);
            $emp->arquivo = $nome;
        }

        try {
            $emp->save();
            return redirect('empenho')->with('sucess', 'Empenho criado com sucesso!');
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->withInput()->with('error', 'Verifique se todos os campos estão preenchidos corretamente! <br/>Erro: ' . $ex->getMessage());
        } 
    }

    public function show($id) {
        return redirect()->action('DetalheEmpenhoController@show', ['id' => $id]);
    }

    public function edit($id) {

        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('orcamento')->with(['error' => $this->msgSemPermissao]);
        }

        $empenho = Empenho::find($id);
        $empr = Empresa::getTodas();
        $nat = Natureza::getTodas();
        $orc = Orcamento::orderBy('ano', 'DESC')->get();
        $pgtitulo = "Editando empenho";
        return view('empenho.edit')->with([
            'empenho' => $empenho, 
            'empresas' => $empr, 
            'natureza' => $nat, 
            'orcamento' => $orc, 
            'pgtitulo' => $pgtitulo
        ]);
    }

    public function update(Request $request, $id) {
       
        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('orcamento')->with(['error' => $this->msgSemPermissao]);
        }
        
        $emp = Empenho::find($id);

        $emp->numero = strtoupper($request->input('numero'));
        $emp->valor = $request->input('valor');
        $emp->id_natureza = $request->input('id_natureza');
        $emp->id_empresa = $request->input('id_empresa');
        $emp->id_orcamento = $request->input('id_orcamento');
        $emp->data = $request->input('data');
        $emp->cancelado = $request->input('cancelado');

        // upload do arquivo
        if ($request->hasFile('arquivo')) {
            $nome = $request->file('arquivo')->getClientOriginalName();
            $upload = $request->file('arquivo')->storeAs('empenhos', $nome);
            $emp->arquivo = $nome;
        }

        try {
            $emp->save();
           return redirect('empenho')->with('sucess', 'Empenho salvo com sucesso!');
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->withInput()->with('error', 'Verifique se todos os campos estão preenchidos corretamente! <br/>Erro: ' . $ex->getMessage());
        } 
    }

    
    //public function destroy($id) {
     //   if (! Auth::check()) {
       //     return redirect('login');
       // }
   // }


    public function graficos() {
        $ano = date('Y');
        /*  $o              = Orcamento previsto
            $rl             = Recursos liberados
            $totalEmp       = Total gasto
            $gtnatureza     = Grafico Gastos por natureza
            $dataliberacao  = Grafico Evolução dos recursos liberados
        */

        $o = Orcamento::where('ano', $ano)->get();
        $rl = RecursosLiberados::where('id_orcamento', $ano)->sum('valor'); 
        $totalEmp = Empenho::where('id_orcamento', $ano)->where('cancelado', 0)->sum('valor');
        $gtnatureza = Empenho::getGastosNatureza($ano);
        $rl = RecursosLiberados::where('id_orcamento', $ano)->sum('valor');
        

        $dataliberacao = RecursosLiberados::where('id_orcamento', $ano)->get();

        return view('orcamento.grafico')->with([
            'orcamento' => $o, 
            'recursos_liberados' => $rl, 
            'total_gasto' => $totalEmp, 
            'gastosnatureza' => $gtnatureza, 
            'dataliberacao' => $dataliberacao, 
            'pgtitulo' => 'Gráficos'
        ]);
    }
}
