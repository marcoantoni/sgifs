<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Html\FormFacade;
use Illuminate\Html\HtmlFacade;
use Illuminate\Support\Facades\Auth;

class MonitoramentoController extends Controller {

    //protected $nivelPermissaoRequerida = 1;
    //protected $msgSemPermissao = "Você não tem permissão para fazer isso";

    public function index() {
        return view("monitoramento.index")->with(["pgtitulo" => "Monitramento"]);
    }

    public function create() {

    }

    public function store(Request $request) {

    }

    public function show($id) {
        //
    }

    public function edit($id) {

    }

    public function update(Request $request, $id) {

    }

    public function destroy($id) {
        //
    }
}
