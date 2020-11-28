<?php
class Users
{

	private $uid;

	private $id = null;
	private $name = null;
	private $email = null;
	private $username = null;
	private $pass = null;
	private $loginhash = null;
	private $deleted = null;
	private $admin = null;
	private $createdAt = null;
	private $lastLogin = null;

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function setUsername($username)
	{
		$this->username = $username;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function getPass()
	{
		return $this->pass;
	}

	public function setPass($pass)
	{
		$this->pass = $pass;
	}

	public function getDeleted()
	{
		return $this->deleted;
	}

	public function setDeleted($deleted)
	{
		$this->deleted = $deleted;
	}

	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;
	}

	public function getLastLogin()
	{
		return $this->lastLogin;
	}

	public function setLastLogin($lastLogin)
	{
		$this->lastLogin = $lastLogin;
	}

	public function getAdmin()
	{
		return $this->admin;
	}

	public function setAdmin($admin)
	{
		return $this->admin = $admin;
	}


	public function validateUsername($u)
	{
		if (preg_match('/^[a-z0-9]+$/', $u)) {
			return true;
		} else {
			return false;
		}
	}


	public function clearLoginHash()
	{
		$_SESSION['chathashlogin'] = '';
	}


	public function setAll($data)
	{
		$this->setId($data['id']);
		$this->setName($data['name']);
		$this->setEmail($data['email']);
		$this->setUsername($data['username']);
		$this->setPass($data['pass']);
	}

	public function getAll()
	{
		$this->getId();
		$this->getName();
		$this->getEmail();
		$this->getUsername();
		return $this;
	}
}
