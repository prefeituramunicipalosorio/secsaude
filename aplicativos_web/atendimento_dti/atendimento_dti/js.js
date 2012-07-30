function urlMod(){
	var urlmod = "mods/atendimento_dti/"; //modifique este local para o local onde ficará instalado seu programa
	return urlmod;
}

function setUrgente(id){
	$('#msg_info').html('Aguarde...');
	$('#msg_info').load(urlMod()+'seturgente.php',{id:id});
}

function novaResposta(id){
	var mensagem = $('#msgreply').val();
	$('#listaRespostas').html('Salvando...');
	$('#listaRespostas').load(urlMod()+'salvaResposta.php',{id: id, mensagem: mensagem});
	$('#msgreply').val('');
}

function novaAnotacao(id){
	var mensagem = $('#msganot').val();
	$('#listaAnotacoes').html('Salvando...');
	$('#listaAnotacoes').load(urlMod()+'salvaAnotacao.php',{id: id, mensagem: mensagem});
	$('#msganot').val('');
}

function statusChamado(id,status){
	$('#msgStatus').html('Salvando...');
	$('#msgStatus').load(urlMod()+'statusChamado.php',{id: id, status: status});
}

function enviarEmail(chave){
	var emaildestino = $('#emaildestino').val();
	var mensagem = $('#corpomensagem').val();
	$('#msgEmail').html('Salvando...');
	$('#msgEmail').load(urlMod()+'enviaEmail.php',{chave: chave, emaildestino: emaildestino, mensagem: mensagem});
	$('#emaildestino').val('');
	$('#corpomensagem').val('');
}

function trocarOrdem(){
	var ordem = $('#trocaordem').val();
	$('#listaDeChamados').html('Carregando...');
	$('#listaDeChamados').load(urlMod()+'listaChamados.php',{ordem: ordem});
        if(ordem == '1'){
            $('#trocaordem').val('0');
        }else{
            $('#trocaordem').val('1');
        }
}

function addNovaTag(){
	var chave = $('#chavechamado').val();
	var tag = $('#formNovaTag').val();
	$('#msgNovaTag').html('Carregando...');
	$('#msgNovaTag').load(urlMod()+'listaTags.php',{chave: chave, tag: tag});
        $('#formNovaTag').val('');
}

function novaTag(){
        $('#novaTag').toggle();
}
