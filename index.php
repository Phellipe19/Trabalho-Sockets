<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Socket</title>
</head>
<body>
    <h1>Socket Client</h1>
    <form action="" method="POST">
        <label for="command">Digite o comando (ex: REG USER 1234 senha ou ASK SECRET 1234 senha):</label><br>
        <input type="text" name="command" id="command" required><br><br>
        <button type="submit">Enviar Comando</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['command'])) {
        $host = '144.22.201.166';  
        $port = 9000;              
        $command = $_POST['command'];

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($socket === false) {
            echo "Erro ao criar o socket: " . socket_strerror(socket_last_error());
            exit();
        }

        $result = socket_connect($socket, $host, $port);
        if ($result === false) {
            echo "Erro ao conectar ao servidor: " . socket_strerror(socket_last_error($socket));
            socket_close($socket);
            exit();
        }

        socket_write($socket, $command, strlen($command));

        $response = socket_read($socket, 2048);
        echo "<h3>Resposta do Servidor:</h3><pre>$response</pre>";

        socket_close($socket);
    }
    ?>
</body>
</html>

