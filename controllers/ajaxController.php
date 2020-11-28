<?php
class ajaxController extends controller
{

	// private $user; 
	private $userDao;

	public function __construct()
	{
		$this->userDao = new UsersDao();
		if (!$this->userDao->verifyLogin()) {
			$array = array(
				'status' => '0'
			);

			echo json_encode($array);
			exit;
		}
	}

	public function index()
	{
	}


	public function get_groups()
	{
		$array = array('status' => '1');
		$groups = new Groups();
		$groupsDao = new GroupsDAO();
		$array['list'] = $groupsDao->getList();
		echo json_encode($array);
		exit;
	}


	public function add_group()
	{
		$array = array('status' => '1', 'error' => '0');
		$groups = new Groups();
		$groupsDao = new GroupsDAO();

		if (!empty($_POST['name'])) {
			$groups->setName($_POST['name']);
			if (!$groupsDao->groupExist($groups)) {
				$groupsDao->add($groups);
			} else {
				$array['error'] = '2';
				$array['errorMsg'] = 'Grupo inválido';
			}
		} else {
			$array['error'] = '1';
			$array['errorMsg'] = 'Falta o NOME do grupo';
		}

		echo json_encode($array);
		exit;
	}

	public function add_message()
	{
		$array = array('status' => '1', 'error' => '0');
		$messagesDao = new MessagesDAO();
		$msg = new Messages();
		$msg->setMsgType('text');
		if (!empty($_POST['msg']) && !empty($_POST['id_group'])) {
			$msg->setMsg($_POST['msg']);
			$msg->setIdGroup($_POST['id_group']);
			$msg->setIdUser($this->userDao->getUid());
			$messagesDao->add($msg);
		} else {
			$array['error'] = '1';
			$array['errorMsg'] = 'Mensagem vazia';
		}
		echo json_encode($array);
		exit;
	}

	public function add_photo()
	{
		$array = array('status' => '1', 'error' => '0');
		$messages = new MessagesDAO();
		$msg = new Messages();
		if (!empty($_POST['id_group'])) {
			$msg->setIdGroup($_POST['id_group']);
			$msg->setIdUser($this->userDao->getUid());
			$allowed = array('image/jpeg', 'image/jpg', 'image/png');
			if (!empty($_FILES['img']['tmp_name'])) {
				if (in_array($_FILES['img']['type'], $allowed)) {
					$newname = md5(time() . rand(0, 9999));
					if ($_FILES['img']['type'] == 'image/png') {
						$msg->setMsg($newname .= '.png');
						$msg->setMsgType('img');
					} else {
						$msg->setMsg($newname .= '.jpg');
						$msg->setMsgType('img');
					}
					move_uploaded_file($_FILES['img']['tmp_name'], 'media/images/' . $newname);
					$messages->add($msg);
					print_r("funcionou");
				} else {
					$array['error'] = '1';
					$array['errorMsg'] = 'Arquivo inválido';
				}
			} else {
				$array['error'] = '1';
				$array['errorMsg'] = 'Arquivo em branco';
			}
		} else {
			$array['error'] = '1';
			$array['errorMsg'] = 'Grupo inválido';
		}
		echo json_encode($array);
		exit;
	}

	public function get_userList()
	{
		$array = array('status' => '1', 'users' => array());
		$groups = array();
		if (!empty($_GET['groups']) && is_array($_GET['groups'])) {
			$groups = $_GET['groups'];
		}

		foreach ($groups as $group) {
			$array['users'][$group] = $this->userDao->getUsersInGroup($group);
		}
		echo json_encode($array);
		exit;
	}

	public function get_messages()
	{
		$array = array('status' => '1', 'msgs' => array(), 'last_time' => date('Y-m-d H:i:s'));
		$messagesDao = new MessagesDAO();
		$messages = new Messages();
		set_time_limit(60);

		$messages->setDateMessage(date('Y-m-d H:i:s'));
		if (!empty($_GET['last_time'])) {
			$messages->setDateMessage($_GET['last_time']);
		}

		$groups = array();
		if (!empty($_GET['groups']) && is_array($_GET['groups'])) {
			$groups = $_GET['groups'];
		}

		$this->userDao->updateGroups($groups);
		$this->userDao->clearGroups();

		while (true) {
			session_write_close();
			$msgs = $messagesDao->get($messages, $groups);
			if (count($msgs) > 0) {
				$array['msgs'] = $msgs;
				$array['last_time'] = date('Y-m-d H:i:s');
				break;
			} else {
				sleep(0.2);
				continue;
			}
		}
		echo json_encode($array);
		exit;
	}
}
