<?
/*
 * Mapa da rede - script que verifica disponibilidade de computadores ou rádios específicos na rede, e exibe em um mapa
 * Copyright (C) 2012 Secretaria Municipal da Saude
 * Osorio, Rio Grande do Sul, Brasil
 * dtisaude@hotmail.com
 * Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */


/*
 * DADOS DE ACESSO
 */
$dburl = "127.0.0.1";
$dbusr = "root";
$dbpwd = "";
$dbnam = "sis";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Mapa Rede - SMS - Os&oacute;rio / RS</title>
		<script src="inc/jquery.js" type="text/javascript"></script>
		<script src="inc/jquery.imageLens.js" type="text/javascript"></script>
		<script src="inc/maparede.js" type="text/javascript"></script>
		<link type="text/css" href="inc/maparede.css" rel="stylesheet" />
		<script>
		$(function() {
			$( "#boxaux" ).draggable();
		});
		</script>
		<meta http-equiv="refresh" content="300;URL=/sms-api/maparede.php">
	</head>
	<body>
	<img src="img/rede.png" style="width: 1360px; height: 720px;" id="img_03">
	<?
	include("inc/crislib.php");
	mysql_connect($dburl,$dbusr,$dbpwd) or die(mysql_error());
	mysql_select_db($dbnam) or die(mysql_error());
        
	if($_GET["d"] == "1"){

                /*
                 * d = demonstração
                 * d = 1 = simula como se alguns pontos da rede ocilando
                 */

		$orderby = "RAND()";
		$limit = 5;
		$link = "<meta http-equiv=\"refresh\" content=\"10;URL=/sms-api/maparede.php?d=1\">";
		$alarm = "<div id=\"boxaux\" draggable=\"true\"><h3>Ferramentas</h3><audio id=\"audio1\" src=\"extras/alarm.wav\" autoplay=\"autoplay\" controls=\"controls\" loop=\"loop\" preload=\"auto\" autobuffer></audio></div>";
	}elseif($_GET["d"] == "2"){

                /*
                 * d = 2 = simula como se todos os pontos da rede tivessem ocilando
                 */

		$orderby = "RAND()";
		$limit = 100;
		$link = "<meta http-equiv=\"refresh\" content=\"5;URL=/sms-api/maparede.php?d=2\">";
		$alarm = "<div id=\"boxaux\" draggable=\"true\"><h3>Ferramentas</h3><audio id=\"audio1\" src=\"extras/alarm.wav\" autoplay=\"autoplay\" controls=\"controls\" loop=\"loop\" preload=\"auto\" autobuffer></audio></div>";
	}else{

                /*
                 * d = '' = não simula nada. Este é como a rede está de fato.
                 */

		$orderby = "";
		$limit = 100;
		$link = "";
		$alarm = "";
	}
	$sel = sel("dti_rede_ips","",$orderby,$limit);
	while($r = fetch($sel)){
		if($r["mediaping"] > 100 && $r["mediaping"] < 299){
		    $classalert = " class=\"alerta1\"";
		}elseif($r["mediaping"] > 300 && $r["mediaping"] < 599){
		    $classalert = " class=\"alerta2\"";
		}elseif($r["mediaping"] > 600 && $r["mediaping"] < 899){
		    $classalert = " class=\"alerta3\"";
		}elseif($r["mediaping"] > 900){
		    $classalert = " class=\"alerta4\"";
		    $contador = $contador + 1;
		}elseif($r["status"] == 0){
		    $classalert = " class=\"alerta5\"";
		    $contador = $contador + 1;
		}else{
		    $classalert = "";
		}
		e("<div id=\"".$r["label"]."\"$classalert></div>");
	}
	if($contador > 0){
		$alarm = "<div id=\"boxaux\" draggable=\"true\"><h3>Ferramentas</h3><audio id=\"audio1\" src=\"extras/alarm.wav\" autoplay=\"autoplay\" controls=\"controls\" loop=\"loop\" preload=\"auto\" autobuffer></audio></div>";
	}
	e($link);
	e($alarm);
	?>
	</body>
</html>
