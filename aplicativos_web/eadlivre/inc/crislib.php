<?
/*
 *  crislib - biblioteca de funções em PHP
 *  Copyright (C) 2012 Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
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
 * @name crisLib <http://paico.wordpress.com/crislib/>
 * @author Original by Tiago Floriano <mail@tiagofloriano.com.br> <http://tiagofloriano.com/>
 * @author Modified by LeoCaseiro <http://www.leocaseiro.com/> 2008-11-28 11:47
 * @author Modified by nome <email ou URI> aaaa-mm-dd hh:mm  //para os pr�ximos que modificarem
 * @version 1.0.2
 * @license GPLv2
 * @since  Documenta��o no formato PHPDocumentor e arquivo em UTF-8		Release 1.0.1	//aqui devemos colocar as releases
 * 
 * 
 * 
 * �NDICE
 * 
 * Resumo de fun��es: fun��es que s�o abrevia��es(resumos) de outras fun��es
 * Login de usu�rios: funl�oes para fazer um login de usu�rio de forma simples e pr�tica
 * Banco de Dados: fun��es para inserir, selecionar, excluir e atualizar dados
 * Arquivos: manipula��o de Arquivos
 * Protocolos: email e ftp
 * Utilidades: fun��es �teis
 * Plugins: adicione aqui os plugins da crisLib
 * 
 */


####################
### Resumo de Fun��es ###
####################

/**
 * Atalho para a fun��o mysql_escape_string
 * 
 * @name escape
 * @author php-br, canal brasileiro de PHP no IRC <irc.freenode.net>
 * @param string $string		//troquei de $n para $string, assim fica mais semantico by LeoCaseiro
 * @return string
 */
function escape($string){
	return mysql_escape_string($string);
}

/**
 * Atalho do mysql_num_rows
 *
 * @name total
 * @param string $query
 * @return int $num
 */
function total($query){
	$num = mysql_num_rows($query);
	return $num;
}


/**
 * Atalho para fun��o mysql_fetch_array
 * 
 * @name fetch
 * @param string $query
 * @return array
 */
function fetch($query){
	$fetch = mysql_fetch_array($query);
	return $fetch;
}

/**
 * Resumo da fun��o mysql_real_escape_string
 *
 * @name str
 * @param string $nome
 * @return string
 */
function str($nome){
	$filtro = strip_tags($nome);
	$filtro = addslashes($filtro);
	$filtro = mysql_real_escape_string($filtro);
	return $filtro;
}


/**
 * Atalho da fun��o echo
 *
 * @name e
 * @param string $texto
 * @return string
 */
function e($texto){
	echo $texto;
}

/**
 * Imprime um par�grafo centralizado
 *
 * @name p
 * @param string $texto
 * @param bool $red	caso for true, exibe texto em vermelho
 */
function p($texto, $red = false){ //(deixei por default o normal, assim...basta digitar p("escrevi aqui"); //Sem precisar do $red
	if(!$red){ //mensagem normal
		e("<p align=\"center\">$texto</p>");
	}elseif($red){ //mensagem de erro
		e("<p align=\"center\" style=\"color: red\">$texto</p>");
	}else{
		echo "<p>$texto</p>";
	}
}


####################
### LOGIN DE USU�RIO ###
####################

/**
 * Fun��o que autentica o usu�rio
 *
 * @name login
 * @param string $usuario
 * @param string $senha
 * @param string $tabela_de_usuarios
 * @param string $tabela_de_sessoes
 * @param string $destino
 */
