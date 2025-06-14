<?php 

namespace Model;

class Producto extends ActiveRecord {
    protected static $tabla = 'productos';
    protected static $columnasDB = ['id', 'nombre', 'og_title', 'og_description', 'meta_description', 'descripcion', 'caracteristicas', 'categoria_id', 'disponibles', 'tactil', 'precio_informativo', 'precio_tactil'];

    public $id;
    public $nombre;
    public $og_title;
    public $og_description;
    public $meta_description;
    public $descripcion;
    public $caracteristicas;
    public $categoria_id;
    public $disponibles;
    public $tactil;
    public $precio_informativo;
    public $precio_tactil;

    public $imagen_url; 
    public $imagen_principal_url;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->og_title = $args['og_title'] ?? '';
        $this->og_description = $args['og_description'] ?? '';
        $this->meta_description = $args['meta_description'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->caracteristicas = $args['caracteristicas'] ?? '';
        $this->categoria_id = $args['categoria_id'] ?? '';
        $this->disponibles = $args['disponibles'] ?? '';
        $this->tactil = $args['tactil'] ?? '';
        $this->precio_informativo = $args['precio_informativo'] ?? '';
        $this->precio_tactil = $args['precio_tactil'] ?? 0;
    }

    // Mensajes de validación para la creación de un evento
    public function validar() {
    if(!$this->nombre) {
        self::$alertas['error'][] = 'El Nombre es Obligatorio';
    }
    if(!$this->og_title) {
        self::$alertas['error'][] = 'El Og Title es Obligatorio';
    }
    if(!$this->og_description) {
        self::$alertas['error'][] = 'El Og Description es Obligatorio';
    }
    if(!$this->meta_description) {
        self::$alertas['error'][] = 'El Meta Description es Obligatorio';
    }
    if(!$this->descripcion) {
        self::$alertas['error'][] = 'La descripción es Obligatoria';
    }
    if(!$this->caracteristicas) {
        self::$alertas['error'][] = 'Debes añadir las caracteristicas del producto';
    }
    if(!$this->categoria_id  || !filter_var($this->categoria_id, FILTER_VALIDATE_INT)) {
        self::$alertas['error'][] = 'Elige una Categoría';
    }
    if(!$this->disponibles  || !filter_var($this->disponibles, FILTER_VALIDATE_INT)) {
        self::$alertas['error'][] = 'Añade una cantidad de Lugares Disponibles';
    }
    if(!$this->tactil) {
        self::$alertas['error'][] = 'elige una opcion valida';
    }
    if(!$this->precio_informativo  || !filter_var($this->precio_informativo, FILTER_VALIDATE_INT)) {
        self::$alertas['error'][] = 'Añade una precio';
    }

    return self::$alertas;
}
}