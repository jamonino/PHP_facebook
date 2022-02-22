<?php

class newEmptyPHP implements \JsonSerializable {
    
    private string $username;
    private string $pass;
    private int $age;
    private int $id;
    
    public function parametersConstruct(int $id, string $username,string $pass,int $age) {
        $this->username = $username;
        $this->pass = $pass;
        $this->age = $age;
        $this->id = $id;
    }
    
    public function jsonConstruct($json) {
        foreach (json_decode($json, true) AS $key => $value) {
            $this->{$key} = $value;
        }
    }

    
    public function DB_insert($dbconn){
        pg_prepare($dbconn, "my_query_INSERT", 'INSERT INTO users (username,pass,age) VALUES ($1,$2,$3) returning id;');
        $result = pg_execute($dbconn, "my_query_INSERT", array($this->username, $this->pass,$this->age));
        while ($row = pg_fetch_row($result)) {
            $this->id = $row[0];
        }
        // Free resultset
        pg_free_result($result);
    }
    
    public static function DB_selectAll($dbconn){
        pg_prepare($dbconn, "my_query_SELECTALL", 'SELECT id,username,pass,age FROM users;');
        $result = pg_execute($dbconn, "my_query_SELECTALL",array());
        $users = array();
        while ($row = pg_fetch_row($result)) {
            $newUser = new User;
            $newUser->parametersConstruct($row[0],$row[1],$row[2],$row[3]);
            $users[]=$newUser;
        }
        // Free resultset
        pg_free_result($result);
        return $users;
    }
    
    public function DB_selectOne($dbconn){
        pg_prepare($dbconn, "my_query_SELECTONE", 'SELECT id,username,pass,age FROM users WHERE id = $1;');
        $result = pg_execute($dbconn, "my_query_SELECTONE",array($this->id));
        if ($row = pg_fetch_row($result)) {
            $this->parametersConstruct($row[0],$row[1],$row[2],$row[3]);
        }
        // Free resultset
        pg_free_result($result);
        return $this;
    }
    
    public function DB_update($dbconn){
        $update = "UPDATE users SET ";
        $fields = array();
        $values = array();
        
        if (isset($this->username)) {
            $fields[] = "username";
            $values[] = $this->username;
        }
        if (isset($this->pass)) {
            $fields[] = "pass";
            $values[] = $this->pass;
        }
        if (isset($this->age)) {
            $fields[] = "age";
            $values[] = $this->age;
        }
        
        for ($i = 0; $i < count($fields); $i++) {
            $update .= $fields[$i]."=$".($i+1);
            if($i!=count($fields)-1){
                $update .= ",";
            }
        }
        $update .=  " where id = $". (count($fields)+1);
        
        $values[] = $this->id;
        
        pg_prepare($dbconn, "my_query_UPDATE", $update);
        $result = pg_execute($dbconn, "my_query_UPDATE", $values);
        
        return $this;
    }
    
    public function DB_delete($dbconn){
        pg_prepare($dbconn, "my_query_DELETE", 'DELETE FROM users WHERE id = $1;');
        $result = pg_execute($dbconn, "my_query_DELETE",array($this->id));
        
        // Free resultset
        pg_free_result($result);
        return $this;
    }
    
    
    //Para que las variables privadas de clase también se conviertan a json
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
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
