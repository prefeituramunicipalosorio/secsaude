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
 * @name Arquivo core.php, pertencente ao programa "Ambiente Virtual de Educação À Distância"
 * @package eadlivre
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 1
 * @version 2
 * @license GPLv2
 * @link http://saude.osorio.rs.gov.br/?ti&s=softwarelivre&ss=eadlivre
 */

/**
 * Tarefas do sistema
 *
 * @name core
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 3
 * @version 1
 * @example $core = new core();
 */
class core {
    /**
<<<<<<< HEAD
     * Verifica no banco qual o idioma escolhido para o ambiente
     *
     * @name lang
     * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
     * @since 9
     * @version 1
     * @example $core->lang();
     */
    public function lang(){
        return "pt-br";
    }

    /**
     * Verifica no banco qual o idioma escolhido para o ambiente
     *
     * @name lang
     * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
     * @since 9
     * @version 1
     * @example $core->lang();
     */
    public function tag_title(){
        return "EAD Livre - Secretaria Municipal da Sa&uacute;de / Os&oacute;rio - RS";
    }

    /**
=======
>>>>>>> 0248ab39a6a9cd328877b24f53cad0b5b943bcfd
     * Realiza a conexão com o banco de dados MySQL
     *
     * @name conecta
     * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
     * @since 1
     * @version 2
     * @param string $pagina | string $secao | string $subsecao
     * @example $core->conteudo($_GET["p"],$_GET["s"],$_GET["ss"]);
     */
    public function conteudo($pagina,$secao,$subsecao){
<<<<<<< HEAD

=======
        
>>>>>>> 0248ab39a6a9cd328877b24f53cad0b5b943bcfd
    }
}

/**
 * Banco de dados
 *
 * @name conexao
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 1
 * @version 2
 * @example $con = new conexao();
 */
class conexao {
    /**
     * Realiza a conexão com o banco de dados MySQL
     *
     * @name conecta
     * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
     * @since 1
     * @version 2
     * @example $con->conecta();
     */
    public function conecta(){
        $con = con(DBUSER,DBPASS,DBURL);
        $db = db(DBNAME);
    }

    /**
     * Fecha a conexão com o banco de dados MySQL
     *
     * @name fecha
     * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
     * @since 2
     * @version 2
     * @example $con->fecha();
     */
    public function fecha(){
        mysql_close();
    }
}

/**
 * Tratamento de autenticação dos usuários
 *
 * @name autentica
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 1
 * @version 1
 * @example $aut = new autentica();
 */
class autentica {
    /**
     * Verifica se há sessões abertas para este usuário no sistema
     *
     * @name verificaAut
     * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
     * @since 2
     * @version 1
     * @example $aut->verificaAut();
     */
    public function verificaAut(){
        $login = str($_SESSION["usuario"]);
        $busca = sel("sessoes","usuario = '$login' and status = '1'");
        return total($busca);
    }

    /**
     * Realiza a autenticação do usuário
     *
     * @name fazAut
     * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
     * @since 2
     * @version 1
     * @param string $login | string $senha
     * @example $aut->fazAut($_POST["usuario"],$_POST["senha"]);
     */
    public function fazAut($login,$senha){
        $login = str($login); # trata o login
        $senha = hash('sha512',$senha); # criptografa a senha
        $busca = sel("usuarios","login = '$login' and senha = '$senha'"); # pesquisa se o usuário e senha existem
        if(total($busca) > 0){ # se existir...
            $r = fetch($busca);
            if($r["status"] == 0){ # se a conta do usuário estiver desativada
                error(LANG_CORE_AUT_ERRO_1); # informa o usuário que sua conta está desativada
            }else{ # se a conta do usuário estiver ativa
                $_SESSION["usuario"] = $login; # guarda login do usuário numa session
                $_SESSION["chaveu"] = $r["chave"]; # guarda chave que identifica o usuário na tabela de usuários, numa session
                $_SESSION["chaves"] = hash('sha512',date("Y-m-d H:i:s")."_eadlivre"); # gera uma chave para esta sessão
                $upd = mysql_query("UPDATE sessoes SET status = '0' WHERE usuario = '$login'") or die(ERROR_MYSQL); # fecha qualquer outra sessão deste usuário
                $ins = ins("sessoes","usuario, chaveu, chaves, data, ip, agente, status","'$login', '".$r["chave"]."', '".$_SESSION["chaves"]."', '".date("Y-m-d H:i:s")."', '".$_SERVER['']."', '".$_SERVER['']."', '1'"); # insere uma nova sessão
                # registra os logs
                $log = new log();
                $log->logu(LANG_CORE_AUT_LOG_1); # registra o log único
                redir("?perfil"); # redireciona para o perfil/painel do usuário
            }
        }else{ # se não existir
            error(LANG_CORE_AUT_ERRO_2);
        }
    }
}

