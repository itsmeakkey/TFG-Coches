<?php

require_once "config.php";
class BaseDeDatosConexion {
    private static $instancia;

    private function __construct($nombreBD){

    }

    private function __clone(){}

    public static function getConexion ($nombreBD) {
        if (self::$instancia==null){
            try {
                $opcion = SGBD.":hosts=". SERVIDOR.";dbname=". $nombreBD;
                self::$instancia = new PDO($opcion, USERBD, PASSWORDDB);
            }catch (PDOException $e){
                self::$instancia=null;
            }
        }
        return self::$instancia;
    }

    public static function mostrarTabla ($resultado){
        echo "<table border='1'>";
        $i=0;
        while ($fi = $resultado ->fetch(PDO::FETCH_ASSOC)){
            if ($i==0){
                foreach ($fi as $clave => $valor){
                    echo "<th>$clave</th>";
                }
            }
            echo "<tr>";
            foreach ($fi as $v){
                echo "<td>$v</td>";
            }
            echo "</tr>";
            $i++;
        }
        echo "</table>";
    }

    public static function cerrarConexion(){
        self::$instancia=null; //Con esto se cierra
        //Si no llamamos a esto, se cerrara la sesion igualmente cuando se cierre el script
    }
}