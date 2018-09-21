<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Html\FormFacade;
use Illuminate\Html\HtmlFacade;
use Illuminate\Support\Facades\Auth;
use App\Item;
use App\Empenho;
use App\DetalheEmpenho;
use Validator;
use App\PermissaoUsuario;

class DetalheEmpenhoController extends Controller {
    
    protected $msgSemPermissao = "Você não tem permissão para fazer isso";
    protected $nivelPermissaoRequerida = 1;

    public function index() {
       //$itens = DetalheEmpenho::get();
       return redirect('empenho');
    }

    public function create() {
      
        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('orcamento')->with(['error' => $this->msgSemPermissao]);
        }
        
        $empenhos = Empenho::orderBy('id', 'asc')->get();       
        $itens = Item::orderBy('id', 'asc')->get();       

        return view('detalhe_empenho.create')->with(['empenhos' => $empenhos, 'itens' => $itens, 'pgtitulo' => 'Adicionando novo item']);
    }

    public function store(Request $request) {
       
        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('orcamento')->with(['error' => $this->msgSemPermissao]);
        }
        try {

            $id_empenho = $request->input('id_empenho');
            $previsao_entrega = $request->input('previsao_entrega');
            $id_itens_selecionados = $request->input('id_itens_selecionados');
            $quantidade_itens_selecionados = $request->input('quantidade_itens_selecionados');
            for ($i = 0; $i < count($id_itens_selecionados); $i++){
                $detalheempenho = new DetalheEmpenho();
                $detalheempenho->id_empenho = $id_empenho;
                $detalheempenho->id_item = $id_itens_selecionados[$i];
                $detalheempenho->quantidade = $quantidade_itens_selecionados[$i];
                $detalheempenho->previsao_entrega = $previsao_entrega;
                $detalheempenho->save();
            }
        }  catch (\Illuminate\Database\QueryException $ex) {
            return back()->withInput()->with('error', 'Verifique os campos se todos os campos estão preenchidos corretamente! <br/>Erro: ' . $ex->getMessage());
        }

        return redirect('empenho');
    }

    // recebe o id do empenho
    public function show($id) {
        $ne = Empenho::find($id);
        $itens = DetalheEmpenho::getDetalhes($id);
        //return $itens;
        return view('detalhe_empenho.show')->with(['itens' => $itens, 'pgtitulo' => 'Lista de todos os itens do empenho nº ' . $ne->numero]);
    }

    public function edit($id) {
        $item = DetalheEmpenho::find($id);
        return view('detalhe_empenho.edit')->with(['item' => $item, 'pgtitulo' => 'Editando item do empenho']);
    }

    public function update(Request $request, $id) {

        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('orcamento')->with(['error' => $this->msgSemPermissao]);
        }
        
        try {
            $item = DetalheEmpenho::find($id);
            $item->previsao_entrega = $request->input('previsao_entrega');
            $item->entregue = $request->input('entregue');
            $item->quantidade = $request->input('quantidade');
            $item->cancelado = $request->input('cancelado');
            $item->save();
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->withInput()->with('error', 'Verifique os campos se todos os campos estão preenchidos corretamente! <br/>Erro: ' . $ex->getMessage());
        }

        $id_empenho = $item->id_empenho;

        return redirect()->action('DetalheEmpenhoController@show', ['id' => $id_empenho])->with(['success' => 'Item do empenho alterado com sucesso!']);
  
    }

    public function destroy($id) {
        $item = DetalheEmpenho::find($id);
        $item->delete($id);
        $resp = ['status' => 'successo'];
        // retorna um json pois a exclusão é feita via ajax
        return response()->json($resp);
    }
}
