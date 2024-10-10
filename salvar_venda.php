<?php
// Conexão com o banco
include 'conexao.php';

// Dados do formulário
$icms = $_POST['icms'];
$valor = $_POST['valor_total_nf'];

// Inserir venda no banco
try {
    $sql = "INSERT INTO venda (icms, valor_total_nf) VALUES (:icms, :valor)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':icms', $icms);
    $stmt->bindParam(':valor', $valor);
    $stmt->execute();
    echo "Venda cadastrada com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao cadastrar venda: " . $e->getMessage();
}
?>
