#!/usr/bin/python

"""
* Este arquivo faz parte do pacote de códigos "Mapa da rede".
* Mapa da rede - script que verifica disponibilidade de computadores ou rádios específicos na rede, e exibe em um mapa
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

import os, re, MySQLdb, datetime, time
from datetime import *

db = MySQLdb.connect("127.0.0.1","root","","sis")
sql = db.cursor()

query = "SELECT * FROM dti_rede_ips ORDER BY ip ASC"
sql.execute(query)
sel = sql.fetchall()
for y in sel:
	cmd = "ping -c4 " + y[1]
	r = "".join(os.popen(cmd).readlines())
	pegadata = datetime.now()
	data = pegadata.strftime("%Y-%m-%d %H:%M:%S")
	if re.search ("64 bytes from", r):
		# link up
		explode = r.split('min/avg/max/mdev = ')
		explode2 = explode[1].split('/')
		ins2 = "INSERT INTO dti_rede_pings (ip, data, mediaping, status) VALUES ('%s', '%s', '%s', '1')" % (y[1],data,explode2[1])
		upd = "UPDATE dti_rede_ips SET mediaping = '%s', status = '1' WHERE ip = '%s'" % (explode2[1],y[1])
		print "# %s = on (%s)" % (y[1],y[2])
	else:
		# link down"
		ins2 = "INSERT INTO dti_rede_pings (ip, data, status) VALUES ('%s', '%s', '0')" % (y[1],data)
		upd = "UPDATE dti_rede_ips SET status = '0' WHERE ip = '%s'" % (y[1])
		print "# %s = OFFLINE (%s)" % (y[1],y[2])
	sql.execute(ins2)
	db.commit()
	sql.execute(upd)
	db.commit()
db.close()
