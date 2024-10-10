create database vendas;
use vendas;

create table produto (
       codigo_produto integer primary key auto_increment,
       descricao_produto varchar(30),
       preco_produto float,
       peso real
);

create table venda (
       numero_nf integer primary key auto_increment,
       icms date,
       valor_total_nf float
);

create table itens (
       num_item integer PRIMARY KEY AUTO_INCREMENT,
       qtde_item integer
);


ALTER TABLE produto MODIFY descricao_produto VARCHAR(50);


ALTER TABLE nota_fiscal ADD COLUMN icms FLOAT AFTER numero_nf;


ALTER TABLE produto ADD COLUMN peso FLOAT;


DESCRIBE produto;


DESCRIBE nota_fiscal;


ALTER TABLE nota_fiscal CHANGE valor_nf valor_total_nf FLOAT;


ALTER TABLE nota_fiscal DROP COLUMN data_nf;


DROP TABLE itens;


ALTER TABLE nota_fiscal RENAME TO venda;
