<?php
class Messages
{
	private $id;
	private $id_user;
	private $id_group;
	private $date_msg;
	private $msg;
	private $msg_type;

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		return $this->id = $id;
	}

	public function getIdUser()
	{
		return $this->id_user;
	}

	public function setIdUser($id_user)
	{
		return $this->id_user = $id_user;
	}

	public function getIdGroup()
	{
		return $this->id_group;
	}

	public function setIdGroup($id_group)
	{
		return $this->id_group = $id_group;
	}

	public function getDateMessage()
	{
		return $this->date_msg;
	}

	public function setDateMessage($date_msg)
	{
		return $this->date_msg = $date_msg;
	}

	public function getMsg()
	{
		return $this->msg;
	}

	public function setMsg($msg)
	{
		return $this->msg = $msg;
	}

	public function getMsgType()
	{
		return $this->msg_type;
	}

	public function setMsgType($msg_type)
	{
		return $this->msg_type = $msg_type;
	}
}
