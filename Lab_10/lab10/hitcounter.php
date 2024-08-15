<?php
    class HitCounter {
        private $connect;
        private $table;

        function __construct($host, $user, $pwd, $db, $paraTab) {
            $this->table = $paraTab;
            $this->connect = new mysqli($host, $user, $pwd, $db);
        }

        function startOver() {
            $temp = $this->connect->query("UPDATE " . $this -> table . " SET hits = 0 WHERE id = 1");
            return $temp;
        }

        function getHits() {
            $temp = $this->connect->query("SELECT * FROM  " . $this -> table . " ;");
            return mysqli_fetch_assoc($temp)["hits"];
        }

        function setHits() {
            $temp = $this->connect->query("UPDATE  " . $this -> table . "  SET hits = hits + 1 WHERE id = 1");
            return $temp;
        }

        function closeConnection() {
            $this->connect->close();
        }
    }
?>