<?php
session_start(); 

$iduser = $_SESSION['iduser'];

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'vazajo';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

$sql = "SELECT nome, email FROM users WHERE iduser = '$iduser'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nome = $row['nome'];
    $email = $row['email'];
} else {
    echo "Utilizador não encontrado!";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novoNome = $_POST['nome'];
    $novoEmail = $_POST['email'];

    $updateSql = "UPDATE users SET nome = ?, email = ? WHERE iduser = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssi", $novoNome, $novoEmail, $iduser);

    if ($updateStmt->execute()) {
        echo "Informações atualizadas com sucesso!";
        $nome = $novoNome;
        $email = $novoEmail;
    } else {
        echo "Erro ao atualizar as informações: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Utilizador</title>
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #121212; 
            color: #f4f4f9; 
        }

        header {
            background: linear-gradient(90deg, #f4d03f, #e3b81e); 
            padding: 30px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        header h1 {
            margin: 0;
            font-size: 42px;
            color: #121212;
        }

        nav {
            background-color: #333; 
            padding: 15px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            padding: 10px 15px;
            transition: background-color 0.3s, transform 0.3s;
            border-radius: 5px;
        }

        nav a:hover {
            background-color: #f4d03f; 
            color: #121212;
            transform: scale(1.1);
        }

        main {
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .section-title {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #f4d03f;
        }

        .section-content {
            width: 100%;
            max-width: 800px;
            text-align: justify;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        form {
            width: 100%;
            max-width: 800px;
            margin-top: 20px;
            display: none; 
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 18px;
        }

        .form-group input {
            padding: 10px;
            width: 100%;
            border: 2px solid #444;
            border-radius: 5px;
            background-color: #1c1c1c;
            color: #f4f4f9;
            font-size: 16px;
        }

        button {
            padding: 15px 30px;
            background-color: #f4d03f;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
        }

        button:hover {
            background-color: #e3b81e;
            transform: scale(1.1);
        }
    </style>
    <script>
        function toggleForm() {
            const form = document.getElementById('edit-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <header>
        <h1>Perfil do Utilizador</h1>
    </header>
    <nav>
        <a href="landpage.html">Início</a>
        <a href="sobre.html" class="active">Sobre</a>
    </nav>
    <main>
        <section>
            <h2 class="section-title">Detalhes do Utilizador</h2>
            <div class="section-content">
                <p><strong>Nome:</strong> <?php echo htmlspecialchars($nome); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            </div>
        </section>

        <section>
            <button onclick="toggleForm()">Editar Perfil</button>
            <form id="edit-form" action="perfil.php" method="POST">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <button type="submit">Salvar Alterações</button>
            </form>
        </section>
    </main>
</body>
</html>
