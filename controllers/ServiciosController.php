<?php

namespace Controllers;

use Classes\Paginacion;
use MVC\Router;
use Model\Servicio;
use Model\CategoriaServicio;
use Intervention\Image\ImageManagerStatic as Image;

class ServiciosController {

    public static function index(Router $router) {

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/servicios?page=1');
        }

        $categorias = CategoriaServicio :: all('ASC');

        if(!is_admin()) {
            header('Location: /login');
        }

        $router->render('admin/servicios/index', [
            'titulo' => 'Categorias servicios',
            'categorias' => $categorias,
            
        ]);
    }
    
    public static function crear(Router $router) {
        
        if(!is_admin()) {
            header('Location: /login');
        }

        $alertas = [];
        $categorias = CategoriaServicio::all('ASC');
        $servicio = new Servicio;   

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!is_admin()) {
                header('Location: /login');
            }
            //leer imagen
            if(!empty($_FILES['imagen']['tmp_name'])) {

                $carpeta_imagenes = '../public/img/servicios';
                //crear carpeta de imagenes si no existe
                if(!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0777, true);
                }
                
                $imagen_png = Image :: make($_FILES['imagen']['tmp_name']) -> fit(800, 800) -> encode ('png', 80);
                $imagen_webp = Image :: make($_FILES['imagen']['tmp_name']) -> fit(800, 800) -> encode ('webp', 80);

                $nombre_imagen = md5(uniqid(rand(), true));

                $_POST['imagen'] = $nombre_imagen;                
            }

            $servicio -> sincronizar($_POST);
            //validar
            $alertas = $servicio -> validar();

            //guardar registro
            if(empty($alertas)) {               
                //guardar imagenes
                $imagen_png -> save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                $imagen_webp -> save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");

                $resultado = $servicio -> guardar();


                if($resultado) {
                    header('Location: /admin/servicios');
                }
            }
        }

        $router->render('admin/servicios/crear', [
            'titulo' => 'Registrar servicio',
            'categorias' => $categorias,
            'alertas' => $alertas,
            'servicio' => $servicio,
        ]);
    }
    
    
    public static function editar(Router $router) {
        
        if(!is_admin()) {
            header('Location: /login');
        }

        $alertas = [];
        $categorias = CategoriaServicio::all('ASC');
        //validar el ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id) {
            header('Location: /admin/servicios');
        }

        //obteber isntructor a editar
        $servicio = Servicio :: find($id);

        if (!$servicio) {
            header('Location: /admin/servicios');
        }

        $servicio -> imagen_actual = $servicio -> imagen;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if(!is_admin()) {
                header('Location: /login');
            }
            //leer imagen
            if(!empty($_FILES['imagen']['tmp_name'])) {

                $carpeta_imagenes = '../public/img/servicios';
                //crear carpeta de imagenes si no existe
                if(!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0777, true);
                }
                
                $imagen_png = Image :: make($_FILES['imagen']['tmp_name']) -> fit(800, 800) -> encode ('png', 80);
                $imagen_webp = Image :: make($_FILES['imagen']['tmp_name']) -> fit(800, 800) -> encode ('webp', 80);
    
                $nombre_imagen = md5(uniqid(rand(), true));
    
    
                //guardar imagenes
                $imagen_png -> save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                $imagen_webp -> save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
    
                $_POST['imagen'] = $nombre_imagen;                
            } else {
                $_POST['imagen'] = $servicio -> imagen_actual;
            }
    
            $servicio -> sincronizar($_POST);
            //validar
            $alertas = $servicio -> validar();
    
            if(empty($alertas)) {
                if(isset($nombre_imagen)) {
                    //guardar imagenes
                    $imagen_png -> save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                    $imagen_webp -> save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
                }
                
                $resultado = $servicio -> guardar();
    
                if($resultado) {
                    header('Location: /admin/servicios');
                }
            }   
        }

        $router->render('admin/servicios/editar', [
            'titulo' => 'Editar servicio',
            'categorias' => $categorias,
            'alertas' => $alertas,
            'servicio' => $servicio,
        ]);
    }

    
    public static function eliminar() {        

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!is_admin()) {
                header('Location: /login');
            }

            $id = $_POST['id'];
            $servicio = Servicio :: find($id);

            $id = filter_var($id, FILTER_VALIDATE_INT);

            if(isset($servicio)) {
                header('Location: /admin/servicios');
            }

            $resultado = $servicio -> eliminar();
            
            if($resultado) {
                header('Location: /admin/servicios');
            }
        }
    }
}