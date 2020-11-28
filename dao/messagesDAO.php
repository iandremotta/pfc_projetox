<?php

class MessagesDAO extends dao
{
    public function add($msg)
    {
        $sql = "INSERT INTO messages (id_user, id_group, date_msg, msg, msg_type) VALUES (:uid, :id_group, NOW(), :msg, :msg_type)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':uid', $msg->getIdUser());
        $sql->bindValue(':id_group', $msg->getIdGroup());
        $sql->bindValue(':msg', $msg->getMsg());
        $sql->bindValue(':msg_type', $msg->getMsgType());
        $sql->execute();
    }

    public function get($messages, $groups)
    {
        $array = array();
        $sql = "SELECT 
			messages.*,
			users.username as user_name
			FROM messages
			LEFT JOIN users ON users.id = messages.id_user
			WHERE date_msg > :date_msg AND id_group IN (" . (implode(',', $groups)) . ")";

        // $sql = "SELECT * FROM messages WHERE date_msg > :date_msg AND id_group IN (" . (implode(',', $groups)) . ")";
        $sql = $this->db->prepare($sql);

        $sql->bindValue(':date_msg', $messages->getDateMessage());
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }
}
