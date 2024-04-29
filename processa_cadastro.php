<?php
// Conexão com o banco de dados (substitua as informações conforme necessário)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "membros";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Processamento do formulário
$nome = $_POST['nome'];
$data_nascimento = $_POST['data_nascimento'];
$email = $_POST['email'];
$foto = $_FILES['foto']['name'];

// Move o arquivo de foto para o diretório desejado
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["foto"]["name"]);
move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);

// Insere os dados no banco de dados
$sql = "INSERT INTO membros (nome, data_nascimento, email, foto) VALUES ('$nome', '$data_nascimento', '$email', '$foto')";

if ($conn->query($sql) === TRUE) {
    echo "Cadastro realizado com sucesso";
} else {
    echo "Erro ao cadastrar: " . $conn->error;
}

$conn->close();
?>
