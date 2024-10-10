<?php
// Inicia a sessão para lidar com as mensagens de sucesso
session_start();

// Conexão com o banco de dados
include 'conexao.php';

// Verifica se o formulário foi submetido via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['descricao_produto'])) {
    $descricao = $_POST['descricao_produto'];
    $preco = $_POST['preco_produto'];
    $peso = $_POST['peso_produto'];

    try {
        // Insere o produto no banco de dados
        $sql = "INSERT INTO produto (descricao_produto, preco_produto, peso) VALUES (:descricao, :preco, :peso)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':peso', $peso);
        $stmt->execute();

        // Armazena uma mensagem de sucesso na sessão
        $_SESSION['mensagem_sucesso'] = "Produto cadastrado com sucesso!";
        
        // Redireciona para evitar a submissão duplicada ao recarregar
        header("Location: cadastrar_produto.php");
        exit();
    } catch (PDOException $e) {
        echo "<p>Erro ao cadastrar produto: " . $e->getMessage() . "</p>";
    }
}

// Buscar todos os produtos cadastrados
$produtos = [];
try {
    $sql = "SELECT * FROM produto";
    $stmt = $pdo->query($sql);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar produtos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos para a tabela de produtos */
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
        /* Estilo para melhorar a aparência geral */
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
        input[type="text"], input[type="number"] {
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
        /* Estilo para o botão de voltar */
        .btn-voltar {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin-top: 20px;
        }
        .btn-voltar:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Cadastrar Produto</h1>

    <!-- Exibe a mensagem de sucesso, se existir, e remove da sessão -->
    <?php
    if (isset($_SESSION['mensagem_sucesso'])) {
        echo "<p>" . $_SESSION['mensagem_sucesso'] . "</p>";
        unset($_SESSION['mensagem_sucesso']); // Remove a mensagem após exibir
    }
    ?>

    <form action="cadastrar_produto.php" method="POST">
        <label for="descricao">Descrição do Produto:</label>
        <input type="text" id="descricao" name="descricao_produto" required>

        <label for="preco">Preço do Produto:</label>
        <input type="number" id="preco" name="preco_produto" step="0.01" required>

        <label for="peso">Peso do Produto:</label>
        <input type="number" id="peso" name="peso_produto" step="0.01" required>

        <input type="submit" value="Cadastrar">
    </form>

    <!-- Botão para voltar ao index -->
    <a href="index.html" class="btn-voltar">Voltar ao Index</a>

    <h2>Produtos Cadastrados</h2>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Peso</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td><?php echo $produto['codigo_produto']; ?></td>
                    <td><?php echo $produto['descricao_produto']; ?></td>
                    <td><?php echo number_format($produto['preco_produto'], 2, ',', '.'); ?></td>
                    <td><?php echo $produto['peso']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
