<?php
require_once 'config.php';

// 1. ABSTRACTION
abstract class SystemModel {
    protected $db;
    public function __construct($pdo) { // CONSTRUCTOR
        $this->db = $pdo;
    }
    abstract public function save();
}

// 2. INHERITANCE
class Customer extends SystemModel {
    // ENCAPSULATION
    private $userId;
    private $name;
    private $phone;
    private $service;

    public function __construct($pdo, $userId, $name, $phone, $service) {
        parent::__construct($pdo);
        $this->userId = $userId;
        $this->name = $name;
        $this->phone = $phone;
        $this->service = $service;
    }

    // CRUD - Create (Inasajili na ku-encrypt row yote)
    public function save() {
        $encryptedName = encryptData($this->name);
        $encryptedPhone = encryptData($this->phone);
        $encryptedService = encryptData($this->service);

        $sql = "INSERT INTO customers (user_id, customer_name, phone_number, service_type) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->userId, $encryptedName, $encryptedPhone, $encryptedService]);
    }

    // POLYMORPHISM & CRUD - Read/Search (Inatoa na ku-decrypt data)
    public static function viewAll($pdo, $searchQuery = '') {
        $sql = "SELECT * FROM customers";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $finalData = [];
        foreach ($results as $row) {
            $decryptedName = decryptData($row['customer_name']);
            $decryptedPhone = decryptData($row['phone_number']);
            $decryptedService = decryptData($row['service_type']);

            if ($searchQuery !== '') {
                if (stripos($decryptedName, $searchQuery) === false && stripos($decryptedService, $searchQuery) === false) {
                    continue;
                }
            }

            $finalData[] = [
                'id' => $row['id'],
                'customer_name' => $decryptedName,
                'phone_number' => $decryptedPhone,
                'service_type' => $decryptedService
            ];
        }
        return $finalData;
    }

    // CRUD - Delete
    public static function delete($pdo, $id) {
        $sql = "DELETE FROM customers WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>