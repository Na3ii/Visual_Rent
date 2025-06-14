<?php 

namespace Model;

class CategoriaProducto extends ActiveRecord {
    protected static $tabla = 'categoriasproductos';
    protected static $columnasDB = ['id', 'nombre', 'og_title', 'og_description', 'meta_description', 'descripcion', 'imagen', 'url'];

    public $id;
    public $nombre;
    public $og_title;
    public $og_description;
    public $meta_description;
    public $descripcion;
    public $imagen;
    public $url;

    public $imagen_actual;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->og_title = $args['og_title'] ?? '';
        $this->og_description = $args['og_description'] ?? '';
        $this->meta_description = $args['meta_description'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this -> url = $args['url'] ?? '';
    }

    // Mensajes de validación para la creación de un evento
    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->og_title) {
            self::$alertas['error'][] = 'El Título es Obligatorio';
        }
        if(!$this->og_description) {
            self::$alertas['error'][] = 'La Descripción para las Redes Sociales es Obligatoria';
        }
        if(!$this->meta_description) {
            self::$alertas['error'][] = 'La Descripción para los Motores de Búsqueda es Obligatoria';
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