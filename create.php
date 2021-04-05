<?php 
    require("./conexion/conexion.php");
    require("./encriptacion/algoritmo.php");
    
    $sessionTime = 60*60*24*7;
    session_set_cookie_params(60*60*24*7);
    session_start();

    if(isset($_COOKIE['id_sesion']) && isset($_COOKIE['grupo'])) //Comprueba si la cookie esta guardada y baja los datos
    {
        $id_encriptado = $_COOKIE['id_sesion'];
        $grupo_cookie = $_COOKIE['grupo'];
        $id = $desencriptar($id_encriptado);
        
        if($grupo_cookie != 'Crear')
        {
            header("Location: horario?GP=".$grupo_cookie);
        }
    }
    else
    {
        header("Location: signup");
    }

    $Title_Nombre = 'Solo se permiten letras y numeros';
    $Estado_hache2 = 'Escribe el nombre en minusculas por favor.';
    $Estado_Creacion = 0;
    $Estado_Asignacion = 0;
    $Nombre_Horario = '';
    $M1 = ''; $M2 = ''; $M3 = ''; $M4 = ''; $M5 = ''; $M6 = ''; $M7 = ''; $M8 = ''; $M9 = ''; $M10 = '';
    $Lunes = array();
    $Martes = array();
    $Miercoles = array();
    $Jueves = array();
    $Viernes = array();

    if(isset($_POST['create']))
    {
        $Nombre_Horario = $_REQUEST['escuela_p']."_".$_REQUEST['title'];

        $_SESSION['Nombre_Horario'] = $Nombre_Horario;

        if(file_exists("arreglos/$Nombre_Horario.php"))
        {
            $Error = 'El horario ya fue creado';
            $Estado_hache2 = 'Escribe de nuevo el horario y aprieta el boton "Asignar", para elegir ese grupo';
            $Estado_Asignacion = 1;
        }
        else
        {
            $Estado_Creacion = 1;
            $Estado_hache2 = 'Llena con el nombre de tus materias, puedes dejar materias en blanco.';
        }
    }

    if(isset($_POST['asignacion']))
    {
        $horario_asig = $_SESSION['Nombre_Horario'];
        $cambio = $mysqli->query("UPDATE `usuario` SET `grupo` = '$horario_asig' WHERE `usuario`.`id` = $id");
        
        setcookie("grupo", $horario_asig, time() + $sessionTime, "/");
        header("Location: horario?GP=".$horario_asig);
    }


    if(isset($_POST['saveschedule']))
    {
        $M1 = $_REQUEST['materia1'];
        $M2 = $_REQUEST['materia2'];
        $M3 = $_REQUEST['materia3'];
        $M4 = $_REQUEST['materia4'];
        $M5 = $_REQUEST['materia5'];
        $M6 = $_REQUEST['materia6'];
        $M7 = $_REQUEST['materia7'];
        $M8 = $_REQUEST['materia8'];
        $M9 = $_REQUEST['materia9'];
        $M10 = $_REQUEST['materia10'];
        
        $_SESSION['M1'] = $M1;
        $_SESSION['M2'] = $M2;
        $_SESSION['M3'] = $M3;
        $_SESSION['M4'] = $M4;
        $_SESSION['M5'] = $M5;
        $_SESSION['M6'] = $M6;
        $_SESSION['M7'] = $M7;
        $_SESSION['M8'] = $M8;
        $_SESSION['M9'] = $M9;
        $_SESSION['M10'] = $M10;

        $Estado_Creacion = 2;
        $Estado_hache2 = 'Llena las materias, es un horario de 8 horas, puedes dejar espacios en blanco';
    }

    if(isset($_POST['saveschedulecreate']))
    {
        $Lunes = array($_REQUEST['lun_m1'],
                       $_REQUEST['lun_m2'],
                       $_REQUEST['lun_m3'],
                       $_REQUEST['lun_m4'],
                       $_REQUEST['lun_m5'],
                       $_REQUEST['lun_m6'],
                       $_REQUEST['lun_m7'],
                       $_REQUEST['lun_m8']);

        $Martes = array($_REQUEST['mar_m1'],
                       $_REQUEST['mar_m2'],
                       $_REQUEST['mar_m3'],
                       $_REQUEST['mar_m4'],
                       $_REQUEST['mar_m5'],
                       $_REQUEST['mar_m6'],
                       $_REQUEST['mar_m7'],
                       $_REQUEST['mar_m8']);

        $Miercoles = array($_REQUEST['mie_m1'],
                       $_REQUEST['mie_m2'],
                       $_REQUEST['mie_m3'],
                       $_REQUEST['mie_m4'],
                       $_REQUEST['mie_m5'],
                       $_REQUEST['mie_m6'],
                       $_REQUEST['mie_m7'],
                       $_REQUEST['mie_m8']);

        $Jueves = array($_REQUEST['jue_m1'],
                       $_REQUEST['jue_m2'],
                       $_REQUEST['jue_m3'],
                       $_REQUEST['jue_m4'],
                       $_REQUEST['jue_m5'],
                       $_REQUEST['jue_m6'],
                       $_REQUEST['jue_m7'],
                       $_REQUEST['jue_m8']);
                       
        $Viernes = array($_REQUEST['vie_m1'],
                       $_REQUEST['vie_m2'],
                       $_REQUEST['vie_m3'],
                       $_REQUEST['vie_m4'],
                       $_REQUEST['vie_m5'],
                       $_REQUEST['vie_m6'],
                       $_REQUEST['vie_m7'],
                       $_REQUEST['vie_m8']);

        $Estado_Creacion = 3;
        $Estado_hache2 = 'Por ultimo indica la hora de inicio de tu horario, en horas de 0 a 24';
        require('./datos/aisgnacion_creacion.php');
        for($i=0;$i<8;$i++)
        {
            $_SESSION['Lunes'][$i] = $Lunes[$i];
            $_SESSION['Martes'][$i] = $Martes[$i];
            $_SESSION['Miercoles'][$i] = $Miercoles[$i];
            $_SESSION['Jueves'][$i] = $Jueves[$i];
            $_SESSION['Viernes'][$i] = $Viernes[$i];
        }
    }

    if(isset($_POST['savehours']))
    {
        $Hora_Inicio = $_REQUEST['hora_inicio'];
        $_SESSION['Hora_ini'] = $Hora_Inicio;
        $Estado_Creacion = 4;
    }

    if($Estado_Creacion == 4)
    {
        $Nombre_Horario = $_SESSION['Nombre_Horario'];
        $archivo = fopen("arreglos/$Nombre_Horario.php", "wb");

        if($archivo == false)
        {
            $Error = 'Fallo al crear horario';
        }
        else
        {
            fwrite($archivo, '<?php'.PHP_EOL);
            fwrite($archivo, '$A='."'".$_SESSION['M1']."'".';'.PHP_EOL);
            fwrite($archivo, '$B='."'".$_SESSION['M2']."'".';'.PHP_EOL);
            fwrite($archivo, '$C='."'".$_SESSION['M3']."'".';'.PHP_EOL);
            fwrite($archivo, '$D='."'".$_SESSION['M4']."'".';'.PHP_EOL);
            fwrite($archivo, '$E='."'".$_SESSION['M5']."'".';'.PHP_EOL);
            fwrite($archivo, '$F='."'".$_SESSION['M6']."'".';'.PHP_EOL);
            fwrite($archivo, '$G='."'".$_SESSION['M7']."'".';'.PHP_EOL);
            fwrite($archivo, '$H='."'".$_SESSION['M8']."'".';'.PHP_EOL);
            fwrite($archivo, '$I='."'".$_SESSION['M9']."'".';'.PHP_EOL);
            fwrite($archivo, '$J='."'".$_SESSION['M10']."'".';'.PHP_EOL);
            fwrite($archivo, '$K="Off"'.';'.PHP_EOL);
            fwrite($archivo, '$N=""'.';'.PHP_EOL);

            for($i=0;$i<8;$i++)
            {
                $Lunes[$i] = $_SESSION['Lunes'][$i];
                $Martes[$i] = $_SESSION['Martes'][$i];
                $Miercoles[$i] = $_SESSION['Miercoles'][$i];
                $Jueves[$i] = $_SESSION['Jueves'][$i];
                $Viernes[$i] = $_SESSION['Viernes'][$i];
            }

            fwrite($archivo, '$Lunes=array('."$Lunes[0], $Lunes[1], $Lunes[2], $Lunes[3], $Lunes[4], $Lunes[5], $Lunes[6], $Lunes[7],".'$K);'.PHP_EOL);
            fwrite($archivo, '$Martes=array('."$Martes[0], $Martes[1], $Martes[2], $Martes[3], $Martes[4], $Martes[5], $Martes[6], $Martes[7],".'$K);'.PHP_EOL);
            fwrite($archivo, '$Miercoles=array('."$Miercoles[0], $Miercoles[1], $Miercoles[2], $Miercoles[3], $Miercoles[4], $Miercoles[5], $Miercoles[6], $Miercoles[7],".'$K);'.PHP_EOL);
            fwrite($archivo, '$Jueves=array('."$Jueves[0], $Jueves[1], $Jueves[2], $Jueves[3], $Jueves[4], $Jueves[5], $Jueves[6], $Jueves[7],".'$K);'.PHP_EOL);
            fwrite($archivo, '$Viernes=array('."$Viernes[0], $Viernes[1], $Viernes[2], $Viernes[3], $Viernes[4], $Viernes[5], $Viernes[6], $Viernes[7],".'$K);'.PHP_EOL);
            fwrite($archivo, '$Color=array("#7e36b9", "#ca2c2c", "#d45500", "#2f4f40", "#1d72b8", "#aa006c", "white");'.PHP_EOL);
            fwrite($archivo, '$Materias=array($A, $B, $C, $D, $E, $F, $G, $H, $I, $J);'.PHP_EOL);
            fwrite($archivo, '$Hora_Ini='.$_SESSION['Hora_ini'].PHP_EOL);
            fwrite($archivo, '?>');
            fclose($archivo);

            $cambio = $mysqli->query("UPDATE `usuario` SET `grupo` = '$Nombre_Horario' WHERE `usuario`.`id` = $id");
            setcookie("grupo", $Nombre_Horario, time() + $sessionTime, "/");

            header("Location: horario?GP=$Nombre_Horario");
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/reloj.jpg" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="css/estilo_registro.css">
    <link rel="stylesheet" href="css/estilo_footer_h_c.css">
    <link rel="stylesheet" href="css/estilo_tablet_registro.css" media="(min-width: 768px)">
    <title>Creación de horario VCMJ</title>

</head>
<body>
<body bgcolor="#fbf7ff">
    <header class="animate__animated animate__fadeInLeft">
        <div class="header-logo--container">
            <table>
                <tr>
                    <td>
                        <img src="images/logo_vcmj.png" alt="Visual CMJ, Logo" width="140px" height="30px">
                    </td>
                    <td>
                        <?php if(isset($Error)): ?>
                            <font size="3px" color="red"><?= $Error ?></font>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
    </header>

<main class="animate__animated animate__fadeInUp">
        <section class="main-form--container">
            <h1>Crea tu propio horario personalizado</h1>
            <h2><?= $Estado_hache2 ?></a></h2> <br>

            <?php if($Estado_Creacion == 0): ?>
                <form action="create" method="post">
                    <label for="escuela">
                        <span>Escuela de Procedencia</span>
                        <input type="text" name="escuela_p" id="escuela" placeholder="ej: cecyt8, enp7, cchote" 
                        required pattern="[A-Za-z1-0]+" style="text-transform:lowercase;" 
                        onkeyup="javascript:this.value=this.value.toLowerCase();" title="<?= $Title_Nombre ?>">
                    </label>

                    <label for="name">
                        <span>Nombre del Horario</span>
                        <input type="text" name="title" id="name" placeholder="ej: 6im14" 
                        required pattern="[A-Za-z1-0]+" style="text-transform:lowercase;" 
                        onkeyup="javascript:this.value=this.value.toLowerCase();" title="<?= $Title_Nombre ?>">
                    </label>
    
                    <?php if($Estado_Asignacion == 0): ?>
                    <input type="submit" name="create" id="submit" value="  Create  ">
                    <?php endif; ?>

                    <?php if($Estado_Asignacion == 1): ?>
                    <input type="submit" name="asignacion" id="submit" value="  Asignar  ">
                    <?php endif; ?>
                    </div><br><br>
                </form>
            <?php endif; ?>


            <?php if($Estado_Creacion == 1): ?>
                <datalist id="llenado_materias">
                    <option value="Libre"></option>
                </datalist>
                <form action="create" method="post">
                    <label for="materias">
                        <?php for($i=1;$i<11;$i++): ?>
                            <span>Materia <?= $i ?></span>
                            <input list="llenado_materias" type="text" name="materia<?= $i ?>" id="materias" 
                            placeholder="ej: Programacion" required pattern="[A-Za-z0-9\áéíóú]*">
                        <?php endfor; ?>
                    </label><br>
                    <input type="submit" name="saveschedule" id="submit" value="  Guardar materias  ">
                    </div><br><br>
                </form>
            <?php endif; ?>


            <?php if($Estado_Creacion == 2): ?>
                <datalist id="materias_creadas">
                    <option value="<?= $M1 ?>"></option>
                    <option value="<?= $M2 ?>"></option>
                    <option value="<?= $M3 ?>"></option>
                    <option value="<?= $M4 ?>"></option>
                    <option value="<?= $M5 ?>"></option>
                    <option value="<?= $M6 ?>"></option>
                    <option value="<?= $M7 ?>"></option>
                    <option value="<?= $M8 ?>"></option>
                    <option value="<?= $M9 ?>"></option>
                    <option value="<?= $M10 ?>"></option>
                    <option value="Libre"></option>
                </datalist>

                <form action="create" method="post">
                    <label for="Lunes">
                        <?php for($i=1;$i<9;$i++): ?>
                            <span>Lunes hora <?= $i ?></span>
                            <input  list="materias_creadas"type="text" name="lun_m<?= $i ?>" id="materias" placeholder="ej: <?= $M1 ?>" 
                            required pattern="[A-Za-z0-9\áéíóú]*" title="<?= $Title_Nombre ?>">
                        <?php endfor; ?>
                    </label><br><br>

                    <label for="Martes">
                        <?php for($i=1;$i<9;$i++): ?>
                            <span>Martes hora <?= $i ?></span>
                            <input list="materias_creadas" type="text" name="mar_m<?= $i ?>" id="materias" placeholder="ej: <?= $M2 ?>" 
                            required pattern="[A-Za-z0-9\áéíóú]*" title="<?= $Title_Nombre ?>">
                        <?php endfor; ?>
                    </label><br><br>

                    <label for="Miercoles">
                        <?php for($i=1;$i<9;$i++): ?>
                            <span>Miercoles hora <?= $i ?></span>
                            <input list="materias_creadas" type="text" name="mie_m<?= $i ?>" id="materias" placeholder="ej: <?= $M3 ?>" 
                            required pattern="[A-Za-z0-9\áéíóú]*" title="<?= $Title_Nombre ?>">
                        <?php endfor; ?>
                    </label><br><br>

                    <label for="Jueves">
                        <?php for($i=1;$i<9;$i++): ?>
                            <span>Jueves hora <?= $i ?></span>
                            <input list="materias_creadas" type="text" name="jue_m<?= $i ?>" id="materias" placeholder="ej: <?= $M4 ?>" 
                            required pattern="[A-Za-z0-9\áéíóú]*" title="<?= $Title_Nombre ?>">
                        <?php endfor; ?>
                    </label><br>

                    <label for="Viernes">
                        <?php for($i=1;$i<9;$i++): ?>
                            <span>Viernes hora <?= $i ?></span>
                            <input list="materias_creadas" type="text" name="vie_m<?= $i ?>" id="materias" placeholder="ej: <?= $M5 ?>" 
                            required pattern="[A-Za-z0-9\áéíóú]*" title="<?= $Title_Nombre ?>">
                        <?php endfor; ?>
                    </label><br>

                    <input type="submit" name="saveschedulecreate" id="submit" value="  Guardar Horario  ">
                    </div><br><br>
                    
                </form>
            <?php endif; ?>

            <?php if($Estado_Creacion == 3): ?>
                <form action="create" method="post">
                    <label for="horas">
                            <span>Hora de Inicio</span>
                            <input type="number" name="hora_inicio" max="24" pattern="[0-9]"  id="horas">
                    </label><br>
                    <input type="submit" name="savehours" id="submit" value="  Guardar Hora  ">
                    </div><br><br>
                </form>
            <?php endif; ?>            
        </section>
    </main> <br><br><br>
    <div class="footer-background--top">
        <picture>
            <source media="(min-width: 720px)" srcset="./images/bg-foot-horario-desktop.svg">
            <source media="(max-width: 719px)" srcset="./images/bg-foot-horario-mobil.svg">
            <img src="images/bg-footer-top-mobile.svg" width="100%">
        </picture>
        <div class="foot">
        </div>
    </div>
    .
</body>
</html>