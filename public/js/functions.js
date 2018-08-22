

function redirectToEmpenhos(){
  var e = document.getElementById("anos_anteriores");
  var ano = e.options[e.selectedIndex].text

	var baseUrl = location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: '');
	var redirectTo = baseUrl + '/empenho/' + ano;
 	window.location.replace(redirectTo);
}

function validarTxtSugestao(){
    if(document.getElementById('respostasim').checked) {
      var nome = $("#nome").val(); 
      var email = $("#email").val(); 
      alert(nome + email);
      var erros = 0;
      
      /*if (nome.length < 3){
        erros++;
        $("#msgaviso").append("Você marcou que deseja uma respota: Preencha seu nome<br>"); 
      }
      if (email.length < 3){
        erros++;
        $("#msgaviso").append("Você marcou que deseja uma respota: Preencha seu email<br>");
      }*/

      //if (erros > 0){
       // $("#aviso").show();

        return false;
        
    //  }
  }