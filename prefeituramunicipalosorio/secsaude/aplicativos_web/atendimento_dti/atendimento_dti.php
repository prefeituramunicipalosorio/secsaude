<?
/*
 *  Sistema de Atendimento e Gestão de Demandas do Setor de TI
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
 * @name Sistema de Atendimento e Gestão de Demandas do Setor de TI
 * @package atendimento_dti
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 1
 * @version 1
 * @license GPLv2
 * @link http://saude.osorio.rs.gov.br/?ti&s=softwarelivre&ss=licenca
 */

# Este script é usado em conjunto com um framework desenvolvido dentro da Secretaria Municipal da Saúde de Osório, RS, Brasil.
# Para executa-lo fora deste framework, é necessário comentar o trecho "if(permissaoMod...." e a conclusão deste if

header("Content-Type: text/html; charset=ISO-8859-1",true);

/**
 * Função usada pelo framework para incluir o módulo no back-end do sistema usado na Secretaria Municipal da Saúde de Osório, RS, Brasil.
 *
 * @name admMod
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @version 1
 * @since 1
 * @example admMod($_GET["p"]);
 * @param string $p
 */
function admMod($p = false){
        //função que verifica se o usuário tem ou não permissão para acessar o módulo
	if(permissaoMod("atendimento_dti") == true){
                //inclui o arquivo de funções auxiliares
                include(URL_MODULO."function.php");

		#$p = $_GET["p"];

		e("<script src=\"".URL_MODULO."js.js\" type=\"text/javascript\"></script>");
		e("<link type=\"text/css\" href=\"".URL_MODULO."css.css\" rel=\"stylesheet\" />");

                //monta menu de navegação lateral
		menuLateral();

		e("<div id=\"conteudo_dti\">");

                //monta título
		e("<h3>Gest&atilde;o de demandas");
		e(" &raquo; ");
                if($p == ""){ echo "Chamados abertos"; }
		if($p == "novo"){ echo "Novo chamado"; }
		if($p == "reabertos"){ echo "Chamados reabertos"; }
		if($p == "fechados"){ echo "Chamados fechados"; }
		if($p == "chamado"){ $chave = str($_GET["i"]); $buscaid = sel("dti_atendimento","chave = '$chave'"); $r = fetch($buscaid); echo "Chamado #".$r["id"]." &raquo; ".utf8_decode($r["assunto"]); }
		e("</h3>");
                
                # LISTA DE CHAMADOS / PÁGINA INICIAL DO MÓDULO
		if($p == ""){
			if($_POST["a"] == 1){
				$chave = hash('sha512',date('YmdHis'));
				$assunto = str(utf8_encode($_POST["assunto"]));
				$motivo = str(utf8_encode($_POST["motivo"]));
				$urgencia = str($_POST["urgencia"]);
				$chave = hash('sha512',date('YmdHis').$assunto);
				$idusuario = str($_SESSION["idu"]);
				
				$ins = ins("dti_atendimento","chave, idusuario, data, dataupdate, assunto, motivo, urgencia_usuario, status", "'$chave', '$idusuario', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."', '$assunto', '$motivo', '$urgencia', '1'");
				
				info("<span style=\"font-size: 11px\">Chamado aberto com sucesso!</span>");
				e("<br>");
			}
                        ?>
                        <div style="margin-bottom: 30px; margin-top: -20px;">
                            <a href="#" onclick="trocarOrdem()" id="dialog_link" class="ui-state-default ui-corner-all" style="margin-left: 10px; margin-right: 5px;"><span class="ui-icon ui-icon-shuffle"></span>Trocar ordem</a> <a href="#" onclick="$('#mostraTags').toggle()" id="dialog_link" class="ui-state-default ui-corner-all" style="margin-left: 10px; margin-right: 5px;"><span class="ui-icon ui-icon-tag"></span>Tags</a>
                        </div>
                        <div id="mostraTags" style="display: none">
                            <? listaTagsHome(); ?>
                        </div><?
                        e("<input type=\"hidden\" id=\"trocaordem\" value=\"1\">
                            <div id=\"listaDeChamados\">");
			listaChamados(1,false,str($_GET["tag"]));
                        e("</div>");
		}

                # NOVO CHAMADO
		if($p == "novo"){
			?>
			<form name="fdsfsda" method="post" action="<?= URL_MODULO_VIA_PAINEL ?>">
				<input type="hidden" name="a" value="1">
				<p><label>Assunto: </label><br>
				<input type="text" name="assunto" id="assunto2"></p>
				
				<p><small>NOTA: se o atendimento for referente a alguma configura&ccedil;&atilde;o/instala&ccedil;&atilde;o no PC, procure informar junto com o motivo do atendimento, o n&uacute;mero do IP.</small></p>
				
				<p><label>Motivo: </label><br>
				<textarea name="motivo" id="motivo"></textarea></p>
				
				<p><label>Urg&ecirc;ncia?</label><br>
				<select name="urgencia">
					<option value="0">N&atilde;o</option>
					<option value="1">Sim</option>
				</select></p>
				
				<p><input type="submit" value="Registrar novo chamado!"></p>
			</form>
			<?
		}

                # LISTA DE CHAMADOS REABERTOS
		if($p == "reabertos"){
			listaChamados(3);
		}

                # LISTA DE CHAMADOS FECHADOS
		if($p == "fechados"){
			listaChamados(2);
		}

                # VISUALIZAÇÃO DE UM CHAMADO
		if($p == "chamado"){
                        ?>
                          <script type="text/javascript">
                          $(function() {
                            var availableTags = [
                              <?
                                $sel5 = sel("dti_atendimento_tags","");
                                $tags = "";
                                $cont = 1;
                                while($w = fetch($sel5)){
                                    $sel6 = sel("dti_atendimento","status = '1' and tags LIKE '%".$w["tag"]."%'");
                                    $totalchamados = total($sel6);
                                    if($totalchamados > 0){
                                          e("\"".utf8_decode($w["tag"])."\"");
                                          #if($cont < $totalchamados){
                                              e(",
                                              ");
                                          #}
                                          #$cont = $cont + 1;
                                    }
                                }
                                e("\"DTI\"");
                              ?>
                            ];
                            $( "#formNovaTag" ).autocomplete({
                              source: availableTags
                            });
                          });
                          </script>
                        <input type="hidden" id="chavechamado" value="<?= $chave ?>"><a name="inicioMSG"></a>
                        <?
			/*
			CHAMADO PRINCIPAL
			*/
			$dt = explode(" ",$r["data"]);
			
			e("<div id=\"msgStatus\"></div>");
			
			e("<div id=\"msg_chamado\">".utf8_decode($r["motivo"]));
			e("<div id=\"msg_info\">".data($dt[0])." &agrave;s ".substr($dt[1],0,5).", por ".utf8_decode(campo("dti_pessoas","nome",$r["idusuario"]))." (".utf8_decode(campo("unidades","nome",campo("dti_pessoas","unidade",$r["idusuario"]))).")");
			
			if($r["urgencia_usuario"] == 1 or $r["urgencia_atendente"] == 1){
				e("<br><span style=\"color: red; font-weight: bold\">O ");
			}
			
			if($r["urgencia_usuario"] == 1){
				e("usu&aacute;rio");
			}
			if($r["urgencia_atendente"] == 1){
				if($r["urgencia_usuario"] == 1){
					e(" e o ");
				}
				e("atendente");
			}
			if($r["urgencia_usuario"] == 1 or $r["urgencia_atendente"] == 1){
				if($r["urgencia_usuario"] == 1 && $r["urgencia_atendente"] == 1){
					e(" setaram ");
				}else{
					e(" setou ");
				}
				e("este chamado como URGENTE!");
			}
			e("<br><a href=\"#\" onclick=\"setUrgente('".$r["id"]."')\">Setar/Retirar URG&Ecirc;NCIA neste chamado</a> | ");
			if($r["status"] == 1 or $r["status"] == 3){
				e("<a href=\"#\" onclick=\"statusChamado('".$r["id"]."','2')\">Fechar chamado</a>");
			}elseif($r["status"] == 2){
				e(" Chamado fechado por ".campo("dti_pessoas","nome",$r["quemfechou"]).". Se quiser reabrir este chamado, clique <a href=\"#\" onclick=\"statusChamado('".$r["id"]."','3')\">aqui</a>.");
			}
			
			e("</div>");
                        #if($_SESSION["usuario"] == "tiago"){
                            e("<div id=\"msgNovaTag\">");
                            listaTags($chave);
                            e("</div>");
                            e("<div id=\"novaTag\" style=\"display: none\">
                                <label>Separe as tags com espa&ccedil;o: <input type=\"text\" id=\"formNovaTag\"></label> 
				<a href=\"#\" onclick=\"addNovaTag()\">Adicionar novas tags</a>
                            </div>");
                        #}
                        e("</div>");
			
			/*
			RESPOSTAS
			*/
			e("<a name=\"respostas\" title=\"respostas\"></a><h4>Respostas deste chamado</h4>");
			e("<div id=\"listaRespostas\">");
			$selreply = sel("dti_atendimento_respostas","idchamado = '".$r["id"]."'","id ASC");
			if(total($selreply) == 0){
				info("<span style=\"font-size: 11px;\">Nenhuma resposta foi registrada neste chamado.</span>");
			}
			while($g = fetch($selreply)){
				$dt = explode(" ",$g["data"]);
				if($g["atendente"] == 1){ $border = " style=\"border-left: solid 3px orange; margin-left: 30px;\""; }else{ $border = ""; }
				e("<div id=\"msg_chamado\"$border>".utf8_decode($g["mensagem"]));
				e("<div id=\"msg_info\">".data($dt[0])." &agrave;s ".substr($dt[1],0,5).", por ".utf8_decode(campo("dti_pessoas","nome",$g["idusuario"]))." (".utf8_decode(campo("unidades","nome",campo("dti_pessoas","unidade",$g["idusuario"]))).")</div>");
				e("</div>");
			}
			e("</div>");
			/*
			FORMULÁRIO PARA RESPOSTA
			*/
			if($r["status"] != 2){
				e("<h4>Nova resposta</h4>");
				e("<p><textarea id=\"msgreply\"></textarea><br>
				<a href=\"#respostas\" onclick=\"novaResposta('".$r["id"]."')\">Enviar resposta</a></p>");
			}
			/*
			ANOTAÇÕES /// SOMENTE DTI
			*/
			if($_SESSION["unidade"] == "9"){
				e("<a name=\"anotacoes\" title=\"anotacoes\"></a><h4>Anota&ccedil;&otilde;es (somente DTI)</h4>");
				e("<div id=\"listaAnotacoes\">");
				$selreply = sel("dti_atendimento_anotacoes","idchamado = '".$r["id"]."'","id ASC");
				if(total($selreply) == 0){
					info("<span style=\"font-size: 11px;\">Nenhuma anota&ccedil;&atilde;o foi registrada neste chamado.</span>");
				}
				while($g = fetch($selreply)){
					$dt = explode(" ",$g["data"]);
					e("<div id=\"msg_chamado\" style=\"border-left: solid 3px lightblue; margin-left: 30px;\">".utf8_decode($g["mensagem"]));
					e("<div id=\"msg_info\">".data($dt[0])." &agrave;s ".substr($dt[1],0,5).", por ".utf8_decode(campo("dti_pessoas","nome",$g["idusuario"]))." (".utf8_decode(campo("unidades","nome",campo("dti_pessoas","unidade",$g["idusuario"]))).")</div>");
					e("</div>");
				}
				e("</div>");
				/*
				FORMULÁRIO PARA ANOTAÇÕES
				*/
				e("<p><textarea id=\"msganot\"></textarea><br>
				<a href=\"#anotacoes\" onclick=\"novaAnotacao('".$r["id"]."')\">Enviar anota&ccedil;&atilde;o</a></p>");
			}
			
			/*
			UPLOAD DE IMAGENS
			*/
			e("<h4>Upload de imagens</h4>");
			e("<p>Se necess&aacute;rio envie-nos prints de tela do erro para auxiliar no atendimento. Para isto, use a ferramenta abaixo:</p>");
			e("<iframe name=\"uploadimagens\" frameborder=\"0\" marginheight=\"0\" marginwidth=\"0\" scrolling=\"auto\" src=\"".URL_MODULO."upload.php?c=$chave\" width=\"650\" height=\"200\" allowtransparency=\"true\" style=\"border-bottom: dashed 1px #ccc;\"></iframe>");
			
			if($_SESSION["unidade"] == "9"){
				e("<div style=\"clear: both\"></div><a href=\"#enviaremail\" onclick=\"sDisplay('sendmail','block')\">Enviar por e-mail para alguem</a>");
				e("<div id=\"sendmail\" style=\"display: none; border: dashed 1px #ccc; margin: 10px; padding: 10px;\">");
				e("<a title=\"enviaremail\" name=\"enviaremail\"></a><h4>Enviar por e-mail</h4>");
				e("<div id=\"msgEmail\"></div>");
				e("<label>E-mail destino: <br><input id=\"emaildestino\" type=\"text\" style=\"width: 100%;\"></label><br>
				<label>Mensagem: </label><br>
				<textarea id=\"corpomensagem\" style=\"width: 100%;\"></textarea><br>
				<a href=\"#enviaremail\" onclick=\"enviarEmail('$chave')\">Enviar e-mail</a>");
				e("</div>");
			}
		}

		e("<link rel=\"stylesheet\" type=\"text/css\" href=\"http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin\">");
		e("<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.js\" type=\"text/javascript\"></script>");
		e("<script src=\"https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js\" type=\"text/javascript\"></script>");
		e("<br><br></div>"); //fecha conteudo_dti
	}
}
