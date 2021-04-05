<?php
    require('./encriptacion/algoritmo.php');
    require('./conexion/conexion.php');

    $sessionTime = 60*60*24*2;
    $tresessionTime = 60*60*24*365;
    session_set_cookie_params(60*60*24*7);
    session_start();

    $message = '';
    $passcon="";
    $value_mail = '';
    $value_pwd = '';
    $value_una = 0;

    if(isset($_COOKIE['mail']) && isset($_COOKIE['pwd']))
    {
        $value_mail = $desencriptar($_COOKIE['mail']);
        $value_pwd = $desencriptar($_COOKIE['pwd']);
        $value_una = 1;
    }

    if(isset($_POST['submit']))
    {
        $mail = $_REQUEST['email'];
        $pwd = $_REQUEST['password'];

        if($mysqli->query("SELECT * FROM `usuario` WHERE `correo` = '$mail'"))
        {
            $resultado = $mysqli->query("SELECT * FROM `usuario` WHERE `correo` = '$mail'");
            $resultado->data_seek(0);

            while($fila = $resultado->fetch_assoc())
            {
                $passcon = $fila['pwd'];
                $grupo = $fila['grupo'];
                $nombre = $fila['nombre'];
                $id = $fila['id'];
            }
            $id_enc = $encriptar($id);
            $pwd_enc = $encriptar($pwd);
            $mail_enc = $encriptar($mail);            

            $_SESSION['id'] = $id_enc;
            $_SESSION['grupo'] = $grupo;
            $_SESSION['pwd'] = $pwd_enc;
            $_SESSION['mail'] = $mail_enc;

            if(password_verify($pwd, $passcon))
            {
                if(isset($_COOKIE['id_session']))
                {
                    header("Location: horario?GP=".$_SESSION['grupo']);
                }
                else
                {
                    setcookie("id_sesion", $_SESSION['id'], time() + $sessionTime, "/");
                    setcookie("grupo", $_SESSION['grupo'], time() + $sessionTime, "/");
                    if(isset($_POST['nav_trust']))
                    {
                        setcookie("pwd", $_SESSION['pwd'], time() + $tresessionTime, "/");
                        setcookie("mail", $_SESSION['mail'], time() + $tresessionTime, "/");
                    }
                    header("Location: horario?GP=".$_SESSION['grupo']);
                }
            }
            else
            {
                $Error = "Error en contraseña";
            }
        }
        else
        {
            $Error = "Error en el correo" ;
        }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="¿Tienes una cuenta en VIsual CMJ?, Logeate ahora">
    <link rel="shortcut icon" href="./images/reloj.jpg" type="image/x-icon">
    <title>Inicia Sesion en Visual CMJ</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="./css/estilo_registro.css">
    <link rel="stylesheet" href="./css/estilo_footer_h_c.css">
    <link rel="stylesheet" href="./css/estilo_tablet_registro.css" media="(min-width: 768px)">
    
    <script type="text/javascript">
        function greenInput(){    
            var value_uni = <?= $value_una ?>;
            if(value_uni == 1)
            {
                document.getElementById('email').style.borderBottomWidth = "2px";
                document.getElementById('password').style.borderBottomWidth = "2px";
                document.getElementById('email').style.borderBottomColor = "#008000";
                document.getElementById('password').style.borderBottomColor = "#008000";
            }    
        }
    </script>

</head>

<body onload="greenInput()">
    
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
                        <p align="center" color="red"><?= $Error ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
    
        </div>
    
    </header>

    <main class="animate__animated animate__fadeInUp">

        <section class="main-form--container">

            <h1>Sigue organizando tu tiempo </h1>
            <h2>Aun no tienes una cuenta? | <a href="signup">Registrate</a></h2>

            <form action="login" method="post">
                <label for="email">
                    <span>Mail</span>
                    <input type="email" name="email" id="email" placeholder="ej: JaibaZequi@mail.com" 
                    value="<?= $value_mail ?>" autocomplete="email" autocomplete="mail" required>
                </label>
                <label for="password">
                    <span>Contraseña</span>
                    <input type="password" name="password" id="password" value="<?= $value_pwd ?>"
                     minlength="8" required>
                </label>
                <div class="check-container">
                <label for="check" class="check">
                    <input type="checkbox" id="check" name="nav_trust"> ¿Confias en este navegador? 
                </label><br>
                <input type="submit" name="submit" id="submit" value="Iniciar Sesion">
                </div>
            </form>
        </section>
    </main><br><br>
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