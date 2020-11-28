<?php

class VisitorsDAO extends dao
{
    public function insert($location, $users)
    {
        $sql = "INSERT INTO visitors (ip, country, region, date_access, user_id) VALUES(:ip, :country, :region, :date, (select id from users where username = :username ))";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":ip", $location->getIp());
        $sql->bindValue(":country", $location->getCountry());
        $sql->bindValue(":region", $location->getRegion());
        $sql->bindValue(":date", $location->getDate());
        $sql->bindValue(":username", $users->getUsername());
        $sql->execute();
    }
}
