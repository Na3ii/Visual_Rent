<?php

namespace Controllers;

use MVC\Router;
use Model\Producto;
use Model\CategoriaServicio;
use Model\Servicio;
use Classes\Paginacion;
use Model\Contacto;
use Classes\Email;
use Model\Galeria;

class PaginasController {
    public static function index(Router $router) {

        $productos = Producto :: getVarios(4);
        $categorias = CategoriaServicio::getVarios(3);
        $imagenes = Galeria::getVarios(3);
        
        $router->render('paginas/index', [
            'titulo' => 'Inicio',
            'productos' => $productos,
            'categorias' => $categorias,
            'imagenes' => $imagenes,
        ]);
    }
    
    public static function catalogo(Router $router) {

        $productos = Producto :: all('ASC');

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /catalogo?page=1');
        }

        $registros_por_pagina = 8;
        $total_registros = Producto :: total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);
        
        if($paginacion -> pagina_actual > $paginacion -> totalPaginas()) {
            header('Location: /catalogo?page=' . $paginacion -> totalPaginas());
        }

        $productos = Producto :: paginar($registros_por_pagina, $paginacion -> offset());

        
        $router->render('paginas/catalogo', [
            'titulo' => 'Catalogo',
            'productos' => $productos,
            'paginacion' => $paginacion -> paginacion(),
        ]);
    }

    public static function obtenerProducto() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                echo json_encode(['error' => 'ID no válido']);
                return;
            }
    
            $producto = Producto::find($id);
    
            if (!$producto) {
                echo json_encode(['error' => 'Producto no encontrado']);
                return;
            }
    
            echo json_encode($producto);
        }
    }
    
    public static function servicios(Router $router) {
        
        $categorias = CategoriaServicio::all('ASC');

        $router->render('paginas/servicios', [
            'titulo' => 'Nuestros Servicios',
            'categorias' => $categorias
        ]);
    }
    
    public static function verCategoria(Router $router) {
        $id = $_GET['id'] ?? null;
    
        if (!$id) {
            header('Location: /servicios');
            return;
        }
    
        $servicios = Servicio::belongsTo('categoria_id', $id);
        $categoria = CategoriaServicio::find($id);
    
        if (!$categoria) {
            header('Location: /servicios');
            return;
        }
    
        $router->render('paginas/categoria', [
            'titulo' => 'Servicios de ' . $categoria->nombre,
            'servicios' => $servicios,
            'categoria' => $categoria
        ]);
    }

    public static function galeria(Router $router) {

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /galeria?page=1');
            exit;
        }

        $registros_por_pagina = 12;
        $total_registros = Galeria :: total();
        //Evita que haya 0 páginas disponibles
        $total_paginas = max(1, ceil($total_registros / $registros_por_pagina));
    
        if($pagina_actual > $total_paginas) {
            header('Location: /galeria?page=' . $total_paginas);
            exit;
        }

        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);

        $imagenes = Galeria :: paginar($registros_por_pagina, $paginacion -> offset());
        $clases_masonry = ['masonry-sm', 'masonry-md', 'masonry-lg'];

        $router->render('paginas/galeria', [
            'titulo' => 'Galería de Proyectos - Pantallas LED, Tótems y Eventos',
            'imagenes' => $imagenes,
            'paginacion' => $paginacion -> paginacion(),
            'clases_masonry' => $clases_masonry,
        ]);
    }
    
    public static function contacto(Router $router) {
        
        $alertas = [];
        $contacto = new Contacto;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contacto -> sincronizar($_POST);
            $alertas = $contacto->validar();

            if (empty($alertas)) {
                $resultado = $contacto->guardar();
    
                if ($resultado) {
                    //enviar correos
                    $nombre = $contacto->nombre ?? '';
                    $empresa = $contacto->empresa ?? '';
                    $email = $contacto->email ?? '';
                    $telefono = $contacto->telefono ?? '';
                    $mensaje = $contacto->mensaje ?? '';

                    $emailContacto = new Email($email, $nombre, null, $empresa, $telefono, $mensaje);
                    $emailContacto->enviarFormularioContacto();
                    $emailContacto->enviarConfirmacionContactoUsuario();

                    $alertas['exito'][] = 'Tu mensaje fue enviado correctamente';
                    //Contacto::setAlerta('exito', 'Tu mensaje fue enviado correctamente');
                    // Reiniciamos para evitar que los campos queden con datos antiguos
                    $contacto = new Contacto;
                } else {
                    //Contacto::setAlerta('error', 'Hubo un error al guardar el mensaje. Inténtalo de nuevo.');
                    $alertas['error'][] = 'Hubo un error al guardar el mensaje. Inténtalo de nuevo.';
                }
            }
        }

        $router->render('paginas/contacto', [
            'titulo' => 'Contacto',
            'contacto' => $contacto,
            'alertas' => $alertas
        ]);
    }
}