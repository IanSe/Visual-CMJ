<?php
            switch($Datos_Lunes)
            {
                default:
                    $ID_Lunes = 0;
                break;
                case 'Off':
                    $ID_Lunes = 5;
                break;
                case 'Libre':
                    $ID_Lunes = 6;
                break;
                case '':
                    $ID_Lunes = 6;
                break;
            }

            switch($Datos_Martes)
            {
                default:
                    $ID_Martes = 1;
                break;
                case 'Off':
                    $ID_Martes = 5;
                break;
                case '':
                    $ID_Martes = 6;
                break;
                case 'Libre':
                    $ID_Martes = 6;
                break;
            }

            switch($Datos_Miercoles)
            {
                default:
                    $ID_Miercoles = 2;
                break;
                case 'Off':
                    $ID_Miercoles = 5;
                break;
                case '':
                    $ID_Miercoles = 6;
                break;
                case 'Libre':
                    $ID_Miercoles = 6;
                break;
            }

            switch($Datos_Jueves)
            {
                default:
                    $ID_Jueves = 3;
                break;
                case 'Off':
                    $ID_Jueves = 5;
                break;
                case '':
                    $ID_Jueves = 6;
                break;
                case 'Libre':
                    $ID_Jueves = 6;
                break;
            }

            switch($Datos_Viernes)
            {
                default:
                    $ID_Viernes = 4;
                break;
                case 'Off':
                    $ID_Viernes = 5;
                break;
                case '':
                    $ID_Viernes = 6;
                break;
                case 'Libre':
                    $ID_Viernes = 6;
                break;
            }
?>