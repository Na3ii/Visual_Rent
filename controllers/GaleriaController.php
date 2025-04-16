<?php

namespace Controllers;

use Classes\Paginacion;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;
use Model\Galeria;

class GaleriaController {

    public static function index(Router $router) {
        
        if(!is_admin()) {
            header('Location: /login');
        }

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/galeria?page=1');
            exit;
        }

        $registros_por_pagina = 10;
        $total_registros = Galeria :: total();
        //Evita que haya 0 páginas disponibles
        $total_paginas = max(1, ceil($total_registros / $registros_por_pagina));
    
        if($pagina_actual > $total_paginas) {
            header('Location: /admin/galeria?page=' . $total_paginas);
            exit;
        }

        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);

        $imagenes = Galeria :: paginar($registros_por_pagina, $paginacion -> offset());

        $router->render('admin/galeria/index', [
            'titulo' => 'Galeria',
            'imagenes' => $imagenes,
            'paginacion' => $paginacion -> paginacion(),
        ]);
    }

    public static function crear(Router $router) {
    
        if(!is_admin()) {
            header('Location: /login');
        }
    
        $alertas = [];
        $imagen = new Galeria;   
    
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            if(!is_admin()) {
                header('Location: /login');
            }
            //leer imagen
            if(!empty($_FILES['imagen']['tmp_name'])) {
    
                $carpeta_imagenes = '../public/img/galeria';
                //crear carpeta de imagenes si no existe
                if(!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0777, true);
                }
                
                $imagen_png = Image :: make($_FILES['imagen']['tmp_name']) -> resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('png', 80);
                $imagen_webp = Image :: make($_FILES['imagen']['tmp_name']) -> resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('png', 80);
    
                $nombre_imagen = md5(uniqid(rand(), true));
    
                $_POST['imagen'] = $nombre_imagen;                
            }
    
            $imagen -> sincronizar($_POST);
            //validar
            $alertas = $imagen -> validar();
    
            //guardar registro
            if(empty($alertas)) {               
                //guardar imagenes
                $imagen_png -> save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                $imagen_webp -> save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
    
                $resultado = $imagen -> guardar();
    
                if($resultado) {
                    header('Location: /admin/galeria');
                }
            }
        }
    
        $router->render('admin/galeria/crear', [
            'titulo' => 'Agregar Imagen',
            'alertas' => $alertas,
            'imagen' => $imagen,
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
            header('Location: /admin/galeria');
        }
    
        //obteber isntructor a editar
        $imagen = Galeria :: find($id);
    
        if (!$imagen) {
            header('Location: /admin/galeria');
        }
    
        $imagen -> imagen_actual = $imagen -> imagen;
    
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
         
            
            if(!is_admin()) {
                header('Location: /login');
            }
            //leer imagen
            if(!empty($_FILES['imagen']['tmp_name'])) {
    
                $carpeta_imagenes = '../public/img/galeria';
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
                $_POST['imagen'] = $imagen -> imagen_actual;
            }
    
            $imagen -> sincronizar($_POST);
            //validar
            $alertas = $imagen -> validar();
    
            if(empty($alertas)) {
                if(isset($nombre_imagen)) {
                    //guardar imagenes
                    $imagen_png -> save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                    $imagen_webp -> save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
                }
                
                $resultado = $imagen -> guardar();
    
                if($resultado) {
                    header('Location: /admin/galeria');
                }
            }   
        }
    
        $router->render('admin/galeria/editar', [
            'titulo' => 'Editar Imagen',
            'alertas' => $alertas,
            'imagen' => $imagen,
        ]);
    }
    
    
    public static function eliminar() {        
    
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            if(!is_admin()) {
                header('Location: /login');
            }
    
            $id = $_POST['id'];
            $imagen = Galeria :: find($id);
    
            $id = filter_var($id, FILTER_VALIDATE_INT);
    
            if(isset($imagen)) {
                header('Location: /admin/galeria');
            }
    
            $resultado = $imagen -> eliminar();
            
            if($resultado) {
                header('Location: /admin/galeria');
            }
        }
    }
}
