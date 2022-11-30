<?php
$productos = [
    ['id' => 'pan', 'valor' => 'Pan'],
    ['id' => 'aceite', 'valor' => 'Aceite'],
    ['id' => 'platano', 'valor' => 'Plátano'],
    ['id' => 'arroz', 'valor' => 'Arroz']
];

function totalProductos(): int
{
    $numero = 0;
    if ($_SESSION) {
        foreach ($_SESSION as $cantidad) {
            (int)$numero += (int)$cantidad;
        }
    }
    return $numero;
}
