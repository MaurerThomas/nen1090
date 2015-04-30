<?php
include('password.php');

class User extends Password
{

    private $_db;

    function __construct($db)
    {
        parent::__construct();

        $this->_db = $db;
    }

    private function get_user_hash($email)
    {

        try {
            $stmt = $this->_db->prepare('SELECT password FROM members WHERE email = :email AND active="Yes" ');
            $stmt->execute(array('email' => $email));

            $row = $stmt->fetch();
            return $row['password'];

        } catch (PDOException $e) {
            echo '<p class="bg-danger">' . $e->getMessage() . '</p>';
        }
    }

    public function get_id_from_email($email)
    {

        try {
            $stmt = $this->_db->prepare('SELECT bedrijfsid FROM members WHERE email = :email AND active="Yes" ');
            $stmt->execute(array('email' => $email));

            $row = $stmt->fetch();
            return $row['bedrijfsid'];

        } catch (PDOException $e) {
            echo '<p class="bg-danger">' . $e->getMessage() . '</p>';
        }

    }

    public function getRoleFromDb($email)
    {
        try {
            $stmt = $this->_db->prepare('SELECT email, user_type FROM members WHERE email = :email AND active="Yes" ');
            $stmt->execute(array('email' => $email));

            $row = $stmt->fetch();

            return $row['user_type'];

        } catch (PDOException $e) {
            echo '<p class="bg-danger">' . $e->getMessage() . '</p>';
        }

    }

    public function login($email, $password)
    {

        $hashed = $this->get_user_hash($email);


        if ($this->password_verify($password, $hashed) == 1) {

            $_SESSION['loggedin'] = true;
            return true;
        }
    }

    public function logout()
    {
        session_destroy();
    }

    public function is_logged_in()
    {
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            return true;
        }
    }

}


