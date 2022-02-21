<?php

class user {
    
    private string $username;
    private string $pass;
    private int $age;
    private int $id;
    
    public function __construct(string $username,string $pass,int $age) {
        $this->username = $username;
        $this->pass = $pass;
        $this->age = $age;
    }
    
    public function jsonConstruct($json) {
        $this->set(json_decode($json, true));
    }

    public function set($data) {
        foreach ($data AS $key => $value) {
            if (is_array($value)) {
                $sub = new JSONObject;
                $sub->set($value);
                $value = $sub;
            }
            $this->{$key} = $value;
        }
    }
    
    public function DB_insert($dbconn){
         
        pg_prepare($dbconn, "my_query_INSERT", 'INSERT INTO users (username,pass,age) VALUES ($1,$2,$3) returning id;');


        pg_execute($dbconn, "my_query_INSERT", array($this->username, $this->pass,$this->age));
        
        
    }
    
    public function getUsername(): string {
        return $this->username;
    }

    public function getPass(): string {
        return $this->pass;
    }

    public function getAge(): int {
        return $this->age;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setUsername(string $username): void {
        $this->username = $username;
    }

    public function setPass(string $pass): void {
        $this->pass = $pass;
    }

    public function setAge(int $age): void {
        $this->age = $age;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }


}
