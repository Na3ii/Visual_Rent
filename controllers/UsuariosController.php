<?php

namespace Controllers;

use Classes\Paginacion;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;

class UsuariosController {

    public static function index(Router $router) {



        $router->render('admin/usuarios/index', [
            'titulo' => 'Usuarios',
        ]);
    }
}