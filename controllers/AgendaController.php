<?php

namespace Controllers;

use Classes\Paginacion;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;

class AgendaController {

    public static function index(Router $router) {



        $router->render('admin/agenda/index', [
            'titulo' => 'Agenda',
        ]);
    }
}