<?php

require_once('./utils/phpmailer/SendEmail.php');
class UsersDao extends dao
{
    public function userExists($users)
    {
        $sql = "SELECT * FROM users WHERE username = :u";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":u", $users->getUsername());
        $sql->execute();

        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getUsersInGroup($group)
    {
        $array = array();
        $sql = "SELECT username FROM users WHERE groups LIKE :groups";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":groups", '%!' . $group . '!%');
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $list = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($list as $item) {
                $array[] = $item['username'];
            }
        }
        return $array;
    }

    public function getUid()
    {
        return $this->uid;
    }


    public function verifyLogin()
    {
        if (!empty($_SESSION['chathashlogin'])) {
            $s = $_SESSION['chathashlogin'];
            $sql = "SELECT * FROM users WHERE loginhash = :hash";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(":hash", $s);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $data = $sql->fetch();
                $this->uid = $data['id'];
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function emailExists($users)
    {

        $sql = "SELECT * FROM users WHERE email = :e";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":e", $users->getEmail());
        $sql->execute();

        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function registerUser($users)
    {
        $newpass = password_hash($users->getPass(), PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, username, pass, created_at) VALUES (:n, :e, :u, :p, :c)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":n", $users->getName());
        $sql->bindValue(":e", $users->getEmail());
        $sql->bindValue(":u", $users->getUsername());
        $sql->bindValue(":p", $newpass);
        $sql->bindValue(":c", $users->getCreatedAt());
        $sql->execute();
    }

    public function recoveryPassword($users)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":email", $users->getEmail());
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch();

            $users->setId($sql['id']);
            $users->setEmail($sql['email']);
            $token = md5(time() . rand(0, 99999) . rand(0, 99999));
            $sql = "INSERT INTO user_token (id_user, ut_hash) VALUES (:id_user, :ut_hash);";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(":id_user", $users->getId());
            $sql->bindValue(":ut_hash", $token);
            $sql->execute();
            $mail = new SendEmail();
            $link = BASE_URL . 'login/resetpass?token=' . $token;
            $body = "<strong>Clique no link para redefinir sua senha</strong>:<br/>
                <a href='" . $link . "'>Alterar senha</a> <br> <br>
                Equipe SysChat!   
            ";
            $subject = "SysCHAT - Alterar senha";

            $mail->sendMail($users->getEmail(), $subject, $body);

            exit;
        }
    }

    public function updateGroups($groups)
    {
        $groupstring = '';
        if (count($groups) > 0) {
            $groupstring = '!' . implode('!', $groups) . '!';
        }

        $sql = "UPDATE users SET last_update = NOW(), groups = :groups WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':groups', $groupstring);
        $sql->bindValue(':id', $this->uid);
        $sql->execute();
    }

    //bug
    public function clearGroups()
    {
        $sql = "UPDATE users SET groups = '' WHERE last_update < DATE_ADD(NOW(), INTERVAL -1 MINUTE)";
        $this->db->query($sql);
    }

    public function getCurrentGroups()
    {
        $array = array();
        $sql = "SELECT groups from users where id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $this->uid);
        $sql->execute();
        $sql = $sql->fetch();
        $array = explode('!', $sql['groups']);

        if (count($array) > 0) {
            array_pop($array);
            array_shift($array);
            $groupsDao = new GroupsDAO();
            $array = $groupsDao->getNamesByArray($array);
        }
        return $array;
    }

    public function updatePass($id)
    {

        if (isset($_POST['password']) && (!empty($_POST['password']))) {
            $pass = $_POST['password'];
            $newpass = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET pass = :pass WHERE id = :id";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(":pass", $newpass);
            $sql->bindValue(":id", $id);
            $sql->execute();
            header("Location:" . BASE_URL . 'settings');
        }
    }

    public function verifyToken($token)
    {
        $sql = "SELECT * FROM user_token where ut_hash = :ut_hash AND used = 0";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":ut_hash", $token);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return true;
        } else
            header("Location:" . BASE_URL . 'login');
    }

    public function resetPass($token, $user)
    {
        $sql = "SELECT * FROM user_token WHERE ut_hash = :ut_hash AND used = 0";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":ut_hash", $token);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            $id = $sql['id_user'];;
            $_SESSION['chathashlogin'] = '';
            $sql2 = "UPDATE users SET pass = :pass WHERE id = :id";
            $sql2 = $this->db->prepare($sql2);
            $sql2->bindValue(":pass", password_hash($user->getPass(), PASSWORD_DEFAULT));
            $sql2->bindValue(":id", $id);
            $sql2->execute();
            $sql3 = "UPDATE USER_TOKEN SET used = 1 WHERE ut_hash = :ut_hash";
            $sql3 = $this->db->prepare($sql3);
            $sql3->bindValue(":ut_hash", $token);
            $sql3->execute();
        } else {
            header("Location:" . BASE_URL . 'login');
        }
    }

    public function validateUser($users)
    {

        $sql = "SELECT * FROM users WHERE email = :email AND deleted = 0";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":email", $users->getEmail());
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $info = $sql->fetch();
            if (password_verify($users->getPass(), $info['pass'])) {
                $loginhash = md5(rand(0, 99999) . time() . $info['id'] . $info['username']);
                $this->setLoginHash($info['id'], $loginhash, $users->getLastLogin());
                $_SESSION['chathashlogin'] = $loginhash;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function setLoginHash($uid, $hash, $lastLogin)
    {

        $sql = "UPDATE users SET loginhash = :hash, last_login = :last  WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":hash", $hash);
        $sql->bindValue(":last", $lastLogin);
        $sql->bindValue(":id", $uid);
        $sql->execute();
    }

    public function updateEmail($users)
    {
        $sql = 'UPDATE users SET email = :email where id = :id';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":email", $users->getEmail());
        $sql->bindValue(":id", $users->getId());
        $sql->execute();
    }

    public function findBy()
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id", $this->uid);
        $sql->execute();
        $data = $sql->fetch();
        return $data;
    }

    public function updateData($user, $value)
    {
        if ($value == 'deleted') {
            $sql = "UPDATE users SET deleted = 1 WHERE id = :id";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(":id", $user->getId());
            $sql->execute();
        }

        if ($value == 'name') {
            $sql = "UPDATE users SET name = :name WHERE ID = :id";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(":name", $user->getName());
            $sql->bindValue(":id", $user->getId());
            $sql->execute();
        }

        if ($value == 'email') {
            $sql = "UPDATE users SET email = :email WHERE ID = :id";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(":email", $user->getEmail());
            $sql->bindValue(":id", $user->getId());
            $sql->execute();
        }

        if ($value == 'username') {
            $sql = "UPDATE users SET username = :username WHERE ID = :id";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(":username", $user->getUsername());
            $sql->bindValue(":id", $user->getId());
            $sql->execute();
        }

        if ($value == 'pass') {
            $sql = "UPDATE users SET pass = :pass WHERE id = :id";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(":pass", password_hash($user->getPass(), PASSWORD_DEFAULT));
            $sql->bindValue(":id", $user->getId());
            $sql->execute();
        }
    }
};
