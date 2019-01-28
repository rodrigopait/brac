<?php

class PurchaseRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function purchaseAdd($usuarioId) {
        $configuration=ConfigurationRepository::getInstance()->listConf();

        $total = 0;
        if (!empty($_SESSION['carrito']['vuelos']['directos'])) {
            foreach ($_SESSION['carrito']['vuelos']['directos'] as $key => $value) {
                $clase=$_SESSION['carrito']['directos']['datos'][$key]['tipo'];
                if ($clase == 'capacidad_economica') {
                    $suma=0;
                }
                elseif ($clase == 'capacidad_ejecutiva') {
                    $suma=$configuration->getPrecioEjecutiva();
                }
                else{
                    $suma=$configuration->getPrecioPrimera();
                }
                $preciosDirectos[]=$suma;

            }

            foreach ($_SESSION['carrito']['vuelos']['directos'] as $key => $flightId) {
                $precioVuelo = $this->queryList("SELECT precio FROM vuelo WHERE id = ?", array($flightId));
                $pasajeros=$_SESSION['carrito']['directos']['datos'][$key]['pasajeros'];
                foreach ($precioVuelo[0] as $row) {
                    $total += (($row['precio'] * $pasajeros) + $preciosDirectos[$key]) ;
                    $preciosDirectos[$key]+= $row['precio'];
                }
                
            }
        }

        if (!empty($_SESSION['carrito']['vuelos']['escalas'])) {
            foreach ($_SESSION['carrito']['vuelos']['escalas'] as $key => $value) {
                $clase=$_SESSION['carrito']['escalas']['datos'][$key]['tipo'];
                if ($clase == 'capacidad_economica') {
                    $suma=0;
                }
                elseif ($clase == 'capacidad_ejecutiva') {
                    $suma=$configuration->getPrecioEjecutiva();
                }
                else{
                    $suma=$configuration->getPrecioPrimera();
                }
                $preciosEscalas[]=$suma;

            }
            foreach ($_SESSION['carrito']['vuelos']['escalas'] as $key => $flightId) {
                $idEscala=explode('v',$flightId);
                foreach ($idEscala as $value) {
                    $precioVueloEscala = FlightRepository::getInstance()->queryList("SELECT precio FROM vuelo WHERE id = ?", array($value));
                    $pasajeros=$_SESSION['carrito']['escalas']['datos'][$key]['pasajeros'];
                    foreach ($precioVueloEscala[0] as $row) {
                        $preciosEscalas[$key] += $row['precio'];
                        $total +=(($row['precio'] * $pasajeros) + $preciosEscalas[$key]);
                    }
                    
                }

            }
        }


        foreach ($_SESSION['carrito']['rooms'] as $roomId) {
            $precioHabitacion = RoomRepository::getInstance()->queryList("SELECT precio FROM habitacion WHERE id = ?", array($roomId));
            foreach ($precioHabitacion[0] as $row) {
                $total += $row['precio'];
            }
        }

        foreach ($_SESSION['carrito']['cars'] as $carId) {
            $precioAuto = CarRepository::getInstance()->queryList("SELECT precio FROM auto WHERE id = ?", array($carId));
            foreach ($precioAuto[0] as $row) {
                $total += $row['precio'];
            }
        }



        //REGISTRO LA COMPRA
        $fecha_actual=date('Y-m-d H:i:s');
        $query = $this->queryList("INSERT INTO compra (fecha, total, usuario_id) VALUES (?,?,?)", array($fecha_actual, $total, $usuarioId));
        $compra_id = $query[1];


        //REGISTRO LOS VUELOS DIRECTOS DE LA COMPRA 
        if (!empty($_SESSION['carrito']['vuelos']['directos'])) {
            foreach ($_SESSION['carrito']['vuelos']['directos'] as $flightId) {
                $key = array_search($flightId, $_SESSION['carrito']['vuelos']['directos']);
                $clase=$_SESSION['carrito']['directos']['datos'][$key]['tipo'];
                $pasajeros=$_SESSION['carrito']['directos']['datos'][$key]['pasajeros'];
                $clase_vuelo= explode('_',$clase);
                $this->queryList("INSERT INTO vuelo_compra (vuelo,pasajeros,clase_vuelo,precio_vuelo,compra_id) VALUES (?,?,?,?,?)", array($flightId, $pasajeros,$clase_vuelo[1],$preciosDirectos[$key],$compra_id));
                $this->queryList("UPDATE vuelo SET $clase = $clase - ? WHERE id = ?", array($pasajeros,$flightId));
            }
        }

