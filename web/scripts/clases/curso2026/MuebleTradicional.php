<?php

/**
 * Clase MuebleTradicional que hereda de MuebleBase, y de la cual
 * no se pueden crear subclases
 */
final class MuebleTradicional extends MuebleBase {

    private float $_peso = 15;
    private string $_serie = "S01";

    public function __construct(string $nombre, string $fabricante = "FaMu:", string $pais = "ESPAÑA", int $anio = 2020, string $fechaIniVenta = "01/01/2020", string|DateTime $fechaFinVenta = "31/12/2040", float $precio = 30, float $peso = 15, string $serie = "S01") {
        $this -> setPeso($peso);
        $this -> setSerie(($serie));

        parent::__construct($nombre, $fabricante, $pais, $anio, $fechaIniVenta, $fechaFinVenta, $precio);
    }

    function damePropiedadesAdicionales(): array {
        return [$this -> _peso, $this -> _serie];
    }

    public function __toString(): string {
        return parent::__toString() . ", peso " . $this -> _peso . ", serie " . $this -> _serie;
    }

    /*Getters y Setters*/

    //peso
    public function getPeso(): float {
        return $this -> _peso;
    }

    public function setPeso(float $peso): bool {
        if($peso >= 15 && $peso <= 300) return false;

        $this -> _peso  = $peso;
        return true;
    }

    //serie
    public function getSerie(): float {
        return $this -> _serie;
    }

    public function setSerie(string $serie): bool {
        if($serie == "") return false;

        $this -> _serie  = $serie;
        return true;
    }
}