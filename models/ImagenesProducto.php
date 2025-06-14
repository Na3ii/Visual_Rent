<?php

namespace Model;


class ImagenesProducto extends ActiveRecord {

    protected static $tabla = 'imagenesproducto';
    protected static $columnasDB = ['id', 'url', 'producto_id', 'descripcion', 'orden', 'is_main'];

    public $id;
    public $url;
    public $producto_id;
    public $descripcion;
    public $orden;
    public $is_main;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->url = $args['url'] ?? '';
        $this->producto_id = $args['producto_id'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->orden = $args['orden'] ?? '';
        $this->is_main = $args['is_main'] ?? 0;
    }

    public function validar(){
        if(!$this->descripcion){
            self::$alertas['error'][] = 'La descripción es Obligatoria';
        }
    }
}