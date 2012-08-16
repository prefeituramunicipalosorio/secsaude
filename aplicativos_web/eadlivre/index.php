<?
session_start();
error_reporting(1);
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
 * @name Ambiente Virtual de Educação À Distância
 * @package eadlivre
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 1
 * @version 2
 * @license GPLv2
 * @link http://saude.osorio.rs.gov.br/?ti&s=softwarelivre&ss=eadlivre
 */

include("inc/crislib.php");
include("inc/core.php");
include("inc/config.php");
include("lang/".LANG."/lang.php");

include("templates/default/index.php");