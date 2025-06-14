<?php

namespace Controllers;

use Model\Producto;
use Model\ImagenesProducto;
use Intervention\Image\ImageManagerStatic as Image;

class imagenesProductoController {

    public static function listar($producto_id) {

        if(!$producto_id) {
            echo json_encode([]);
            return;
        }

        $imagenes = ImagenesProducto::belongsTo('producto_id', $producto_id);
        echo json_encode($imagenes);
    }

    public static function eliminarImagenes(int $id): bool {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imagenes = ImagenesProducto::belongsTo('producto_id', $id);

            if($imagenes) {
                foreach ($imagenes as $imagen) {
                    $carpeta_imagenes = '../public/img/productos/';
                    $carpeta_thumbs = '../public/img/productos/thumbs/';

                    $nombre_imagen = $imagen->url;

                    $rutas = [
                        $carpeta_imagenes . $nombre_imagen . '.png',
                        $carpeta_imagenes . $nombre_imagen . '.webp',
                        $carpeta_thumbs . $nombre_imagen . '.png',
                        $carpeta_thumbs . $nombre_imagen . '.webp'
                    ];

                    foreach ($rutas as $ruta) {
                        if (file_exists($ruta)) {
                            unlink($ruta);
                        }
                    }
                    $imagen->eliminar();
                }
                return true;
            }

        }
    }

    public static function crearImagenes(
        $producto_id, $imagenes, $descripciones = [], $orden = [], $is_main_flags = []) {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!$producto_id || empty($imagenes['tmp_name'])) {
                echo json_encode(['resultado' => false]);
                return;
            }

            //leer imagen
            if(!empty($imagenes['tmp_name'][0])) {
                
                $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'webp'];
                $max_tamano = 5 * 1024 * 1024; // 5MB
                $carpeta_imagenes = realpath(__DIR__ . '../img/productos');
                //crear carpeta de imagenes si no existe
                if (!is_dir($carpeta_imagenes)) {
                    // Si no existe, entonces usamos mkdir con ruta absoluta calculada
                    $carpeta_base = realpath(__DIR__ . '/../img') ?: __DIR__ . '/../img';
                    $carpeta_imagenes = $carpeta_base . '/productos';
                    if (!is_dir($carpeta_imagenes)) {
                        if (!mkdir($carpeta_imagenes, 0777, true)) {
                            error_log("❌ No se pudo crear la carpeta productos: $carpeta_imagenes");
                            echo json_encode(['resultado' => false, 'error' => 'Error creando carpeta productos']);
                            return;
                        }
                    }
                }

                $carpeta_thumbs = $carpeta_imagenes . '/thumbs';
                if (!is_dir($carpeta_thumbs)) {
                    if (!mkdir($carpeta_thumbs, 0777, true)) {
                        error_log("❌ No se pudo crear la carpeta thumbs: $carpeta_thumbs");
                        echo json_encode(['resultado' => false, 'error' => 'Error creando carpeta thumbs']);
                        return;
                    }
                }

                $imagenes_guardadas = [];
                // Asegurar que todos los arrays tienen la misma cantidad de elementos
                $conteo_imagenes = is_array($imagenes['tmp_name']) ? count($imagenes['tmp_name']) : 1;
                $descripciones = is_array($descripciones) ? $descripciones : [$descripciones];
                $orden = is_array($orden) ? $orden : [$orden];
                $is_main_flags = is_array($is_main_flags) ? $is_main_flags : [$is_main_flags];

                if (
                    count($descripciones) !== $conteo_imagenes ||
                    count($orden) !== $conteo_imagenes ||
                    count($is_main_flags) !== $conteo_imagenes
                ) {
                    echo json_encode(['status' => 'error', 'mensaje' => 'Desalineacion de datos en imagenes']);
                    return;
                }
                for ($i = 0; $i < $conteo_imagenes; $i++) {
                    $tmp = is_array($imagenes['tmp_name']) ? $imagenes['tmp_name'][$i] : $imagenes['tmp_name'];
                    $nombre_original = is_array($imagenes['name']) ? $imagenes['name'][$i] : $imagenes['name'];
                    $error = is_array($imagenes['error']) ? $imagenes['error'][$i] : $imagenes['error'];
                    $size = is_array($imagenes['size']) ? $imagenes['size'][$i] : $imagenes['size'];

                    if ($error !== UPLOAD_ERR_OK) {
                        echo json_encode(['status' => 'error', 'mensaje' => "Error al subir la imagen: $nombre_original"]);
                        return;
                    }

                    if ($size > $max_tamano) {
                        echo json_encode(['status' => 'error', 'mensaje' => "La imagen $nombre_original supera los 5MB"]);
                        return;
                    }

                    $extension = strtolower(pathinfo($nombre_original, PATHINFO_EXTENSION));
                    if (!in_array($extension, $extensiones_permitidas)) {
                        echo json_encode(['status' => 'error', 'mensaje' => "Extensión no permitida: $nombre_original"]);
                        return;
                    }

                    $nombre_imagen = md5(uniqid(rand(), true));
                    $ruta_base = $carpeta_imagenes . '/' . $nombre_imagen;
                    $ruta_thumb = $carpeta_thumbs . '/' . $nombre_imagen;

                    try {
                        $img = Image::make($tmp)->resize(800, null, function ($c) { $c->aspectRatio(); });
                        $thumb = Image::make($tmp)->resize(100, null, function ($c) { $c->aspectRatio(); });

                        $img->save("$ruta_base.png", 80);
                        $img->encode('webp', 80)->save("$ruta_base.webp");

                        $thumb->save("$ruta_thumb.png", 80);
                        $thumb->encode('webp', 80)->save("$ruta_thumb.webp");

                        // Guardar en BD
                        $imagen_producto = new ImagenesProducto();
                        $imagen_producto->url = $nombre_imagen;
                        $imagen_producto->producto_id = $producto_id;
                        $imagen_producto->orden = (int)$orden[$i];
                        $imagen_producto->descripcion = $descripciones[$i] ?? '';
                        $imagen_producto->is_main = (int)$is_main_flags[$i] ?? 0;
                        $imagen_producto->guardar();

                    } catch (Exception $e) {
                        echo json_encode(['status' => 'error', 'mensaje' => 'Error al procesar la imagen: ' . $e->getMessage()]);
                        return;
                    }
                }
                echo json_encode(['status' => 'success', 'mensaje' => 'Imágenes guardadas correctamente']);
                exit;
            }
        }
    }

    public static function actualizarImagenes($producto_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // ELIMINAR imágenes marcadas
            $aEliminar = $_POST['eliminadas'] ?? [];
            if (is_array($aEliminar) && count($aEliminar) > 0) {
                
                foreach ($aEliminar as $idImg) {

                    $imagen = ImagenesProducto::find($idImg);
                    if ($imagen) {

                        $url = $imagen->url;
                        if ($url) {
                            // 2. Borrar ficheros
                            $paths = [
                                __DIR__ . "/../img/productos/{$url}.png",
                                __DIR__ . "/../img/productos/{$url}.webp",
                                __DIR__ . "/../img/productos/thumbs/{$url}.png",
                                __DIR__ . "/../img/productos/thumbs/{$url}.webp",
                            ];
                            foreach ($paths as $p) {
                                if (file_exists($p)) unlink($p);
                            }
                        }

                        $imagen->eliminar();
                    }                    
                }
            }
            //ACTUALIZAR imágenes existentes
            $filas = $_POST['actuales'] ?? [];
            foreach ($filas as $fila) {
                // fila = ['id'=>.., 'descripcion'=>.., 'orden'=>.., 'eliminada'=>.., 'is_main'=>..]
                if (isset($fila['id']) && $fila['eliminada'] !== '1') {
                    $imagen = ImagenesProducto::find((int)$fila['id']);
                    if ($imagen && $imagen->producto_id == $producto_id) {
                        $imagen->descripcion = $fila['descripcion'] ?? $imagen->descripcion;
                        $imagen->orden       = (int)($fila['orden'] ?? $imagen->orden);
                        $imagen->is_main     = (int)($fila['is_main'] ?? $imagen->is_main);
                        $imagen->guardar();
                    }
                }
            }
        }
    }
}