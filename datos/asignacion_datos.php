<?php
        switch($Var_Grupo)
        {
            case 'cecyt8_6im1': case 'cecyt8_6im2': case 'cecyt8_6im3': case 'cecyt8_6im4': case 'cecyt8_6im5':
                $Carrera = 'manto_6';
            break;

            case 'cecyt8_6im6': case "cecyt8_6im7":
                $Carrera = "auto_6";
            break;

            case 'cecyt8_6im8': case "cecyt8_6im9":case 'cecyt8_6im10':case 'cecyt8_6im11':
                $Carrera = 'plasticos_6';
            break;    
            
             case "cecyt8_6im12": case 'cecyt8_6im13': case "cecyt8_6im14":
                $Carrera = 'compu_6';
            break;
            
            case 'cecyt8_4im1': case 'cecyt8_4im2': case 'cecyt8_4im3': case 'cecyt8_4im4': case 'cecyt8_4im5':
                $Carrera = 'manto_4';
            break;
            
            case 'cecyt8_4im6': case "cecyt8_4im7":
                $Carrera = "auto_4";
            break;

            case 'cecyt8_4im8': case "cecyt8_4im9": case 'cecyt8_4im10': case 'cecyt8_4im11':
                $Carrera = 'plasticos_4';
            break;    
            
            case 'cecyt8_4im12': case "cecyt8_4im13": case 'cecyt8_4im14': case "cecyt8_4im15": case "cecyt8_4im16":
                $Carrera = 'compu_4';
            break;
            default:
                $Carrera = 'basica';
            break;
        }
?>