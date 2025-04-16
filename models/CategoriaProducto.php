<?php 

namespace Model;

class CategoriaProducto extends ActiveRecord {
    protected static $tabla = 'categoriasproductos';
    protected static $columnasDB = ['id', 'nombre', 'url'];

    public $id;
    public $nombre;
    public $url;
}