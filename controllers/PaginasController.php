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
use Model\ImagenesProducto;
use Model\CategoriaProducto;

class PaginasController {
    public static function index(Router $router) {

        $productos = Producto :: getVarios(4);
        // Para cada producto, obtener su imagen principal
        foreach ($productos as $producto) {
            $imagenPrincipal = ImagenesProducto::whereArray(['producto_id' => $producto->id, 'is_main' => 1]);
            if (!empty($imagenPrincipal)) {
                $producto->imagen_url = $imagenPrincipal[0]->url;
            } else {
                // Fallback si no hay 'is_main', tomar la primera por orden o la primera encontrada
                $imagenesProd = ImagenesProducto::belongsTo('producto_id', $producto->id);
                if(!empty($imagenesProd)) {
                    usort($imagenesProd, function($a, $b) { return $a->orden - $b->orden; });
                    $producto->imagen_url = $imagenesProd[0]->url;
                } else {
                    $producto->imagen_url = 'placeholder-product'; // Placeholder si no hay imágenes
                }
            }
        }

       // debuguear($productos);
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

        $metaDescription = "Arriendo de equipos audiovisuales profesionales para tus eventos. Experiencias inolvidables con Visual Rent. Cotiza online.";
        $ogTitle = "Visual Rent | Arriendo de Tótems, patanllas y Equipos Audiovisuales para Eventos";
        $ogDescription = "Transforma tu evento en una experiencia inolvidable con nuestros equipos audiovisuales de alta tecnología.";
        
        $router->render('paginas/index', [
            'titulo' => 'Arriendo de equipos audiovisuales para tus eventos',
            'productos' => $productos,
            'categorias' => $categorias,
            'imagenes' => $imagenes,
            'jsonLD' => $jsonLD,
            'metaDescription' => $metaDescription,                                                                                                                              
            'ogTitle' => $ogTitle,
            'ogDescription' => $ogDescription
        ]);
    }

