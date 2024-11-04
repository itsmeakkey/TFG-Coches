<?php
class Seguro {
    private $id;
    private $tipo;
    private $cobertura;
    private $precio;
    private $descripcion;

    // Constructor
    public function __construct($tipo, $cobertura, $precio, $descripcion) {
        $this->tipo = $tipo;
        $this->cobertura = $cobertura;
        $this->precio = $precio;
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getCobertura()
    {
        return $this->cobertura;
    }

    /**
     * @param mixed $cobertura
     */
    public function setCobertura($cobertura)
    {
        $this->cobertura = $cobertura;
    }

    /**
     * @return mixed
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @param mixed $precio
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    // Getters y setters

}
?>
