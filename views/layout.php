<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- Set default meta -->
    <?php
    $metaDescription = "Arriendo de equipos audiovisuales profesionales para tus eventos. Experiencias inolvidables con Visual Rent. Cotiza online.";
    $ogTitle = "Visual Rent | Arriendo de Equipos Audiovisuales para Eventos";
    $ogDescription = "Transforma tu evento en una experiencia inolvidable con nuestros equipos audiovisuales de alta tecnología.";

    if (isset($vista)) {
        if ($vista === 'servicios') { 
            $metaDescription ="Visual Rent ofrece soluciones creativas y tecnológicas para tus eventos: diseño gráfico impactante, asistencia técnica en terreno, desarrollo de software personalizado para pantallas interactivas, DJs para ambientación sonora y sistemas de iluminación perimetral inteligentes.";
            $ogTitle = "Servicios Visual Rent | Soluciones Tecnológicas para Eventos";
            $ogDescription = $metaDescription;
    ?>
            <!-- JSON-LD para Servicios -->
            <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "Service",
                "name": "Arriendo de Equipos Audiovisuales para Eventos",
                "provider": {
                    "@type": "Organization",
                    "name": "Visual Rent",
                    "url": "https://visualrent.cl",
                    "logo": "https://visualrent.cl/img/logo.png"
                },
                "areaServed": {
                    "@type": "Country",
                    "name": "Chile"
                },
                "serviceType": "Servicios audiovisuales y tecnológicos para eventos",
                "description": "Visual Rent ofrece soluciones integrales para eventos: diseño gráfico, asistencia técnica, desarrollo de software personalizado, DJs y ambientación, iluminación inteligente y más.",
                "termsOfService": "https://visualrent.cl/terminos-y-condiciones",
                "hasOfferCatalog": {
                    "@type": "OfferCatalog",
                    "name": "Servicios de Visual Rent",
                    "itemListElement": [
                    {
                        "@type": "Offer",
                        "itemOffered": {
                        "@type": "Service",
                        "name": "Diseño Gráfico",
                        "description": "Transformamos ideas en impacto visual. Diseños que fusionan arte y tecnología para destacar tu marca en todos los formatos digitales."
                        }
                    },
                    {
                        "@type": "Offer",
                        "itemOffered": {
                        "@type": "Service",
                        "name": "Técnico en Terreno",
                        "description": "Llevamos la solución directamente a tu puerta. Instalaciones, soporte y asistencia técnica profesional donde lo necesites, cuando lo necesites."
                        }
                    },
                    {
                        "@type": "Offer",
                        "itemOffered": {
                        "@type": "Service",
                        "name": "Desarrollo de Software",
                        "description": "Desarrollamos juegos, formularios y apps personalizadas para tus pantallas interactivas. Si no tienes software, ¡nosotros lo creamos por ti!"
                        }
                    },
                    {
                        "@type": "Offer",
                        "itemOffered": {
                        "@type": "Service",
                        "name": "DJ de Ambiente",
                        "description": "Sonido que conecta, música que transforma. Creamos atmósferas únicas con DJs expertos y ambientación sonora para eventos que se viven con los cinco sentidos."
                        }
                    },
                    {
                        "@type": "Offer",
                        "itemOffered": {
                        "@type": "Service",
                        "name": "Iluminación Perimetral",
                        "description": "Ilumina emociones, diseña ambientes. Realza espacios y crea experiencias envolventes con iluminación inteligente y estética."
                        }
                    }
                    ]
                }
            }
            </script>
        <?php } elseif ($vista === 'catalogo') {
            $metaDescription ="Descubre nuestro catálogo de productos en arriendo. Encuentra artículos para todas tus necesidades con precios competitivos y opciones de alquiler flexibles.";
            $ogTitle = "Servicios Visual Rent | Catalogo de productos";
            $ogDescription = $metaDescription;
        ?>
            <!-- JSON-LD para un Producto del Catálogo -->
            <script type="application/ld+json">
            {
            "@context": "https://schema.org",
            "@type": "Product",
            "name": "Catalogo de productos",
            "description": "Descubre nuestro catálogo de productos en arriendo. Encuentra artículos para todas tus necesidades con precios competitivos y opciones de alquiler flexibles.",
            "brand": {
                "@type": "Brand",
                "name": "Visual Rent"
            }
            }
            </script>
        <?php } ?>
    <?php } ?>
    <meta name="description" content="<?php echo htmlspecialchars($metaDescription); ?>">
    <meta name="keywords" content="arriendo audiovisual, arriendo de totem, alquiler de pantallas informativas digitales, totem publicitarios con pantalla táctil, Arriendo pendones LED, Pantallas LED para eventos corporativos, Renta de videowall LED, sistemas de audio para conferencias, equipos eventos, iluminación, sonido, pantallas LED, visual rent, eventos Chile">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Visual Rent | Arriendo de Equipos Audiovisuales para Eventos">
    <meta property="og:description" content="Transforma tu evento en una experiencia inolvidable con nuestros equipos audiovisuales de alta tecnología.">
    <meta property="og:image" content="https://visualrent.cl/img/og-image.jpg"> <!-- Imagen de 1200x630px -->
    <meta property="og:url" content="https://visualrent.cl/<?php echo $vista ?? ''; ?>">
    <meta property="og:site_name" content="Visual Rent">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Visual Rent | Arriendo de Equipos Audiovisuales para Eventos">
    <meta name="twitter:description" content="Transforma tu evento en una experiencia inolvidable con nuestros equipos audiovisuales de alta tecnología.">
    <meta name="twitter:image" content="https://visualrent.cl/img/og-image.jpg">
    <meta name="theme-color" content="#257ec0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Camilo Jimenez Na3ii">
    <meta http-equiv="Content-Language" content="es">

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "Visual Rent",
      "image": "https://visualrent.cl/img/og-image.jpg",
      "url": "https://visualrent.cl",
      "telephone": "+56 9 2051 9944",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Santiago",
        "addressCountry": "CL"
      },
      "description": "Arriendo de equipos audiovisuales: tótems digitales, pantallas y pendones LED para eventos.",
      "sameAs": [
        "https://www.instagram.com/visualrentchile",
        "https://www.facebook.com/visualrent"
      ]
    }
    </script>
    <title>Visual Rent - <?php echo isset($titulo) ? $titulo : 'Equipos Audiovisuales para Eventos'; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/build/css/app.css">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="canonical" href="https://visualrent.cl<?php echo isset($vista) ? '/' . $vista : ''; ?>" />
    <link rel="alternate" href="https://visualrent.cl" hreflang="es-cl" />
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin="" defer></script>
</head>
<body>
    <?php
        include_once __DIR__ .'/templates/header.php';
        echo $contenido;
        include_once __DIR__ .'/templates/footer.php'; 
        include_once __DIR__ .'/templates/whatsapp.php';
    ?>
    
    <script src="/build/js/bundle.min.js" defer></script>
</body>
</html>