<?php
class PlanPago {
    private $id;
    private $tipo;
    private $descripcion;
    private $num_cuotas;
    private $monto_total;
    private $cuota;
    private $fecha_ini;
    private $fecha_fin;
    private $metodo_pago;
    private $reserva_id;

    // Constructor
    public function __construct($tipo, $descripcion, $num_cuotas, $monto_total, $cuota, $fecha_ini, $fecha_fin, $metodo_pago, $reserva_id) {
        $this->tipo = $tipo;
        $this->descripcion = $descripcion;
        $this->num_cuotas = $num_cuotas;
        $this->monto_total = $monto_total;
        $this->cuota = $cuota;
        $this->fecha_ini = $fecha_ini;
        $this->fecha_fin = $fecha_fin;
        $this->metodo_pago = $metodo_pago;
        $this->reserva_id = $reserva_id;
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

    /**
     * @return mixed
     */
    public function getNumCuotas()
    {
        return $this->num_cuotas;
    }

    /**
     * @param mixed $num_cuotas
     */
    public function setNumCuotas($num_cuotas)
    {
        $this->num_cuotas = $num_cuotas;
    }

    /**
     * @return mixed
     */
    public function getMontoTotal()
    {
        return $this->monto_total;
    }

    /**
     * @param mixed $monto_total
     */
    public function setMontoTotal($monto_total)
    {
        $this->monto_total = $monto_total;
    }

    /**
     * @return mixed
     */
    public function getCuota()
    {
        return $this->cuota;
    }

    /**
     * @param mixed $cuota
     */
    public function setCuota($cuota)
    {
        $this->cuota = $cuota;
    }

    /**
     * @return mixed
     */
    public function getFechaIni()
    {
        return $this->fecha_ini;
    }

    /**
     * @param mixed $fecha_ini
     */
    public function setFechaIni($fecha_ini)
    {
        $this->fecha_ini = $fecha_ini;
    }

    /**
     * @return mixed
     */
    public function getFechaFin()
    {
        return $this->fecha_fin;
    }

    /**
     * @param mixed $fecha_fin
     */
    public function setFechaFin($fecha_fin)
    {
        $this->fecha_fin = $fecha_fin;
    }

    /**
     * @return mixed
     */
    public function getMetodoPago()
    {
        return $this->metodo_pago;
    }

    /**
     * @param mixed $metodo_pago
     */
    public function setMetodoPago($metodo_pago)
    {
        $this->metodo_pago = $metodo_pago;
    }

    /**
     * @return mixed
     */
    public function getReservaId()
    {
        return $this->reserva_id;
    }

    /**
     * @param mixed $reserva_id
     */
    public function setReservaId($reserva_id)
    {
        $this->reserva_id = $reserva_id;
    }

    // Getters y setters

}
?>
