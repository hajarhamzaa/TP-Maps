<?php
class Connexion {
    private $connection; // Correction de la faute de frappe "connextion" -> "connection"

    public function __construct() {
        $host = 'localhost';
        $dbname = 'localisation';
        $login = 'root';
        $password = '';
        
        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$dbname", $login, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Activation des erreurs PDO
            $this->connection->exec("SET NAMES utf8mb4"); // Meilleur encodage que UTF8
        } catch (PDOException $e) { // Spécification du type d'exception
            die('Erreur de connexion : ' . $e->getMessage()); // Message d'erreur plus clair
        }
    }

    public function getConnection() { // Correction du nom de la méthode
        return $this->connection;
    }
}
?>