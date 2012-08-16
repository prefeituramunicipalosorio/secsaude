<?
/*
 *  EAD Livre para capacitações à distância com foco na facilidade de uso e pequena curva de aprendizado para usar o ambiente
 *  Copyright (C) 2012 Secretaria Municipal da Saúde
 *                   Osório, Rio Grande do Sul, Brasil
 *                          dtisaude@hotmail.com
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

/**
 * @name Arquivo index.php, pertencente ao programa "Ambiente Virtual de Educação À Distância"
 * @package eadlivre
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 2
 * @version 2
 * @license GPLv2
 * @link http://saude.osorio.rs.gov.br/?ti&s=softwarelivre&ss=eadlivre
 */
include("templates/".TEMA_DIR."/lang/".LANG."/lang.php");
$core = new core();
$tema = new temas();
?>
<html>
    <head>
        <title><?= TAG_TITLE ?></title>

        <meta http-equiv="content-language" content="<?= LANG ?>">
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
        <meta name="description" content="" />
        <meta name="keywords" content="">
        <meta name="robots" content="noindex,nofollow">
        <meta name="robots" content="noarchive">
        <meta name="author" content="Tiago Floriano, Dep. TI, Secretaria Municipal da Saude, Osorio, RS" />
        <meta name="reply-to" content="dtisaude@hotmail.com">
        <meta name="google" content="notranslate" />
        
        <script type="text/javascript" src="inc/js.js"></script>
        <link type="text/css" href="inc/css.css" rel="stylesheet" />
        
        <script type="text/javascript" src="<?= "templates/".TEMA_DIR ?>/inc/js.js"></script>
        <link type="text/css" href="<?= "templates/".TEMA_DIR ?>/inc/css.css" rel="stylesheet" />

        <script type="text/javascript" src="<?= "templates/".TEMA_DIR ?>/inc/jquery-1.5.1.js"></script>
        <link type="text/css" href="<?= "templates/".TEMA_DIR ?>/inc/jqueryui/css/redmond/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
        <script type="text/javascript" src="<?= "templates/".TEMA_DIR ?>/inc/jqueryui/js/jquery-ui-1.8.10.custom.min.js"></script>
        <link type="text/css" href="<?= "templates/".TEMA_DIR ?>/inc/jqueryui.css" rel="stylesheet" />
    </head>
    <body>
        <div id="coluna_esq">
            <div id="topo">
                <? $tema->logo() ?>
                <? $tema->boxlogin() ?>
            </div>
        </div>
        <div id="conteudo">
            <div id="menu">
                <? $tema->menu() ?>
            </div>
            <div id="conteudo">
                <? $core->conteudo($_GET["p"],$_GET["s"],$_GET["ss"]) ?>
            </div>
        </div>
        <div style="clear: both"></div>
        <div id="rodape">
            <?= COPY_MSG ?><br>
            <?= COPY_GPL ?>
        </div>
    </body>
</html>