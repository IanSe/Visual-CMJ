<?php 
    require('conexion/conexion.php');
    require('encriptacion/algoritmo.php'); //Solicita datos de encriptación

    $sessionTime = 60*60*24*7;
    $r_sessionTime = 60*60*24*1;
    session_set_cookie_params(60*60*24*7);
    session_start(); //Inicia sesion 

    $grupo = null;
    $id = null;

    if(isset($_COOKIE['id_sesion'])) //Verifica que se haya iniciado sesion
    {
        $id_enc = $_COOKIE['id_sesion'];
        $grupo = $_COOKIE['grupo'];
        $id = $desencriptar($id_enc);

        require("./arreglos/$grupo.php");
    }
    else //En caso de no haber iniciado, se redirecciona al inicio de sesion 
    {
       header("Location: login");
    }

    if($grupo == 'Crear')
    {
        header('Location: create');
    }

    $Dia = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"); //Declaracion de arreglo del dia
    $i = 0;
    $Control = 0;
    $mensaje_estado_link = 'Da click en empezar para guardar tus links a tus clases en linea';
    $mensaje_estado_recordatorios = 'Escribe una nota para tus clases de mañana';
    $Humor = 0;
    $placeholder = array('Link', 'Link', 'Link', 'Link', 'Link', 'Link', 'Link', 'Link', 'Link', 'Link');
    $Link = array();

    require('./source_schedule.php');

    if($Hora >= 22)
    {
        $Feel_Day = "sentiste";
    }
    else
    {
        $Feel_Day = "sientes";
    }

    if(!empty($id))
    {
        if($mysqli->query("SELECT * FROM `links` WHERE `id` = '$id'"))
        {
            $resultado = $mysqli->query("SELECT * FROM `links` WHERE `id` = '$id'");
            $resultado->data_seek(0);

            while($fila = $resultado->fetch_assoc())
            {
                $place[0] = $fila['materia1'];
                $place[1] = $fila['materia2'];
                $place[2] = $fila['materia3'];
                $place[3] = $fila['materia4'];
                $place[4] = $fila['materia5'];
                $place[5] = $fila['materia6'];
                $place[6] = $fila['materia7'];
                $place[7] = $fila['materia8'];
                $place[8] = $fila['materia9'];
                $place[9] = $fila['materia10'];

                for($i=0;$i<10;$i++)
                {
                    $placeholder[$i] = $desencriptar($place[$i]);
                }
            }
        }

        if($mysqli->query("SELECT * FROM `usuario` WHERE `id` = '$id'"))
        {
            $resultado = $mysqli->query("SELECT * FROM `usuario` WHERE `id` = '$id'");
            $resultado->data_seek(0);

            while($fila = $resultado->fetch_assoc())
            {
                $nombre_usuario = $fila['nombre'];
            }
        }
    }

    if(isset($_POST['start_link_save']))
    {
        $Control = 1;
        $mensaje_estado_link = 'Copia y pega tus links para tus clases en linea, 
        sino tienes alguno selecciona "Libre".';
    }
    
    if(isset($_POST['recordatoriosform']))
    {
        $recordatorios_tomo = $_REQUEST['recordatorios_tom'];
        $recor_enc = $encriptar($recordatorios_tomo);

        if(!empty($id))
        {
            setcookie("reminder", $recor_enc, time() + $r_sessionTime, "/");
        }
    }

    if(isset($_POST['savelinks_into_db']))
    {
        $Link_aenc = array();
        $Link_aenc[0] = $_REQUEST["lmateria0"]; 
        $Link_aenc[1] = $_REQUEST["lmateria1"]; 
        $Link_aenc[2] = $_REQUEST["lmateria2"]; 
        $Link_aenc[3] = $_REQUEST["lmateria3"]; 
        $Link_aenc[4] = $_REQUEST["lmateria4"]; 
        $Link_aenc[5] = $_REQUEST["lmateria5"]; 
        $Link_aenc[6] = $_REQUEST["lmateria6"]; 
        $Link_aenc[7] = $_REQUEST["lmateria7"]; 
        $Link_aenc[8] = $_REQUEST["lmateria8"]; 
        $Link_aenc[9] = $_REQUEST["lmateria9"]; 

        for($i=0;$i<10;$i++)
        {
            if($Link_aenc[$i] == 'Libre')
            {
                $Link_aenc[$i] = '#';
            }
            $Link[$i] = $encriptar($Link_aenc[$i]);
        }

        if(!empty($id))
        {
            if($placeholder == 'Link')
            {
                $sql = "INSERT INTO `links` (`id`, `materia1`, `materia2`, `materia3`, `materia4`, `materia5`, `materia6`, `materia7`, `materia8`, `materia9`, `materia10`) VALUES 
                ('$id', '$Link[0]', '$Link[1]', '$Link[2]', '$Link[3]', '$Link[4]', '$Link[5]', '$Link[6]', '$Link[7]', '$Link[8]', '$Link[9]')";
                $catch = $mysqli->query($sql);
            }
            else
            {
                $sql = "UPDATE `links` SET `materia1` = '$Link[0]', `materia2` = '$Link[1]',  `materia3` = '$Link[2]',
                 `materia4` = '$Link[3]',  `materia5` = '$Link[4]',  `materia6` = '$Link[5]',  `materia7` = '$Link[6]',
                 `materia8` = '$Link[7]',  `materia9` = '$Link[8]',  `materia10` = '$Link[9]' WHERE `links`.`id` = $id;";
                $catch = $mysqli->query($sql);
            }


            if(!$catch)
            {
                $mensaje_estado_link = 'Error al subir '.$mysqli->error;
            }
            else
            {
                $mensaje_estado_link = 'Links guardados correctamente';
            }
            $Control = 0;
        }
    }
