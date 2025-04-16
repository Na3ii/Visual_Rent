<?php 

namespace Model;

class CategoriaServicio extends ActiveRecord {
    protected static $tabla = 'categoriasservicios';
    protected static $columnasDB = ['id', 'nombre', 'descripcion', 'imagen', 'url'];

    public $id;
    public $nombre;
    public $descripcion;
    public $imagen;
    public $url;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this -> url = $args['url'] ?? '';
    }

    // Mensajes de validación para la creación de un evento
    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->descripcion) {
            self::$alertas['error'][] = 'La descripción es Obligatoria';
        }
        if(!$this->imagen) {
            self::$alertas['error'][] = 'La imagen es Obligatoria';
        }

        return self::$alertas;
    }
}