function login($usuario, $senha, $tabela_de_usuarios, $tabela_de_sessoes, $destino){
	//verifica se o usu�rio e a senha constam na tabela
	echo "Verificando usu&aacute;rio ... ";
	$sel = sel($tabela_de_usuarios,"usuario = '$usuario' and senha = '$senha'","","");
	echo "<b>ok</b><br>";
	if(mysql_num_rows($sel) == 0){//se n�o existir, mostra a mensagem abaixo
		echo "<i>Este usu&aacute;rio n&atilde;o existe!</i><br><br>";
		echo "<a href=\"javascript:history.go(-1);\">Voltar</a>";
		exit; //encerra a execu��o do arquivo, n�o permitindo que o usu�rio prossiga
	}else{
		echo "Gravando sess&atilde;o ... ";
		//guarda usuario e senha
		$_SESSION["login"] = $usuario;
		$_SESSION["senha"] = $senha;
		echo "<b>ok</b><br>";
		//guarda um valor de sess�o �nico para gravar que o usu�rio est� logado
		if($tabela_de_controle_de_sessoes != ""){
			$_SESSION["idsession"] = date("H") + date("i") + date("s") + date("d") + date("m") + date("Y");
			$idsession = $_SESSION["idsession"];
			ins($tabela_de_controle_de_sessoes,"usuario, senha, sessao, status","'$usuario', '$senha', '$idsession','online'");
		}
		echo "Redirecionando ... ";
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=$destino\">";
		echo "<b>ok</b>";
		exit;
	}
}

/**
 * Fun��o para desautenticar o usu�rio
 *
 * @name logoff
 * @param sting $usuario
 * @param string $senha	//na minha opini�o, este valor � desnecess�rio para esta fun��o By LeoCaseiro
 * @param string $tabela_de_usuarios
 * @param string $tabela_de_sessoes
 * @param string $destino
 */
function logoff($usuario, $senha, $tabela_de_usuarios, $tabela_de_sessoes, $destino){
	if($tabela_de_sessoes != ""){
		$ids = $_SESSION["idsession"];
		$sel = sel($tabela_de_sessoes,"ids = '$ids' and usuario = '$usuario and senha = '$senha'","","");
		if(total($sel) != 0){
			$r = fetch($sel);
			$del = del($tabela_de_sessoes,$r["id"]);
			$_SESSION["idsession"] = "";
			$_SESSION["login"] = "";
			$_SESSION["senha"] = "";
			echo "Usu&aacute;rio desautenticado...";
		}
	}else{
		$login = $_SESSION["login"];
		$senha = $_SESSION["senha"];
		$sel = sel($tabela_de_usuarios,"login = '$login' and senha = '$senha'","","");
		if(total($sel) > 0){
			$_SESSION["login"] = "";
			$_SESSION["senha"] = "";
			echo "Usu&aacute;rio desautenticado...";
		}
	}
}

/**
 * Verifica se o usu�rio est� autenticado e o redireciona para a p�gina de login
 *
 * @name is_autenticado	
 * @param string $tabela_de_usuarios
 * @param string $destino
 * @param string $tabela_de_sessoes
 */
function is_autenticado($tabela_de_usuarios, $destino, $tabela_de_sessoes) {
	if(is_on($tabela_de_usuarios,$tabela_de_sessoes) == false){
		e("Voc&ecirc; n&atilde;o est&aacute; logado! Redirecionando...");
		e("<meta http-equiv=\"refresh\" content=\"0;URL=$destino\">");
	}
}


/**
 * Verifica se o usu�rio est� autenticado
 *
 * @name is_on
 * @param string $tabela_de_usuarios
 * @param bool $tabela_de_sessoes caso for true, verifica autentica��o atrav�s de tabela de controle de sess�es no banco de dados
 * @return bool
 */
function is_on($tabela_de_usuarios, $tabela_de_sessoes = false){
	$login = str($_SESSION["login"]);
	$senha = str($_SESSION["senha"]);
	$sel = sel($tabela_de_usuarios,"usuario = '$login' and senha = '$senha'","","");
	if(total($sel) == 0){
		return false;
	}else{
		if($tabela_de_sessoes != ""){
			$ids = $_SESSION["idsession"];
			$sel = sel($tabela_de_sessoes,"ids = '$ids' and usuario = '$usuario and senha = '$senha'","","");
			if(total($sel) == 0){
				return false;
			}else{
				return true;
			}
		}else{
			return true;
		}
	}
}

######################
### BANCO DE DADOS ###
######################

/**
 * Fun��o para conectar no Bando de Dados
 * 
 * @name con
 * @param string $usuario
 * @param string $senha
 * @return bool
 */
function con($usuario, $senha, $localhost=false){
        if($localhost == false){ $localhost = "localhost"; }
	if(!mysql_connect($localhost,$usuario,$senha)){
		echo "Erro ao conectar no db.";
		return false;
	} else {
		return true;
	}
}


