<?php

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function comprobarRutas()
    {

        // Detectar la URL correctamente aunque el hosting no defina PATH_INFO
        $url_actual = explode('?', $_SERVER['REQUEST_URI'])[0];
        $script_name = dirname($_SERVER['SCRIPT_NAME']);
        if (strpos($url_actual, $script_name) === 0) {
            $url_actual = substr($url_actual, strlen($script_name));
        }
        $url_actual = $url_actual ?: '/';
         if ($url_actual[0] !== '/') {
            $url_actual = '/' . $url_actual;
        }

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$url_actual] ?? null;
        } else {
            $fn = $this->postRoutes[$url_actual] ?? null;
        }


        if ( $fn ) {
            call_user_func($fn, $this);
        } else {
            echo "Página No Encontrada o Ruta no válida";
        }
    }

    public function render($view, $datos = [])
    {
        $datos['vista'] = $view;

        foreach ($datos as $key => $value) {
            $$key = $value; 
        }

        ob_start(); 

        include_once __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean(); // Limpia el Buffer

        //Utilizar el Layout de acuerdo a la url
        
        $url_actual = $_SERVER['REQUEST_URI'] ?? '/';

        if(str_contains($url_actual, '/admin')) {
            include_once __DIR__ . '/views/admin-layout.php';
        } else {
            include_once __DIR__ . '/views/layout.php';
        }
    }
}
