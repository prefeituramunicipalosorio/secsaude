# cria o banco de dados
CREATE DATABASE eadlivre;

# guarda as sessões abertas no ambiente
CREATE TABLE sessoes (
    id INT(11) AUTO_INCREMENT,
    usuario INT(11),
    chaveu VARCHAR(128),
    chaves VARCHAR(128),
    data DATETIME,
    ip VARCHAR(50),
    agente VARCHAR(50),
    status INT(1),
    PRIMARY KEY(id)
);

# tabela onde será incluidos os usuários do sistema, independente do cargo no ambiente (aluno, professor, administrador..). Essa separação será feita em outras tabelas.
CREATE TABLE usuarios (
    id INT(11) AUTO_INCREMENT,
    nome VARCHAR(50),
    email VARCHAR(50),
    login VARCHAR(20),
    senha VARCHAR(128),
    status INT(1),
    PRIMARY KEY(id)
);

# insere um usuário padrão com login = admin e senha = paico
INSERT INTO usuarios (id, nome, email, login, senha, status) VALUES (NULL, 'Tiago Floriano', 'mail@poweredbycaffeine.com.br', 'admin', 'fa38f3103751a64c615d9eb5c1b662fe7d90d6dd2694a21e5efdad3090bc3a1e7d9976f3c9a5f94bc9f1e75920d841b4ffb9f9ab9e6043a41db50117abdebbf0', '1');
