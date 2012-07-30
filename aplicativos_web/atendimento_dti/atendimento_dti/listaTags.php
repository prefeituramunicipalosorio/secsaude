<?
/*
 * Este arquivo faz parte do pacote de códigos "Sistema de Atendimento e Gestão de Demandas do Setor de TI".
 * E está sob a licença GPLv2, localizada em http://saude.osorio.rs.gov.br/?ti&s=softwarelivre&ss=licenca ou no diretório "licenca" (sem aspas) deste pacote de códigos.
 * Copyright (C) 2012 Secretaria Municipal da Saúde, Osório, Rio Grande do Sul, Brasil, dtisaude@hotmail.com
 */

/**
 * @name Arquivo listaTags.php, que adiciona tags (palavras-chave) aos chamados deste programa
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
$tag = str($_POST["tag"]);

$tags = explode(" ",$tag);

$numtags = count($tags);

$contador = 0;

#echo "n: $numtags | t1: ".$tags[0];

while($contador != $numtags){
    $sel = sel("dti_atendimento","chave = '$chave'");
    $r = fetch($sel);
    if(strpos($r["tags"],$tags[$contador]) === false){
        if($tags[$contador] != ""){
            $novatag = $tags[$contador]." ".$r["tags"];
            $upd = mysql_query("UPDATE dti_atendimento SET tags = '$novatag' WHERE chave = '$chave'") or die(mysql_error());
            $buscaTag = sel("dti_atendimento_tags","tag = '".$tags[$contador]."'");
            if(total($buscaTag) == 0){
                $ins = ins("dti_atendimento_tags","tag, numchamados","'".$tags[$contador]."', '1'");
            }
        }
    }
    $contador = $contador + 1;
}

listaTags($chave);

e("<script type=\"text/javascript\"> window.location.href='#inicioMSG'; </script>");