/**
 * Selecionando um db
 *
 * @name db
 * @param string $db
 * @return bool
 */
function db($db){
	if(!mysql_select_db($db)){
		echo "Erro ao selecionar db.";
		return false;
	} else {
		return true;
	}
}


/**
 * Fun��o para exucutar consulta(select) no banco
 *
 * @name sel
 * @param string $tabela
 * @param string $condicoes
 * @param string $ordem
 * @param int $limite
 * @return true|die		if die, print mysql_error
 */
function sel($tabela, $condicoes, $ordem = false, $limite = false){
	$query = "SELECT * FROM $tabela";
	if($condicoes != "") {
		$query .= " WHERE $condicoes";
	}
	if($ordem != ""){
		$query .= " ORDER BY $ordem";
	}
	if($limite != ""){
		$query .= " LIMIT $limite";
	}
	$sql = mysql_query($query) or die(mysql_error());
	return $sql;
}


/**
 * Retorna o valor de um determinado registro(id) na tabela
 *
 * @name campo
 * @param string $tabela
 * @param string $campo
 * @param int $id
 * @return string
 */
function campo($tabela, $campo, $id){
	$sel = mysql_query("SELECT * FROM $tabela WHERE id = '$id'") or die(mysql_error());
	$r = mysql_fetch_array($sel);
	return $r[$campo];
}


/**
 * Insere os campos com os respectivos valores
 *
 * @name ins
 * @param string $tabela
 * @param string $campos	seguidos de v�rgula
 * @param string $valores	seguidos de v�rgula
 * @return true|die		if die, print mysql_error
 */
function ins($tabela, $campos, $valores){
	$query = "INSERT INTO $tabela ($campos) VALUES ($valores)";
	$sql = mysql_query($query) or die(mysql_error());
	return $sql;
}


/**
 * Efetua uma altera��o (update) em uma tabela com seus respectivos valores
 *
 * @name upd
 * @param string $tabela
 * @param string $dados
 * @param int $id
 * @return true|die		if die, print mysql_error
 */
function upd($tabela, $dados, $id){
	$query = "UPDATE $tabela SET $dados WHERE id = '$id'";
	$sql = mysql_query($query) or die(mysql_error());
	return $sql;
}


/**
 * Deletar
 *
 * @name del
 * @param string $tabela
 * @param int $id
 * @return true|die		if die, print mysql_error
 */
function del($tabela, $id){
	$query = "DELETE FROM $tabela WHERE id = '$id'";
	$sql = mysql_query($query) or die(mysql_error());
	return $sql;
}


/**
 * Criar tabela
 *
 * @name createT
 * @param string $nometabela
 * @param string $campos
 * @return true|die		if die, print mysql_error
 */
function createT($nometabela,$campos){
	$sql = mysql_query("CREATE TABLE IF NOT EXISTS $nometabela ( id int(11), $campos, primary key(id) )") or die(mysql_error());
	return $sql;
}

##############
### ARQUIVOS ###
##############

# - Nome: Upload de arquivos
function up($arquivo,$destino,$extensoes){//para permitir todas extens��es de arquivos, deixe a $extens�es em branco, se n�o, informe todas as extens�es permitidas

}

# - Nome: Gera miniatura de imagem gif, png ou jpg
/**
 * Gera miniatura de imagem gif, png ou jpg
 *
 * @param string $imagem
 * @param int $h	altura
 * @param int $w	largura
 * @return string endere�o da miniatura gerada da imagem ($imagem)
 * @example im("imagens/minhaimagem.png",150,200);
 */
