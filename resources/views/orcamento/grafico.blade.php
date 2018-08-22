@extends('layout')

@section('content')
    <h1 class="ls-title-intro ls-ico-stats">Gastos do campus</h1>

    <script type="text/javascript" src="{{ URL::asset('js/Chart.js') }}"></script>

    <div class="col-md-4">
        <h2 class="ls-title-3">Orçamento atual</h2>
        <canvas id="orcamento" width="400px" height="400px"></canvas>
    </div>
    <div class="col-md-4">
        <h2 class="ls-title-3">Gastos por natureza</h2>
        <canvas id="gastosnatureza" width="400px" height="400px"></canvas>
    </div>
    <div class="col-md-4">
        <h2 class="ls-title-3">Evolução dos recursos liberados</h2>
        <canvas id="dataliberacao" width="400px" height="400px"></canvas>
    </div>

    <script>
        var dynamicColors = function() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return "rgb(" + r + "," + g + "," + b + ")";
        }

        var ctxnatureza = document.getElementById("gastosnatureza");
        var ctxorcamento = document.getElementById("orcamento");
        var ctcliberacaorecursos = document.getElementById("dataliberacao");


        var graficoNatureza = new Chart(ctxnatureza, {
            type: 'doughnut',
            data: {
                labels: [
                    @foreach ($gastosnatureza as $g)
                        "{{ $g->natureza }}",
                    @endforeach
                ],
                datasets: [{
                    data: [
                        @foreach ($gastosnatureza as $g)
                            {{ $g->soma }},
                        @endforeach

                    ],
                    backgroundColor: [
                      @foreach ($gastosnatureza as $g)//  dynamicColors(),
                        dynamicColors(),
                        @endforeach
                    ],
                    borderWidth: 1
                }]
            }
        });

        var graficoOrcamento = new Chart(ctxorcamento, {
            type: 'bar',
            data: {
                labels: ["Orçamento previsto", "Recursos liberados", "Total gasto"],
                datasets: [{
                    label: 'R$',
                    data: [{{ $orcamento[0]->valor_previsto }}, {{ $recursos_liberados}}, {{ $total_gasto }}],
                    backgroundColor: ["rgba(255, 99, 132, 0.2)", "rgba(255, 159, 64, 0.2)", "rgba(255, 205, 86, 0.2)"],
                    borderColor: ["rgb(255, 99, 132)", "rgb(255, 159, 64)", "rgb(255, 205, 86)"],
                    borderWidth: 1
                }]
            }
        });

        var graficoLiberacaoRecursos = new Chart(ctcliberacaorecursos, {
            type: 'line',
            data: {
                labels: [
                    @foreach($dataliberacao as $dt_liberado)
                        "{{ $dt_liberado->data }}",
                    @endforeach
                ],
                datasets: [{
                    label: 'R$',
                    data: [
                         @foreach($dataliberacao as $dt_liberado)
                            "{{ $dt_liberado->valor }}",
                         @endforeach
                    ],
                    borderWidth: 0
                }]
            }
        });
    </script>
@stop