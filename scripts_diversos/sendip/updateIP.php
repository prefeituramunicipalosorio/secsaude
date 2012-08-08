<?
/*
 *  updateIP.php - script que atualiza as informações de IP e MAC no banco de dados
 * Este arquivo é parte integrante do pacote sendIP (https://github.com/prefeituramunicipalosorio/secsaude/tree/master/scripts_diversos)
 * Copyright (C) 2012 Secretaria Municipal da Saúde
 * Osório, Rio Grande do Sul, Brasil
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
error_reporting(0);
include("crislib.php");
date_default_timezone_set('America/Sao_Paulo');

con("root","");
db("sis");

$ip0 = str($_GET["ip0"]);
$ip1 = str($_GET["ip1"]);
if($ip0 == ""){
    if($ip1 == ""){
        exit;
    }else{
        $ip = $ip1;
    }
}else{
    $ip = $ip0;
}
$mac = str($_GET["mac"]);
$nmac = $mac[0].$mac[1].":".$mac[3].$mac[4].":".$mac[6].$mac[7].":".$mac[9].$mac[10].":".$mac[12].$mac[13].":".$mac[15].$mac[16];

$data = date("Y-m-d H:i:s");

$i = ins("dti_rede_clientes","ip0, ip1, mac, data","'$ip0','$ip1','$nmac','$data'");

mysql_connect("127.0.0.1","usr201201","q4w9Q3SGYjVazHmL") or die(mysql_error());
mysql_select_db("PrW2KqYEbfv5hcQe") or die(mysql_error());
$upd = mysql_query("UPDATE dti_patrimonio SET ip_rede = '$ip' WHERE gab_mac = '$nmac'") or die(mysql_error());

mysql_close();
