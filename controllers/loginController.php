<?php

use function PHPSTORM_META\type;

class loginController extends controller
{

	public function index()
	{
		$data = array(
			'msg' => ''
		);

		if (!empty($_GET['error'])) {
			if ($_GET['error'] == '1') {
				$data['msg'] =  $this->lang->get('ERROR1',  true);
			}
		}

		$this->loadView('login', $data);
	}

	public function signin()
	{

		if (!empty($_POST['email'])) {
			$users = new Users();
			$userDao = new UsersDao();
			$users->setEmail(strtolower($_POST['email']));
			$users->setPass($_POST['pass']);
			$users->setLastLogin(date('Y-m-d H:i:s'));

			$visitors = new Visitors();
			$visitorDao = new VisitorsDAO();
			// $ip_address = $_SERVER['REMOTE_ADDR']; 

			$visitors->setIp($_SERVER['REMOTE_ADDR']);
			$visitors->setDate($users->getLastLogin());
			$ip_address = $_SERVER['REMOTE_ADDR'];
			$geopluginURL = 'http://www.geoplugin.net/php.gp?id=' . $visitors->getIp();
			$addrDetailsArr = unserialize(file_get_contents($geopluginURL));
			$visitors->setCountry($addrDetailsArr['geoplugin_countryName']);
			$visitors->setRegion($addrDetailsArr['geoplugin_region']);


			// $visitors->setCountry();


			if ($userDao->validateUser($users)) {
				$visitorDao->insert($visitors, $users);
				header("Location: " . BASE_URL);
				exit;
			} else {
				header("Location: " . BASE_URL . 'login?error=1');
				exit;
			}
		} else {
			header("Location: " . BASE_URL . 'login');
			exit;
		}
	}

	public function signup()
	{
		$data = array(
			'msg' => ''
		);

		if (!empty($_POST['username'])) {
			$users = new Users();
			$userDao = new UsersDao();
			$users->setName($_POST['name']);
			$users->setEmail($_POST['email']);
			$users->setUsername(strtolower($_POST['username']));
			$users->setPass($_POST['pass']);
			$users->setCreatedAt(date('Y-m-d'));


			if (!$userDao->emailExists($users)) {
				if ($users->validateUsername($users->getUsername())) {
					if (!$userDao->userExists($users)) {
						$userDao->registerUser($users);
						header("Location: " . BASE_URL . "login");
					} else {
						$data['msg'] = 'Usuário já existente!';
					}
				} else {
					$data['msg'] = 'Usuário não válido (Digite apenas letras e números).';
				}
			} else {
				$data['msg'] = "E-mail inválido.";
			}
		}



		$this->loadView('signup', $data);
	}


	public function forget()
	{
		$data = array(
			'msg' => ''
		);

		if (!empty($_POST['email'])) {
			$user = new Users();
			$userDao = new UsersDao();
			$user->setEmail($_POST['email']);
			$userDao->recoveryPassword($user);
		}

		$this->loadView('forget', $data);
	}


	public function resetpass()
	{
		$data = array(
			'msg' => ''
		);
		if (!empty($_GET['token'])) {
			$userDao = new UsersDao();
			$user = new Users();
			$token = $_GET['token'];
			if ($userDao->verifyToken($token)) {
				if (isset($_POST['password'])) {
					$pass = $_POST['password'];
					$confirmPass = $_POST['confirmPass'];
					if ($pass == $confirmPass) {
						$user->setPass($pass);
						$userDao->resetPass($token, $user);
						header('location:' . BASE_URL);
					} else {
						$data['msg'] = 'Confira os dados';
					}
				}
			}
		}
		$this->loadView('resetpass', $data);
	}

	public function logout()
	{
		$users = new Users();
		$users->clearLoginHash();

		header("Location: " . BASE_URL . 'login');
	}
}
