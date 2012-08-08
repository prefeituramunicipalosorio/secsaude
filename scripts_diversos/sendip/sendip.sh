#!/bin/bash

: << LICENCA
/*
* Script para atualização de IP num banco de dados mysql hospedado em outro computador
* Copyright (C) 2012 Secretaria Municipal da Saúde
* Osório, Rio Grande do Sul, Brasil
* dtisaude@hotmail.com
* Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
*
* Este programa e software livre; voce pode redistribui-lo e/ou
* modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
* publicada pela Free Software Foundation; tanto a versao 2 da
* Licenca como (a seu criterio) qualquer versao mais nova.
*
* Este programa e distribuido na expectativa de ser util, mas SEM
* QUALQUER GARANTIA; sem mesmo a garantia implicita de
* COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
* PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
* detalhes.
*
* Voce deve ter recebido uma copia da Licenca Publica Geral GNU
* junto com este programa; se nao, escreva para a Free Software
* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
* 02111-1307, USA.
*
* Copia da licenca no diretorio licenca/licenca_en.txt
* licenca/licenca_pt.txt
*/
LICENCA

localhost="127.0.0.1"
ip0="$(ifconfig eth0 | grep "end.:" | cut -f2 -d ':' | sed 's/Bcast/ /g' | sed 's/ //g')"
ip1="$(ifconfig eth1 | grep "end.:" | cut -f2 -d ':' | sed 's/Bcast/ /g' | sed 's/ //g')"

IN="`ip addr | cut -c16-32 | egrep \"[0-9a-z]{2}[:][0-9a-z]{2}[:][0-9a-z]{2}[:][0-9a-z]{2}[:][0-9a-z]{2}[:][0-9a-z]{2}$\"`"
set -- "$IN"
IFS=" "; declare -a Array=($*)
mac="${Array[0]}"

url="http://$localhost/updateIP.php?ip0=$ip0&ip1=$ip1&mac=$mac"

curl $url
