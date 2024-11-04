<?php
class Reserva {
    private $id;
    private $fechaInicio;
    private $fechaFin;
    private $usuario_id;
    private $vehiculo_id;

    // Constructor
    public function __construct($fechaInicio, $fechaFin, $usuario_id, $vehiculo_id) {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->usuario_id = $usuario_id;
        $this->vehiculo_id = $vehiculo_id;
    }

    // Getters y setters
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
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * @param mixed $fechaInicio
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;
    }

    /**
     * @return mixed
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    /**
     * @param mixed $fechaFin
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;
    }

    /**
     * @return mixed
     */
    public function getUsuarioId()
    {
        return $this->usuario_id;
    }

    /**
     * @param mixed $usuario_id
     */
    public function setUsuarioId($usuario_id)
    {
        $this->usuario_id = $usuario_id;
    }

    /**
     * @return mixed
     */
    public function getVehiculoId()
    {
        return $this->vehiculo_id;
    }

    /**
     * @param mixed $vehiculo_id
     */
    public function setVehiculoId($vehiculo_id)
    {
        $this->vehiculo_id = $vehiculo_id;
    }

    // Getters y setters

}
?>
