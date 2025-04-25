<?php
include_once 'dao/IDao.php';
include_once 'classe/Position.php';
include_once 'connexion/Connexion.php';

class PositionService implements IDao {
    private $connexion;

    public function __construct() {
        $this->connexion = new Connexion();
    }

public function create($position) {
    $query = "INSERT INTO position (latitude, longitude, date, imei) VALUES (:latitude, :longitude, :date, :imei)";
    $req = $this->connexion->getConnection()->prepare($query);
    
    $req->bindValue(':latitude', $position->getLatitude());
    $req->bindValue(':longitude', $position->getLongitude());
    $req->bindValue(':date', $position->getDate()->format('Y-m-d H:i:s')); // Conversion en string
    $req->bindValue(':imei', $position->getImei());
    
    return $req->execute();
}
    public function delete($id) {
        $query = "DELETE FROM position WHERE id = :id";
        $req = $this->connexion->getConnection()->prepare($query);
        $req->bindValue(':id', $id);
        return $req->execute();
    }

    public function getAll() {
        $query = "SELECT * FROM position ORDER BY date DESC";
        $req = $this->connexion->getConnection()->prepare($query);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM position WHERE id = :id";
        $req = $this->connexion->getConnection()->prepare($query);
        $req->bindValue(':id', $id);
        $req->execute();
        return $req->fetch(PDO::FETCH_ASSOC);
    }

    public function update($position) {
        $query = "UPDATE position SET latitude = :latitude, longitude = :longitude, date = :date, imei = :imei WHERE id = :id";
        $req = $this->connexion->getConnection()->prepare($query);
        
        $req->bindValue(':id', $position->getId());
        $req->bindValue(':latitude', $position->getLatitude());
        $req->bindValue(':longitude', $position->getLongitude());
        $req->bindValue(':date', $position->getDate());
        $req->bindValue(':imei', $position->getImei());
        
        return $req->execute();
    }

    // Méthode supplémentaire pour récupérer les positions par IMEI
    public function getByImei($imei) {
        $query = "SELECT * FROM position WHERE imei = :imei ORDER BY date DESC";
        $req = $this->connexion->getConnection()->prepare($query);
        $req->bindValue(':imei', $imei);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
}