<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root"; // Usuário padrão do XAMPP/WAMP
$password = ""; // Senha padrão é vazia no XAMPP/WAMP
$dbname = "vazajo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["username"];
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $confirm_pass = $_POST["confirm_password"];

    // Verificar se as senhas coincidem
    if ($pass !== $confirm_pass) {
        echo "<script>alert('As senhas não coincidem!'); window.location.href='register.html';</script>";
        exit();
    }

    // Validar o e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('E-mail inválido!'); window.location.href='register.html';</script>";
        exit();
    }

    // Verificar se o nome de usuário ou e-mail já existem no banco
    $stmt = $conn->prepare("SELECT * FROM users WHERE nome = ? OR email = ?");
    $stmt->bind_param("ss", $user, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Nome de usuário ou e-mail já registrado!'); window.location.href='register.html';</script>";
        exit();
    }

    // Criptografar a senha antes de armazenar no banco de dados
    $hashed_password = $pass;

    // Inserir o novo usuário no banco de dados
    $stmt = $conn->prepare("INSERT INTO users (nome, email, passe) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $email, $hashed_password);
    
    if ($stmt->execute()) {
        echo "<script>alert('Cadastro bem-sucedido!'); window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar usuário!'); window.location.href='register.html';</script>";
    }
}

$conn->close();
?>
