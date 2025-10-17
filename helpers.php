<?php

const MAX_WIDTH  = 1280;           // px
const MAX_HEIGHT = 1280;           // px
const MAX_BYTES  = 1_000_000;      // 1 MB

/** Devuelve lista de URLs de imágenes encontradas en <img src> y en background-image:url(...) */
function extraerUrlsImagenes(string $html): array {
    $urls = [];

    // 1) <img src="...">
    $doc = new DOMDocument();
    // evita warnings por HTML incompleto
    @$doc->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);
    foreach ($doc->getElementsByTagName('img') as $img) {
        $src = $img->getAttribute('src');
        if ($src) $urls[] = trim($src);
    }

    // 2) style="background-image:url(...)"
    // busca url(...) dentro de cualquier atributo style
    $pattern = '/style\s*=\s*([\'"])(.*?)\1/i';
    if (preg_match_all($pattern, $html, $m)) {
        foreach ($m[2] as $style) {
            // extrae múltiples url(...) si las hay
            if (preg_match_all('/url\(\s*([\'"]?)(.+?)\1\s*\)/i', $style, $m2)) {
                foreach ($m2[2] as $u) $urls[] = trim($u);
            }
        }
    }

    // normaliza y deduplica
    $urls = array_values(array_unique(array_filter($urls)));
    return $urls;
}

/**
 * Intenta mapear una URL a una ruta absoluta local
 * - absoluta /ruta/archivo.png  -> $_SERVER['DOCUMENT_ROOT'] . /ruta/archivo.png
 * - relativa img/archivo.png     -> $rutahtml . img/archivo.png
 * - http(s)://mismo-host/ruta    -> DOCUMENT_ROOT . /ruta
 * Devuelve null si parece externa o no se puede resolver.
 */
function resolverRutaLocal(string $url, string $rutahtml): ?string {
    $url = html_entity_decode($url);

    // caso url(data:...) -> ignorar
    if (stripos($url, 'data:') === 0) return null;

    // si es absoluta con esquema
    if (preg_match('#^https?://#i', $url)) {
        $pu = parse_url($url);
        if (empty($pu['host']) || empty($pu['path'])) return null;

        // si es el mismo host (o no te importa y quieres forzar local) compara contra HTTP_HOST
        $sameHost = isset($_SERVER['HTTP_HOST']) && strcasecmp($pu['host'], $_SERVER['HTTP_HOST']) === 0;
        if (!$sameHost) {
            // si tu entorno usa dominios distintos pero misma máquina, puedes permitirlo aquí
            return null; // externo -> no tocar
        }
        $path = $pu['path'];
        return safeJoin($_SERVER['DOCUMENT_ROOT'] ?? '', $path);
    }

    // si empieza con "/" (absoluta en docroot)
    if (strlen($url) && $url[0] === '/') {
        return safeJoin($_SERVER['DOCUMENT_ROOT'] ?? '', $url);
    }

    // relativa a $rutahtml
    return realpath(rtrim($rutahtml, '/\\') . DIRECTORY_SEPARATOR . $url) ?: null;
}

/** Une base + path asegurando que queda dentro del directorio base (evita path traversal). */
function safeJoin(string $base, string $path): ?string {
    $base = rtrim($base, '/\\');
    $full = $base . '/' . ltrim($path, '/\\');
    $real = realpath($full);
    if (!$real) return null;
    // comprueba que real está dentro de base
    $baseReal = realpath($base);
    if ($baseReal && strpos($real, $baseReal) === 0) return $real;
    return null;
}

/** Redimensiona/recomprime si se excede límites. Sobrescribe el mismo archivo. */
function procesarImagenSiExcede(string $absPath): void {
    $info = @getimagesize($absPath);
    if (!$info) return;

    [$w, $h] = $info;
    $mime = $info['mime'] ?? '';

    // soportados
    $soportados = ['image/jpeg','image/png','image/webp'];
    if (!in_array($mime, $soportados, true)) return;

    $peso = @filesize($absPath) ?: 0;
    $excedeDim = ($w > MAX_WIDTH || $h > MAX_HEIGHT);
    $excedePeso = ($peso > MAX_BYTES);
    if (!$excedeDim && !$excedePeso) return;

    // carga
    switch ($mime) {
        case 'image/jpeg': $src = @imagecreatefromjpeg($absPath); break;
        case 'image/png' : $src = @imagecreatefrompng($absPath); break;
        case 'image/webp': $src = @imagecreatefromwebp($absPath); break;
        default: return;
    }
    if (!$src) return;

    // escala si hace falta
    if ($excedeDim) {
        $scale = min(MAX_WIDTH / $w, MAX_HEIGHT / $h);
        $scale = min($scale, 1.0);
        $nw = (int) floor($w * $scale);
        $nh = (int) floor($h * $scale);
    } else {
        $nw = $w; $nh = $h;
    }

    $dst = imagecreatetruecolor($nw, $nh);

    // manejo de alpha para png/webp
    $hasAlpha = ($mime === 'image/png' || $mime === 'image/webp');
    if ($hasAlpha) {
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
        $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
        imagefilledrectangle($dst, 0, 0, $nw, $nh, $transparent);
    } else {
        $white = imagecolorallocate($dst, 255, 255, 255);
        imagefilledrectangle($dst, 0, 0, $nw, $nh, $white);
    }

    imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);

    // guardado con compresión, intentando quedar por debajo de MAX_BYTES
    $tmp = tempnam(sys_get_temp_dir(), 'img');

    // el objetivo es sobrescribir el MISMO archivo
    $target = $absPath;

    // bucle de calidad
    // png: 0 (sin compresión) .. 9 (máxima compresión) — invertimos la lógica para bajar tamaño
    // jpg/webp: 0..100 (baja->alta)
    if ($mime === 'image/png') {
        // probamos compresión 6..9
        foreach ([6,7,8,9] as $level) {
            @imagepng($dst, $tmp, $level);
            if ((@filesize($tmp) ?: PHP_INT_MAX) <= MAX_BYTES) break;
        }
    } elseif ($mime === 'image/webp') {
        for ($q=85; $q>=50; $q-=5) {
            @imagewebp($dst, $tmp, $q);
            if ((@filesize($tmp) ?: PHP_INT_MAX) <= MAX_BYTES) break;
        }
    } else { // jpeg
        for ($q=85; $q>=50; $q-=5) {
            @imagejpeg($dst, $tmp, $q);
            if ((@filesize($tmp) ?: PHP_INT_MAX) <= MAX_BYTES) break;
        }
    }

    // reemplazo atómico
    if (is_file($tmp)) {
        // preserva permisos al reemplazar
        @chmod($tmp, @fileperms($target) ?: 0644);
        @rename($tmp, $target);
        @clearstatcache(true, $target);
    } else {
        @unlink($tmp);
    }

    imagedestroy($src);
    imagedestroy($dst);
}