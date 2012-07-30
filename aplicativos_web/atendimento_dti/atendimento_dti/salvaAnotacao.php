<?
/*
 * Este arquivo faz parte do pacote de códigos "Sistema de Atendimento e Gestão de Demandas do Setor de TI".
 * E está sob a licença GPLv2, localizada em http://saude.osorio.rs.gov.br/?ti&s=softwarelivre&ss=licenca ou no diretório "licenca" (sem aspas) deste pacote de códigos.
 * Copyright (C) 2012 Secretaria Municipal da Saúde, Osório, Rio Grande do Sul, Brasil, dtisaude@hotmail.com
 */

/**
 * @name Arquivo salvaAnotacao.php, que adiciona anotações aos chamados deste programa
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
	$ins = ins("dti_atendimento_anotacoes","idchamado, idusuario, data, mensagem","'$idchamado', '$idusuario', '".date("Y-m-d H:i:s")."', '$mensagem'");
        updateChamado($idchamado);
	info("<span style=\"font-size: 11px;\">Nova anota&ccedil;&atilde;o adicionada ao chamado!</span>");
}

$selreply = sel("dti_atendimento_anotacoes","idchamado = '$idchamado'","id ASC");
while($g = fetch($selreply)){
	$dt = explode(" ",$g["data"]);
	e("<div id=\"msg_chamado\" style=\"border-left: solid 3px lightblue; margin-left: 30px;\">".utf8_decode($g["mensagem"]));
	e("<div id=\"msg_info\">".data($dt[0])." &agrave;s ".substr($dt[1],0,5).", por ".utf8_decode(campo("dti_pessoas","nome",$g["idusuario"]))." (".utf8_decode(campo("unidades","nome",campo("dti_pessoas","unidade",$g["idusuario"]))).")</div>");
	e("</div>");
}