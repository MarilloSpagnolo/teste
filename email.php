<?php
// Conexão com o banco de dados e consulta dos aniversariantes (mesmo código usado no item 4)

// Verifica conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta SQL para obter os aniversariantes do dia
$today = date('m-d');
$sql = "SELECT * FROM membros WHERE DATE_FORMAT(data_nascimento, '%m-%d') = '$today'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Enviar e-mails para os aniversariantes do dia
    while($row = $result->fetch_assoc()) {
        $to = $row["email"];
        $subject = "Feliz Aniversário!";
        $message = "Olá " . $row["nome"] . ",\n\nFeliz Aniversário! Desejamos a você um dia cheio de alegria e bênçãos.\n\nEquipe da Igreja";
        $headers = "From: suportetiouvir@gmail.com";
        
        // Anexar a foto ao e-mail
        $file = 'uploads/' . $row["foto"];
        $filename = $row["foto"];
        $file_size = filesize($file);
        $handle = fopen($file, "r");
        $content = fread($handle, $file_size);
        fclose($handle);
        $content = chunk_split(base64_encode($content));
        $uid = md5(uniqid(time()));
        
        $header = "From: suportetiouvir@gmail.com\r\n";
        $header .= "Reply-To: suportetiouvir@gmail.com\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
        
        $message = "--".$uid."\r\n";
        $message .= "Content-type:text/plain; charset=UTF-8\r\n";
        $message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $message .= $message."\r\n\r\n";
        $message .= "--".$uid."\r\n";
        $message .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n";
        $message .= "Content-Transfer-Encoding: base64\r\n";
        $message .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
        $message .= $content."\r\n\r\n";
        $message .= "--".$uid."--";

        // Envia o e-mail
        mail($to, $subject, $message, $header);
        
        echo "E-mail enviado para " . $row["email"] . "<br>";
    }
} else {
    echo "Nenhum aniversariante hoje";
}
$conn->close();
?>
