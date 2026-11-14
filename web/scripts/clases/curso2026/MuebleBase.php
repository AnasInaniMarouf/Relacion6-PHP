<?php
/**
 * Clase abstracta MuebleBase
 */
abstract class MuebleBase {

    private Caracteristicas $_caracteristicas;

    const MAXIMO_MUEBLES = 10;
    private static int $_mueblesCreados = 0;

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
                                float $precio = 30, Caracteristicas $caracs = new Caracteristicas()) {  //se crea el objeto caracteristicas vacio por si no se llegara a pasar

        if (self::$_mueblesCreados >= self::MAXIMO_MUEBLES) {
            throw new Exception("Máximo de muebles alcanzado");
        }

        if (!$this->setNombre($nombre)) {
            throw new Exception("Nombre no válido");
        }

        $this->setFabricante($fabricante);
        $this->setPais($pais);
        $this->setAnio($anio);
        $this->setFechaIniVenta($fechaIniVenta);
        $this->setFechaFinVenta($fechaFinVenta);
        $this->setPrecio($precio);

        $this->_caracteristicas = $caracs;

        self::$_mueblesCreados++;
    }

    /**
     * Funcion que recibe un numero determinado de valores, si es impar elimina el ultimo
     * valor, y despues añade los valores (de dos en dos) al array _caracteristicas
     */
    public function añadirCaracteristicas(mixed ...$valores): void {
        if(count($valores) % 2 != 0) {  //si no es par (o sea es impar)
            unset($valores[count($valores) - 1]);   //elimina el ultimo valor
        }

        //recorre todos los valores que se han introducido, para introducirlos en _caracteristicas
        for($i = 0; $i < count($valores); $i+=2) {
            $this -> _caracteristicas -> __set($valores[$i], $valores[$i+1]);   //añade (o modifica si existe) una caracteristica con el carac (valores[i]) y el valor (la siguiente posicion, o sea valores[i+1])
        }
    }

    /**
     * Funcion que devuelve un array con el nombre de las propiedades
     * adicionales a la clase base
     *
     * @return array
     */
    abstract public function damePropiedadesAdicionales(): array;


    /**
     * Funcion que valida si puede crear un mueble o no
     * en funcion del numero maximo de muebles
     *
     * @param integer $numero cantidad de muebles que se pueden crear, si es 0 o menos devuelve false
     * @return boolean true si se puede y false si no
     */
    public static function puedeCrear(int &$numero): bool {
        $numero = self::MAXIMO_MUEBLES - self::$_mueblesCreados;

        return ($numero > 0);
    }


    /**
     * Funcion que devuelve una cadena con las propiedades de un mueble
     *
     * @return string
     */
    public function __toString(): string {

        return "MUEBLE de clase " . get_class($this) . " con nombre " . $this -> _nombre .
            ", fabricante " . $this-> _fabricante . ", fabricado en " . $this -> _pais .
            " a partir del año " . $this -> _anio . ", vendido desde " . $this -> _fechaIniVenta .
            " hasta " . $this -> _fechaFinVenta . ", precio " . $this -> _precio .
            ". Caracteristicas: " . $this ->_caracteristicas;
    }

    /*Getters y setters */
    //nombre
    public function getNombre(): string {
        return $this->_nombre;
    }

    public function setNombre(string $nombre): bool {
        $nombre = trim($nombre);

        if ($nombre == "" || mb_strlen($nombre) > 40) {
            return false;
        }

        $this->_nombre = mb_strtoupper($nombre);
        return true;
    }

    //fabricante
    public function getFabricante(): string {
        return $this->_fabricante;
    }

    public function setFabricante(string $fabricante): void {
        $fabricante = trim($fabricante);

        if ($fabricante != "") {
            if (substr($fabricante, 0, 5) != "FaMu:") {
                $fabricante = "FaMu:" . $fabricante;
            }
            $this->_fabricante = $fabricante;

        } else {
            $this->_fabricante = "FaMu:";
        }
    }

    //pais
    public function getPais(): string {
        return $this->_pais;
    }

    public function setPais(string $pais): void {
        $pais = trim($pais);
        if($pais == "" || mb_strlen($pais) > 20) $this -> _pais = $pais;
    }

    //año (anio)
    public function getAnio(): int {
        return $this->_anio;
    }

    public function setAnio(int $anio): void {
        $this->_anio = ($anio >= 2020 && $anio <= intval(date("Y")))? $anio: 2020;
    }

    //fechaIniVenta
    public function getFechaIniVenta(): string {
        return $this->_fechaIniVenta;
    }

    public function setFechaIniVenta(string $fechaIniVenta): void {
        $fecha = DateTime::createFromFormat('d/m/Y', $fechaIniVenta);

        $esValida = $fecha && $fecha->format('d/m/Y') == $fechaIniVenta;

        $fechaMinima = DateTime::createFromFormat('!d/m/Y','01/01/' . $this->_anio);

        if ($esValida && $fecha >= $fechaMinima) {
            $this->_fechaIniVenta = $fechaIniVenta;
        } else {
            $this->_fechaIniVenta = '01/01/' . $this->_anio;
        }
    }

    //fechaFinVenta
    public function getFechaFinVenta(): string|DateTime {
        return $this->_fechaFinVenta;
    }

    public function setFechaFinVenta(string|DateTime $fechaFinVenta): bool {
        if ($fechaFinVenta instanceof DateTime) {
            $fecha = $fechaFinVenta;
        } else {
            $fecha = DateTime::createFromFormat('d/m/Y', $fechaFinVenta);   //crea una fecha a partir de un formato

            if ($fecha->format('d/m/Y') != $fechaFinVenta) {    //->format() convierte la fecha a cadena
                return false;
            }
        }

        $fechaInicio = DateTime::createFromFormat('d/m/Y', $this->_fechaIniVenta);  //iguala la fecha de inicio a la fecha de fin de venta, no sin antes convertirlo a una fecha

        if ($fecha < $fechaInicio) {
            return false;
        }

        $this->_fechaFinVenta = $fechaFinVenta;
        return true;
    }

    //precio
    public function getPrecio(): float {
        return $this->_precio;
    }

    public function setPrecio(float $precio): bool {
        if ($precio < 30) {
            return false;
        }

        $this->_precio = $precio;
        return true;
    }

    //caracteristicas
    public function getCaracteristicas(): Caracteristicas {
        return $this -> _caracteristicas;
    }

    //Deshabilitar la sobrecarga dinámica en la clase
    public function __get(string $nombre): mixed {
        throw new Exception("No existe la propiedad " . $nombre);
    }

    public function __set(string $nombre, mixed $valor): void {
        throw new Exception("No existe la propiedad " . $nombre);
    }

    public function __isset(string $nombre): bool {
        throw new Exception("No existe la propiedad " . $nombre);
    }

    public function __unset(string $nombre): void {
        throw new Exception("No existe la propiedad " . $nombre);
    }
}