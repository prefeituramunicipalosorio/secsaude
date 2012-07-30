<?
/*
 * Este arquivo faz parte do pacote de códigos "Sistema de Atendimento e Gestão de Demandas do Setor de TI".
 * E está sob a licença GPLv2, localizada em http://saude.osorio.rs.gov.br/?ti&s=softwarelivre&ss=licenca ou no diretório "licenca" (sem aspas) deste pacote de códigos.
 * Copyright (C) 2012 Secretaria Municipal da Saúde, Osório, Rio Grande do Sul, Brasil, dtisaude@hotmail.com
 */

/**
 * @name Arquivo statusChamado.php, que seta o status dos chamados deste programa
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
$status = str($_POST["status"]);

if(empty($idchamado)){
	error("<span style=\"font-size: 11px;\">Oops! Ocorreu algum erro! Informe o DTI.</span>");
}else{
	$selidusr = sel("dti_pessoas","login = '".str($_SESSION["usuario"])."'");
	$b = fetch($selidusr);
	$idusuario = $b["id"];
	
	$upd = upd("dti_atendimento","status = '$status', quemfechou = '$idusuario'",$idchamado);
        updateChamado($idchamado);
	info("<span style=\"font-size: 11px;\">Status do chamado alterado!</span>");
}