function im($imagem, $h, $w){
	//verifica na $imagem o que � pasta, o que � arquivo e o que � extens�o
	$explode = explode("/",$imagem);
	$pasta = $explode[0]."/"; // $pasta = pasta_de_imagens/
	$arquivo = $explode[1]; // $arquivo = arquivo.jpg ou .gif ou .png
	$explode = explode(".",$arquivo);
	$extensao = $explode[1];
	$nomearquivo = $explode[0];
	//script original: http://sniptools.com/tutorials/generating-jpggifpng-thumbnails-in-php-using-imagegif-imagejpeg-imagepng
	//adaptado por Tiago Floriano Webdesigner em 27 de outubro de 2007
	$thumbWidth = $w; // Intended dimension of thumb
	$thumbHeight = $h;
	if(!file_exists($pasta.$nomearquivo."_".$w.$h.".".$extensao)){
		if($extensao == "jpg" or $extensao == "JPG" or $extensao == "jpeg" or $extensao == "JPEG"){
			// Beyond this point is simply code.
			$sourceImage = imagecreatefromjpeg($imagem);
			$sourceWidth = imagesx($sourceImage);
			$sourceHeight = imagesy($sourceImage);

			$targetImage = imagecreatetruecolor($thumbWidth,$thumbHeight);
			imagecopyresampled($targetImage,$sourceImage,0,0,0,0,$thumbWidth,$thumbHeight,imagesx($sourceImage),imagesy($sourceImage));
			imagejpeg($targetImage,$pasta.$nomearquivo."_".$w.$h.".".$extensao);
			$thumbName = $pasta.$nomearquivo."_".$w.$h.".".$extensao;
		}
		if($extensao == "gif" or $extensao == "GIF"){
			// Beyond this point is simply code.
			$sourceImage = imagecreatefromgif($imagem);
			$sourceWidth = imagesx($sourceImage);
			$sourceHeight = imagesy($sourceImage);

			$targetImage = imagecreatetruecolor($thumbWidth,$thumbHeight);
			imagecopyresampled($targetImage,$sourceImage,0,0,0,0,$thumbWidth,$thumbHeight,imagesx($sourceImage),imagesy($sourceImage));
			imagegif($targetImage, $pasta.$nomearquivo."_".$w.$h.".".$extensao);
			$thumbName = $pasta.$nomearquivo."_".$w.$h.".".$extensao;
		}
		if($extensao == "png" or $extensao == "PNG"){
			// Beyond this point is simply code.
			$sourceImage = imagecreatefrompng($imagem);
			$sourceWidth = imagesx($sourceImage);
			$sourceHeight = imagesy($sourceImage);

			$targetImage = imagecreatetruecolor($thumbWidth,$thumbHeight);
			imagecopyresampled($targetImage,$sourceImage,0,0,0,0,$thumbWidth,$thumbHeight,imagesx($sourceImage),imagesy($sourceImage));
			imagepng($targetImage, $pasta.$nomearquivo."_".$w.$h.".".$extensao);
			$thumbName = $pasta.$nomearquivo."_".$w.$h.".".$extensao;
		}
	}else{
		$thumbName = $pasta.$nomearquivo."_".$w.$h.".".$extensao;
	}
	return $thumbName;
}

/**
 * Exibe arquivos de uma pasta
 *
 * @param string $diretorio
 */
function pasta($diretorio){

}

/**
 * Edita arquivo
 *
 * @param string $arquivo
 */
function arq($arquivo){

}

################
### PROTOCOLOS ###
################

/**
 * Fun��o para Enviar E-mail
 *
 * @param string $destino
 * @param string $assunto
 * @param string $mensagem
 * @param string $remetente
 * @param string $tipo	(html|texto)	
 * @param string $protocolo	(mail|smtp)
 */
function sendmail($destino, $assunto, $mensagem, $remetente, $tipo, $protocolo){//o $tipo � se o e-mail � html ou somente texto, o $protocolo � se � usando a fun��o mail ou smtp
	if($protocolo == "mail"){ //criado por LeoCaseiro e adaptado por Tiago Floriano
		if($tipo == "html"){
			/* Para enviar email HTML, voc� precisa definir o header Content-type. */
			$headers  = 'MIME-Version: 1.0\n';
			$headers .= 'Content-type: text/html; charset=iso-8859-1\n';
		}
		/* headers adicionais */
		$headers .= "From: $deNome <$deEmail>\r\n";
		$headers .= "To: $paraNome <$paraEmail>\r\n";
		/* Enviar o email */
		if(mail($para, $assunto, $mensagem, $headers)) {
			return true;
		}else{
			return false;
		}
	}else{
		//smtp
	}
}



/**
 * Criar conta de e-mail no cPanel
 *
 * @param string $email
 * @param string $senha
 */
function criamail($email, $senha){

}

/**
 * Deleta e-mail do cPanel
 *
 * @param string $email
 * @param string $senha
 */
