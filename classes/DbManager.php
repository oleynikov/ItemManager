<?php

    class DbManager
    {
        private $host;
        private $user;
        private $password;
        private $database;
        private $lnk;

        public function __construct($a, $b, $c, $d)
        {
            $this -> host = $a;
            $this -> user = $b;
            $this -> password = $c;
            $this -> database = $d;

            $this->connect();
        }

        public function __destruct()
        {
            unset ($this -> user, $this -> password);
            mysqli_close($this->lnk);
        }

        public function query($query)
        {
            echo $query;

            return mysqli_query($this->lnk, $query);
        }

        private function connect()
        {
            $this->lnk = mysqli_connect
            (
                $this->host,
                $this->user,
                $this->password,
                $this->database
            );
        }

        
    }
    
?>
