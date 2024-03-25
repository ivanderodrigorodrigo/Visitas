<?php

namespace app\controllers;

class globalController {

    public function getid ($ref){  

        $ref_id = null;
        
        // Obtener la URL completa
        $url_completa = $_SERVER['REQUEST_URI'];
        // Parsear la URL para obtener sus componentes
        $url_componentes = parse_url($url_completa);

        if (isset($url_componentes['query'])){
            //Parsear la cadena de consulta para obtener los parámetros
            parse_str($url_componentes['query'], $parametros);
            $ref_id = isset($parametros[$ref]) ? $parametros[$ref] : null;    

        }

        return $ref_id;
    }

    /*----------  Funcion limpiar cadenas  ----------*/
    public function limpiarCadena($cadena){

        $palabras=["<script>","</script>","<script src","<script type=","SELECT * FROM","SELECT "," SELECT ","DELETE FROM","INSERT INTO","DROP TABLE","DROP DATABASE","TRUNCATE TABLE","SHOW TABLES","SHOW DATABASES","<?php","?>","--","^","<",">","==",";","::"];

        $cadena=trim($cadena);
        $cadena=stripslashes($cadena);

        foreach($palabras as $palabra){
            $cadena=str_ireplace($palabra, "", $cadena);
        }

        $cadena=trim($cadena);
        $cadena=stripslashes($cadena);

        return $cadena;
    }



}

?>