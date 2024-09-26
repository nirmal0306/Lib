<?php

    class Database {
        private $server="mysql:host=localhost;dbname=library_management_system";
        private $username = "root";
        private $password = "";
        protected $connection=null;

        public function openConnection() {

            try {
                    $this->connection = new PDO($this->server,
                    $this->username,
                    $this->password);

                    $this->connection->setAttribute(
                        PDO::ATTR_ERRMODE,
                        PDO::ERRMODE_EXCEPTION);
                    //echo "connection success";
                    return $this->connection;
        
            }

            catch(PDOException $e) {
                echo "Error" . $e->getMessage();
            }
        }

            public function closeConnection () {
                $this->connection  = null;
            }
    }
?>