<?php 

    $Fecha = getdate();
    $DiaP = $Fecha['wday'];
    $HoraP = $Fecha['hours'];
    $Minutos = $Fecha['minutes'];
    $Segundos = $Fecha['seconds'];
    
    $Hora = $HoraP - 7;  
    //El servidor del que saca la hora esta en una zona horaria GMT+1, esto reduce la diferencia horaria para que sea la exacta en mexico
    $Siguiente_Hora = $HoraP - 8; 
    //Lee la siguiente hora para comparar
    $Horario = date("a");
    
    if($Hora<0)
    {  //Lee la fecha para cuadrarla a la correcta, ya que cuando en el servidor era una hora posterior a 0 y menor a 7 daba una hora negativa
        $HoraP = $HoraP + 24;
        $Hora = $HoraP - 7;
        if($Siguiente_Hora < 0)
        {
        $Siguiente_Hora = $HoraP - 8;
        }
        $DiaP = $DiaP - 1;
        if($DiaP<0)
        {
            $DiaP = $DiaP + 7;
        }
    }

    $hora_actual_php = $Dia[$DiaP].' - '.$Hora;
    if($Minutos < 10)
    {   
        $hora_actual_php.= ":0".$Minutos; 
    }
    else
    {
        $hora_actual_php.= ":".$Minutos;
    }
?>