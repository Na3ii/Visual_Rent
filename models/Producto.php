<?php 

namespace Model;

class Producto extends ActiveRecord {
    protected static $tabla = 'productos';
    protected static $columnasDB = ['id', 'nombre', 'descripcion', 'caracteristicas', 'categoria_id', 'disponibles', 'tactil', 'precio_informativo', 'precio_tactil', 'imagen'];

    public $id;
    public $nombre;
    public $descripcion;
    public $caracteristicas;
    public $categoria_id;
    public $disponibles;
    public $tactil;
    public $precio_informativo;
    public $precio_tactil;
    public $imagen;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->caracteristicas = $args['caracteristicas'] ?? '';
        $this->categoria_id = $args['categoria_id'] ?? '';
        $this->disponibles = $args['disponibles'] ?? '';
        $this->tactil = $args['tactil'] ?? '';
        $this->precio_informativo = $args['precio_informativo'] ?? '';
        $this->precio_tactil = $args['precio_tactil'] ?? 0;
        $this->imagen = $args['imagen'] ?? '';
    }

    // Mensajes de validación para la creación de un evento
    public function validar() {
    if(!$this->nombre) {
        self::$alertas['error'][] = 'El Nombre es Obligatorio';
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
    if(!$this->imagen) {
        self::$alertas['error'][] = 'La imagen es Obligatoria';
    }

    return self::$alertas;
}
}