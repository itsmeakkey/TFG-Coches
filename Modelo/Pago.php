<?php
class Pago {
    private $id;
    private $fecha;
    private $monto;
    private $id_plan_pagos;

    // Constructor
    public function __construct($fecha, $monto, $id_plan_pagos) {
        $this->fecha = $fecha;
        $this->monto = $monto;
        $this->id_plan_pagos = $id_plan_pagos;
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
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * @param mixed $monto
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;
    }

    /**
     * @return mixed
     */
    public function getIdPlanPagos()
    {
        return $this->id_plan_pagos;
    }

    /**
     * @param mixed $id_plan_pagos
     */
    public function setIdPlanPagos($id_plan_pagos)
    {
        $this->id_plan_pagos = $id_plan_pagos;
    }

    // Getters y setters

}
?>
