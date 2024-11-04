<?php
class Vehiculo {
    private $id;
    private $marca;
    private $modelo;
    private $matricula;
    private $plazas;
    private $combustible;
    private $precioDia;
    private $fechaMatriculacion;
    private $estado;

    // Constructor
    public function __construct($marca, $modelo, $matricula, $plazas, $combustible, $precioDia, $fechaMatriculacion, $estado) {
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->matricula = $matricula;
        $this->plazas = $plazas;
        $this->combustible = $combustible;
        $this->precioDia = $precioDia;
        $this->fechaMatriculacion = $fechaMatriculacion;
        $this->estado = $estado;
    }

    // Getters y setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * @param mixed $marca
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    /**
     * @return mixed
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * @param mixed $modelo
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }

    /**
     * @return mixed
     */
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * @param mixed $matricula
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;
    }

    /**
     * @return mixed
     */
    public function getPlazas()
    {
        return $this->plazas;
    }

    /**
     * @param mixed $plazas
     */
    public function setPlazas($plazas)
    {
        $this->plazas = $plazas;
    }

    /**
     * @return mixed
     */
    public function getCombustible()
    {
        return $this->combustible;
    }

    /**
     * @param mixed $combustible
     */
    public function setCombustible($combustible)
    {
        $this->combustible = $combustible;
    }

    /**
     * @return mixed
     */
    public function getPrecioDia()
    {
        return $this->precioDia;
    }

    /**
     * @param mixed $precioDia
     */
    public function setPrecioDia($precioDia)
    {
        $this->precioDia = $precioDia;
    }

    /**
     * @return mixed
     */
    public function getFechaMatriculacion()
    {
        return $this->fechaMatriculacion;
    }

    /**
     * @param mixed $fechaMatriculacion
     */
    public function setFechaMatriculacion($fechaMatriculacion)
    {
        $this->fechaMatriculacion = $fechaMatriculacion;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }



}
?>

