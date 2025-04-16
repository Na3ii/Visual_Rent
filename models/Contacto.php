<?php


namespace Model;

class Contacto extends ActiveRecord {
    protected static $tabla = 'formulariocontacto';
    protected static $columnasDB = ['id', 'nombre', 'empresa', 'email', 'telefono', 'mensaje'];

    public $id;
    public $nombre;
    public $empresa;
    public $email;
    public $telefono;
    public $mensaje;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->empresa = $args['empresa'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->mensaje = $args['mensaje'] ?? '';
    }

    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if (!$this->empresa) {
            self::$alertas['error'][] = 'La empresa es Obligatoria';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es Obligatorio';
        }
        if (!$this->mensaje) {
            self::$alertas['error'][] = 'El mensaje es Obligatorio';
        }

        return self::$alertas;
    }
}