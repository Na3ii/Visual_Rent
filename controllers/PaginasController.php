<?php

namespace Controllers;

use MVC\Router;
use Model\Producto;
use Model\CategoriaServicio;
use Model\Servicio;
use Classes\Paginacion;
use Model\Contacto;
use Classes\Email;
use Model\Galeria;

class PaginasController {
    public static function index(Router $router) {

        $productos = Producto :: getVarios(4);
        $categorias = CategoriaServicio::getVarios(3);
        $imagenes = Galeria::getVarios(3);

        $jsonLD = [
            "@context" => "https://schema.org",
            "@type" => "LocalBusiness",
            "name" => "Visual Rent",
            "image" => "https://visualrent.cl/img/og-image.jpg",
            "url" => "https://visualrent.cl",
            "telephone" => "+56 9 2051 9944",
            "address" => [
                "@type" => "PostalAddress",
                "streetAddress" => "Avenida Ricardo Lyon 1351, Providencia",
                "addressLocality" => "Santiago",
                "addressCountry" => "CL"
            ],
            "description" => "Arriendo de equipos audiovisuales: tótems digitales, pantallas y pendones LED para eventos.",
            "openingHours" => "Mo-Sa 08:00-20:00",
            "sameAs" => [
                "https://www.instagram.com/visualrentchile",
                "https://www.facebook.com/visualrent",
            ],
        ];
        
        $router->render('paginas/index', [
            'titulo' => 'Inicio',
            'productos' => $productos,
            'categorias' => $categorias,
            'imagenes' => $imagenes,
            'jsonLD' => $jsonLD,
        ]);
    }
    
    public static function catalogo(Router $router) {

        $productos = Producto :: all('ASC');

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /catalogo?page=1');
        }

