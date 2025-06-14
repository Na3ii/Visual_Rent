<?php

namespace Controllers;
use MVC\Router;
use Model\Producto;
use Model\ImagenesProducto;
use Model\CategoriaProducto;
use Controllers\imagenesProductoController;

class ProductosController {

    public static function index(Router $router) {

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/productos?page=1');
        }

        $categorias = CategoriaProducto :: all('ASC');

        if(!is_admin()) {
            header('Location: /login');
        }

        $router->render('admin/productos/index', [
            'titulo' => 'Productos',
            'categorias' => $categorias,
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
                $_POST['precio_tactil'] = '0';
            }

            $producto -> sincronizar($_POST);
            $alertas = $producto -> validar();
            //guardar registro
            if(empty($alertas)) {
                $resultado = $producto -> guardar();

                if($resultado) {
                    $imagenes = $_FILES['imagenes'] ?? [];
                    $descripciones = $_POST['descripciones'] ?? [];
                    $orden = $_POST['ordenes'] ?? [];
                    $is_main_flags = $_POST['is_main'] ?? [];
                    imagenesProductoController::crearImagenes
                    ($producto->id, $imagenes, $descripciones, $orden, $is_main_flags);

                    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                        header('Content-Type: application/json');
                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Producto creado correctamente',
                            'id_producto' => $producto->id
                        ]);
                        exit;
                    }                   
                    //header('Location: /admin/productos');
                    //exit;
                }
            }

            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'error',
                    'errores' => $alertas
                ]);
                exit;
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
            exit;
        }

        $alertas = [];
        $categorias = CategoriaProducto::all('ASC');
        //validar el ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id) {
            header('Location: /admin/productos');
            exit;
        }
        //obteber producto a editar
        $producto = Producto :: find($id);
        $imagenes_actuales = ImagenesProducto::belongsTo('producto_id', $id);

        if (!$producto) {
            header('Location: /admin/productos');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $producto -> sincronizar($_POST);
            $alertas = $producto -> validar();
    
            if(empty($alertas)) {                
                $resultado = $producto -> guardar();
        
                if ($resultado) {
                    $producto_id = $producto->id;
                    imagenesProductoController::actualizarImagenes($producto_id);
                    // CREAR imágenes nuevas
                    $imagenes     = $_FILES['imagenes']     ?? [];
                    $descripciones= $_POST['descripciones'] ?? [];
                    $ordenes      = $_POST['ordenes']       ?? [];
                    $is_main      = $_POST['is_main']       ?? [];

                    // Reutiliza tu método existente
                    imagenesProductoController::crearImagenes(
                        $producto->id,
                        $imagenes,
                        $descripciones,
                        $ordenes,
                        $is_main
                    );
                    // 5) Respuesta AJAX
                    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                        header('Content-Type: application/json');
                        echo json_encode([
                            'status'       => 'success',
                            'message'      => 'Producto editado correctamente',
                            'id_producto'  => $producto->id
                        ]);
                        exit;
                    }
                    // Si no es AJAX, rediriges
                    header('Location: /admin/productos');
                    exit;
                }
            
            }   
        }
        
        $router->render('admin/productos/editar', [
            'titulo' => 'Editar Producto',
            'categorias' => $categorias,
            'alertas' => $alertas,
            'producto' => $producto,
            'imagenes_actuales' => $imagenes_actuales,
        ]);
    }
    
    public static function eliminar() {        

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/productos');
            exit;
        }
        if (!is_admin()) {
            header('Location: /login');
            exit;
        }
        // 1) Validar y sanear el ID
        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /admin/productos');
            exit;
        }
        // 2) Buscar el producto y sus imágenes
        $producto = Producto::find($id);
        if (!$producto) {
            header('Location: /admin/productos');
            exit;
        }

        $borrarImagenes = imagenesProductoController::eliminarImagenes($id);
        if ($borrarImagenes && $producto->eliminar()){
            header('Location: /admin/productos');
        }
        
    }
}