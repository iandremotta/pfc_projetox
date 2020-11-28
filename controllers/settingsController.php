<?php

class settingsController extends controller
{

    private $user;
    private $userDao;
    public function __construct()
    {
        parent::__construct();
        $this->userDao = new UsersDao();
        $this->user = new Users();
        if (!$this->userDao->verifyLogin()) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
    }

    public function index()
    {
        $data = array('msg' => '');
        $data['user'] =  $this->userDao->findBy();
        $this->user->setAll($data['user']);


        $this->loadView('settings', $data);
    }

    public function updatename()
    {
        $data = array();
        $data['user'] = $this->userDao->findBy();
        $this->user->setAll($data['user']);
        if (!empty($_POST['data']) && isset($_POST['data'])) {
            $this->user->setName($_POST['data']);
            $this->userDao->updateData($this->user, 'name');
            header("location:" . BASE_URL . 'settings');
        }


        $this->loadView('updatename', $data);
    }

    public function updateEmail()
    {
        $data = array();
        $data['user'] = $this->userDao->findBy();
        $this->user->setAll($data['user']);
        if (!empty($_POST['data']) && isset($_POST['data'])) {
            $this->user->setEmail(strtolower($_POST['data']));
            if (!$this->userDao->emailExists($this->user)) {
                $this->userDao->updateData($this->user, 'email');
                header("location:" . BASE_URL . 'settings');
            } else {
                $data['msg'] = 'E-mail já cadastrado.';
            }
        }

        $this->loadView('updateemail', $data);
    }

    public function updateusername()
    {
        $data = array();
        $data['user'] = $this->userDao->findBy();
        $this->user->setAll($data['user']);
        if (!empty($_POST['data']) && isset($_POST['data'])) {
            $this->user->setUsername(strtolower($_POST['data']));
            if (!$this->userDao->userExists($this->user)) {
                $this->userDao->updateData($this->user, 'username');
                header("location:" . BASE_URL . 'settings');
            } else {
                $data['msg'] = 'Username já cadastrado.';
            }
        }
        $this->loadView('updateusername', $data);
    }



    public function resetpass()
    {
        $data = array();
        $data['user'] = $this->userDao->findBy();
        $this->user->setAll($data['user']);
        if (isset($_POST['password'])) {
            $pass = $_POST['password'];
            $confirmPass = $_POST['confirmPass'];
            if ($pass == $confirmPass) {
                $this->user->setPass($pass);
                $this->userDao->updateData($this->user, 'pass');
                header('location:' . BASE_URL);
            } else {
                $data['msg'] = 'Confira os dados';
            }
        }
        $this->loadView('resetpass', $data);
    }

    public function deleteUser()
    {
        $data = array();
        $data['user'] = $this->userDao->findBy();
        $this->user->setAll($data['user']);

        if (isset($_POST['data']) && (!empty($_POST['data'])) && $_POST['data'] == 'confirmar') {
            $this->userDao->updateData($this->user, 'deleted');
            $this->user->clearLoginHash();
            header('location:' . BASE_URL);
        }

        if (isset($_POST['data']) || (!empty($_POST['data']))) {
            $data['msg'] = 'Escreva confirmar.';
        }

        $this->loadView('deleteuser', $data);
    }
}
