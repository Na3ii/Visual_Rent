<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-6CYHYNH3C3"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-6CYHYNH3C3');
    </script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-17167237777">
    </script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'AW-17167237777');
    </script>
    <!-- Google tag (gtag.js) event -->
    <script>
    gtag('event', 'form_submit', {
        // <event_parameters>
    });
    </script>

    <meta name="google-site-verification" content="2c9p05aniqD4mjmzRfxaaArmLNxD1FPqMyCSj61dx1A" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <script id="cookieyes" type="text/javascript" src="https://cdn-cookieyes.com/client_data/c80734bea6f55a41cc95ef08/script.js"></script>
    <?php if (!empty($jsonLD)): ?>
    <script type="application/ld+json">
        <?= json_encode($jsonLD, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
    </script>
    <?php endif; ?>
    <meta name="description" content="<?php echo htmlspecialchars($metaDescription); ?>">
    <meta name="keywords" content="arriendo audiovisual, arriendo de totem, alquiler de pantallas informativas digitales, totem publicitarios con pantalla táctil, Arriendo pendones LED, Pantallas LED para eventos corporativos, Renta de videowall LED, sistemas de audio para conferencias, equipos eventos, iluminación, sonido, pantallas LED, visual rent, eventos Chile">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo htmlspecialchars($ogTitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($ogDescription); ?>">
    <meta property="og:image" content="https://visualrent.cl/img/og-image.jpg"> <!-- Imagen de 1200x630px -->
    <meta property="og:url" content="https://visualrent.cl/<?php echo $vista ?? ''; ?>">
    <meta property="og:site_name" content="Visual Rent">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($ogTitle); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($ogDescription); ?>">
    <meta name="twitter:image" content="https://visualrent.cl/img/og-image.jpg">
    <meta name="theme-color" content="#257ec0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Camilo Jimenez Na3ii">
    <meta http-equiv="Content-Language" content="es">
    <title>Visual Rent - <?php echo isset($titulo) ? $titulo : 'Equipos Audiovisuales para Eventos'; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/build/css/app.css">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <?php if (isset($url_canonica) && $url_canonica) { ?>
        <link rel="canonical" href="<?= htmlspecialchars($url_canonica); ?>" />
    <?php } else { ?>
        <link rel="canonical" href="https://visualrent.cl<?= isset($vista) ? '/' . $vista : ''; ?>" />
    <?php } ?>
    <link rel="alternate" href="https://visualrent.cl" hreflang="es-cl" />
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin="" defer></script>
    
    <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-PW9XNVXM');</script>
    <!-- End Google Tag Manager -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const whatsappButton = document.querySelector('.whatsapp-button');
            if (whatsappButton) {
                whatsappButton.addEventListener('click', function() {
                    gtag('event', 'click', {
                        'event_category': 'WhatsApp',
                        'event_label': 'Botón de WhatsApp'
                    });
                });
            }
        });
    </script>
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PW9XNVXM"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php
        include_once __DIR__ .'/templates/header.php';
        echo $contenido;
        include_once __DIR__ .'/templates/footer.php'; 
        include_once __DIR__ .'/templates/whatsapp.php';
    ?>
    
    <script src="/build/js/bundle.min.js" defer></script>
</body>
</html>