    public static function productos(Router $router) {
        
        $categorias = CategoriaProducto::all('ASC');

        $productosLD = [];
        foreach ($categorias as $categoria) {
            $productosLD[] = [
                "@context" => "https://schema.org",
                "@type" => "Product",
                "name" => $categoria->nombre,
                "description" => $categoria->descripcion,
                "image" => "https://visualrent.cl/img/categoria-productos/" . $categoria->imagen . ".webp",
                "offers" => [
                    "@type" => "Offer",
                    "priceCurrency" => "CLP",
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

        $metaDescription = "Descubre nuestros servicios para eventos: diseño gráfico, técnicos en terreno, iluminación, DJ y desarrollo de software. VisualRent te acompaña en cada detalle.";
        $ogTitle = "Servicios para Eventos | VisualRent";
        $ogDescription = "Diseño gráfico, DJ, técnicos, iluminación y desarrollo de software para eventos. VisualRent te acompaña con soluciones integrales.";

        $router->render('paginas/productos/index', [
            'titulo' => 'Equipos para Eventos en Santiago – Totems, Pantallas, Auidio y Más',
            'categorias' => $categorias,
            'jsonLD' => $jsonLD,
            'metaDescription' => $metaDescription,
            'ogTitle' => $ogTitle,
            'ogDescription' => $ogDescription
        ]);
    }
    
    public static function categoriaProducto(Router $router) {
        $id = $_GET['id'] ?? null;
    
        if (!$id) {
            header('Location: /productos/index');
            exit();
        }
    
        $productos = Producto::belongsTo('categoria_id', $id);
        $categoria = CategoriaProducto::find($id);

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /productos/categoria?id=' . $categoria->id  . '&page=1#' . urlencode($categoria->nombre));
            exit();
        }
            
        $registros_por_pagina = 8;
        $total_registros = Producto::total('categoria_id', $id); 
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);

        if($total_registros > 0 && $paginacion -> pagina_actual > $paginacion -> totalPaginas()) {
            header('Location: /productos/categoria?id=' . $categoria->id . '&page=' . $paginacion -> totalPaginas() . '#' . urlencode($categoria->nombre));
            exit();
        }

        $productos = Producto :: paginarPorCategoria('categoria_id', $id, $registros_por_pagina, $paginacion -> offset());

        // Para cada producto, obtener su imagen principal
        foreach ($productos as $producto) {
            $imagenPrincipal = ImagenesProducto::whereArray(['producto_id' => $producto->id, 'is_main' => 1]);
            if (!empty($imagenPrincipal)) {
                $producto->imagen_url = $imagenPrincipal[0]->url;
            } else {
                // Fallback si no hay 'is_main', tomar la primera por orden o la primera encontrada
                $imagenesProd = ImagenesProducto::belongsTo('producto_id', $producto->id);
                if(!empty($imagenesProd)) {
                    usort($imagenesProd, function($a, $b) { return $a->orden - $b->orden; });
                    $producto->imagen_url = $imagenesProd[0]->url;
                } else {
                    $producto->imagen_url = 'placeholder-product'; // Placeholder si no hay imágenes
                }
            }
        }

        // Armar array de productos en formato Schema.org
        $productosLD = [];
        foreach ($productos as $producto) {

            $urlImagenPrincipal = "https://visualrent.cl/img/productos/" . ($producto->imagen_url ?? 'placeholder-product') . ".webp";

            $productosLD[] = [
                "@context" => "https://schema.org",
                "@type" => "Product",
                "name" => $producto->nombre,
                "description" => $producto->descripcion,
                "image" => $urlImagenPrincipal,   
                "sku" => "VR-" . $producto->id,
                "offers" => [
                    "@type" => "Offer",
                    "priceCurrency" => "CLP", // o tu moneda
                    "price" => $producto->precio_informativo,
                    "availability" => ($producto->disponibles > 0) ? "https://schema.org/InStock" : "https://schema.org/OutOfStock",
                    "itemCondition" => "https://schema.org/UsedCondition",
                    "businessFunction" => "https://schema.org/Rental",
                    "shippingDetails" => [
                        "@type" => "OfferShippingDetails",
                        "shippingRate" => [
                            "@type" => "MonetaryAmount",
                            "value" => "80000",
                            "currency" => "CLP"
                        ],
                        "shippingDestination" => [
                            "@type" => "DefinedRegion",
                            "addressCountry" => "CL",
                            "addressRegion" => "RM"
                        ],
                        "shippingLabel" => "Incluye despacho, instalación y retiro. Fecha coordinada con el cliente."
                    ],
                    "hasMerchantReturnPolicy" => [
                    "@type" => "MerchantReturnPolicy",
                    "returnPolicyCategory" => "https://schema.org/NoReturnsRefundPolicy",
                    "applicableCountry" => "CL",
                    "returnMethod" => "https://schema.org/InStoreReturn",
                    "returnFees" => "https://schema.org/ReturnFeesCustomerResponsibility",
                    "merchantReturnDays" => 0
                    ]
                ]
            ];

            $metaDescription = $producto->meta_description ?? "Explora nuestro catálogo de productos para eventos: tótems, pantallas, juegos y pendones LED. Soluciones interactivas y visuales.";
            $ogTitle = $producto->og_title ?? "Catálogo VisualRent: Arriendo de Tecnología para Eventos";
            $ogDescription = $producto->og_description ?? "Explora categorías de productos: tótems, pantallas, juegos y pendones LED. Soluciones interactivas y visuales.";
        }

        // Si hay más de uno, usamos un array con "@graph"
        $jsonLD = count($productosLD) > 1 ? [
            "@context" => "https://schema.org",    
            "image" => "https://visualrent.cl/img/og-image.jpg",
            "@graph" => $productosLD
        ] : $productosLD[0];

        $metaDescription = "Arriendo de equipos audiovisuales profesionales para tus eventos. Experiencias inolvidables con Visual Rent. Cotiza online.";
        $ogTitle = "Visual Rent | Arriendo de Tótems, patanllas y Equipos Audiovisuales para Eventos";
        $ogDescription = "Transforma tu evento en una experiencia inolvidable con nuestros equipos audiovisuales de alta tecnología.";
    
        if (!$categoria) {
            header('Location: /productos');
            return;
        }
    
        $router->render('paginas/productos/categoria', [
            'titulo' => 'Productos de ' . $categoria->nombre,
            'productos' => $productos,
            'categoria' => $categoria,
            'jsonLD' => $jsonLD,
            'metaDescription' => $metaDescription,
            'ogTitle' => $ogTitle,
            'paginacion' => $paginacion -> paginacion(),
            'ogDescription' => $ogDescription
        ]);
    }
    
    public static function catalogo(Router $router) {
        
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /productos/catalogo?page=1');
        }
            
        $registros_por_pagina = 8;
        $total_registros = Producto :: total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);

        if($total_registros > 0 && $paginacion -> pagina_actual > $paginacion -> totalPaginas()) {
            header('Location: /productos/catalogo?page=' . $paginacion -> totalPaginas());
        }

