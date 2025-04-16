<?php

namespace Controllers;

use Classes\Paginacion;
use MVC\Router;
use Model\Producto;
use Model\CategoriaProducto;
use Intervention\Image\ImageManagerStatic as Image;

class ProductosController {

    public static function index(Router $router) {

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/productos?page=1');
        }

        $registros_por_pagina = 10;
        $total_registros = Producto :: total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);
        
        if($paginacion -> pagina_actual > $paginacion -> totalPaginas()) {
            header('Location: /admin/productos?page=' . $paginacion -> totalPaginas());
        }

        $productos = Producto :: paginar($registros_por_pagina, $paginacion -> offset());

        if(!is_admin()) {
            header('Location: /login');
        }

        $router->render('admin/productos/index', [
            'titulo' => 'Productos',
            'productos' => $productos,
            'paginacion' => $paginacion -> paginacion(),
        ]);
    }
    
    public static function crear(Router $router) {
        
        if(!is_admin()) {
            header('Location: /login');
        }

        $alertas = [];
        $categorias = CategoriaProducto::all('ASC');
        $producto = new Producto;   

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            
            // Leer el valor de "tactil" y asegurarse de que sea 0 o 1
            $_POST['tactil'] = isset($_POST['tactil']) && ($_POST['tactil'] === "1" || $_POST['tactil'] === "2") ? (int)$_POST['tactil'] : 0;

            if(!isset($_POST['precio_tactil'])) {
                $_POST['precio_tactil'] === '0';
            }

            if(!is_admin()) {
                header('Location: /login');
            }
            //leer imagen
            if(!empty($_FILES['imagen']['tmp_name'])) {

                $carpeta_imagenes = '../public/img/productos';
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

                $_POST['imagen'] = $nombre_imagen;                
            }

            $producto -> sincronizar($_POST);
            //validar
            $alertas = $producto -> validar();

            //guardar registro
            if(empty($alertas)) {               
                //guardar imagenes
                $imagen_png -> save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                $imagen_webp -> save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");

                $resultado = $producto -> guardar();


                if($resultado) {
                    header('Location: /admin/productos');
                }
            }
        }

        $router->render('admin/productos/crear', [
            'titulo' => 'Registrar Producto',
            'categorias' => $categorias,
            'alertas' => $alertas,
            'producto' => $producto,
        ]);
    }
    
    
    public static function editar(Router $router) {
        
        if(!is_admin()) {
            header('Location: /login');
        }

        $alertas = [];
        $categorias = CategoriaProducto::all('ASC');
        //validar el ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id) {
            header('Location: /admin/productos');
        }

        //obteber isntructor a editar
        $producto = Producto :: find($id);

        if (!$producto) {
            header('Location: /admin/productos');
        }

        $producto -> imagen_actual = $producto -> imagen;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

         
            
            if(!is_admin()) {
                header('Location: /login');
            }
            //leer imagen
            if(!empty($_FILES['imagen']['tmp_name'])) {

                $carpeta_imagenes = '../public/img/productos';
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
                $_POST['imagen'] = $producto -> imagen_actual;
            }
    
            $producto -> sincronizar($_POST);
            //validar
            $alertas = $producto -> validar();
    
            if(empty($alertas)) {
                if(isset($nombre_imagen)) {
                    //guardar imagenes
                    $imagen_png -> save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                    $imagen_webp -> save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
                }
                
                $resultado = $producto -> guardar();
    
                if($resultado) {
                    header('Location: /admin/productos');
                }
            }   
        }

        $router->render('admin/productos/editar', [
            'titulo' => 'Editar Producto',
            'categorias' => $categorias,
            'alertas' => $alertas,
            'producto' => $producto,
        ]);
    }

    
    public static function eliminar() {        

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!is_admin()) {
                header('Location: /login');
            }

            $id = $_POST['id'];
            $producto = Producto :: find($id);

            $id = filter_var($id, FILTER_VALIDATE_INT);

            if(isset($producto)) {
                header('Location: /admin/productos');
            }

            $resultado = $producto -> eliminar();
            
            if($resultado) {
                header('Location: /admin/productos');
            }
        }
    }
}