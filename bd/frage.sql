create database frage DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;;
use frage;

create table usuarios(
    user_email varchar(128) not null,
    user_senha varchar(50) not null,
    user_nome varchar(128) not null,
    user_tipo char(1) not null,
    primary key (user_email)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

create table instituicoes(
    inst_email varchar(50) not null,
    inst_codigo int(10) not null auto_increment,
    inst_doc_tipo varchar(4) not null,
    inst_num_doc varchar(30) not null,
	inst_end_rua varchar(50) not null,
	inst_end_numero varchar(5),
	inst_cep varchar(15) not null,
	inst_bairro varchar(70) not null,
	inst_cidade varchar(50) not null,
	inst_estado varchar(2) not null,
	inst_pais varchar(50) not null,
	inst_telefone varchar(15) not null,
    primary key (inst_codigo),
    foreign key (inst_email) references usuarios (user_email)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

create table alunos(
    aluno_email varchar(50) not null,
    aluno_sobrenome varchar(128) not null,
    aluno_ra varchar(15),
    aluno_rg varchar(14) not null,
    aluno_cpf varchar(14) not null,
    aluno_instituicao int(10) not null,
    foreign key (aluno_instituicao) references instituicoes (inst_codigo),
    foreign key (aluno_email) references usuarios (user_email)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

create table professores(
    professor_email varchar(50) not null,
    professor_sobrenome varchar(128) not null,
    professor_rg varchar(14) not null,
    professor_cpf varchar(14) not null,
    professor_instituicao int(10) not null,
    foreign key (professor_instituicao) references instituicoes (inst_codigo),
    foreign key (professor_email) references usuarios (user_email)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

create table turmas(
    turma_codigo int(10) not null auto_increment,
    turma_nome varchar(50) not null,
    turma_instituicao int(10) not null,
    primary key (turma_codigo),
    foreign key (turma_instituicao) references instituicoes (inst_codigo)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

create table aluno_turma(
    aluno_email varchar(50) not null,
    turma_codigo int(10) not null,
    foreign key (aluno_email) references alunos (aluno_email),
    foreign key (turma_codigo) references turmas (turma_codigo)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

create table materias(
    materia_codigo int(10) not null auto_increment,
    materia_nome varchar(50) not null,
    primary key (materia_codigo)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

create table questionarios(
    quest_codigo int(10) not null auto_increment,
    quest_nome varchar(50) not null,
    quest_professor varchar(50) not null,
    quest_materia int(10) not null,
    quest_numPerguntas int(3) not null,
    quest_tempo int(3),
    quest_visualizar_resposta boolean not null,
    quest_randomiza_perguntas boolean not null,
    quest_necessita_correcao boolean not null,
    primary key (quest_codigo),
    foreign key (quest_professor) references usuarios (user_email),
    foreign key (quest_materia) references materias (materia_codigo)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

create table questionario_turma(
    quest_codigo int not null,
    turma_codigo int not null,
    data_inicio datetime,
    data_fim datetime,
    foreign key (quest_codigo) references questionarios (quest_codigo),
    foreign key (turma_codigo) references turmas (turma_codigo)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

create table perguntas(
    perg_codigo int(10) not null auto_increment,
    perg_enunciado varchar(5000) not null,
    perg_imagem varchar(500),
    perg_peso decimal,
    perg_tipo char(1) not null,
    perg_numAlternativas int(1),
    primary key (perg_codigo)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

create table perguntas_alternativas(
    perg_codigo int(10) not null,
    alternativa_texto varchar(500) not null,
    alternativa_ordem char(1) not null,
    alternativa_correta boolean not null,
    foreign key (perg_codigo) references perguntas (perg_codigo)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

create table tags(
    perg_codigo int(10) not null,
    perg_tag varchar(30) not null,
    foreign key (perg_codigo) references perguntas (perg_codigo)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

create table ordem_perguntas(
    quest_codigo int(10) not null,
    perg_codigo int(10) not null,
    perg_ordem int(3) not null,
    foreign key (quest_codigo) references questionarios (quest_codigo),
    foreign key (perg_codigo) references perguntas (perg_codigo)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

create table respostas_ad(
    user_email varchar(50) not null,
    user_resposta varchar(500) not null,
    quest_codigo int(10) not null,
    perg_codigo int(10) not null,
    foreign key (user_email) references usuarios (user_email),
    foreign key (quest_codigo) references questionarios (quest_codigo),
    foreign key (perg_codigo) references perguntas (perg_codigo)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

create table respostas_vf(
    user_email varchar(50) not null,
    quest_codigo int(10) not null,
    perg_codigo int(10) not null,
    alternativa char(1) not null,
    user_resposta boolean not null,
    foreign key (user_email) references usuarios (user_email),
    foreign key (quest_codigo) references questionarios (quest_codigo),
    foreign key (perg_codigo) references perguntas (perg_codigo)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

create table notas(
    nota_valor decimal not null,
    quest_codigo int(10) not null,
    user_email varchar(50) not null,
    foreign key (quest_codigo) references questionarios (quest_codigo),
    foreign key (user_email) references usuarios (user_email)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


INSERT INTO usuarios VALUES ('uniesp@uniesp.com.br', '12345678', 'Uniesp', 'I');
INSERT INTO instituicoes (inst_email, inst_doc_tipo, inst_num_doc, inst_end_rua, inst_end_numero, inst_cep, inst_bairro, inst_cidade, inst_estado, inst_pais, inst_telefone) VALUES ('uniesp@uniesp.com.br', 'CNPJ', '63.083.869/0001-67', 'Av. Santana', 1070, '13188-000', 'Jd. Amanda', 'Hortolândia', 'SP', 'Brasil', '(19) 3865-8320');

INSERT INTO turmas (turma_nome, turma_instituicao) VALUES ('SI-2014', 00001); 

INSERT INTO usuarios VALUES ('gustavomendes94@gmail.com', '12345678', 'Gustavo', 'P');
INSERT INTO professores VALUES ('gustavomendes94@gmail.com', 'Mendes da Silva', '43.587.666-1', '414.669.788-30', 00001);

INSERT INTO usuarios VALUES ('welder_azevedo@hotmail.com', '12345678', 'Welder', 'A');
INSERT INTO alunos VALUES ('welder_azevedo@hotmail.com', 'Silvestre Azevedo', '2014006000', '00.000.000-0', '000.000.000-00', 00001);
INSERT INTO aluno_turma VALUES ('welder_azevedo@hotmail.com', 00001);