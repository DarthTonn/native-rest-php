<?php

namespace src\Controller;

use src\Core\ApiInterface;
use src\Core\DB;

/**
 * Class MainController
 * @package src\Controller
 */
class MainController extends DB implements ApiInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM address";

        $stmt = $this->db->query($sql);
        $data = $stmt->fetchAll(\PDO::FETCH_OBJ);

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getById(int $id): \stdClass
    {
        $sql = "SELECT * FROM address WHERE ADDRESSID=?";

        $stmt = $this->db->prepare($sql);

        $stmt->execute(array($id));
        
        $data = $stmt->fetch(\PDO::FETCH_OBJ);

        return ($data instanceof \stdClass)? $data : new \stdClass();
    }

    /**
     * {@inheritdoc}
     */
    public function create(): bool
    {
        $json = file_get_contents('php://input');
        $post = json_decode($json);

        $label = $post->label;
        $street = $post->street;
        $houseNumber = $post->houseNumber;
        $postalCode = $post->postalCode;
        $city = $post->city;
        $country = $post->country;

        $sql = "INSERT INTO address (LABEL, STREET, HOUSENUMBER, POSTALCODE, CITY, COUNTRY) VALUES (?,?,?,?,?,?)";

        $stmt = $this->db->prepare($sql);
        $status = $stmt->execute([$label, $street, $houseNumber, $postalCode, $city, $country]);

        return $status;
    }

    /**
     * {@inheritdoc}
     */
    public function update(int $id): bool
    {
        $json = file_get_contents('php://input');
        $post = json_decode($json);

        $label = $post->label;
        $street = $post->street;
        $houseNumber = $post->houseNumber;
        $postalCode = $post->postalCode;
        $city = $post->city;
        $country = $post->country;

        $sql = "UPDATE address SET LABEL=?, STREET=?, HOUSENUMBER=?, POSTALCODE=?, CITY=?, COUNTRY=? WHERE ADDRESSID=?";

        $stmt = $this->db->prepare($sql);
        $status = $stmt->execute([$label, $street, $houseNumber, $postalCode, $city, $country, $id]);

        return $status;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM address WHERE ADDRESSID=?";

        $stmt = $this->db->prepare($sql);
        $status = $stmt->execute(array($id));

        return $status;
    }
}