        $registros_por_pagina = 8;
        $total_registros = Producto :: total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);
        
        if($paginacion -> pagina_actual > $paginacion -> totalPaginas()) {
            header('Location: /catalogo?page=' . $paginacion -> totalPaginas());
        }

        $productos = Producto :: paginar($registros_por_pagina, $paginacion -> offset());

        // Armar array de productos en formato Schema.org
        $productosLD = [];
        foreach ($productos as $producto) {
            $productosLD[] = [
                "@context" => "https://schema.org",
                "@type" => "Product",
                "name" => $producto->nombre,
                "description" => $producto->descripcion,
                "image" => $producto->imagen,
                "offers" => [
                    "@type" => "Offer",
                    "priceCurrency" => "CLP", // o tu moneda
                    "price" => $producto->precio_informativo,
                    "availability" => "https://schema.org/InStock"
                ]
            ];
        }

        // Si hay más de uno, usamos un array con "@graph"
        $jsonLD = count($productosLD) > 1 ? [
            "@context" => "https://schema.org",    
            "image" => "https://visualrent.cl/img/og-image.jpg",
            "@graph" => $productosLD
        ] : $productosLD[0];

        
        $router->render('paginas/catalogo', [
            'titulo' => 'Catalogo',
            'productos' => $productos,
            'paginacion' => $paginacion -> paginacion(),
            'jsonLD' => $jsonLD
        ]);
    }

    public static function obtenerProducto() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = $_GET['id'] ?? null;
            if (!$id) {
                echo json_encode(['error' => 'ID no válido']);
                return;
            }
    
            $producto = Producto::find($id);
    
            if (!$producto) {
                echo json_encode(['error' => 'Producto no encontrado']);
                return;
            }
    
            echo json_encode($producto);
        }
    }
    
    public static function servicios(Router $router) {
        
        $categorias = CategoriaServicio::all('ASC');

        $serviciosLD = [];
        foreach ($categorias as $categoria) {
            $serviciosLD[] = [
                "@context" => "https://schema.org",
                "@type" => "Service",
                "name" => $categoria->nombre,
                "description" => $categoria->descripcion,
                "image" => $categoria->imagen,
                "offers" => [
                    "@type" => "Offer",
                    "priceCurrency" => "CLP",
                    "availability" => "https://schema.org/InStock"
                ]
            ];
        }

        // Si hay más de uno, usamos un array con "@graph"
        $jsonLD = count($serviciosLD) > 1 ? [
            "@context" => "https://schema.org",            
            "image" => "https://visualrent.cl/img/og-image.jpg",
            "@graph" => $serviciosLD
        ] : $serviciosLD[0];

        $router->render('paginas/servicios', [
            'titulo' => 'Nuestros Servicios',
            'categorias' => $categorias,
            'jsonLD' => $jsonLD
        ]);
    }
    
    public static function verCategoria(Router $router) {
        $id = $_GET['id'] ?? null;
    
        if (!$id) {
            header('Location: /servicios');
            return;
        }
    
        $servicios = Servicio::belongsTo('categoria_id', $id);
        $categoria = CategoriaServicio::find($id);

        $serviciosLD = [];
        foreach ($servicios as $servicio) {
            $serviciosLD[] = [
                "@context" => "https://schema.org",
                "@type" => "Service",
                "name" => $servicio->nombre,
                "description" => $servicio->descripcion,
                "image" => $servicio->imagen,
                "offers" => [
                    "@type" => "Offer",
                    "priceCurrency" => "CLP",
                    "availability" => "https://schema.org/InStock"
                ]
            ];
        }

        // Si hay más de uno, usamos un array con "@graph"
        $jsonLD = count($serviciosLD) > 1 ? [
            "@context" => "https://schema.org",
            "@graph" => $serviciosLD
        ] : $serviciosLD[0];
    
        if (!$categoria) {
            header('Location: /servicios');
            return;
        }
    
        $router->render('paginas/categoria', [
            'titulo' => 'Servicios de ' . $categoria->nombre,
            'servicios' => $servicios,
            'categoria' => $categoria,
            'jsonLD' => $jsonLD
        ]);
    }

    public static function galeria(Router $router) {

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /galeria?page=1');
            exit;
        }

        $registros_por_pagina = 12;
        $total_registros = Galeria :: total();
        //Evita que haya 0 páginas disponibles
        $total_paginas = max(1, ceil($total_registros / $registros_por_pagina));
    
        if($pagina_actual > $total_paginas) {
            header('Location: /galeria?page=' . $total_paginas);
            exit;
        }

        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);

        $imagenes = Galeria :: paginar($registros_por_pagina, $paginacion -> offset());
        $clases_masonry = ['masonry-sm', 'masonry-md', 'masonry-lg'];

        $imagesLD = [];
        foreach ($imagenes as $img) {
            $imagesLD[] = [
                "@type" => "ImageObject",
                "description" => $img->descripcion, // si tienes
            ];
        }

        $jsonLD = [
            "@context" => "https://schema.org",
            "image" => "https://visualrent.cl/img/og-image.jpg",
            "@type" => "CollectionPage",
            "name" => "Galería de Productos",
            "mainEntity" => $imagesLD
        ];

        $router->render('paginas/galeria', [
            'titulo' => 'Galería de Proyectos y Eventos',
            'imagenes' => $imagenes,
            'paginacion' => $paginacion -> paginacion(),
            'clases_masonry' => $clases_masonry,
            'jsonLD' => $jsonLD
        ]);
    }
    
    public static function contacto(Router $router) {
        
        $alertas = [];
        $contacto = new Contacto;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contacto -> sincronizar($_POST);
            $alertas = $contacto->validar();

            if (empty($alertas)) {
                $resultado = $contacto->guardar();
    
                if ($resultado) {
                    //enviar correos
                    $nombre = $contacto->nombre ?? '';
                    $empresa = $contacto->empresa ?? '';
                    $email = $contacto->email ?? '';
                    $telefono = $contacto->telefono ?? '';
                    $mensaje = $contacto->mensaje ?? '';

                    $emailContacto = new Email($email, $nombre, null, $empresa, $telefono, $mensaje);
                    $emailContacto->enviarFormularioContacto();
                    $emailContacto->enviarConfirmacionContactoUsuario();

                    $alertas['exito'][] = 'Tu mensaje fue enviado correctamente';
                    //Contacto::setAlerta('exito', 'Tu mensaje fue enviado correctamente');
                    // Reiniciamos para evitar que los campos queden con datos antiguos
                    $contacto = new Contacto;
                } else {
                    //Contacto::setAlerta('error', 'Hubo un error al guardar el mensaje. Inténtalo de nuevo.');
                    $alertas['error'][] = 'Hubo un error al guardar el mensaje. Inténtalo de nuevo.';
                }
            }
        }

        $jsonLD = [
            "@context" => "https://schema.org",
            "image" => "https://visualrent.cl/img/og-image.jpg",
            "@type" => "ContactPage",
            "name" => "Contacto - VisualRent",
            "mainEntity" => "LocalBusiness",
            "description" => "Contáctanos para arriendo de equipos audiovisuales. Pantallas LED, tótems digitales y más.",
            "url" => "https://visualrent.cl/contacto"
        ];

        $router->render('paginas/contacto', [
            'titulo' => 'Contacto',
            'contacto' => $contacto,
            'alertas' => $alertas,
            'jsonLD' => $jsonLD
        ]);
    }
}