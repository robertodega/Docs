<?php
    function htmlContruction($intestazioni=array(),$valori=array()){
        $html = "<table class='t_style'><tr>";
        
        foreach($intestazioni as $i){
            $html .= "<th class='td_style td_style_int'>".$i."</th>";
        }
        
        $html .= "</tr>";
        
        foreach($valori as $val){
            $html .= "<tr>";
            foreach($intestazioni as $i){
                $value = "-";
                if(isset($val["".$i.""])){
                    $value = $val["".$i.""];
                }
                $html .= "<td class='td_style td_style_".$i."'>".$value."</td>";
            }
            $html .= "</tr>";
        }
        $html .= "</table>";
        
        return $html;
    }

    $arrayIntestazioni = array("Nome","Cognome","email","indirizzo","paese");
    $arrayIntestazioni2 = array("Professione","Cognome","indirizzo","stato");
    
    $arrayValori = array(
        array(
            "Nome" => "Gianni"
            ,"Cognome" => "Colombo"
            ,"email" => "gianni.colombo@gmail.com"
            ,"indirizzo" => "via Roma"
            ,"paese" => "Roma"
        )
        ,array(
            "Nome" => "Luigi"
            ,"Cognome" => "Colombo"
            ,"email" => "luigi.colombo@gmail.com"
            ,"indirizzo" => "via Milano"
            ,"paese" => "Catania"
        )
    );

    $arrayValori2 = array(
        array(
            "Professione" => "saldatore"
            ,"Cognome" => "Colombo"
            ,"email" => "gianni.colombo@gmail.com"
            ,"indirizzo" => "via Roma"
            ,"stato" => "Italia"
        )
        ,array(
            "Professione" => "elettricista"
            ,"Cognome" => "Colombo"
            ,"email" => "luigi.colombo@gmail.com"
            ,"indirizzo" => "via Milano"
            ,"stato" => "Italia"
        )
    );


    $html = htmlContruction($arrayIntestazioni,$arrayValori);
    $html2 = htmlContruction($arrayIntestazioni2,$arrayValori2);
?>
<html>
    <head>
        <title>Table Function</title>
        <style>
            .t_style{border-left: 1px solid black;border-top: 1px solid black;}
            .t_style_int{border-left: 1px solid red;border-top: 1px solid red;}
            .td_style{border-bottom: 1px solid black;border-right: 1px solid black;padding: 1%;width: 15%;}
            .td_style_int{border-bottom: 1px solid red;}
        </style>
    </head>
    <body>
        <?php 
            echo $html;
            echo $html2; 
        ?>
    </body>
</html>
