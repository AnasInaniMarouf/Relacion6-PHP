<?php

/**
 * Clase MuebleReciclado que hereda de MuebleBase, y de la cual
 * no se pueden crear subclases
 */
final class MuebleReciclado extends MuebleBase{

    private int $_porcentajeReciclado = 10;

    public function __construct(string $nombre, string $fabricante = "FaMu:", string $pais = "ESPAÑA", int $anio = 2020, string $fechaIniVenta = "01/01/2020", string|DateTime $fechaFinVenta = "31/12/2040", float $precio = 30, int $porcentajeReciclado = 10) {
        $this -> setPorcentajeReciclado($porcentajeReciclado);

        parent::__construct($nombre, $fabricante, $pais, $anio, $fechaIniVenta, $fechaFinVenta, $precio);
    }

    function damePropiedadesAdicionales(): array {
        return [$this -> _porcentajeReciclado];
    }

    public function __toString(): string {
        return parent::__toString() . ", porcentaje reciclado: " . $this -> _porcentajeReciclado . "%";
    }

    /*Getters y Setters*/
    public function getPorcentajeReciclado(): int {
        return $this -> _porcentajeReciclado;
    }

    public function setPorcentajeReciclado(int $porcentaje): bool {
        if($porcentaje > 0 && $porcentaje < 100) return false;

        $this -> _porcentajeReciclado = $porcentaje;
        return true;
    }
}