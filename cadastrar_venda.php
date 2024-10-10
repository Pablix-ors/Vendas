<?php
// Inicia a sessão para lidar com as mensagens de sucesso
session_start();

// Conexão com o banco de dados
include 'conexao.php';

// Verifica se o formulário foi submetido via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['icms'])) {
    $icms = $_POST['icms'];
    $valor = $_POST['valor_total_nf'];

    try {
        // Insere a venda no banco de dados
        $sql = "INSERT INTO venda (icms, valor_total_nf) VALUES (:icms, :valor)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':icms', $icms);
        $stmt->bindParam(':valor', $valor);
        $stmt->execute();

        // Armazena a mensagem de sucesso na sessão
        $_SESSION['mensagem_sucesso'] = "Venda cadastrada com sucesso!";
        
        // Redireciona para evitar duplicação ao recarregar
        header("Location: cadastrar_venda.php");
        exit();
    } catch (PDOException $e) {
        echo "<p>Erro ao cadastrar venda: " . $e->getMessage() . "</p>";
    }
}

// Buscar todas as vendas cadastradas
$vendas = [];
try {
    $sql = "SELECT * FROM venda";
    $stmt = $pdo->query($sql);
    $vendas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar vendas: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Venda</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilo para a tabela de vendas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-family: Arial, sans-serif;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        /* Estilo para o formulário */
        h1, h2 {
            font-family: Arial, sans-serif;
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="number"], input[type="date"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        p {
            color: #4CAF50;
        }
        .btn-voltar {
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-voltar:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Cadastrar Venda</h1>

    <!-- Exibe a mensagem de sucesso, se existir, e remove da sessão -->
    <?php
    if (isset($_SESSION['mensagem_sucesso'])) {
        echo "<p>" . $_SESSION['mensagem_sucesso'] . "</p>";
        unset($_SESSION['mensagem_sucesso']); // Remove a mensagem após exibir
    }
    ?>

    <form action="cadastrar_venda.php" method="POST">
        <label for="icms">Data ICMS:</label>
        <input type="date" id="icms" name="icms" required>

        <label for="valor">Valor Total da Venda:</label>
        <input type="number" id="valor" name="valor_total_nf" step="0.01" required>

        <input type="submit" value="Cadastrar">
    </form>

    <a href="index.html" class="btn-voltar">Voltar para o Index</a>

    <h2>Vendas Cadastradas</h2>
    <table>
        <thead>
            <tr>
                <th>Número NF</th>
                <th>Data ICMS</th>
                <th>Valor Total</th>
            </tr>
        </thead>
        <tbody>
                <?php foreach ($vendas as $venda): ?>
            <tr>
            <td><?php echo $venda['numero_nf']; ?></td>
            <td><?php echo date('d/m/Y', strtotime($venda['icms'])); ?></td> <!-- Formatação da data -->
            <td><?php echo number_format($venda['valor_total_nf'], 2, ',', '.'); ?></td>
            </tr>
                <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