?>

<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="./css/font.css">
    <link rel="stylesheet" href="./css/estilo_config.css">
    <link rel="stylesheet" href="./css/estilo_footer_h_c.css">
    <link rel="stylesheet" href="./css/light_preference.css" media="(prefers-color-scheme: light)">
    <link rel="shortcut icon" href="./images/reloj.jpg" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Poppins:wght@700&display=swap" rel="stylesheet">
    <title>Configuracion</title>

    <script type="text/javascript">
        var UrlActual = window.location;
        var contenido_textarea = "";
        var num_caracteres_permitidos = 50;

        if( UrlActual == "http://localhost/Programas/Horarios/configuracion.php" || UrlActual == "http://192.168.100.124/programas/horarios/configuracion.php")
        {
            window.location = "configuracion";
        }

        function Bloqueo()
        {
            document.getElementById("Menu").style.pointerEvents = "none";
            document.getElementById("Menu").style.display = "none";
            document.getElementById("Btn_Menu").style.display = "inline-block";
            document.getElementById("Btn_Menu").style.pointerEvents = "all";
        }

        function Menu()
        {
            document.getElementById("Menu").style.pointerEvents = "all";
            document.getElementById("Menu").style.display = "inline-block";
            document.getElementById("Btn_Menu").style.display = "none";
            document.getElementById("Btn_Menu").style.pointerEvents = "none";
        }
        function noespacios() 
        {
            var er = new RegExp(/\s/);
            var web = document.getElementById('cdusuario_web').value;
            if(er.test(web))
            {
                alert('No se permiten espacios');
                return false;
            }
            else
            {
                return true;
            }
        }
</script>

</head>

