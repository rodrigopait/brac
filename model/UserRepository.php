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

            $res = self::getInstance()->queryList("SELECT * FROM usuario WHERE usuario = ? AND clave = ?", array($username, $password));
            $user = $res[0]->fetch(PDO::FETCH_ASSOC);

            if ($user['usuario'] == 'admin'){
                $_SESSION['rol'] = 2;
                $_SESSION['usuario'] = $user['usuario'];
            }
            else {
                if(($user['usuario'] == $username) && ($user['clave'] == $password)){     
                        $_SESSION['rol'] = 1;
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
                }else{
                    $mensaje = "Tu usuario o contraseña no son correctas. Por favor vuelve a intentar.";
                    echo "<script>";
                    echo "alert('$mensaje');";
                    echo "</script>";
                }
            }    
        }else{
                $mensaje = "No se han ingresado todos los campos. Por favor vuelve a intentar.";
                echo "<script>";
                echo "alert('$mensaje');";
                echo "</script>";
        }
    }

    public function listAll() {
        $users=null;
        $query = self::getInstance()->queryList("SELECT * FROM usuario WHERE id != 0", array());
        foreach ($query[0] as $row) {
            $user = new User ( $row['id'], $row['usuario'], $row['clave'], $row['nombre'], $row['apellido'], $row['email']);
            $users[]=$user;
        }
        $query = null;
        return $users;
    }

    public function user_remove($userId) {
        $query = $this->queryList("DELETE FROM usuario WHERE id = ?", array($userId));
    }

    public function user_delete($userId) {
        $query = $this->queryList("DELETE FROM usuario WHERE id = ?", array($userId));
    }

    public function user_add($usuario, $clave, $nombre, $apellido, $email) {
        $query = $this->queryList("INSERT INTO usuario (usuario, clave, nombre, apellido, email) VALUES (?,?,?,?,?)", array($usuario, $clave, $nombre, $apellido, $email));
    }

    public function user_information($userId) {
        $user=null;
        $query = $this->queryList("SELECT * FROM usuario WHERE id = ?", array($userId));
        foreach ($query[0] as $row) {
            $user = new User ( $row['id'], $row['usuario'], $row['clave'], $row['nombre'], $row['apellido'], $row['email']);
        }
        $query = null;
        return $user;
    }

    public function user_information_modify($userId, $usuario, $clave, $nombre, $apellido, $email) {
        $this->queryList("UPDATE usuario SET usuario=?, clave=?, nombre=?, apellido=?, email=? WHERE id = ?", array($usuario, $clave, $nombre, $apellido, $email, $userId));
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

}