function delmail($email,$senha){

}

##########################
### UTILIDADES E INUTILIDADES ###
##########################

/**
 * Retira caracteres especiais de uma string
 *
 * @param string $string
 * @return string
 */
function remCE($string){
	//retira acentos
	$string = str_replace("ã","a",$string);
	$string = str_replace("á","a",$string);
	$string = str_replace("à","a",$string);
	$string = str_replace("ä","a",$string);
	$string = str_replace("â","a",$string);

	#$string = str_replace("ẽ","e",$string);
	$string = str_replace("é","e",$string);
	$string = str_replace("è","e",$string);
	$string = str_replace("ë","e",$string);
	$string = str_replace("ê","e",$string);

	$string = str_replace("ĩ","i",$string);
	$string = str_replace("í","i",$string);
	$string = str_replace("ì","i",$string);
	$string = str_replace("ï","i",$string);
	$string = str_replace("î","i",$string);

	$string = str_replace("õ","o",$string);
	$string = str_replace("ó","o",$string);
	$string = str_replace("ò","o",$string);
	$string = str_replace("ö","o",$string);
	$string = str_replace("ô","o",$string);

	$string = str_replace("ũ","u",$string);
	$string = str_replace("ú","u",$string);
	$string = str_replace("ù","u",$string);
	$string = str_replace("ü","u",$string);
	$string = str_replace("û","u",$string);

	$string = str_replace("ç","c",$string);

	//retira outras porcarias
	$string = str_replace("\"","",$string);
	$string = str_replace("'","",$string);
	$string = str_replace("�","",$string);
	$string = str_replace("`","",$string);
	$string = str_replace("!","",$string);
	$string = str_replace("#","",$string);
	$string = str_replace("$","",$string);
	$string = str_replace("%","",$string);
	$string = str_replace("�","",$string);
	$string = str_replace("&","",$string);
	$string = str_replace("*","",$string);
	$string = str_replace("(","",$string);
	$string = str_replace(")","",$string);
	$string = str_replace("_","",$string);
	$string = str_replace("-","",$string);
	$string = str_replace("+","",$string);
	$string = str_replace("=","",$string);
	$string = str_replace("�","",$string);
	$string = str_replace("}","",$string);
	$string = str_replace("]","",$string);
	$string = str_replace("�","",$string);
	$string = str_replace("�","",$string);
	$string = str_replace("�","",$string);
	$string = str_replace("�","",$string);
	$string = str_replace("�","",$string);
	$string = str_replace("�","",$string);
	$string = str_replace("{","",$string);
	$string = str_replace("[","",$string);
	$string = str_replace("�","",$string);
	$string = str_replace("^","",$string);
	$string = str_replace("~","",$string);
	$string = str_replace("?","",$string);
	$string = str_replace("/","",$string);
	$string = str_replace("�","",$string);
	$string = str_replace("<","",$string);
	$string = str_replace(",","",$string);
	$string = str_replace(">","",$string);
#	$string = str_replace(".","",$string);
	$string = str_replace(":","",$string);
	$string = str_replace(";","",$string);
	$string = str_replace("|","",$string);
	$string = str_replace("\\","",$string);
	$string = str_replace(" ","",$string);

	//retira espa�os
	$string = trim($string);

	return $string;
}


/**
 * Exibe m�s em Portugu�s do Brasil
 *
 * @param int $mes
 * @return string	(use ucfirst para deixar com a 1a. letra mai�scula)
 */
function mes($mes){
	if($mes == 1){
		$mes = "janeiro";
	}
	if($mes == 2){
		$mes = "fevereiro";
	}
	if($mes == 3){
		$mes = "mar&ccedil;o";
	}
	if($mes == 4){
		$mes = "abril";
	}
	if($mes == 5){
		$mes = "maio";
	}
	if($mes == 6){
		$mes = "junho";
	}
	if($mes == 7){
		$mes = "julho";
	}
	if($mes == 8){
		$mes = "agosto";
	}
	if($mes == 9){
		$mes = "setembro";
	}
	if($mes == 10){
		$mes = "outubro";
	}
	if($mes == 11){
		$mes = "novembro";
	}
	if($mes == 12){
		$mes = "dezembro";
	}
	return $mes;
}


