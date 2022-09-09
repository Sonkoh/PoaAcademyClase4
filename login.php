<?php
session_start();
require 'config.php';
if (isset($_POST['email']) && isset($_POST['password'])) {
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        if (strlen($_POST['password']) > 4) {
            $pass = md5($_POST['password']);
            $sql = $conn->prepare("SELECT * FROM `users` WHERE `email` = :email AND password = :pass LIMIT 1");
            $sql->bindParam(":email", $_POST['email']);
            $sql->bindParam(":pass", $pass);
            if ($sql->execute()) {
                if ($sql->rowCount() == 1) {
                    $_SESSION['name'] = $sql->fetch(PDO::FETCH_ASSOC)['name'];
                    header('Location: /');
                    echo "no se encontraron los datos mencionados";
                }
            } else {
                echo 'Ha ocurrido un error';
            }
        } else {
            echo 'Tu contraseña es invalida. Debe ser mayor a 4 caracteres';
        }
    } else {
        echo 'Tu respuesta es invalida (email)';
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>
    <form method="post">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" name="email">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>

</html>