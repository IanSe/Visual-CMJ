<?php
    require('encriptacion/algoritmo.php');
    require('conexion/conexion.php');
    $sessionTime = 60*60*24*7;
    session_set_cookie_params(60*60*24*7);
    session_start(); //Inicio de Sesion y Cookies

    $Var_Grupo = '';

    if(isset($_COOKIE['id_sesion']))
    {
        $id = $desencriptar($_COOKIE['id_sesion']);

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
    }

    if(isset($_COOKIE['grupo'])) //Comprueba si la cookie esta guardada y baja los datos
    {
        $Var_Grupo = $_COOKIE['grupo'];
        $home_link = 1;
    }
    else if(isset($_GET['GP'])) //En caso de que no exista una cookie alguna, se bajan los datos a traves de la URL
    {
            $Var_Grupo = $_GET['GP'];
            $home_link = 0;
    }
    else //Sino hay forma de recolectar datos, se muestra un archivo aleatorio y se muestra
    {
        $algp=rand(8,14);
        $Var_Grupo = '6im'.$algp;
        $home_link = 0;
    }
    
    if(isset($_GET['GP']))
    {
    $Var_Gpo_Red = $_GET['GP'];
    }
    else
    {
        $Var_Gpo_Red = '0';
    }

    if($Var_Grupo == 'Crear')
    {
        header('Location: create');
    }

    $Dia = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"); //Declaracion de arreglo del dia
    
    require('./source_schedule.php');

    if(isset($_GET['TP'])) //Condicional que evalua si ya se leyó previamente el Ancho de la ventana 
    {
        $AnchoRel = $_GET['TP'];
    }
    else
    {
        $AnchoRel = 0; //Asigna un valor para que la variable no quede com nula
    }

    $estado_recordatorio = 0;
    $recordatorio = 'De momento no tienes ningun recordatorio';

    if(isset($_COOKIE['reminder']))
    {
        $reminder = $_COOKIE['reminder'];
        $recordatorio = $desencriptar($reminder);
        $estado_recordatorio = 1;
    }

    require('datos/asignacion_datos.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name= "description" content= "Horario web personalizado.">
    <title>Horario</title>
    <link rel="stylesheet" href="./css/estilo_horario.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="./css/estilo_footer_h_c.css">
    <link rel="stylesheet" href="./css/font.css">
    <link rel="stylesheet" href="./css/light_preference.css" media="(prefers-color-scheme: light)">
    <link rel="shortcut icon" href="./images/reloj.jpg" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Poppins:wght@700&display=swap" rel="stylesheet">
    
    <script type="text/javascript">
        
        function AnVentana() //Funcion que lee el ancho de la ventana del Navegador
        {
            var Tam = 0;
            if (typeof window.innerWidth != 'undefined')
            {
                Tam = window.innerWidth;
            }
            else if (typeof document.documentElement != 'undefined'
                && typeof document.documentElement.clientWidth !=
                'undefined' && document.documentElement.clientWidth != 0)
            {
                Tam = document.documentElement.clientWidth;
            }
            else   
            {
                Tam = document.getElementsByTagName('body')[0].clientWidth;
            }
    
            return Tam;
        }
        
        var AnchoR = <?= $AnchoRel ?>; //Paso de variable PHP a JS
        var UrlActual = window.location;
        var Tamaño_Pantalla = AnVentana(); //Uso de funcion
        var Grupo_JS = "<?= $Var_Grupo ?>";
        var Gpo_Red = "<?= $Var_Gpo_Red ?>";
        var home_link_JS = <?= $home_link ?>;

        if(AnchoR != Tamaño_Pantalla || AnchoR == 0) //Condicional que lee si el ancho anterior y el nuevo coninciden 
        {
            if( UrlActual == "http://localhost/Programas/Horarios/horario.php" || 
                UrlActual == "http://localhost/Programas/Horarios/horario" || 
                UrlActual == "http://localhost/Programas/Horarios/horario.php?GP=" + Grupo_JS || 
                UrlActual == "http://localhost/Programas/Horarios/horario?GP=" + Grupo_JS || 
                UrlActual == "http://localhost/Programas/Horarios/horario?TP=" + AnchoR +"&GP=" + Grupo_JS ||
                UrlActual == "http://localhost/Programas/Horarios/horario?TP=" + AnchoR +"&GP=" + Grupo_JS ||
                Gpo_Red != Grupo_JS)
            {
            window.location = "horario?TP=" + Tamaño_Pantalla + "&GP=" + Grupo_JS; 
            //Actualizaion del tamaño y paso de vairable JS a PHP
            }
        }

        function Actualizar() //Funcion JS que ejecuta los cambios de hora para actualizar la pagina    
        {
            var Fecha = new Date();
            var Hora_Actual = Fecha.getHours();
            var Hora_Meta = <?= $Siguiente_Hora ?>;
                
            if(Hora_Actual == Hora_Meta)
            {
                location.reload(true);
            }
        }
        
        function td_session_JS()
        {
        if(home_link_JS == 1)
        {
            document.getElementById("td_session").style.display = "inline";
        }
        else if(home_link_JS == 0)
        {
            document.getElementById("td_session").style.display = "none";
        }
        else
        {
            document.getElementById("td_session").style.color = "red";
        }
        }

        setInterval("Actualizar()",5000); //Intervalo ejecuta la funcion cada 6 segundos
    </script>
</head>

<body onload="td_session_JS()">
    <div class="link" id="hora">
    
    <table align="center">
        <tr>
            <td align="left">
                <a href="../Horarios/">
                    <img src="./images/logo_vcmj.png" alt="Visual CMJ, Logo" width="80px" height="16px">
                </a>
            </td>
            <td id="td_session">
                <a href="configuracion" class="icon-home"></a>
            </td>
            <td align="right">
                <?= $hora_actual_php ?>
            </td>
        </tr>   
    </table>

    </div>

    <?php 

        require("./arreglos/$Var_Grupo.php");

        $total_materias = count($Materias);

        $Ide_Tamaño = 0; //Id para la constuccion del Horario COMPLETO en HTML
        if(isset($_GET['TP'])){ //Condicional que evalua si ya se paso el ancho por JS
            $Tamaño = $_GET['TP']; //Paso de variable JS a PHP
            if($Tamaño <= 720){
                $Ide_Tamaño = 1; //Id para construir el Horario por DIA en HTML
            }
        }

    ?>
  
    <div class="header-main--container animate__animated animate__fadeInDown">
    <div class="hink">

    <table align="center">

        <?php if($Ide_Tamaño == 0): ?> <!-- Horario Completo -->
    
        <tr align="center">
            <td width="10%" align="center" bgcolor="black">Hora</td>
            <?php for($i=1;$i<=5;$i++): ?> 
            <td width="18%" align="center" bgcolor="black"><?= $Dia[$i] ?></td>
            <?php endfor; ?>
        </tr>

        <?php

            $Hora_Uno = $Hora_Ini;
            $Hora_Dos = $Hora_Ini+1;
            $Incremento = 0;

            for($Hora_Uno = $Hora_Ini; $Hora_Uno < $Hora_Ini+8; $Hora_Uno++): 
                //Inicio de ciclo para construir el horario en HTML

                $Datos_Lunes = $Lunes[$Incremento];
                $Datos_Martes = $Martes[$Incremento];
                $Datos_Miercoles = $Miercoles[$Incremento];
                $Datos_Jueves = $Jueves[$Incremento];
                $Datos_Viernes = $Viernes[$Incremento];
                //Extraccion de datos de cada dia
                
                require('./datos/'. $Carrera . '.php'); //Codigo externo, evalua los datos de cada dia y asigna un ID para el color de cada materia
        ?>

        <tr align="center">
            <td  align="center" bgcolor="black"><?php echo $Hora_Uno; echo "-"; echo $Hora_Dos; ?></td>
            <td align="center" bgcolor="<?= $Color[$ID_Lunes] ?>"><?= $Lunes[$Incremento] ?></td>
            <td align="center" bgcolor="<?= $Color[$ID_Martes] ?>"><?= $Martes[$Incremento] ?></td>
            <td align="center" bgcolor="<?= $Color[$ID_Miercoles] ?>"><?= $Miercoles[$Incremento] ?></td>
            <td align="center" bgcolor="<?= $Color[$ID_Jueves] ?>"><?= $Jueves[$Incremento] ?></td>
            <td align="center" bgcolor="<?= $Color[$ID_Viernes] ?>"><?= $Viernes[$Incremento] ?></td>
        </tr>

        <?php 

        $Incremento++; //Incremento de hora
        $Hora_Dos++;

        endfor; //Fin de ciclo de Horario
        
        endif;

        if($Ide_Tamaño == 1): // Horario por Dia
        ?>

        <tr align="center">
            <td width="20%" align="center" bgcolor="black">Hora</td>
            <td width="80%" align="center" bgcolor="black"><?php 
                
                if($Dia[$DiaP] == "Domingo")
                {
                    echo "Horario de Mañana";
                }
                else
                {
                    echo $Dia[$DiaP];
                }
            
            ?></td>
        </tr>
        <?php

        $Hora_Uno = $Hora_Ini;
        $Hora_Dos = $Hora_Ini+1;
        $Incremento = 0;

        for($Hora_Uno = $Hora_Ini; $Hora_Uno < $Hora_Ini+8; $Hora_Uno++):  
            //Inicio de ciclo para construir el horario en HTML

            $Datos_Lunes = $Lunes[$Incremento];
            $Datos_Martes = $Martes[$Incremento];
            $Datos_Miercoles = $Miercoles[$Incremento];
            $Datos_Jueves = $Jueves[$Incremento];
            $Datos_Viernes = $Viernes[$Incremento];
            //Extraccion de datos de cada dia
            
            require('./datos/'. $Carrera . '.php');  //Codigo externo, evalua los datos de cada dia y asigna un ID para el color de cada materia
            
            switch($Dia[$DiaP]){
                case 'Lunes':
                    $Materia_Dia_Actual = $Lunes[$Incremento];
                    $Color_Dia_Actual = $Color[$ID_Lunes];
                break;
                case 'Martes':
                    $Materia_Dia_Actual = $Martes[$Incremento];
                    $Color_Dia_Actual = $Color[$ID_Martes];
                break;
                case 'Miercoles':
                    $Materia_Dia_Actual = $Miercoles[$Incremento];
                    $Color_Dia_Actual = $Color[$ID_Miercoles];
                break;
                case 'Jueves':
                    $Materia_Dia_Actual = $Jueves[$Incremento];
                    $Color_Dia_Actual = $Color[$ID_Jueves];
                break;
                case 'Viernes':
                    $Materia_Dia_Actual = $Viernes[$Incremento];
                    $Color_Dia_Actual = $Color[$ID_Viernes];
                break;
                case 'Sabado': 
                    $Materia_Dia_Actual = "Hoy no tienes clase";
                    $Color_Dia_Actual = "indigo";
                break;
                case 'Domingo':
                    $Materia_Dia_Actual = $Lunes[$Incremento];
                    $Color_Dia_Actual = $Color[$ID_Lunes];
                break;
            }
        ?>

        <tr>
            <td  align="center" bgcolor='black'><?php echo $Hora_Uno; echo "-"; echo $Hora_Dos; ?></td>
            <td align="center" bgcolor="<?= $Color_Dia_Actual ?>"><?= $Materia_Dia_Actual ?></td>
        </tr>
        
        <?php 
        $Incremento++; //Incremento de hora
        $Hora_Dos++;
        endfor; //Fin de ciclo de Horario
        
        endif; 
        ?>
    
    </table>
    </div>
    </div>

    <?php 
    $CActual = "Es fin de semana"; //Materia Actual 
    $CSig = "Vuelve el lunes para ver tu horario"; //Siguiente Materia
    $Link_Actual = "#0"; //Link a la Materia Actual
    $Link_Siguiente = "#0"; //Link a la Materia Siguiente
    $Color_Actual = "";
    $Color_Siguiente = "";
    
    if($DiaP>=1 && $DiaP<=5)
    { //Condicional que revisa si el dia actual es un dia entre semana
        if($Hora < $Hora_Ini)
        {
            $CActual = "Aun no tienes tu primer clase";
            switch($DiaP)
            {
                case 1: 
                    $CSig = $Lunes[0]; 
                break;
                case 2: 
                    $CSig = $Martes[0]; 
                break;
                case 3: 
                    $CSig = $Miercoles[0]; 
                break;
                case 4: 
                    $CSig = $Jueves[0]; 
                break;
                case 5: 
                    $CSig = $Viernes[0]; 
                break;
            }
            if($CSig == "Off")
            {
                switch($DiaP)
                {
                    case 1: 
                        $CSig = $Lunes[1]; 
                    break;
                    case 2: 
                        $CSig = $Martes[1]; 
                    break;
                    case 3: 
                        $CSig = $Miercoles[1]; 
                    break;
                    case 4: 
                        $CSig = $Jueves[1]; 
                    break;
                    case 5: 
                        $CSig = $Viernes[1]; 
                    break;
                }
            }
        }
        if($Hora>=$Hora_Ini && $Hora<=$Hora_Ini+7) 
        //Condicional que revisa si la hora corresponde a un horario de clases 
        {
            $Hora_Auxiliar = $Hora - $Hora_Ini;

            switch($DiaP)
            {
                case 1: 
                    $CSig = $Lunes[$Hora_Auxiliar + 1];
                    $CActual = $Lunes[$Hora_Auxiliar];
                break;
                case 2: 
                    $CSig = $Martes[$Hora_Auxiliar + 1]; 
                    $CActual = $Martes[$Hora_Auxiliar];
                break;
                case 3: 
                    $CSig = $Miercoles[$Hora_Auxiliar + 1]; 
                    $CActual = $Miercoles[$Hora_Auxiliar];
                break;
                case 4: 
                    $CSig = $Jueves[$Hora_Auxiliar + 1]; 
                    $CActual = $Jueves[$Hora_Auxiliar];
                break;
                case 5: 
                    $CSig = $Viernes[$Hora_Auxiliar + 1]; 
                    $CActual = $Viernes[$Hora_Auxiliar];
                break;
            }
            if($CSig == "Off")
            {
                $CSig = "Estas en tu ultima clase del dia";
            }
        }
        if($Hora >= $Hora_Ini+8) //Condicional para el termino de clases
        {
            $CActual = "Ya no tienes clase por el dia de hoy";
            $CSig = "Vuelve mañana";
        }
    }
    
    ?>
    <div class="animate__animated animate__fadeInUp">
    <div class="hink" id="Clases">
        <table align="center">
            <tr>
                <td width="50%"  align="center" bgcolor="black">C. Actual</td>
                <td width="50%" align="center" bgcolor="black">C. Siguiente</td>
            </tr>
            <tr>
            <?php
                for($i = 0 ; $i < 2 ; $i++):
                    
                    if($DiaP>=1 && $DiaP<=5)
                    {
                        $Hora_Auxiliar = $Hora - $Hora_Ini;
                        
                        if($Hora >= $Hora_Ini && $Hora < $Hora_Ini+7)
                        {
                            $Datos_Lunes = $Lunes[$Hora_Auxiliar + $i];
                            $Datos_Martes = $Martes[$Hora_Auxiliar + $i];
                            $Datos_Miercoles = $Miercoles[$Hora_Auxiliar + $i];
                            $Datos_Jueves = $Jueves[$Hora_Auxiliar + $i];
                            $Datos_Viernes = $Viernes[$Hora_Auxiliar + $i];
                        
                            require('./datos/'. $Carrera . '.php');  //Codigo externo, evalua los datos de cada dia y asigna un ID para el color de cada materia
                                
                            switch($Dia[$DiaP])
                            {
                                case 'Lunes':
                                    $Color_Dia_Actual = $Color[$ID_Lunes];
                                break;
                                case 'Martes':
                                    $Color_Dia_Actual = $Color[$ID_Martes];
                                break;
                                case 'Miercoles':
                                    $Color_Dia_Actual = $Color[$ID_Miercoles];
                                break;
                                case 'Jueves':
                                    $Color_Dia_Actual = $Color[$ID_Jueves];
                                break;
                                case 'Viernes':
                                    $Color_Dia_Actual = $Color[$ID_Viernes];
                                break;
                            }
                        }
                        else
                        {
                            $Color_Dia_Actual = "indigo";
                        }
                    }
                    else
                    {
                        $Color_Dia_Actual = "indigo";
                    }

                    for($link_ac=0;$link_ac<$total_materias;$link_ac++)
                    {
                        if($CActual == $Materias[$link_ac])
                        {
                            $control_link_actual = $link_ac;
                        }
                        if($CSig == $Materias[$link_ac])
                        {
                            $control_link_sig = $link_ac;
                        }
                        if($CSig == ' ')
                        {
                            $control_link_sig = 20;
                        }
                        if($CActual == ' ')
                        {
                            $control_link_actual = 20;
                        }
                        if($CSig == 'Libre')
                        {
                            $control_link_sig = 20;
                        }
                        if($CActual == 'Libre')
                        {
                            $control_link_actual = 20;
                        }
                        if($CSig == 'Off')
                        {
                            $control_link_sig = 20;
                        }
                        if($CActual == 'Off')
                        {
                            $control_link_actual = 20;
                        }
                        if($CSig == 'Estas en tu ultima clase del dia')
                        {
                            $control_link_sig = 20;
                        }
                        if($CSig == 'Vuelve mañana')
                        {
                            $control_link_sig = 20;
                            $control_link_actual = 20;
                        }
                        if($CActual == 'Es fin de semana')
                        {
                            $control_link_sig = 20;
                            $control_link_actual = 20;
                        }
                        if($CActual == 'Aun no tienes tu primer clase')
                        {
                            $control_link_actual = 20;
                        }
                    }
                    if($i == 0):
            ?>

                <td align="center" bgcolor=<?= $Color_Dia_Actual ?>>
                    <?php if($control_link_actual < 20 && isset($placeholder[0])): ?>
                        <a href="<?= $placeholder[$control_link_actual] ?>" target="_blank" rel="noopner">
                    <?php endif; ?>
                    <?= $CActual ?>
                    <?php if($control_link_actual < 20 && isset($placeholder[0])): ?>
                        </a>
                    <?php endif; ?>
                </td>

            <?php 
            endif; 
    
            if($i == 1):
            ?>

                <td align="center" bgcolor=<?= $Color_Dia_Actual ?>>
                    <?php if($control_link_sig < 20 && isset($placeholder[0])): ?>
                        <a href="<?= $placeholder[$control_link_sig] ?>" target="_blank" rel="noopner">
                    <?php endif; ?>
                    <?= $CSig ?>
                    <?php if($control_link_sig < 20 && isset($placeholder[0])): ?>
                        </a>
                    <?php endif; ?>
                </td>

            <?php 
            endif;

            endfor;       
            ?>
            </tr>
        </table>
    </div>
    </div>
    <br><br><br><br>

    <?php if($estado_recordatorio == 1): ?>
    <div class="footer-background--top">
        <picture>
            <source media="(min-width: 720px)" srcset="./images/bg-foot-horario-desktop.svg">
            <source media="(max-width: 719px)" srcset="./images/bg-foot-horario-mobil.svg">
            <img src="./images/bg-footer-top-mobile.svg" width="100%">
        </picture>
        <div class="foot">
            <p align="center">Recordatorios.<br>
            <?= $recordatorio ?></p>
        </div>
    </div>
    <?php endif; ?>

    <?php if($estado_recordatorio == 0): ?>
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
    <?php endif; ?>
    .
</body>

</html>