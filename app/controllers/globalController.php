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
            $ref_id = $parametros[$ref];    
        }

        return $ref_id;
    }

}

?>