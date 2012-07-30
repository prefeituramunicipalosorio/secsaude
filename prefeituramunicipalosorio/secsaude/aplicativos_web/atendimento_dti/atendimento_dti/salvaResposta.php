<?
/*
 * Este arquivo faz parte do pacote de códigos "Sistema de Atendimento e Gestão de Demandas do Setor de TI".
 * E está sob a licença GPLv2, localizada em http://saude.osorio.rs.gov.br/?ti&s=softwarelivre&ss=licenca ou no diretório "licenca" (sem aspas) deste pacote de códigos.
 * Copyright (C) 2012 Secretaria Municipal da Saúde, Osório, Rio Grande do Sul, Brasil, dtisaude@hotmail.com
 */

/**
 * @name Arquivo salvaResposta.php, que adiciona respostas aos chamados deste programa
 * @package atendimento_dti
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 1
 * @version 1
 * @license GPLv2
 * @link http://saude.osorio.rs.gov.br/?ti&s=softwarelivre&ss=licenca
 */

session_start();

header("Content-Type: text/html; charset=ISO-8859-1",true);
include("../../inc/crislib.php");
include("../../inc/functions.php");
include("function.php");

$con = conexao();

$idchamado = str($_POST["id"]);
$mensagem = str($_POST["mensagem"]);
$selidusr = sel("dti_pessoas","login = '".str($_SESSION["usuario"])."'");
$b = fetch($selidusr);
$idusuario = $b["id"];

if(empty($idchamado)){
	error("<span style=\"font-size: 11px;\">Oops! Ocorreu algum erro! Informe o DTI.</span>");
}else{
	if($_SESSION["unidade"] == "9"){
		$atendente = 1;
		$emaildestinatario = campo("dti_pessoas","email1",campo("dti_atendimento","idusuario",$idchamado));
		$logindestinatario = campo("dti_pessoas","login",campo("dti_atendimento","idusuario",$idchamado));
		$chavechamado = campo("dti_atendimento","chave",$idchamado);
	}
	$ins = ins("dti_atendimento_respostas","idchamado, idusuario, atendente, data, mensagem","'$idchamado', '$idusuario', '$atendente', '".date("Y-m-d H:i:s")."', '$mensagem'");
	if(!empty($emaildestinatario)){
		mail($emaildestinatario,"[#$idchamado] Seu chamado foi respondido!","Para acessar seu chamado, utilize o login $logindestinatario e acesse este link: http://saude.osorio.rs.gov.br/".URL_MODULO_VIA_PAINEL."&p=chamado&i=$chavechamado ","From: naoresponda@saude.osorio.rs.gov.br");
	}
	info("<span style=\"font-size: 11px;\">Nova resposta adicionada ao chamado!</span>");
        updateChamado($idchamado);
}

$selreply = sel("dti_atendimento_respostas","idchamado = '$idchamado'","id ASC");
while($g = fetch($selreply)){
	$dt = explode(" ",$g["data"]);
	if($g["atendente"] == 1){ $border = " style=\"border-left: solid 3px orange; margin-left: 30px;\""; }else{ $border = ""; }
	e("<div id=\"msg_chamado\"$border>".utf8_decode($g["mensagem"]));
	e("<div id=\"msg_info\">".data($dt[0])." &agrave;s ".substr($dt[1],0,5).", por ".utf8_decode(campo("dti_pessoas","nome",$g["idusuario"]))." (".utf8_decode(campo("unidades","nome",campo("dti_pessoas","unidade",$g["idusuario"]))).")</div>");
	e("</div>");
}
