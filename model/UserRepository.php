<?php

class UserRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {

    }




    public function login_user($username,$password) {

        if(!is_null($username) AND !is_null($password)){
            $array = array(
                ':usuario' => $username,
                ':clave' => $password
            );

            $res = self::getInstance()->queryList("SELECT u.id, u.usuario,u.clave,u.nombre,u.apellido,u.dni,u.email,u.rol_id,u.nro_tarjeta,r.descripcion_rol FROM usuario u INNER JOIN rol r ON u.rol_id = r.id WHERE usuario =? AND clave = ? and bloqueado != 1", array($username, $password));
            $user = $res[0]->fetch(PDO::FETCH_ASSOC);
            if(($user['usuario'] == $username) && ($user['clave'] == $password)){
                $_SESSION['rol'] = $user['descripcion_rol'];
                $_SESSION['usuario'] = $user['usuario'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['carrito']['vuelos']['directos'] =[];
                $_SESSION['carrito']['vuelos']['escalas'] =[];
                $_SESSION['carrito']['autos']=[];
                $_SESSION['carrito']['habitaciones']=[];
                $res[0] = null;
                return $user;
            }
            else{
                 
                $res = self::getInstance()->queryList("SELECT * FROM usuario where usuario = ?", array($username));
                $user = $res[0]->fetch(PDO::FETCH_ASSOC);
                
                $res = self::getInstance()->queryList("SELECT * FROM configuracion where id = 1");
                $conf = $res[0]->fetch(PDO::FETCH_ASSOC);

                if($user['cant_intentos'] + 1 >= $conf['intentos_sesion']){
                    $this->queryList("UPDATE usuario SET cant_intentos=cant_intentos + 1, bloqueado = 1  WHERE usuario = ?", array($username));

                    $mensaje = "Tu usuario fue bloqueado";
                    echo "<script>";
                    echo "alert('$mensaje');";
                    echo "</script>";
                } else {
                    $this->queryList("UPDATE usuario SET cant_intentos=cant_intentos + 1  WHERE usuario = ?", array($username));

                    $mensaje = "Tu usuario o contraseña no son correctas. Por favor vuelve a intentar.";
                    echo "<script>";
                    echo "alert('$mensaje');";
                    echo "</script>";
                }
                
            }
        }
        else{
            $mensaje = "No se han ingresado todos los campos. Por favor vuelve a intentar.";
            echo "<script>";
            echo "alert('$mensaje');";
            echo "</script>";
        }
    }

    public function listAllByRol($rol) {
        $users=null;
        $query = self::getInstance()->queryList("SELECT * FROM usuario WHERE rol_id = ? ", array($rol));
        $users['rol']=$rol;
        foreach ($query[0] as $row) {
            $user = new stdClass();
            $user->id=$row['id'];
            $user->usuario=$row['usuario'];
            $user->nombre=$row['nombre'];
            $user->clave=$row['clave'];
            $user->apellido=$row['apellido'];
            $user->email= $row['email'];
            $user->rol=$row['rol_id'];
            $user->dni=$row['dni'];
            $user->tarjeta=$row['nro_tarjeta'];
            $users['users'][]=$user;
        }
        $query = null;
        return $users;
    }

    public function user_remove($userId) {
        $query = $this->queryList("DELETE FROM usuario WHERE id = ?", array($userId));
    }
/*REPETIDO*/
    public function user_delete($userId) {
        $query = $this->queryList("DELETE FROM usuario WHERE id = ?", array($userId));
    }

    public function user_add($usuario, $clave, $nombre, $apellido, $email, $tarjeta, $pregunta, $respuesta) {
        $query = $this->queryList("INSERT INTO usuario (usuario, clave, nombre, apellido, email,rol_id,nro_tarjeta,pregunta,respuesta) VALUES (?,?,?,?,?,?,?,?,?)", array($usuario, $clave, $nombre, $apellido, $email,1,$tarjeta,$pregunta,$respuesta));
    }

    public function user_information($userId) {
        $user=null;
        $query = $this->queryList("SELECT * FROM usuario  WHERE id = ?", array($userId));
        foreach ($query[0] as $row) {
            $user = new User ( $row['id'], $row['usuario'], $row['clave'], $row['nombre'], $row['apellido'], $row['email'], $row['nro_tarjeta'],$row['dni'] ,$row['rol_id'], $row['cant_intentos'], $row['cant_intentos'], $row['pregunta'], $row['respuesta'], $row['bloqueado']);
        }
        $query = null;
        return $user;
    }

    public function user_information_modify($userId, $usuario, $clave, $nombre, $apellido, $email,$tarjeta,$dni) {
        $this->queryList("UPDATE usuario SET usuario=?, clave=?, nombre=?, apellido=?, email=? , nro_tarjeta=? , dni=? WHERE id = ?", array($usuario, $clave, $nombre, $apellido, $email, $tarjeta,$dni,$userId));
    }

    public function user_login($usuario,$clave)
    {
      $user = null;
      $query = $this->queryList("SELECT * FROM usuario WHERE usuario = ? AND clave =  ?", array($usuario,$clave));
      foreach ($query[0] as $row) {
          $user = new User ( $row['id'], $row['usuario'], $row['clave'], $row['nombre'], $row['apellido'], $row['email']);
      }
      $query = null;
      return $user;
    }
    public function user_information_by_username($username) {
        $user=null;
        $res = self::getInstance()->queryList("SELECT u.id AS id, u.usuario AS usuario, p.pregunta AS pregunta, p.id_pregunta FROM usuario u INNER JOIN preguntas p ON p.id_pregunta = u.pregunta WHERE u.usuario =?", array($username));
        $user = $res[0]->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    

     public function desbloquear($user_id, $pregunta_id, $respuesta) {
        $info=null;
        $res = self::getInstance()->queryList("SELECT * FROM usuario WHERE id =? AND respuesta = ? AND pregunta = ?", array($user_id, $respuesta, $pregunta_id));
        $info = $res[0]->fetch(PDO::FETCH_ASSOC);
        if($info != null) {
            $this->queryList("UPDATE usuario SET bloqueado = 0, cant_intentos=0 WHERE id = ?", array($user_id));
            $mensaje = "El usuario fue desbloqueado con éxito!";
            echo "<script>";
            echo "alert('$mensaje');";
            echo "</script>";
        } else {
            $mensaje = "La respuesta es incorrecta";
            echo "<script>";
            echo "alert('$mensaje');";
            echo "</script>";
        }
        return $info;
    }




    public function logout_user(){
        session_destroy();
        session_start();
        $_SESSION['rol'] = null;
        $_SESSION['usuario'] =null;
        $_SESSION['user_id'] = null;
        $_SESSION['carrito']['vuelos']['directos']=[];
        $_SESSION['carrito']['vuelos']['escalas']=[];
        $_SESSION['carrito']['autos']=[];
        $_SESSION['carrito']['habitaciones']=[];
    }

    public function userComercialAdd($data)
    {
        $query = $this->queryList("INSERT INTO usuario (usuario,clave,nombre, apellido, dni, email,rol_id) VALUES (?,?,?,?,?,?,?)",$data);
    }

}
