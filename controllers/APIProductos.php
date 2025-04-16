<?php

namespace Controllers;
use Model\Producto;

class APIProductos {

    public static function index() {

        $productos = Producto::all();
        echo json_encode($productos);
    }

}