<body onload="Bloqueo()">
    
    <div class="social" id="Btn_Menu">       
        <ul>
            <li><a class="icon-paragraph-justify" onclick="Menu()"></a></li>
        </ul>
    </div>
    <div class = "social" id = "Menu">
		<ul>
            <li><a class="icon-paragraph-justify" onclick="Bloqueo()"></a></li>
            <li><a href="configuracion#control" class="icon-cogs"></a></li>
            <li><a href="configuracion#humor" class="icon-smile2"></a></li>
			<li><a href="configuracion#links" class="icon-calendar"></a></li>
            <li><a href="configuracion#recordatorios" class="icon-pencil"></a></li>
		</ul>
	</div>

    <div class = "link" id = "hora">
        <table align="center">
        <tr>
            <td align="left">
                <a href="../Horarios/">
                    <img src="./images/logo_vcmj.png" alt="Visual CMJ, Logo" width="80px" height="16px">
                </a>
            </td>
            <td>
                <a href="horario" class="icon-clock2"></a>
            </td>
            <td align="right">
                <?= $hora_actual_php ?>
            </td>
        </tr>   
        </table>
    </div>

    <div class="header-main--container animate__animated animate__fadeInDown">
    <div class="Contenedor" id="control">
        <br>
        <h3>Bienvenido, aqui puedes configurar tu horario para tus clases en linea</h3> <br><br>
        Usuario: <?= $nombre_usuario ?><br>
        Grupo: <?= $grupo ?><br><br><br>
        <a href="close_sesion">Cerrar Sesion</a><br>.
    </div><br>
    </div>

    <div class="Emocion" id="humor">
        <br>
        <h3>¿Como te <?= $Feel_Day ?> hoy?</h3> <br><br> 

        <form action="configuracion" method="post">
            <div class="Feliz"><button type="submit" value="1" name="Estado_H"><i class="icon-happy2"></i></button></div>
            <div class="Alegre"><button type="submit" value="2"  name="Estado_H"><i class="icon-smile2"></i></button></div>
            <div class="Normal"><button type="submit" value="3"  name="Estado_H"><i class="icon-neutral2"></i></button></div>
            <div class="Triste"><button type="submit" value="4"  name="Estado_H"><i class="icon-sad2"></i></button></div>
            <div class="Morido"><button type="submit" value="5"  name="Estado_H"><i class="icon-crying2"></i></button></div>
            <br><br>
        </form>

        <?php 
            if(isset($_POST['Estado_H']))
            {
                $Humor = $_REQUEST['Estado_H'];
            }

            switch($Humor)
            {
                case 1:
                    $Mensaje = "Felicidades";
                break;
                case 2:
                    $Mensaje = "Sonrie un poco mas :)";
                break;
                case 3:
                    $Mensaje = "Mañana sera mejor u.u";
                break;
                case 4:
                    $Mensaje = "modo triste";
                break;
                case 5:
                    $Mensaje = "Ouch";
                break;
            }

            if($Humor > 0):
        ?>
        <br><?= $Mensaje ?><br><br>
        <?php endif; ?>
    </div>

    <div class="Contenedor" id="links"><br>
        <h3><?= $mensaje_estado_link ?></h3><br><br>
        <?php if($Control == 0): ?>
            <form action="configuracion" method="post">
                <input type="submit" name="start_link_save" value="Empezar">
            </form> <br><br>
        <?php endif; ?>

            <datalist id="materias_libres">
            <option value="Libre"></option>
            </datalist>

        <?php if($Control == 1): ?>

            <form action="configuracion" method="post">
            <?php for($i=0;$i<10;$i++): ?>
                Link para <?= $Materias[$i] ?>
                <input list="materias_libres" type="text" name="lmateria<?= $i ?>" 
                value="<?= $placeholder[$i] ?>" placeholder="Escribe el link" required><br>

            <?php endfor; ?>
            <br>
            <input type="submit" name="savelinks_into_db" value="Guardar">
            </form> <br><br>

        <?php endif; ?>
    </div>

    <div class="Contenedor" id="recordatorios">
        <br>
        <h3>Notas</h3>
        <br><br>Escribe una nota para tus clases de mañana <br>
        <form action="configuracion" method="post">
            <textarea name="recordatorios_tom" rows="5" cols="50" maxlength="250" minlength="5" require></textarea>
            <br><br>
            <input type="submit" name="recordatoriosform" value="Guardar"><br><br>
        </form>
    </div>
    <br><br><br>
    <div class="footer-background--top">
        <picture>
            <source media="(min-width: 720px)" srcset="./images/bg-foot-horario-desktop.svg">
            <source media="(max-width: 719px)" srcset="./images/bg-foot-horario-mobil.svg">
            <img src="./images/bg-footer-top-mobile.svg" width="100%">
        </picture>
        <div class="foot">
            <p align='center'>VISUAL CMJ<br><br>
                <i>Pichos SA. de CV. © 2021</i>
            </p>
        </div>
    </div>
    .
</body>

</html>