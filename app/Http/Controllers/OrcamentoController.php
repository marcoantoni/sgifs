<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notificacao;
use App\Orcamento;
use App\RecursosLiberados;
use App\Empenho;
use App\PermissaoUsuario;

class OrcamentoController extends Controller {

    protected $id_setor = 1; //id setor que pode mexer na parte orçamentaria
    protected $msgSemPermissao = "Você não tem permissão para fazer isso";
    protected $nivelPermissaoRequerida = 1;

    public function index() {
        $ano = date('Y');
        $o = Orcamento::where('ano', $ano)->get();
        $rl = RecursosLiberados::getValorLiberado($ano);
        $totalEmp = Empenho::getTotalGasto($ano);
        $todosEmp = Empenho::getEmpenhos($ano);
        $orc_anual = Orcamento::orderBy('ano', 'DESC')->get();
        $pgtitulo = "Resumo do orçamento de $ano";
        
        if (Auth::check()) {
            $notificacoes = Notificacao::where('id_user', Auth::User()->id)->where('lida', 0)->get();
        } else {
            $notificacoes = false;
        }

        return view('orcamento.index')->with(['orcamento' => $o, 'recursos_liberados' => $rl, 'total_gasto' => $totalEmp, 'empenhos' => $todosEmp, 'orc_anual' => $orc_anual, 'pgtitulo' => $pgtitulo, 'notificacoes' => $notificacoes]);
    }


    public function create() {
        //
    }

    public function store(Request $request) {
        //
    }

    public function show($id) {
        // cópia do método index;
        // $id representa o ano no banco de dados
        $ano = $id;
        $o = Orcamento::get();
        $rl = RecursosLiberados::getValorLiberado($ano);
        $totalEmp = Empenho::getTotalGasto($ano);
        $todosEmp = Empenho::getEmpenhos($ano);
        $orc_anual = Orcamento::orderBy('ano', 'DESC')->get();

        $pgtitulo = "Resumo do orçamento de $ano";
        
        return view('orcamento.show')->with(['orcamento' => $o, 'recursos_liberados' => $rl, 'total_gasto' => $totalEmp, 'empenhos' => $todosEmp, 'orc_anual' => $orc_anual, 'pgtitulo' => $pgtitulo]);
    }

    public function edit($id) {

        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('orcamento')->with(['error' => $this->msgSemPermissao]);
        }

        $ano = date('Y');
        $pgtitulo = "Editando orçamento de $ano";
        $orcamento = Orcamento::where('ano', '=', $id)->first();
        return view('orcamento.edit')->with(['orcamento' => $orcamento, 'pgtitulo' => $pgtitulo]);
    }

    public function update(Request $request, $id) {
        
        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return $this->msgSemPermissao;
        }

        try {
            $orcamento = Orcamento::where('ano', $id)->update(['valor_previsto' => $request->input('valor_previsto')]);
            return redirect('orcamento')->with(['success' => 'Alteração feira com sucesso!']);
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->withInput()->with('error', 'Verifique se o setor está preenchido corretamente. <br/>Erro: ' . $ex->getMessage());
        }

    }

    public function destroy($id) {
        //
    }

}
