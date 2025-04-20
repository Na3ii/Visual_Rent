<?php


namespace Model;

class Galeria extends ActiveRecord {
    protected static $tabla = 'galeria';
    protected static $columnasDB = ['id', 'imagen', 'descripcion'];

    public $id;
    public $imagen;
    public $descripcion;

    public $imagen_actual;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descrripcion'] ?? '';
    }

    public function validar() {
        if(!$this->imagen) {
            self::$alertas['error'][] = 'la imagen es Obligatorio';
        }
        if(!$this->descripcion) {
            self::$alertas['error'][] = 'la descripcion es Obligatoria';
        }

        return self::$alertas;
    }
}