<?
/*
 * Este arquivo faz parte do pacote de códigos "Sistema de Atendimento e Gestão de Demandas do Setor de TI".
 * E está sob a licença GPLv2, localizada em http://saude.osorio.rs.gov.br/?ti&s=softwarelivre&ss=licenca ou no diretório "licenca" (sem aspas) deste pacote de códigos.
 * Copyright (C) 2012 Secretaria Municipal da Saúde, Osório, Rio Grande do Sul, Brasil, dtisaude@hotmail.com
 */

/**
 * @name Arquivo functions.php, que guarda funções úteis a este programa
 * @package atendimento_dti
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 1
 * @version 1
 * @license GPLv2
 * @link http://saude.osorio.rs.gov.br/?ti&s=softwarelivre&ss=licenca
 */
 

### CONFIGURAÇÕES GERAIS ###
define('URL_MODULO','mods/atendimento_dti/'); //informe o diretório onde o módulo será instalado, a partir da raiz
define('URL_MODULO_VIA_PAINEL','/?painel&m=atendimento_dti'); //informe como ficará a URL no navegador para acessar seu módulo
include_once("crislib.php"); //inclusão da biblioteca de funções crislib.php


/**
 * @name menuLateral()
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 1
 * @example menuLateral();
 */
function menuLateral(){
    $path = URL_MODULO_VIA_PAINEL."&p=";
    ?>
    <div id="menulateral">
        <ul>
            <li><a href="<?= $path."novo" ?>">Novo chamado</a></li>
            <li><a href="<?= $path."" ?>">Chamados abertos</a></li>
            <li><a href="<?= $path."reabertos" ?>">Chamados reabertos</a></li>
            <li><a href="<?= $path."fechados" ?>">Chamados fechados</a></li>
        </ul>
    </div>
    <?
}

/**
 * @name listaChamados()
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 1
 * @param int $status | int $ordem | string $tag
 * @example listaChamados('1','1','desenvolvimento');
 */
function listaChamados($status=1,$ordem=false,$tag=false){
	$where = "";
	if($_SESSION["unidade"] != "9"){
		$where .= "idusuario = '".str($_SESSION["idu"])."'";
	}
	
	#if($status != 1){
		if($where != ""){
			$where .= " and ";
		}
		if($status == 1){
			$where .= "(status = '1' or status = '3')";
		}else{
			$where .= "status = '$status'";
		}
                if($tag == true){
                    if($where != ""){
                        $where .= " and ";
                    }
                    $tag = utf8_encode($tag);
                    $where .= "tags LIKE '%$tag%'";
                }
	#}
 #echo $where;
        if($ordem == true){
            if($ordem == "1"){
                $ordem = "dataupdate ASC";
            }else{
                $ordem = "dataupdate DESC";
            }
        }else{
            $ordem = "dataupdate DESC";
        }
	$sel = sel("dti_atendimento","$where","$ordem");
        $totalchamados = total($sel);
	if($totalchamados == 0){
		error("<span style=\"font-size: 11px;\">Nenhum chamado encontrado aqui.</span>");
	}
	while($r = fetch($sel)){
		$dt = explode(" ",$r["data"]);
		e("<div id=\"linhachamado\">[#".$r["id"]."] ");

		
		if($status == 1){
			if($r["status"] == 3){
				e("[reaberto] ");
			}
		}

		if($r["urgencia_usuario"] == 1 or $r["urgencia_atendente"] == 1){
			e("(<span style=\"color: red; font-weight: bold\">!!!</span>)");
		}
		/*if($r["urgencia_usuario"] == 1){
			e("!!!");
		}
		if($r["urgencia_atendente"] == 1){
			e("!!!");
		}
		if($r["urgencia_usuario"] == 1 or $r["urgencia_atendente"] == 1){
			e("</span>)");
		}*/
		$buscarespostas = sel("dti_atendimento_respostas","idchamado = '".$r["id"]."'");
		$contareplys = total($buscarespostas);
		if($contareplys == 0){
			$contareplys = "nenhuma intera&ccedil;&atilde;o ainda";
		}
		if($contareplys == 1){
			$contareplys = "1 resposta";
		}
		if($contareplys > 1){
			$contareplys = "$contareplys respostas";
		}
		if($r["urgencia_atendente"] == 1){
			e(" <span style=\"color: red;\"><a href=\"".URL_MODULO_VIA_PAINEL."&p=chamado&i=".$r["chave"]."\" style=\"color: red;\">");
		}else{
			e(" <a href=\"".URL_MODULO_VIA_PAINEL."&p=chamado&i=".$r["chave"]."\">");
		}
		e(utf8_decode($r["assunto"])."</a>, ".data($dt[0])." &agrave;s ".substr($dt[1],0,5).", por ".utf8_decode(campo("dti_pessoas","nome",$r["idusuario"]))." (".utf8_decode(campo("unidades","nome",campo("dti_pessoas","unidade",$r["idusuario"])))."), $contareplys");
		
		if($r["urgencia_atendente"] == 1){
			e("</span>");
		}
		
		e("</div>");
	}
        $datahora = date("Y-m-d H:i:s");
        $buscaStats = sel("dti_atendimento_contador","data = '".date("Y-m-d")."' and numchamados = '$totalchamados'");
        if(total($buscaStats) == 0){
            //insere nova contagem
            $ins = ins("dti_atendimento_contador","data, datah, numchamados","'".date("Y-m-d")."', '$datahora', '$totalchamados'");
        }

        //verifica se o novo contador para ver se é maior que já teve
        $maiorStat = sel("dti_atendimento_contador","numchamados < '$totalchamados'","numchamados DESC,datah DESC","1");
        if(total($maiorStat) > 0 && $status == 1){
            $i = fetch($maiorStat);
            if($i["numchamados"] < $totalchamados){
                $dh = explode(" ",$i["datah"]);
                $data = data($dh[0]);
                $hora = $dh[1];
                #$record = "Este &eacute; o <b style=\"color: red\">maior</b> n&uacute;mero de chamados desde $data, &agrave;s $hora (".$i["numchamados"]." chamados).";
            }
        }else{
            $menorStat = sel("dti_atendimento_contador","numchamados > '$totalchamados'","numchamados ASC,datah DESC","1");
            if(total($menorStat) > 0 && $status == 1){
                $i = fetch($menorStat);
                if($i["numchamados"] > $totalchamados){
                    $dh = explode(" ",$i["datah"]);
                    $data = data($dh[0]);
                    $hora = $dh[1];
                    #$record = "Este &eacute; o <b style=\"color: green\">menor</b> n&uacute;mero de chamados desde $data, &agrave;s $hora (".$i["numchamados"]." chamados).";
                }
            }
        }
        info("Temos $totalchamados chamados abertos neste momento. $record");
}

