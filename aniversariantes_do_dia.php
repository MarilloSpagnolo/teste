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

// Consulta SQL para obter os aniversariantes do dia
$today = date('m-d');
$sql = "SELECT * FROM membros WHERE DATE_FORMAT(data_nascimento, '%m-%d') = '$today'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Exibir os aniversariantes do dia
    while($row = $result->fetch_assoc()) {
        echo "Nome: " . $row["nome"]. " - Data de Nascimento: " . $row["data_nascimento"]. "<br>";
        // Exibir a foto (substitua 'uploads/' pelo caminho real da pasta onde as fotos estão armazenadas)
        echo '<img src="uploads/' . $row["foto"] . '" alt="Foto"><br>';
    }
} else {
    echo "Nenhum aniversariante hoje";
}
$conn->close();
?>
