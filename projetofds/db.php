<?php
session_start();

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "vazajo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["username"];
    $pass = $_POST["password"]; 

    $sql = "SELECT iduser FROM users WHERE nome = '$user' AND passe = '$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows >= 1) {
               
        $row = $result->fetch_assoc();
        $iduser = $row['iduser'];
       
        $_SESSION["logged_in"] = true;
        $_SESSION["iduser"] = $iduser;
        $_SESSION["username"] = $user;
        $_SESSION["email"] = $email;
        
        header("Location: landpage.html"); 
        exit();
    } else {
        echo "<script>alert('Usuário ou senha incorretos!'); window.location.href='index.html';</script>";
    }
}

$conn->close();
?>