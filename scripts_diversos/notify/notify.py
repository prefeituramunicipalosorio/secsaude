#!/usr/bin/python

"""
* Script que verifica no banco de dados se ha alguma notificacao para este computador
* Copyright (C) 2012 Secretaria Municipal da Saude
* Osorio, Rio Grande do Sul, Brasil
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
"""

import os, re, MySQLdb, datetime, time, socket, fcntl, struct
from datetime import *

db_url = "127.0.0.1"
db_usuario = "root"
db_senha = ""
db_nome = "sis"

db = MySQLdb.connect(db_url,db_usuario,db_senha,db_nome)
sql = db.cursor()

def get_ip_address(ifname):
    s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
    return socket.inet_ntoa(fcntl.ioctl(
        s.fileno(),
        0x8915,  # SIOCGIFADDR
        struct.pack('256s', ifname[:15])
    )[20:24])
try:
        ip = get_ip_address('eth0')
except:
        ip = get_ip_address('eth1')

percent = "%"
query = "SELECT * FROM dti_notificacoes WHERE (ip LIKE '%s%s%s' or ip = '') AND status = '1' ORDER BY ip ASC" % (percent,ip,percent)
sql.execute(query)
sel = sql.fetchall()
contador = 0
for y in sel:
        contador = contador+1

        if contador > 0:
                if y[5] == "":
                        icone = "important"
                else:
                        icone = y[5]
                cmd = "DISPLAY=:0 notify-send -i %s '%s' '%s'" % (icone,y[1],y[2])
                r = "".join(os.popen(cmd).readlines())

db.close()
