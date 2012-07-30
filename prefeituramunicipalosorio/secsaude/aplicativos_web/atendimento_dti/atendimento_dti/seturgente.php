<?
/*
 * Este arquivo faz parte do pacote de códigos "Sistema de Atendimento e Gestão de Demandas do Setor de TI".
 * E está sob a licença GPLv2, localizada em http://saude.osorio.rs.gov.br/?ti&s=softwarelivre&ss=licenca ou no diretório "licenca" (sem aspas) deste pacote de códigos.
 * Copyright (C) 2012 Secretaria Municipal da Saúde, Osório, Rio Grande do Sul, Brasil, dtisaude@hotmail.com
 */

/**
 * @name Arquivo seturgente.php, que seta como urgente os chamados deste programa
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

$id = str($_POST["id"]);

if(empty($id)){
	error("<span style=\"font-size: 11px;\">Oops! Ocorreu algum erro! Informe o DTI.</span>");
}else{
	if($_SESSION["unidade"] != "9"){
		$campo = campo("dti_atendimento","urgencia_usuario",$id);
		if($campo == 1){ $campo = 0; }else{ $campo = 1; }
		$campotabela = "urgencia_usuario = '$campo'"; 
	}else{
		$campo = campo("dti_atendimento","urgencia_atendente",$id);
		if($campo == 1){ $campo = 0; }else{ $campo = 1; }
		$campotabela = "urgencia_atendente = '$campo'"; 
	}
	$upd = upd("dti_atendimento",$campotabela,$id);
        updateChamado($idchamado);
	#info("<span style=\"font-size: 11px;\">Status de URG&Ecirc;NCIA atualizado!</span>");
}

$buscaid = sel("dti_atendimento","id = '$id'"); 
$r = fetch($buscaid);
$dt = explode(" ",$r["data"]);
e("".data($dt[0])." &agrave;s ".substr($dt[1],0,5).", por ".utf8_decode(campo("dti_pessoas","nome",$r["idusuario"]))." (".utf8_decode(campo("unidades","nome",campo("dti_pessoas","unidade",$r["idusuario"]))).")");
			
			if($r["urgencia_usuario"] == 1 or $r["urgencia_atendente"] == 1){
				e("<br><span style=\"color: red; font-weight: bold\">O ");
			}
			
			if($r["urgencia_usuario"] == 1){
				e("usu&aacute;rio");
			}
			
			if($r["urgencia_atendente"] == 1){
				if($r["urgencia_usuario"] == 1){
					e(" e o ");
				}
				e("atendente");
			}
			
			if($r["urgencia_usuario"] == 1 or $r["urgencia_atendente"] == 1){
				if($r["urgencia_usuario"] == 1 && $r["urgencia_atendente"] == 1){
					e(" setaram ");
				}else{
					e(" setou ");
				}
				e("este chamado como URGENTE!");
			}
			
			e("<br><a href=\"#\" onclick=\"setUrgente('".$r["id"]."')\">Setar/Retirar URG&Ecirc;NCIA deste chamado</a>");