/**
 * Tratamento dos dados de usuários (aluno, instrutor, administrador...)
 *
 * @name usuarios
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 1
 * @version 1
 * @example $usr = new usuarios();
 */
class usuarios {

}

/**
 * Tratamento dos dados de cursos
 *
 * @name cursos
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 1
 * @version 1
 * @example $cursos = new cursos();
 */
class cursos {

}

/**
 * Tratamento dos dados de turmas
 *
 * @name turmas
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 1
 * @version 1
 * @example $turmas = new turmas();
 */
class turmas {

}

/**
 * Tratamento dos dados de instrutores
 *
 * @name instrutores
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 1
 * @version 1
 * @example $instrutores = new instrutores();
 */
class instrutores {

}

/**
 * Tratamento dos dados de alunos
 *
 * @name alunos
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 1
 * @version 1
 * @example $alunos = new alunos();
 */
class alunos {

}

/**
 * Tratamento mensagens privadas enviadas entre os usuários do sistema
 *
 * @name mp
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 2
 * @version 1
 * @example $mp = new mp();
 */
class mp {

}

/**
 * Tratamento dos dados de modulos
 *
 * @name modulos
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 1
 * @version 1
 * @example $modulos = new modulos();
 */
class modulos {

}

/**
 * Tratamento dos dados de foruns de debate do curso ou do módulo
 *
 * @name forum
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 1
 * @version 1
 * @example $forum = new forum();
 */
class forum {

}

/**
 * Tratamento dos dados de questionarios
 *
 * @name questionario
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 1
 * @version 1
 * @example $questionario = new questionario();
 */
class questionario {

}

/**
 * Tratamento dos dados de avaliacoes (notas sobre trabalhos, atividades, questionários...)
 *
 * @name avaliacoes
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 1
 * @version 1
 * @example $avaliacoes = new avaliacoes();
 */
class avaliacoes {

}

/**
 * Tratamento dos dados de atividades (trabalhos, pesquisas, etc)
 *
 * @name atividades
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 1
 * @version 1
 * @example $atividades = new atividades();
 */
class atividades {

}

/**
 * Tratamento dos logs do programa (registrando atividades no programa ou atividades dos alunos no ambiente)
 *
 * @name log
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 2
 * @version 1
 * @example $log = new log();
 */
class log {
    /**
     * Registra logs do sistema, como erros cometidos pelo usuário, erros do sistema, etc
     *
     * @name logs
     * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
     * @since 2
     * @version 1
     * @param string $txt
     * @example $log->logs("Deixou um campo em branco.");
     */
    public function logs($txt){

    }
    /**
     * Registra logs do usuário do ambiente, como visualização de atividade, clique em links, etc.
     *
     * @name loga
     * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
     * @since 2
     * @version 1
     * @param string $txt
     * @example $log->loga("Visualizou a atividade $urlatividade.");
     */
    public function loga($txt){

    }
    /**
     * Registra um log único para ambos tipos de logs (do sistema, do ambiente)
     *
     * @name logu
     * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
     * @since 2
     * @version 1
     * @param string $txt
     * @example $log->logu("Entrou no ambiente.");
     */
    public function logu($txt){

    }
}

/**
 * Trabalha com os temas visuais do ambiente
 *
 * @name temas
 * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
 * @since 3
 * @version 1
 * @example $tema = new temas();
 */
class temas {
    /**
     * Pesquisa no banco de dados qual tema está sendo usado no ambiente
     *
     * @name tema
     * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
     * @since 3
     * @version 1
     * @example $tema->tema();
     */
    public function tema(){
<<<<<<< HEAD
        return "default";
=======

>>>>>>> 0248ab39a6a9cd328877b24f53cad0b5b943bcfd
    }

    /**
     * Exibe o logo ou o nome do site/ambiente (imagem ou texto), de acordo com configuração no banco
     *
     * @name logo
     * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
     * @since 3
     * @version 1
     * @example $tema->logo();
     */
    public function logo(){
<<<<<<< HEAD
        echo "
            <div id=\"logo\">
                <a href=\"/eadlivre/\">EADLivre</a>
            </div>";
=======

>>>>>>> 0248ab39a6a9cd328877b24f53cad0b5b943bcfd
    }

    /**
     * Monta menu no tema
     *
     * @name menu
     * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
     * @since 3
     * @version 1
     * @example $tema->menu();
     */
    public function menu(){

    }

    /**
     * Mostra box para usuário fazer o login ou, se o usuário já estiver logado, mostra mensagem ao usuário
     * @name boxlogin
     * @author Tiago Cardoso Floriano <mail@poweredbycaffeine.com.br>
     * @since 4
     * @version 1
     * @example $tema->boxlogin();
     */
    public function boxlogin(){
<<<<<<< HEAD
        echo "
        <div id=\"bemvindo\">
            Seja bem vindo visitante!
        </div>";
=======
        
>>>>>>> 0248ab39a6a9cd328877b24f53cad0b5b943bcfd
    }
}