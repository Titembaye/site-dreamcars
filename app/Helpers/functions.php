<?php

function convertirEnLettres($nombre) {
    $unites = array('zero', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf');
    $dizaines = array('', '', 'vingt', 'trente', 'quarante', 'cinquante', 'soixante', 'soixante-dix', 'quatre-vingt', 'quatre-vingt-dix');

    if ($nombre < 0 || $nombre >= 1000000000) {
        return "Nombre non pris en charge";
    }

    if ($nombre < 10) {
        return $unites[$nombre];
    } elseif ($nombre < 20) {
        return 'dix-' . $unites[$nombre - 10];
    } elseif ($nombre < 100) {
        $dizaine = $dizaines[(int)($nombre / 10)];
        $unite = $nombre % 10;
        return ($unite == 0) ? $dizaine : $dizaine . '-' . $unites[$unite];
    } elseif ($nombre < 1000) {
        $centaine = $unites[(int)($nombre / 100)] . ' cent';
        $reste = $nombre % 100;
        return ($reste == 0) ? $centaine : $centaine . ' ' . convertirEnLettres($reste);
    } elseif ($nombre < 1000000) {
        $millier = convertirEnLettres((int)($nombre / 1000)) . ' mille';
        $reste = $nombre % 1000;
        return ($reste == 0) ? $millier : $millier . ' ' . convertirEnLettres($reste);
    } else {
        $million = convertirEnLettres((int)($nombre / 1000000)) . ' millions';
        $reste = $nombre % 1000000;
        return ($reste == 0) ? $million : $million . ' ' . convertirEnLettres($reste);
    }
}

?>
