<?
/*
 * Este arquivo faz parte do pacote de códigos "Sistema de Atendimento e Gestão de Demandas do Setor de TI".
 * E está sob a licença GPLv2, localizada em http://saude.osorio.rs.gov.br/?ti&s=softwarelivre&ss=licenca ou no diretório "licenca" (sem aspas) deste pacote de códigos.
 * Copyright (C) 2012 Secretaria Municipal da Saúde, Osório, Rio Grande do Sul, Brasil, dtisaude@hotmail.com
 */

/**
 * @name Arquivo enviaEmail.php, que informa por e-mail quando o chamado foi respondido
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

$chave = str($_POST["chave"]);
$mensagem = str($_POST["mensagem"]);
$mensagememail = str(utf8_decode($_POST["mensagem"]));
$emaildestino = str($_POST["emaildestino"]);
$buscaid = sel("dti_atendimento","chave = '$chave'"); 
$r = fetch($buscaid);

if(empty($chave) or empty($mensagem) or empty($emaildestino)){
	error("<span style=\"font-size: 11px;\">Oops! Ocorreu algum erro! Informe o DTI! Oops!!! Tu &eacute; do DTI!!! Chama o programador!!! =S</span>");
}else{
	$ins = ins("dti_atendimento_anotacoes","idchamado, idusuario, data, mensagem","'".$r["id"]."', '".$r["idusuario"]."', '".date("Y-m-d H:i:s")."', 'Um e-mail foi enviado para $emaildestino com a seguinte mensagem: <br><i>$mensagem</i>'");
	updateChamado("",$chave);
        $headers = "From: DTI Saude - Osorio / RS <dtisaude@hotmail.com>\r\nCc: dtisaude@hotmail.com";
	mail($emaildestino,"Pedido de suporte #".$r["id"]." / Secretaria da Sa&uacute;de - Os&oacute;rio/RS","Mensagem do DTI: \n\n $mensagememail \n\n --------------------- \n\n Para visualizar o chamado, copie o c�digo abaixo: \n\n$chave \n\n E cole no seguinte link: http://saude.osorio.rs.gov.br/?ticket \n\n Atenciosamente, \n DTI - SMS / Os�rio-RS",$headers);
	info("<span style=\"font-size: 11px;\">E-mail enviado!</span>");
}
?>