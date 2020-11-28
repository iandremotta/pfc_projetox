<?php

class GroupsDAO extends dao
{
    public function getList()
    {
        $array = array();
        $sql = "SELECT * FROM db_batepapo.groups where deleted = 0 ORDER by name ASC";
        $sql = $this->db->query($sql);
        // fetch assoc não retorna items repetitdos
        $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function groupExist($groups)
    {
        $sql = "SELECT * FROM groups WHERE groups = :g";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":g", $groups->getName());
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function add($groups)
    {
        $sql = "INSERT INTO db_batepapo.groups (name) VALUES (:name)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':name', $groups->getName());
        $sql->execute();
    }

    public function getName($id)
    {
        $sql = "SELECT name FROM db_batepapo.groups WHERE id = $id";
        $sql = $this->db->query($sql);
        $array = $sql->fetch();
        return $array['name'];
    }

    public function getNamesByArray($id_groups)
    {
        $array = array();
        if (count($id_groups) > 0) {
            $sql = "SELECT name, id FROM groups WHERE id in (" . (implode(',', $id_groups)) . ")";

            $sql = $this->db->query($sql);
            if ($sql->rowCount() > 0) {
                $array = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        return $array;
    }
}
