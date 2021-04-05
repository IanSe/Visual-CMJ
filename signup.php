<?php

require('./conexion/conexion.php');
require('./encriptacion/algoritmo.php');

$direc_scan = scandir('./arreglos/', 1);
$n_carpeta = count($direc_scan);

for($i=0;$i<$n_carpeta-2;$i++)
{
    $info_archivo[$i] = pathinfo("./arreglos/$direc_scan[$i]", PATHINFO_FILENAME);
    $name_file[$i] = $info_archivo[$i];
}

$sessionTime = 60*60*24*2;
session_set_cookie_params(60*60*24*2);
session_start();

$mensaje_confirmacion = 0;

if(isset($_GET['error']))
{
    $Error = $_GET['error'];
}

if(isset($_POST['submit']))
{   
    $nombre = $_REQUEST['nombre'];
    $apellido = $_REQUEST['apellido'];
    $edad = $_REQUEST['age'];
    $email = $_REQUEST['email'];
    $grupo = $_REQUEST['grupo'];
    $pwd = $_REQUEST['password'];
    $numero = $_REQUEST['tel'];
    $completo = $nombre." ".$apellido;
    $codigo=rand(1111,9999);

    if($mysqli->query("SELECT * FROM `usuario` WHERE `correo` = '$email'"))
    {
        $resultado = $mysqli->query("SELECT * FROM `usuario` WHERE `correo` = '$email'");
        $resultado->data_seek(0);

        while($fila = $resultado->fetch_assoc())
        {
            $id = $fila['id'];
            $Error = "Este correo ya ha sido registrado";
        }
    }

    $mensaje_confirmacion = 1;

    if(!isset($Error))
    {
        $password = password_hash($pwd, PASSWORD_BCRYPT);
        $sql = "INSERT INTO `usuario` (`nombre`, `correo`, `numero`, `pwd`, `grupo`) VALUES ('$completo', '$email', '$numero', '$password', '$grupo')";
        $mysqli->query($sql);

        if($mysqli->query("SELECT * FROM `usuario` WHERE `correo` = '$email'"))
        {
            $resultado = $mysqli->query("SELECT * FROM `usuario` WHERE `correo` = '$email'");
            $resultado->data_seek(0);
    
            while($fila = $resultado->fetch_assoc())
            {
                $id = $fila['id'];
            }
        }
        
        $id_enc = $encriptar($id);
        $nombre_enc = $encriptar($nombre);

        $_SESSION['nombre'] = $nombre_enc;
        $_SESSION['id'] = $id_enc;
        $_SESSION['grupo'] = $grupo;

        setcookie("id_sesion", $_SESSION['id'], time() + $sessionTime, "/");
        setcookie("grupo", $_SESSION['grupo'], time() + $sessionTime, "/");

        if($grupo != 'Crear')
        {
            $Next_URL = 'horario?GP='.$grupo;
        }
        else
        {
            $Next_URL = 'create';
        }
        Header("Location: $Next_URL");
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Registrate en Visual CMJ y administra tu tiempo">
    <link rel="shortcut icon" href="./images/reloj.jpg" type="image/x-icon">
    <title>Registrate en Visual CMJ</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="./css/estilo_registro.css">
    <link rel="stylesheet" href="./css/estilo_footer_h_c.css">
    <link rel="stylesheet" href="./css/estilo_tablet_registro.css" media="(min-width: 768px)">

</head>

<body bgcolor="#fbf7ff" onload="grouphide()">
    <header class="animate__animated animate__fadeInLeft">
        <div class="header-logo--container">
            <table>
                <tr>
                    <td>
                        <a href="../Horarios/">
                        <img src="./images/logo_vcmj.png" alt="Visual CMJ, Logo" width="140px" height="30px"></a>
                    </td>
                    <td>
                        <?php if(isset($Error)): ?>
                        <font align="center" color="red"><?= $Error ?></font>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
    </header>

    <main class="animate__animated animate__fadeInUp">
        <section class="main-form--container">
            <h1>Empieza a organizar tu tiempo</h1>
            <h2>¿Tienes una cuenta? | <a href="login">Inicia Sesion</a></h2>
            <form action="signup" method="post">
                <label for="name">
                    <span>Nombre</span>
                    <input type="text" name="nombre" id="name" placeholder="ej: Alejandro" 
                    required pattern="[A-Za-z]+" title="Solo se permiten letras">
                </label>
                <label for="last-name">
                    <span>Apellido</span>
                    <input type="text" name="apellido" id="last-name" placeholder="ej: Taboada" required pattern="[A-Za-z]+" title="Solo se permiten letras">
                </label>
                <label for="num">
                    <span>Numero Celular </span>
                    <input type="number" name="tel" id="tel" pattern="[0-9]" title="Solo se permiten numeros">
                </label>
                <label for="age">
                    <span>Edad</span>
                    <input type="number" name="age" id="age" max="100" required pattern="[0-9]" title="Solo se permiten numeros">
                </label>
                <label for="email">
                    <span>Mail</span>
                    <input type="email" name="email" id="email" placeholder="ej: name@mail.com" 
                    autocomplete="email" autocomplete="mail" required>
                </label>
                <div id="cecyt8">
                <label for="grupo"><br>
                <span> Grupo</span>
                    <select name="grupo">
                        <option value="Crear">Crea el tuyo</option>
                        <option disabled>Ya creados</option>
                        <?php for($i=0;$i<$n_carpeta-2;$i++): ?>
                            <option value="<?= $name_file[$i] ?>"><?= $name_file[$i] ?></option>
                        <?php endfor; ?>
                    </select>
                </label>
                </div><br>
                <label for="password">
                    <span>Contraseña</span>
                    <input type="password" name="password" id="password" minlength="8" required>
                </label><br>
                <div class="check-container">
                <label for="check" class="check">
                    <input type="checkbox" id="check" name="politicas" required>
                    <a href="data_term" target="_blank" rel="noopener">Acepto terminos y politicas de datos </a>
                </label><br>
                <input type="submit" name="submit" id="submit" value="Registrar">
                </div><br><br>
            </form>
        </section>
    </main> <br><br>
    <div class="footer-background--top">
        <picture>
            <source media="(min-width: 720px)" srcset="./images/bg-foot-horario-desktop.svg">
            <source media="(max-width: 719px)" srcset="./images/bg-foot-horario-mobil.svg">
            <img src="./images/bg-footer-top-mobile.svg" width="100%">
        </picture>
        <div class="foot">
        </div>
    </div>
    .
</body>
</html>