<?php

namespace Controllers;

use MVC\Router;
use Model\CategoriaServicio;
use Intervention\Image\ImageManagerStatic as Image;
use Classes\Paginacion;
use Model\Servicio;

class CategoriaServicioController {

    
    public static function crear(Router $router) {
        
        if(!is_admin()) {
            header('Location: /login');
        }

        $alertas = [];
        $categoria = new CategoriaServicio;   

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!is_admin()) {
                header('Location: /login');
            }
            //leer imagen
            if(!empty($_FILES['imagen']['tmp_name'])) {

                $carpeta_imagenes = '../public/img/categoria-servicios';
                //crear carpeta de imagenes si no existe
                if(!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0777, true);
                }
                
                $imagen_png = Image :: make($_FILES['imagen']['tmp_name']) -> resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('png', 80);
                $imagen_webp = Image :: make($_FILES['imagen']['tmp_name']) -> resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('webp', 80);

                $nombre_imagen = md5(uniqid(rand(), true));

                $_POST['imagen'] = $nombre_imagen;                
            }

            $categoria -> sincronizar($_POST);
            //validar
            $alertas = $categoria -> validar();

            //guardar registro
            if(empty($alertas)) {               
                //guardar imagenes
                $imagen_png -> save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                $imagen_webp -> save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");

                $categoria -> url = md5(uniqid());

                $resultado = $categoria -> guardar();


                if($resultado) {
                    header('Location: /admin/servicios');
                }
            }
        }

        $router->render('admin/categoria-servicios/crear', [
            'titulo' => 'Registrar Categoria',
            'categoria' => $categoria,
            'alertas' => $alertas,
        ]);
    }
    
    public static function verCategoria (Router $router) {
        
        if(!is_admin()) {
            header('Location: /login');
        }

        $alertas = [];

        $token = $_GET['url'];
        if(!$token) {
            header('Location: /admin/servicios');
        }

        $categoria = CategoriaServicio :: where('url', $token);
        if(!$categoria) {
            header('Location: /admin/servicios');
        }
        $id = $categoria->id;
        //$servicios = Servicio :: belongsTo('categoria_id', $id);
        //debuguear($servicios);
        
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/categoria-servicios?url=' . $categoria->url . '&page=1');
        }

        $servicios_por_pagina = 10;
        $total_servicios = Servicio :: total('categoria_id', $id);

        $total_paginas = max(1, ceil($total_servicios / $servicios_por_pagina));
    
        if($pagina_actual > $total_paginas) {
            header('Location: /admin/servicios?page=' . $total_paginas);
            exit;
        }

        $paginacion = new Paginacion($pagina_actual, $servicios_por_pagina, $total_servicios);

        $servicios = Servicio :: paginarPorCategoria('categoria_id', $id, $servicios_por_pagina, $paginacion -> offset());
        //debuguear($servicios);

        $router -> render ('admin/categoria-servicios/index', [
            'titulo' => $categoria->nombre,
            'categoria' => $categoria,
            'servicios' => $servicios,
            'paginacion' => $paginacion -> paginacion(),
            'alertas' => $alertas
        ]);
    }
    
    public static function editar(Router $router) {
        
        if(!is_admin()) {
            header('Location: /login');
        }

        $alertas = [];
        //validar el ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id) {
            header('Location: /admin/servicios');
        }

        //obteber isntructor a editar
        $categoria = CategoriaServicio :: find($id);

        if (!$categoria) {
            header('Location: /admin/servicios');
        }

        $categoria -> imagen_actual = $categoria -> imagen;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if(!is_admin()) {
                header('Location: /login');
            }
            //leer imagen
            if(!empty($_FILES['imagen']['tmp_name'])) {

                $carpeta_imagenes = '../public/img/categoria-servicios';
                //crear carpeta de imagenes si no existe
                if(!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0777, true);
                }
                
                $imagen_png = Image :: make($_FILES['imagen']['tmp_name']) -> resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('png', 80);
                $imagen_webp = Image :: make($_FILES['imagen']['tmp_name']) -> resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('png', 80);

                $nombre_imagen = md5(uniqid(rand(), true));
    
    
                //guardar imagenes
                $imagen_png -> save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                $imagen_webp -> save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
    
                $_POST['imagen'] = $nombre_imagen;                
            } else {
                $_POST['imagen'] = $categoria -> imagen_actual;
            }
    
            $categoria -> sincronizar($_POST);
            //validar
            $alertas = $categoria -> validar();
    
            if(empty($alertas)) {
                if(isset($nombre_imagen)) {
                    //guardar imagenes
                    $imagen_png -> save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                    $imagen_webp -> save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
                    
                }
                
                $resultado = $categoria -> guardar();
    
                if($resultado) {
                    header('Location: /admin/servicios');
                }
            }   
        }

        $router->render('admin/categoria-servicios/editar', [
            'titulo' => 'Editar categoria',
            'categoria' => $categoria,
            'alertas' => $alertas,
        ]);
    }

    
    public static function eliminar() {        

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!is_admin()) {
                header('Location: /login');
            }

            $id = $_POST['id'];
            $categoria = CategoriaServicio :: find($id);

            $id = filter_var($id, FILTER_VALIDATE_INT);

            if(isset($categoria)) {
                header('Location: /admin/servicios');
            }

            $resultado = $categoria -> eliminar();
            
            if($resultado) {
                header('Location: /admin/servicios');
            }
        }
    }
}