/**
 * @name updateChamado()
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 1
 * @param int $idchamdo | string $chave
 * @example updateChamado('1','minhachavecriptografada');
 */
function updateChamado($idchamado,$chave=false){
        if($chave == true){
            $upd = mysql_query("UPDATE dti_atendimento SET dataupdate = '".date("Y-m-d H:i:s")."' SET chave = '$chave'") or die(mysql_error());
        }else{
            $upd = upd("dti_atendimento","dataupdate = '".date("Y-m-d H:i:s")."'",$idchamado);
        }
}

/**
 * @name listaTags()
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 1
 * @param string $chave
 * @example listaTags('minhachavecriptografada');
 */
function listaTags($chave){
        $sel = sel("dti_atendimento","chave = '$chave'");
        $r = fetch($sel);
        e("<b>Tags: </b>");
        $tags = explode(" ",$r["tags"]);
        $numtags = count($tags);
        $contador = 0;
        while($contador != $numtags){
            e("<a href=\"".URL_MODULO_VIA_PAINEL."&tag=".utf8_decode($tags[$contador])."\">".utf8_decode($tags[$contador])."</a> ");
            $contador = $contador + 1;
        }
        e(" [<a href=\"#\" onclick=\"novaTag()\">nova tag</a>]");
}

/**
 * @name listaTagsHome()
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 1
 * @example listaTagsHome();
 */
function listaTagsHome(){
    $sel = sel("dti_atendimento_tags","");
    $tags = "";
    while($r = fetch($sel)){
        $sel2 = sel("dti_atendimento","status = '1' and tags LIKE '%".$r["tag"]."%'");
        $totalchamados = total($sel2);
        if($totalchamados > 0){
            $fontsize = 10+($totalchamados*2);
            $tags .= "<a href=\"".URL_MODULO_VIA_PAINEL."&tag=".utf8_decode($r["tag"])."\" style=\"font-size: {$fontsize}px\">".utf8_decode($r["tag"])."</a> ";
        }
    }
    info($tags);
    e("<br>");
}