/**
 * Transforma data formato aaaa-mm-dd para dd/mm/aaaa ou dd de mm de aaaa
 *
 * @param string $data 	(aaaa-mm-dd)
 * @param bool $tipo	(if true, exibe dd/mm/aaaa, else print dd de mm de aaaa) //valor default
 * @return string	(dd/mm/aaaa)
 */
function data($data, $tipo = 0){
	if($tipo == 0){
		$data = explode("-",$data);
		$data = $data[2]."/".$data[1]."/".$data[0];
	}elseif($tipo == 1){
		$data = explode("-",$data);
		$data = $data[2]." de ".mes($data[1])." de ".$data[0];
	}else{
		$data = explode("/",$data);
		$data = $data[2]."-".$data[1]."-".$data[0];
        }
	return $data;
}


/**
 * Atalho para URL (Ex: ?pagina ao inv�s de page=pagina)
 *
 * @param string $uri
 * @param string $pasta
 * @return string
 * @example $path = url($_SERVER['REQUEST_URI'],"meusite/"); include($path);
 */
function url($uri, $pasta) { //Podemos amadurecer mais ainda esta fun��o
	if($uri == "/$pasta"){ $uri = "/?home"; }
	$uri = explode("?",$uri);
	$uri = explode("&",$uri[1]);
	$uri = $uri[0];
	$arquivo = "pages/".$uri.".php";//pages ? o nome da pasta onde ficar?o os arquivos internos que guardam o conte?do, que ser?o inseridos no arquivo principal, no lugar do conte?do. Mude para o nome da pasta onde voc? guarda os arquivos.
	if(is_file($arquivo)){
		$path = $arquivo;
	}else{
		$path = "pages/erro.php";
	}
	return $path;
}

/**
 * Verifica se uma string est� vazia
 *
 * @param string $var
 * @param int $num
 * @return bool
 */
function is_clear($var, $num){ //pega variavel e o n�mero de campos que h� nela
	$str = explode(" ",$var); //registra array
	$cont = 0;
	while($cont <= $num){ //enquanto a $cont for diferente de $num, ele faz a verifica��o
		if($str[$cont] != ""){ //se $str n�o for vazia, soma 1 na $result
			$result = $result + 1;
		}
		$cont = $cont + 1;
	}
	if($result == $num){ //se todas as $str tiverem valor, o resultado deste if deve ser true
		return true;
	}else{ //se houver algum campo vazio, dar� false
		return false;
	}
}

/**
 * Fun��o que gera lista de um select de estado(UF) do Brasil
 *
 * @param string $tipo	(full)
 * @param string $selecione (campo marcado)
 */
function gerauf($tipo, $selecione){ //Acho que poderia melhorar essa fun��o usando o selected="selected" e tamb�m trocando a ordem dos campos
	if($tipo == "full"){
		echo "<select name=\"uf\">";
		echo "<option>$selecione</option>";
	}
	echo "<option value=\"AC\">AC</option>
	<option value=\"AL\">AL</option>
	<option value=\"AP\">AP</option>
	<option value=\"AM\">AM</option>
	<option value=\"BA\">BA</option>
	<option value=\"CE\">CE</option>
	<option value=\"DF\">DF</option>
	<option value=\"ES\">ES</option>
	<option value=\"GO\">GO</option>
	<option value=\"MA\">MA</option>
	<option value=\"MT\">MT</option>
	<option value=\"MS\">MS</option>
	<option value=\"MG\">MG</option>
	<option value=\"PA\">PA</option>
	<option value=\"PB\">PB</option>
	<option value=\"PR\">PR</option>
	<option value=\"PE\">PE</option>
	<option value=\"PI\">PI</option>
	<option value=\"RJ\">RJ</option>
	<option value=\"RN\">RN</option>
	<option value=\"RS\">RS</option>
	<option value=\"RO\">RO</option>
	<option value=\"RR\">RR</option>
	<option value=\"SC\">SC</option>
	<option value=\"SP\">SP</option>
	<option value=\"SE\">SE</option>
	<option value=\"TO\">TO</option>";
	if($tipo == "full"){
		echo "</select>";
	}
}

function redir($url,$tempo=0){
    e("<meta http-equiv=\"refresh\" content=\"$tempo;URL=$url\">");
}