        //REGISTRO LOS VUELOS ESCALAS DE LA COMPRA 
        if (!empty($_SESSION['carrito']['vuelos']['escalas'])) {

            foreach ($_SESSION['carrito']['vuelos']['escalas'] as $key => $flightId) {
                $clase=$_SESSION['carrito']['escalas']['datos'][$key]['tipo'];
                $pasajeros=$_SESSION['carrito']['escalas']['datos'][$key]['pasajeros'];
                $clase_vuelo= explode('_',$clase);
                $this->queryList("INSERT INTO vuelo_compra (vuelo,pasajeros,clase_vuelo,precio_vuelo,compra_id) VALUES (?,?,?,?,?)", array($flightId,$pasajeros,$clase_vuelo[1],$preciosEscalas[$key],$compra_id));
                $idVuelo=explode('v',$flightId);
                foreach ($idVuelo as $value) {
                    $this->queryList("UPDATE vuelo SET $clase = $clase - ? WHERE id = ?", array($pasajeros, $value));
                }
            }
        }


        //REGISTRO LAS HABITACIONES
        if (!empty($_SESSION['carrito']['rooms'])) {
            foreach ($_SESSION['carrito']['rooms'] as $key => $roomId) {
                $this->queryList("INSERT INTO habitacion_alquiler (desde, hasta, id_habitacion, compra_id) VALUES (?,?,?,?)", array($_SESSION['carrito']['roomsFechaDesde'][$key], $_SESSION['carrito']['roomsFechaHasta'][$key], $roomId, $compra_id));
            }
        }

