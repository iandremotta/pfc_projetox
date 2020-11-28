<?php

class Visitors
{

    private $id;
    private $ip;
    private $country;
    private $region;
    private $date;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        return $this->id = $id;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function setIp($ip)
    {
        return $this->ip = $ip;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        return $this->country = $country;
    }

    public function getRegion()
    {
        return $this->region;
    }

    public function setRegion($region)
    {
        return $this->region = $region;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        return $this->date = $date;
    }
}
