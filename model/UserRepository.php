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




    public function login_user() {

        $username = $_POST['username'];
        $password = $_POST['password'];

        if(!is_null($username) AND !is_null($password)){
            $array = array(
                ':username' => $username,
                ':password' => $password
            );

            $res = self::getInstance()->queryList("SELECT u.id, u.usuario,u.clave,u.nombre,u.apellido,u.dni,u.email,u.rol_id,u.nro_tarjeta,r.descripcion_rol FROM usuario u INNER JOIN rol r ON u.rol_id = r.id WHERE usuario =? AND clave = ?", array($username, $password));
            $user = $res[0]->fetch(PDO::FETCH_ASSOC);
            if(($user['usuario'] == $username) && ($user['clave'] == $password)){
                $_SESSION['rol'] = $user['descripcion_rol'];
                $_SESSION['usuario'] = $user['usuario'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['flights'][] = null;
                $_SESSION['rooms'][] = null;
                $_SESSION['roomsFechaDesde'][] = null;
                $_SESSION['roomsFechaHasta'][] = null;
                $_SESSION['cars'][] = null;
                $_SESSION['carsFechaDesde'][] = null;
                $_SESSION['carsFechaHasta'][] = null;
                $res[0] = null;
            }
            else{
                $mensaje = "Tu usuario o contraseña no son correctas. Por favor vuelve a intentar.";
                echo "<script>";
                echo "alert('$mensaje');";
                echo "</script>";
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

    public function user_add($usuario, $clave, $nombre, $apellido, $email, $tarjeta) {
        $query = $this->queryList("INSERT INTO usuario (usuario, clave, nombre, apellido, email,rol_id,nro_tarjeta) VALUES (?,?,?,?,?,?,?)", array($usuario, $clave, $nombre, $apellido, $email,1,$tarjeta));
    }

    public function user_information($userId) {
        $user=null;
        $query = $this->queryList("SELECT * FROM usuario  WHERE id = ?", array($userId));
        foreach ($query[0] as $row) {
            $user = new User ( $row['id'], $row['usuario'], $row['clave'], $row['nombre'], $row['apellido'], $row['email'], $row['nro_tarjeta'],$row['dni'] ,$row['rol_id']);
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




    public function logout_user(){
        session_destroy();
        session_start();
        $_SESSION['rol']=0;
        $_SESSION['flights'] = null;
        $_SESSION['rooms'] = null;
        $_SESSION['cars'] = null;
        $_SESSION['carsFechaDesde'][] = null;
        $_SESSION['carsFechaHasta'][] = null;
        $_SESSION['roomsFechaDesde'][] = null;
        $_SESSION['roomsFechaHasta'][] = null;
    }

<<<<<<< HEAD
}
=======
    public function userComercialAdd($data)
    {
        $query = $this->queryList("INSERT INTO usuario (usuario,clave,nombre, apellido, dni, email,rol_id) VALUES (?,?,?,?,?,?,?)",$data);
    }

}
>>>>>>> d9fe05e83f97b2e899fb8181df563807f335ba28
