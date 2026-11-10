<?php
abstract class MuebleBase {
    const MAXIMOMUEBLES = 2;
    private static int $_mueblesCreados;

    private string $_nombre;
    private string $_fabricante = "FaMu:";
    private string $_pais = "ESPAÑA";
    private int $_anio = 2020;
    private string $_fechaIniVenta = "01/01/2020";
    private string | DateTime $_fechaFinVenta = "31/12/2040";
    private float $_precio = 30;

    public function __construct(string $nombre, string $fabricante = "FaMu:",
                                string $pais = "ESPAÑA", int $anio = 2020,
                                string $fechaIniVenta = "01/01/2020",
                                string|DateTime $fechaFinVenta = "31/12/2040",
                                float $precio = 30) {

        //cadena de máximo 40, no puede estar vacía, a mayúscula, obligatorio
        if(mb_strlen($nombre) <= 40 && $nombre != "") $this->_nombre = strtoupper($nombre);
        
        //cadena de máximo 30, por defecto ‘FaMu:’, siempre se añade al principio FaMu:
        //si no lo tiene ya - se recorta a 30 caracteres-
        if(mb_strlen($fabricante) <= 30) {
            if(substr($fabricante, 0, 4) === "FaMu:") $this->_fabricante = $fabricante;
            else $this->_fabricante = "FaMu:" . $fabricante;
        }

        //cadena, máximo 20 caracteres, por defecto ‘ESPAÑA’
        if(mb_strlen($pais) <= 20) $this->_pais = $pais;

        //entero, año de inicio de fabricación, valor entre 2020 y el año actual, por defecto 2020
        if(mb_strlen($anio) >= 2020 && $anio < intval(date("Y"))) $this->_anio = $anio;

        //cadena, fecha en la que se empieza a vender el mueble, no puede ser anterior al uno
        //de enero del Anio de inicio de fabricación, en caso de fallo se asigna “01/01/anio
        if(mb_strlen($nombre) <= 40 && $nombre != "") $this->_fechaIniVenta = $fechaIniVenta;

        //
        if(mb_strlen($nombre) <= 40 && $nombre != "") $this->_fechaFinVenta = $fechaFinVenta;

        //
        if(mb_strlen($nombre) <= 40 && $nombre != "") $this->_precio = $precio;
    }
}