        $productos = Producto :: paginar($registros_por_pagina, $paginacion -> offset());
        // Para cada producto, obtener su imagen principal
        foreach ($productos as $producto) {
            $imagenPrincipal = ImagenesProducto::whereArray(['producto_id' => $producto->id, 'is_main' => 1]);
            if (!empty($imagenPrincipal)) {
                $producto->imagen_url = $imagenPrincipal[0]->url;
            } else {
                // Fallback si no hay 'is_main', tomar la primera por orden o la primera encontrada
                $imagenesProd = ImagenesProducto::belongsTo('producto_id', $producto->id);
                if(!empty($imagenesProd)) {
                    usort($imagenesProd, function($a, $b) { return $a->orden - $b->orden; });
                    $producto->imagen_url = $imagenesProd[0]->url;
                } else {
                    $producto->imagen_url = 'placeholder-product'; // Placeholder si no hay imágenes
                }
            }
        }

        // Armar array de productos en formato Schema.org
        $productosLD = [];
        foreach ($productos as $producto) {

            $urlImagenPrincipal = "https://visualrent.cl/img/productos/" . ($producto->imagen_url ?? 'placeholder-product') . ".webp";

            $productosLD[] = [
                "@context" => "https://schema.org",
                "@type" => "Product",
                "name" => $producto->nombre,
                "description" => $producto->descripcion,
                "image" => $urlImagenPrincipal,   
                "sku" => "VR-" . $producto->id,
                "offers" => [
                    "@type" => "Offer",
                    "priceCurrency" => "CLP", // o tu moneda
                    "price" => $producto->precio_informativo,
                    "availability" => ($producto->disponibles > 0) ? "https://schema.org/InStock" : "https://schema.org/OutOfStock",
                    "itemCondition" => "https://schema.org/UsedCondition",
                    "businessFunction" => "https://schema.org/Rental",
                    "shippingDetails" => [
                        "@type" => "OfferShippingDetails",
                        "shippingRate" => [
                            "@type" => "MonetaryAmount",
                            "value" => "80000",
                            "currency" => "CLP"
                        ],
                        "shippingDestination" => [
                            "@type" => "DefinedRegion",
                            "addressCountry" => "CL",
                            "addressRegion" => "RM"
                        ],
                        "shippingLabel" => "Incluye despacho, instalación y retiro. Fecha coordinada con el cliente."
                    ],
                    "hasMerchantReturnPolicy" => [
                    "@type" => "MerchantReturnPolicy",
                    "returnPolicyCategory" => "https://schema.org/NoReturnsRefundPolicy",
                    "applicableCountry" => "CL",
                    "returnMethod" => "https://schema.org/InStoreReturn",
                    "returnFees" => "https://schema.org/ReturnFeesCustomerResponsibility",
                    "merchantReturnDays" => 0
                    ]
                ]
            ];

            $metaDescription = $producto->meta_description ?? "Explora nuestro catálogo de productos para eventos: tótems, pantallas, juegos y pendones LED. Soluciones interactivas y visuales.";
            $ogTitle = $producto->og_title ?? "Catálogo VisualRent: Arriendo de Tecnología para Eventos";
            $ogDescription = $producto->og_description ?? "Explora categorías de productos: tótems, pantallas, juegos y pendones LED. Soluciones interactivas y visuales.";
        }

        // Si hay más de uno, usamos un array con "@graph"
        $jsonLD = count($productosLD) > 1 ? [
            "@context" => "https://schema.org",    
            "image" => "https://visualrent.cl/img/og-image.jpg",
            "@graph" => $productosLD
        ] : $productosLD[0];
        