        //REGISTRO LOS AUTOS
        if (!empty($_SESSION['carrito']['cars'])) {
            foreach ($_SESSION['carrito']['cars'] as $key => $carId) {
                $key = array_search($carId, $_SESSION['carrito']['cars']);
                $this->queryList("INSERT INTO auto_alquiler (desde, hasta, id_auto, compra_id) VALUES (?,?,?,?)", array($_SESSION['carrito']['carsFechaDesde'][$key], $_SESSION['carrito']['carsFechaHasta'][$key], $carId, $compra_id));
            }
        }


    }

    public function userPurchases($usuarioId) {
        $compras=null;
        $query = $this->queryList("SELECT * FROM compra WHERE usuario_id = ?", array($usuarioId));
        foreach ($query[0] as $row) {
            $compra = new Purchase($row['id'], $row['fecha'], $row['total'], $row['usuario_id']);
            $compras[] = $compra;
        }
        return $compras;
    }

    public function userPurchasesCurrents($userId)
    {
        $compras=null;
        $date=date('Y-m-d');
        $query = $this->queryList("SELECT * FROM compra WHERE usuario_id = ? AND fecha >= ?", array($userId, $date));
        foreach ($query[0] as $row) {
            $compra = new Purchase($row['id'], $row['fecha'], $row['total'], $row['usuario_id']);
            $compras[] = $compra;
        }
        return $compras;
    }

    public function userPurchasesNotCurrents($userId)
    {
        $compras=null;
        $date=date('Y-m-d');
        $query = $this->queryList("SELECT * FROM compra WHERE usuario_id = ? AND fecha < ?", array($userId, $date));
        foreach ($query[0] as $row) {
            $compra = new Purchase($row['id'], $row['fecha'], $row['total'], $row['usuario_id']);
            $compras[] = $compra;
        }
        return $compras;
    }



    public function userPurchasesDetail($compraId) {
        $compras=null;
        $misDirectos=array();
        $misEscalas=array();
        $query = $this->queryList("SELECT * FROM vuelo_compra WHERE compra_id = ? AND cancelado IS NULL", array($compraId));
        foreach ($query[0] as $row) {
            $escalas=strpos($row['vuelo'],'v');
            if ($escalas === false) {    
                $query2 = $this->queryList("SELECT * FROM vuelo WHERE id = ?",array($row['vuelo']));
                foreach ($query2[0] as $row2) {
                    $vuelo= new stdClass();
                    $vuelo->id=$row['vuelo'];
                    $vuelo->vueloCompraVuelo = $row['vuelo'];
                    $vuelo->pasajerosCompraVuelo = $row['pasajeros'];    
                    $vuelo->claseCompraVuelo = $row['clase_vuelo'];
                    $vuelo->precioCompraVuelo = number_format($row['precio_vuelo'] * $row['pasajeros'],0,',','.');
                    $vuelo->origen = $row2['ciudad_origen'];
                    $vuelo->destino = $row2['ciudad_destino'];
                    $vuelo->fechaSalida = $row2['fecha_salida'];
                    $vuelo->fechaLlegada = $row2['fecha_llegada'];

                    $misDirectos[]=$vuelo;
                }
            }
            else{
                $vuelosEscalas=explode('v',$row['vuelo']);
                $arrayEscalas=[]; 
                foreach ($vuelosEscalas as $key => $value) {
                   $query2 = $this->queryList("SELECT *
                                               FROM vuelo 
                                               WHERE id = ?",
                                               array($value));

                   foreach ($query2[0] as $row2) {
                       $vuelo= new stdClass();
                       $vuelo->vueloCompraVuelo = $row['vuelo'];
                       $vuelo->pasajerosCompraVuelo = $row['pasajeros'];    
                       $vuelo->claseCompraVuelo = $row['clase_vuelo'];
                       $vuelo->precioCompraVuelo =$row['precio_vuelo'] * $row['pasajeros'];
                       $vuelo->origen = $row2['ciudad_origen'];
                       $vuelo->destino = $row2['ciudad_destino'];
                       $vuelo->fechaSalida = $row2['fecha_salida'];
                       $vuelo->fechaLlegada = $row2['fecha_llegada'];
           
                   }
                   $arrayEscalas[]= $vuelo;
                }

                $misEscalas[]=$arrayEscalas;

            }

        }
        $compras['vuelos']['directos']=$misDirectos;
        $compras['vuelos']['escalas']=$misEscalas;

        /*DETALLE DE HABITAACIONES*/
       $rooms=array();
        $query3 = $this->queryList("SELECT id_habitacion, desde, hasta FROM habitacion_alquiler WHERE compra_id = ? and cancelado IS NULL", array($compraId));
        foreach ($query3[0] as $row3) {  
            $query4 = $this->queryList("SELECT h.precio precio, ho.nombre hotel, p.nombre pais, c.nombre ciudad, h.capacidad
                                        FROM habitacion as h 
                                             INNER JOIN hotel as ho ON(h.hotel_id = ho.id)
                                             INNER JOIN ciudad as c on(ho.ciudad_id=c.id)
                                             INNER JOIN pais as p on(c.pais_id = p.id)
                                        WHERE h.id = ?", array($row3['id_habitacion']));
            $fechaDesde = $row3['desde'];
            $fechaHasta = $row3['hasta'];
            foreach ($query4[0] as $row4) {
                $room = new stdClass();
                $room->id = $row3['id_habitacion']; 
                $room->desde=$fechaDesde;
                $room->hasta=$fechaHasta;
                $room->precio=$row4['precio'];
                $room->hotel=$row4['hotel'];
                $room->capacidad=$row4['capacidad'];
                $room->pais=utf8_encode($row4['pais']);
                $room->ciudad=utf8_encode($row4['ciudad']);
                $rooms[]=$room;
            }
        }
        $compras['rooms']=$rooms;



        $cars=null;
        $query5 = $this->queryList("SELECT id_auto, desde, hasta FROM auto_alquiler WHERE compra_id = ? and cancelado IS NULL", array($compraId));
        foreach ($query5[0] as $row5) {
            $query6 = $this->queryList("SELECT a.precio, m.descripcion, c.nombre as ciudad, p.nombre as pais, a.capacidad, ma.descripcion as marca 
                                        FROM  auto as a INNER JOIN modelo m ON(a.modelo_id = m.id)
                                                        INNER JOIN marca  ma ON(m.marca_id = ma.id)
                                                        INNER JOIN ciudad c ON(a.ciudad_id = c.id)
                                                        INNER JOIN pais p ON(c.pais_id = p.id)  
                                        WHERE a.id = ?", array($row5['id_auto'])); 
            $fechaDesde = $row5['desde'];
            $fechaHasta = $row5['hasta'];
            foreach ($query6[0] as $row6) {
                $car = new stdClass();
                $car->id= $row5['id_auto'];
                $car->desde=$fechaDesde;
                $car->hasta=$fechaHasta;
                $car->precio=$row6['precio'];
                $car->modelo=utf8_encode($row6['descripcion']);
                $car->marca=utf8_encode($row6['marca']);
                $car->pais=utf8_encode($row6['pais']);
                $car->ciudad=utf8_encode($row6['ciudad']);
                $car->capacidad=($row6['capacidad']);        
                $cars[]=$car;
            }
        }
        $compras['cars']=$cars;
        return $compras;
    }

    public function userPurchasesClosed($compraId) {
        $compras=null;
        $misDirectos=array();
        $misEscalas=array();
        $query = $this->queryList("SELECT * FROM vuelo_compra WHERE compra_id = ? AND cancelado IS NOT NULL", array($compraId));
        foreach ($query[0] as $row) {
            $escalas=strpos($row['vuelo'],'v');
            if ($escalas === false) {    
                $query2 = $this->queryList("SELECT * FROM vuelo WHERE id = ?",array($row['vuelo']));
                foreach ($query2[0] as $row2) {
                    $vuelo= new stdClass();
                    $vuelo->id=$row['vuelo'];
                    $vuelo->vueloCompraVuelo = $row['vuelo'];
                    $vuelo->pasajerosCompraVuelo = $row['pasajeros'];    
                    $vuelo->claseCompraVuelo = $row['clase_vuelo'];
                    $vuelo->precioCompraVuelo = number_format($row['precio_vuelo'] * $row['pasajeros'],0,',','.');
                    $vuelo->origen = $row2['ciudad_origen'];
                    $vuelo->destino = $row2['ciudad_destino'];
                    $vuelo->fechaSalida = $row2['fecha_salida'];
                    $vuelo->fechaLlegada = $row2['fecha_llegada'];

                    $misDirectos[]=$vuelo;
                }
            }
            else{
                $vuelosEscalas=explode('v',$row['vuelo']);
                $arrayEscalas=[]; 
                foreach ($vuelosEscalas as $key => $value) {
                   $query2 = $this->queryList("SELECT *
                                               FROM vuelo 
                                               WHERE id = ?",
                                               array($value));

                   foreach ($query2[0] as $row2) {
                       $vuelo= new stdClass();
                       $vuelo->vueloCompraVuelo = $row['vuelo'];
                       $vuelo->pasajerosCompraVuelo = $row['pasajeros'];    
                       $vuelo->claseCompraVuelo = $row['clase_vuelo'];
                       $vuelo->precioCompraVuelo =number_format($row['precio_vuelo'] * $row['pasajeros'],0,',','.');
                       $vuelo->origen = $row2['ciudad_origen'];
                       $vuelo->destino = $row2['ciudad_destino'];
                       $vuelo->fechaSalida = $row2['fecha_salida'];
                       $vuelo->fechaLlegada = $row2['fecha_llegada'];
           
                   }
                   $arrayEscalas[]= $vuelo;
                }

                $misEscalas[]=$arrayEscalas;

            }

        }
        $compras['vuelos']['directos']=$misDirectos;
        $compras['vuelos']['escalas']=$misEscalas;

        /*DETALLE DE HABITAACIONES*/
       $rooms=array();
        $query3 = $this->queryList("SELECT id_habitacion, desde, hasta FROM habitacion_alquiler WHERE compra_id = ? and cancelado IS NOT NULL", array($compraId));
        foreach ($query3[0] as $row3) {  
            $query4 = $this->queryList("SELECT h.precio precio, ho.nombre hotel, p.nombre pais, c.nombre ciudad, h.capacidad
                                        FROM habitacion as h 
                                             INNER JOIN hotel as ho ON(h.hotel_id = ho.id)
                                             INNER JOIN ciudad as c on(ho.ciudad_id=c.id)
                                             INNER JOIN pais as p on(c.pais_id = p.id)
                                        WHERE h.id = ?", array($row3['id_habitacion']));
            $fechaDesde = $row3['desde'];
            $fechaHasta = $row3['hasta'];
            foreach ($query4[0] as $row4) {
                $room = new stdClass();
                $room->id = $row3['id_habitacion']; 
                $room->desde=$fechaDesde;
                $room->hasta=$fechaHasta;
                $room->precio=$row4['precio'];
                $room->hotel=$row4['hotel'];
                $room->capacidad=$row4['capacidad'];
                $room->pais=utf8_encode($row4['pais']);
                $room->ciudad=utf8_encode($row4['ciudad']);
                $rooms[]=$room;
            }
        }
        $compras['rooms']=$rooms;



        $cars=null;
        $query5 = $this->queryList("SELECT id_auto, desde, hasta FROM auto_alquiler WHERE compra_id = ? and cancelado IS NOT NULL", array($compraId));
        foreach ($query5[0] as $row5) {
            $query6 = $this->queryList("SELECT a.precio, m.descripcion, c.nombre as ciudad, p.nombre as pais, a.capacidad, ma.descripcion as marca 
                                        FROM  auto as a INNER JOIN modelo m ON(a.modelo_id = m.id)
                                                        INNER JOIN marca  ma ON(m.marca_id = ma.id)
                                                        INNER JOIN ciudad c ON(a.ciudad_id = c.id)
                                                        INNER JOIN pais p ON(c.pais_id = p.id)  
                                        WHERE a.id = ?", array($row5['id_auto'])); 
            $fechaDesde = $row5['desde'];
            $fechaHasta = $row5['hasta'];
            foreach ($query6[0] as $row6) {
                $car = new stdClass();
                $car->id= $row5['id_auto'];
                $car->desde=$fechaDesde;
                $car->hasta=$fechaHasta;
                $car->precio=$row6['precio'];
                $car->modelo=utf8_encode($row6['descripcion']);
                $car->marca=utf8_encode($row6['marca']);
                $car->pais=utf8_encode($row6['pais']);
                $car->ciudad=utf8_encode($row6['ciudad']);
                $car->capacidad=($row6['capacidad']);        
                $cars[]=$car;
            }
        }
        $compras['cars']=$cars;
        return $compras;
    }





    public function purchaseById($purchaseId) {
        $compras=null;
        $query = $this->queryList("SELECT * FROM compra WHERE id = ?", array($purchaseId));
        foreach ($query[0] as $row) {
            $compra = new Purchase($row['id'], $row['fecha'], $row['total'], $row['usuario_id']);
            $compras[] = $compra;
        }
        return $compras;
    }

    public function deletePurchaseRoom($roomId,$compraId,$precio)
    {   

        $configuration=ConfigurationRepository::getInstance()->listConf();
        $porcentaje =(($precio * $configuration->getPorcentajeDevolucion()) / 100);

        $query = $this->queryList("UPDATE habitacion_alquiler
                                   SET cancelado = 1 
                                   WHERE id_habitacion=? and compra_id=?", 
                                          array($roomId,$compraId));

        $query2 = $this->queryList("UPDATE  compra SET total= total - ? 
                                                   WHERE id=?", array($precio,$compraId));

    }

    public function deletePurchaseCar($carId,$compraId,$precio){
        $configuration=ConfigurationRepository::getInstance()->listConf();
        $precio = (($precio * $configuration->getPorcentajeDevolucion())/100) - $precio;
       $query = $this->queryList("UPDATE auto_alquiler
                                  SET cancelado = 1 
                                  WHERE id_auto=? and compra_id=?", 
                                         array($carId,$compraId));
       
       $query2 = $this->queryList("UPDATE  compra SET total - ? 
                                                  WHERE id= ?", array($precio,$compraId));
    }

    public function deletePurchaseFlight($flightId,$compraId,$precio){
        $configuration=ConfigurationRepository::getInstance()->listConf();
        $precio = (($precio * $configuration->getPorcentajeDevolucion())/100) - $precio;
        $query = $this->queryList("UPDATE vuelo_compra
                                   SET cancelado = 1
                                   WHERE vuelo=? and compra_id=?", 
                                          array($flightId,$compraId));

        $query2 = $this->queryList("UPDATE  compra SET total - ? 
                                                   WHERE id=?", array($precio,$compraId));

    }
}
?>