##################
### PLUGINS
/* para adicionar novas extens��es, adicione as seguintes linhas abaixo:
if(file_exists("nomedoarquivo.php")){
include("nomedoarquivo.php");
}
*/
# para pegar plugins da crisLib acesse http://blogosfera.us
# para adicionar plugins no site da crisLib, envie para crislib@blogosfera.us. Seus cr�ditos ser�o mantidos!

/**
 * Mostra mensagem de informação usando jqueryui.com. Baixe a biblioteca em http://jqueryui.com para usar esta função.
 * @name info
 * @since v. r2
 * @param string $txt
 * @example info("Cadastro efetuado com sucesso!");
 * @return string
 */
function info($txt,$width=false){
    if($width == true){ $width = "width: ".$width."px"; }
    e("<div class=\"ui-widget\" style=\"margin-top: 3px;$width\">");
    e("<div class=\"ui-state-highlight ui-corner-all\" style=\"padding: 5px;\">");
    e("<span class=\"ui-icon ui-icon-info\" style=\"float: left; margin-right: 0.3em;\"></span><span style=\"font-size: 11px;\">");
    e($txt);
    e("</span></div>");
    e("</div>");
}

/**
 * Mostra mensagem de erro usando jqueryui.com. Baixe a biblioteca em http://jqueryui.com para usar esta função.
 * @name error
 * @since v. r2
 * @param string $txt
 * @example error("Você não preencheu o campo e-mail!");
 * @return string
 */
function error($txt,$width=false){
    if($width == true){ $width = "width: ".$width."px"; }
    e("<div class=\"ui-widget\" style=\"margin-top: 3px;$width\">");
    e("<div class=\"ui-state-error ui-corner-all\" style=\"padding: 5px;\">");
    e("<span class=\"ui-icon ui-icon-info\" style=\"float: left; margin-right: 0.3em;\"></span><span style=\"font-size: 11px;\">");
    e($txt);
    e("</span></div>");
    e("</div>");
}


/**
 * Cria janela popup
 * @param string $nomejanela
 * @param string $nomedivajax
 * @param int $width
 * @param int $height
 * @param string|boolean $conteudo
 */
function janelaUI($nomejanela,$nomedivajax,$width,$height,$conteudo=false){
        ?>
        <div id="<?= $nomejanela ?>" style="display: none;">
            <div class="ui-overlay">
                <div class="ui-widget-overlay" style="position: absolute; z-index: 99999999999999;"></div>
                <div id="<?= $nomejanela ?>_background" class="ui-widget-shadow ui-corner-all" style="width: <?= $width+22 ?>px; height: <?= $height+22 ?>px; position: absolute; z-index: 99999999999999; left: 50%; top: 50%; padding: 11px; margin-left: -<?= ($width+22)/2 ?>px; margin-top: -<?= ($height+22)/2 ?>px;"></div>
            </div>
            <div id="<?= $nomedivajax ?>" style="position: absolute; z-index: 99999999999999; width: <?= $width ?>px; height: <?= $height ?>px; left: 50%; top: 50%; padding: 10px; margin-left: -<?= $width/2 ?>px; margin-top: -<?= $height/2 ?>px; overflow:auto;" class="ui-widget ui-widget-content ui-corner-all"><?= $conteudo ?></div>
        </div>
        <?
}

/**
 * Cria tag <a> com jqueryui
 * @name iUI
 * @param string $nome
 * @param string $onclick
 * @param string $icon
 * @example aUI('Cadastrar','fazCadastro()','disk');
 */
function aUI($nome,$onclick,$icon,$href=false){
	if($href == false){ $href = "#"; }
        e("<a href=\"$href\" onclick=\"$onclick\" id=\"dialog_link\" class=\"ui-state-default ui-corner-all\" style=\"margin-right: 5px;\"><span class=\"ui-icon ui-icon-$icon\"></span>$nome</a>");
}

/**
 * Adiciona classe da jQuery UI para modificar o visual de um campo de formulário
 * @name iUI
 * @example <input type='text' id='nome'<?= iUI() ?>>
 */
function iUI(){
    return " class=\"ui-state-default ui-corner-all\"";
}

?>