        $router->render('paginas/productos/catalogo', [
            'titulo' => 'Catálogo de Productos para Eventos: Tótems, Pantallas, Juegos y Más',
            'productos' => $productos,
            'paginacion' => $paginacion -> paginacion(),
            'jsonLD' => $jsonLD,
            'metaDescription' => "Explora nuestro catálogo de productos para eventos: tótems, pantallas, juegos y pendones LED. Soluciones interactivas y visuales.",
            'ogTitle' => "Catálogo VisualRent: Arriendo de Tecnología para Eventos",
            'ogDescription' => "Explora categorías de productos: tótems, pantallas, juegos y pendones LED. Soluciones interactivas y visuales.",
            'ogImage' => 'https://visualrent.cl/img/og-image.jpg'
        ]);
    }

    public static function detalleProducto(Router $router) {
        $id = $_GET['id'] ?? null;
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /productos/catalogo');
            exit;
        }

        $producto = Producto::find($id);

        if (!$producto) {
            header('Location: /productos/catalogo'); 
            exit;
        }

        $imagenes_producto = ImagenesProducto::belongsTo('producto_id', $producto->id);
        usort($imagenes_producto, function ($a, $b) {
            if ($a->is_main != $b->is_main) {
                return $b->is_main - $a->is_main; 
            }
            return $a->orden - $b->orden; 
        });
        
        $main_image_url = 'placeholder-product'; 
        if (!empty($imagenes_producto)) {
            $main_image_url = $imagenes_producto[0]->url; 
        }

        $related_productos_raw = Producto::whereArray(['categoria_id' => $producto->categoria_id]);
        $related_productos = [];
        if (is_array($related_productos_raw)) {
            foreach($related_productos_raw as $rp) {
                if (count($related_productos) >= 5) break; 
                if ($rp->id != $producto->id) {
                    // Aquí asignaremos a $rp->imagen_principal_url, así que esta propiedad también debe existir en Producto.php
                    // o manejarlo de otra forma si $rp es un array y no un objeto Producto con esa propiedad.
                    // Por ahora, asumiendo que se añade dinámicamente o que se debe declarar en Producto.php también.
                    $img_principal_rel_obj_array = ImagenesProducto::whereArray(['producto_id' => $rp->id, 'is_main' => 1]);
                     if (empty($img_principal_rel_obj_array) ) { 
                         $temp_imgs = ImagenesProducto::belongsTo('producto_id', $rp->id);
                         if(!empty($temp_imgs)) {
                            usort($temp_imgs, function($a, $b) { return $a->orden - $b->orden; });
                            // $rp->imagen_principal_url = $temp_imgs[0]->url; // Descomentar si $imagen_principal_url está declarada
                        } else {
                            // $rp->imagen_principal_url = 'placeholder-product'; // Descomentar
                        }
                    } else {
                         // $rp->imagen_principal_url = $img_principal_rel_obj_array[0]->url; // Descomentar
                    }
                    // Para evitar el error de propiedad dinámica en $rp, si $rp es un objeto Producto:
                    // Primero, asegúrate de que 'imagen_principal_url' esté declarada en la clase Producto.
                    // Luego, asigna el valor:
                    $img_principal_url_for_related = 'placeholder-product';
                    if (!empty($img_principal_rel_obj_array)) {
                        $img_principal_url_for_related = $img_principal_rel_obj_array[0]->url;
                    } else {
                        $temp_imgs = ImagenesProducto::belongsTo('producto_id', $rp->id);
                        if(!empty($temp_imgs)) {
                            usort($temp_imgs, function($a, $b) { return $a->orden - $b->orden; });
                            $img_principal_url_for_related = $temp_imgs[0]->url;
                        }
                    }
                    $rp->imagen_principal_url = $img_principal_url_for_related; // Asignación después de calcularla
                    
                    $related_productos[] = $rp;
                }
            }
        }
        
        $categoria = CategoriaProducto::find($producto->categoria_id);

        $json_imagenes = json_encode($imagenes_producto);

        $imagenesJsonLd = array_map(function($img) {
            return "https://visualrent.cl/img/productos/" . $img->url . ".webp"; 
        }, $imagenes_producto);

        $jsonLD = [
            "@context" => "https://schema.org",
            "@type" => "Product",
            "name" => $producto->nombre,
            "description" => $producto->meta_description ?: strip_tags($producto->descripcion),
            "image" => !empty($imagenesJsonLd) ? $imagenesJsonLd : ["https://visualrent.cl/img/productos/" . $main_image_url . ".webp"], 
            "sku" => "VR-" . $producto->id, 
            "brand" => [
                "@type" => "Brand", 
                "name" => "Visual Rent" 
            ],
            "offers" => [
                "@type" => "Offer",
                "priceCurrency" => "CLP", 
                "price" => $producto->precio_informativo,
                "availability" => ($producto->disponibles > 0) ? "https://schema.org/InStock" : "https://schema.org/OutOfStock",
                "itemCondition" => "https://schema.org/UsedCondition", 
                "businessFunction" => "https://schema.org/Rental",
                "url" => "https://visualrent.cl/producto?id=" . $producto->id 
            ]
        ];
        if ($categoria) {
            $jsonLD["category"] = $categoria->nombre;
        }

        $router->render('paginas/productos/detalle', [
            'titulo' => $producto->nombre,
            'producto' => $producto,
            'imagenes' => $imagenes_producto, 
            'main_image_url' => $main_image_url, 
            'related_productos' => $related_productos,
            'categoria' => $categoria,
            'json_imagenes' => $json_imagenes,
            'jsonLD' => $jsonLD,
            'metaDescription' => $producto->meta_description ?: strip_tags(substr($producto->descripcion, 0, 155)),
            'ogTitle' => $producto->og_title ?: $producto->nombre . " | Visual Rent",
            'ogDescription' => $producto->og_description ?: strip_tags(substr($producto->descripcion, 0, 155)),
            'ogImage' => !empty($imagenes_producto) ? "https://visualrent.cl/img/productos/" . $imagenes_producto[0]->url . ".webp" : 'https://visualrent.cl/img/productos/' . $main_image_url . '.webp' 
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

        $metaDescription = "Descubre nuestros servicios para eventos: diseño gráfico, técnicos en terreno, iluminación, DJ y desarrollo de software. VisualRent te acompaña en cada detalle.";
        $ogTitle = "Servicios para Eventos | VisualRent";
        $ogDescription = "Diseño gráfico, DJ, técnicos, iluminación y desarrollo de software para eventos. VisualRent te acompaña con soluciones integrales.";

        $router->render('paginas/servicios/index', [
            'titulo' => 'Servicios para Eventos en Santiago – Diseño, DJ, Iluminación y Más',
            'categorias' => $categorias,
            'jsonLD' => $jsonLD,
            'metaDescription' => $metaDescription,
            'ogTitle' => $ogTitle,
            'ogDescription' => $ogDescription
        ]);
    }
    
    public static function categoriaServicio(Router $router) {
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

        $metaDescription = "Arriendo de equipos audiovisuales profesionales para tus eventos. Experiencias inolvidables con Visual Rent. Cotiza online.";
        $ogTitle = "Visual Rent | Arriendo de Tótems, patanllas y Equipos Audiovisuales para Eventos";
        $ogDescription = "Transforma tu evento en una experiencia inolvidable con nuestros equipos audiovisuales de alta tecnología.";
    
        if (!$categoria) {
            header('Location: /servicios');
            return;
        }
    
        $router->render('paginas/servicios/categoria', [
            'titulo' => 'Servicios de ' . $categoria->nombre,
            'servicios' => $servicios,
            'categoria' => $categoria,
            'jsonLD' => $jsonLD,
            'metaDescription' => $metaDescription,
            'ogTitle' => $ogTitle,
            'ogDescription' => $ogDescription
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

        $metaDescription = "Mira cómo transformamos eventos con tecnología, diseño y creatividad. Revisa nuestra galería y conoce lo que VisualRent puede hacer por ti.";
        $ogTitle = "Galería de Eventos | VisualRent";
        $ogDescription = "Inspírate con nuestras instalaciones, pantallas y tótems en ferias y eventos. Resultados reales y experiencia.";

        $router->render('paginas/galeria', [
            'titulo' => 'Galería de Proyectos – Eventos y Tecnología en Acción',
            'imagenes' => $imagenes,
            'paginacion' => $paginacion -> paginacion(),
            'clases_masonry' => $clases_masonry,
            'jsonLD' => $jsonLD,
            'metaDescription' => $metaDescription,
            'ogTitle' => $ogTitle,
            'ogDescription' => $ogDescription
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

        $metaDescription = "Contáctanos y lleva tu evento al siguiente nivel. Resolvemos tus dudas y armamos una propuesta personalizada. VisualRent: soluciones reales, atención directa.";
        $ogTitle = "Contáctanos | VisualRen";
        $ogDescription = "¿Tienes un evento? Escríbenos para cotizaciones, dudas o propuestas personalizadas. Atención directa y profesional.";

        $router->render('paginas/contacto', [
            'titulo' => 'Contacto – Solicita tu Cotización para Eventos en Santiago',
            'contacto' => $contacto,
            'alertas' => $alertas,
            'jsonLD' => $jsonLD,
            'metaDescription' => $metaDescription,
            'ogTitle' => $ogTitle,
            'ogDescription' => $ogDescription
        ]);
    }
    
    public static function politicaPrivacidad(Router $router) {

        $jsonLD = [
            "@context" => "https://schema.org",
            "@type" => "WebPage",
            "name" => "Política de Privacidad",
            "url" => "https://tusitio.com/politica-de-privacidad",
            "description" => "Consulta cómo recopilamos, usamos y protegemos tu información personal."
        ];   

        $metaDescription = "Protegemos tu información. Consulta nuestra política de privacidad para saber cómo tratamos tus datos personales.";
        $ogTitle = "Política de Privacidad - Compromiso con tus datos";
        $ogDescription = "Tu privacidad es nuestra prioridad. Descubre cómo protegemos, usamos y almacenamos tu información personal.";     
    
        $router->render('paginas/politica-de-privacidad', [
            'titulo' => 'Política de Privacidad | Protección de Datos Personales',
            'jsonLD' => $jsonLD,
            'metaDescription' => $metaDescription,
            'ogTitle' => $ogTitle,
            'ogDescription' => $ogDescription
        ]);
    }
    
    public static function terminosCondiciones(Router $router) {

        $jsonLD = [
            "@context" => "https://schema.org",
            "@type" => "WebPage",
            "name" => "Términos y Condiciones",
            "url" => "https =>//tusitio.com/terminos-y-condiciones",
            "description" => "Lee nuestros términos y condiciones de uso del sitio y nuestros servicios."
        ];       

        $metaDescription = "Conoce los términos y condiciones que regulan el uso de nuestro sitio y los servicios que ofrecemos.";
        $ogTitle = "Términos y Condiciones - Conoce tus derechos y deberes";
        $ogDescription = "Consulta los términos y condiciones que rigen el uso de nuestro sitio y los servicios que ofrecemos."; 
    
        $router->render('paginas/terminos-y-condiciones', [
            'titulo' => 'Términos y Condiciones | Uso Responsable del Sitio',
            'jsonLD' => $jsonLD,
            'metaDescription' => $metaDescription,
            'ogTitle' => $ogTitle,
            'ogDescription' => $ogDescription
        ]);
    }
    
    public static function politicaCookies(Router $router) {

        $jsonLD = [
            "@context" => "https://schema.org",
            "@type" => "WebPage",
            "name" => "Política de Cookies",
            "url" => "https =>//tusitio.com/politica-de-cookies",
            "description" => "Esta página explica cómo usamos cookies para mejorar la experiencia del usuario y analizar el tráfico del sitio."
        ];        

        $metaDescription = "Descubre cómo utilizamos cookies para mejorar tu experiencia en nuestro sitio web y cómo puedes gestionarlas.";
        $ogTitle = "Política de Cookies - Cómo usamos cookies en nuestro sitio";
        $ogDescription = "Te explicamos qué cookies usamos, con qué propósito y cómo puedes gestionarlas para una navegación segura.";
    
        $router->render('paginas/politica-de-cookies', [
            'titulo' => 'Política de Cookies | Experiencia Personalizada y Transparente',
            'jsonLD' => $jsonLD,
            'metaDescription' => $metaDescription,
            'ogTitle' => $ogTitle,
            'ogDescription' => $ogDescription
        ]);
    }
    
    public static function avisoLegal(Router $router) {

        $jsonLD = [
            "@context" => "https://schema.org",
            "@type" => "WebPage",
            "name" => "Aviso Legal",
            "url" => "https =>//tusitio.com/aviso-legal",
            "description" => "Información legal sobre la titularidad y el uso del sitio web."
        ];        

        $metaDescription = "Arriendo de equipos audiovisuales profesionales para tus eventos. Experiencias inolvidables con Visual Rent. Cotiza online.";
        $ogTitle = "Aviso Legal - Transparencia y cumplimiento normativo";
        $ogDescription = "Revisa la información legal sobre el propietario del sitio, derechos de autor, condiciones legales y más.";
    
        $router->render('paginas/aviso-legal', [
            'titulo' => 'Aviso Legal | Información Jurídica y Transparencia',
            'jsonLD' => $jsonLD,
            'metaDescription' => $metaDescription,
            'ogTitle' => $ogTitle,
            'ogDescription' => $ogDescription
        ]);
    }
    
    public static function garantiaDevoluciones(Router $router) {

        $jsonLD = [
            "@context" => "https://schema.org",
            "@type" => "WebPage",
            "name" => "Garantía y Devoluciones",
            "url" => "https =>//tusitio.com/garantia-y-devoluciones",
            "description" => "Conoce nuestras políticas de garantía y devoluciones para todos nuestros productos y servicios."
        ];        

        $metaDescription = "Conoce nuestras políticas de garantía y devoluciones para compras de productos y servicios. Tu satisfacción es prioridad.";
        $ogTitle = "Política de Garantías y Devoluciones - Tu satisfacción está asegurada";
        $ogDescription = "Conoce nuestros procesos de devolución y garantías. Te ofrecemos tranquilidad en cada compra o arriendo.";
    
        $router->render('paginas/garantia-y-devoluciones', [
            'titulo' => 'Garantía y Devoluciones | Compra Segura y Confiable',
            'jsonLD' => $jsonLD,
            'metaDescription' => $metaDescription,
            'ogTitle' => $ogTitle,
            'ogDescription' => $ogDescription
        ]);
    }
    
    public static function mediosPago(Router $router) {

        $jsonLD = [
            "@context" => "https://schema.org",
            "@type" => "WebPage",
            "name"=> "Medios de Pago",
            "url"=> "https=>//tusitio.com/medios-de-pago",
            "description"=> "Consulta los métodos de pago disponibles: tarjetas, transferencias, pagos en línea y más."
        ];        

        $metaDescription = "Aceptamos diversos medios de pago para tu comodidad. Descubre las opciones disponibles y cómo utilizarlas.";
        $ogTitle = "Medios de Pago - Elige la opción que más te convenga";
        $ogDescription = "Aceptamos múltiples medios de pago para facilitar tus compras. Revisa todas las opciones disponibles.";
    
        $router->render('paginas/medios-de-pago', [
            'titulo' => 'Medios de Pago | Opciones Seguras y Flexibles',
            'jsonLD' => $jsonLD,
            'metaDescription' => $metaDescription,
            'ogTitle' => $ogTitle,
            'ogDescription' => $ogDescription
        ]);
    }
    
    public static function nosotros(Router $router) {

        $jsonLD = [
            "@context" => "https://schema.org",
            "@type" => "AboutPage",
            "name" => "Sobre Nosotros",
            "url" => "https =>//tusitio.com/nosotros",
            "description" => "Conoce más sobre nuestra empresa, nuestro equipo y lo que hacemos."
        ];        

        $metaDescription = "Conoce quiénes somos, nuestra historia, experiencia y compromiso en brindar soluciones innovadoras para eventos.";
        $ogTitle = "Quiénes Somos - Innovación y experiencia a tu servicio";
        $ogDescription = "Conoce nuestra historia, equipo y compromiso por ofrecer soluciones tecnológicas para eventos inolvidables.";
    
        $router->render('paginas/nosotros', [
            'titulo' => 'Quiénes Somos | Pasión por la Tecnología y los Eventos',
            'jsonLD' => $jsonLD,
            'metaDescription' => $metaDescription,
            'ogTitle' => $ogTitle,
            'ogDescription' => $ogDescription
        ]);
    }
    
    public static function misionVision(Router $router) {

        $jsonLD = [
            "@context" => "https://schema.org",
            "@type" => "AboutPage",
            "name" => "Misión y Visión",
            "url" => "https =>//tusitio.com/mision-y-vision",
            "description" => "Descubre nuestra misión, visión y los valores que guían cada uno de nuestros proyectos y servicios."
        ];        

        $metaDescription = "Conoce nuestra misión, visión y valores que impulsan nuestro trabajo y compromiso con la excelencia.";
        $ogTitle = "Misión, Visión y Valores - Lo que nos mueve cada día";
        $ogDescription = "Descubre nuestra misión, visión y los valores que guían nuestro trabajo diario y relaciones con clientes.";
    
        $router->render('paginas/mision-y-vision', [
            'titulo' => 'Misión, Visión y Valores | Nuestro Compromiso',
            'jsonLD' => $jsonLD,
            'metaDescription' => $metaDescription,
            'ogTitle' => $ogTitle,
            'ogDescription' => $ogDescription
        ]);
    }
    
    public static function clientes(Router $router) {

        $jsonLD = [
            "@context" => "https://schema.org",
            "@type" => "WebPage",
            "name" => "Nuestros Clientes",
            "url" => "https =>//tusitio.com/nuestros-clientes",
            "description" => "Conoce a las empresas y organizaciones que han confiado en nosotros para sus eventos y soluciones tecnológicas."
        ];       

        $metaDescription = "Empresas y organizaciones que confían en nuestros servicios para sus eventos. Descubre quiénes son nuestros clientes.";
        $ogTitle = "Nuestros Clientes - Casos de éxito y confianza";
        $ogDescription = "Grandes empresas y organizaciones han confiado en nosotros. Conoce algunos de nuestros clientes destacados."; 
    
        $router->render('paginas/clientes', [
            'titulo' => 'Nuestros Clientes | Empresas que confían en nosotros',
            'jsonLD' => $jsonLD,
            'metaDescription' => $metaDescription,
            'ogTitle' => $ogTitle,
            'ogDescription' => $ogDescription
        ]);
    }
    
    public static function alianzas(Router $router) {

        $jsonLD = [
            "@context" => "https://schema.org",
            "@type" => "WebPage",
            "name" => "Alianzas",
            "url" => "https =>//tusitio.com/alianzas",
            "description" => "Explora nuestras alianzas estratégicas con marcas y organizaciones líderes del sector."
        ];        

        $metaDescription = "Conoce nuestras alianzas estratégicas con marcas líderes y empresas del sector tecnológico y de eventos.";
        $ogTitle = "Alianzas - Juntos llegamos más lejos";
        $ogDescription = "Explora nuestras alianzas con empresas líderes para ofrecer soluciones integrales en tecnología y eventos.";
    
        $router->render('paginas/alianzas', [
            'titulo' => 'Alianzas Estratégicas | Colaboraciones que potencian resultados',
            'jsonLD' => $jsonLD,
            'metaDescription' => $metaDescription,
            'ogTitle' => $ogTitle,
            'ogDescription' => $ogDescription
        ]);
    }
    
    public static function preguntasFrecuentes(Router $router) {

        $jsonLD = [
            "@context" => "https://schema.org",
            "@type" => "FAQPage",
            "mainEntity" => [
                [
                    "@type" => "Question",
                    "name" => "¿Qué servicios ofrece VisualRent?",
                    "acceptedAnswer" => [
                        "@type" => "Answer",
                        "text" => "En VisualRent.cl nos especializamos en el arriendo de equipos para eventos corporativos, ferias y activaciones de marca. Ofrecemos tótems interactivos, pantallas LED, sonido profesional, iluminación, efectos especiales como el Ciclón Millonario y mucho más."
                    ]
                ],
                [
                    "@type" => "Question",
                    "name" => "¿A qué regiones realizan envíos?",
                    "acceptedAnswer" => [
                        "@type" => "Answer",
                        "text" => "Principalmente operamos en Santiago y regiones cercanas. Sin embargo, dependiendo del tipo de evento y la logística, podemos evaluar envíos a otras regiones de Chile. Te recomendamos contactarnos con antelación para coordinar."
                    ]
                ],
                [
                    "@type" => "Question",
                    "name" => "¿Cómo puedo cotizar un servicio?",
                    "acceptedAnswer" => [
                        "@type" => "Answer",
                        "text" => "Puedes llenar el formulario de contacto en nuestro sitio web, escribirnos directamente por WhatsApp o enviarnos un correo a contacto@visualrent.cl. Recibirás una cotización personalizada según los requerimientos de tu evento."
                    ]
                ],
                [
                    "@type" => "Question",
                    "name" => "¿Qué incluye el servicio de arriendo?",
                    "acceptedAnswer" => [
                        "@type" => "Answer",
                        "text" => "Todos nuestros servicios incluyen entrega, instalación, asistencia técnica y retiro. En algunos casos también ofrecemos soporte en tiempo real durante el evento para asegurar que todo funcione correctamente."
                    ]
                ],
                [
                    "@type" => "Question",
                    "name" => "¿Con cuánto tiempo de anticipación debo reservar?",
                    "acceptedAnswer" => [
                        "@type" => "Answer",
                        "text" => "Te recomendamos hacer la reserva al menos con 7 a 10 días de anticipación, especialmente en temporada alta (ferias, festividades o lanzamientos). Esto nos permite garantizar disponibilidad y una correcta planificación logística."
                    ]
                ],
                [
                    "@type" => "Question",
                    "name" => "¿Qué medios de pago aceptan?",
                    "acceptedAnswer" => [
                        "@type" => "Answer",
                        "text" => "Aceptamos pagos vía transferencia bancaria, tarjetas de crédito/débito, y pagos con factura para empresas que cuenten con convenio. Consulta en Medios de Pago para más información."
                    ]
                ],
                [
                    "@type" => "Question",
                    "name" => "¿Qué pasa si se daña un equipo durante el evento?",
                    "acceptedAnswer" => [
                        "@type" => "Answer",
                        "text" => "Todos nuestros equipos cuentan con mantenimiento preventivo y son revisados antes de cada entrega. En caso de daños por mal uso o negligencia, se evalúa la situación y se aplica la cláusula de garantía según lo indicado en nuestros Términos y Condiciones."
                    ]
                ],
                [
                    "@type" => "Question",
                    "name" => "¿Ofrecen soporte técnico en el lugar?",
                    "acceptedAnswer" => [
                        "@type" => "Answer",
                        "text" => "Sí, dependiendo del tipo de equipo y evento, podemos incluir un técnico en terreno para garantizar el funcionamiento óptimo durante toda la actividad. Este servicio puede tener un costo adicional."
                    ]
                ],
                [
                    "@type" => "Question",
                    "name" => "¿Puedo cancelar una reserva?",
                    "acceptedAnswer" => [
                        "@type" => "Answer",
                        "text" => "Las cancelaciones se deben realizar con al menos 72 horas de anticipación. Si se cancela fuera de ese plazo, puede aplicarse un cobro por costos administrativos o de preparación. Revisa nuestra sección de Garantías y Devoluciones."
                    ]
                ],
                [
                    "@type" => "Question",
                    "name" => "¿Dónde puedo ver fotos o videos de los equipos en acción?",
                    "acceptedAnswer" => [
                        "@type" => "Answer",
                        "text" => "Puedes visitar nuestra Galería donde encontrarás imágenes y videos de eventos realizados con nuestros productos, así como testimonios de nuestros clientes."
                    ]
                ]
            ]
        ];        

        $metaDescription = "Resuelve tus dudas rápidamente consultando nuestras preguntas frecuentes sobre productos, servicios y reservas.";
        $ogTitle = "Preguntas Frecuentes - Encuentra respuestas rápidas";
        $ogDescription = "Consulta las respuestas a las dudas más comunes sobre nuestros productos, servicios y procesos de reserva.";
    
        $router->render('paginas/preguntas-frecuentes', [
            'titulo' => 'Preguntas Frecuentes | Resuelve tus dudas al instante',
            'jsonLD' => $jsonLD,
            'metaDescription' => $metaDescription,
            'ogTitle' => $ogTitle,
            'ogDescription' => $ogDescription
        ]);
    }
}