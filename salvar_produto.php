<?php
// Conexão com o banco
include 'conexao.php';

// Dados do formulário
$descricao = $_POST['descricao_produto'];
$preco = $_POST['preco_produto'];
$peso = $_POST['peso_produto'];

// Inserir produto no banco
try {
    $sql = "INSERT INTO produto (descricao_produto, preco_produto, peso) VALUES (:descricao, :preco, :peso)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':peso', $peso);
    $stmt->execute();
    echo "Produto cadastrado com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao cadastrar produto: " . $e->getMessage();
}
?>
