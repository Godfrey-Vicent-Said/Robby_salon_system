<?php
require_once 'config.php';

// Encapsulation na OOP kamili
class Customer {
    private $db;
    private $name;
    private $phone;
    private $service;

    public function __construct($database_connection) {
        $this->db = $database_connection;
    }

    // CRUD Operation: Create na Data Encryption kabla ya ku-save kwenye DB
    public function addCustomer($name, $phone, $service) {
        // MAELEKEZO: Data lazima ziwe encrypted kabla ya kuwekwa kwenye DB
        $enc_name = encryptData($name);
        $enc_phone = encryptData($phone);
        $enc_service = encryptData($service);

        $sql = "INSERT INTO customers (name, phone, service) VALUES (:name, :phone, :service)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':name' => $enc_name,
            ':phone' => $enc_phone,
            ':service' => $enc_service
        ]);
    }

    // CRUD Operation: Read na Data Decryption wakati wa kurudisha data
    public function getAllCustomers() {
        $sql = "SELECT * FROM customers";
        $stmt = $this->db->query($sql);
        $encrypted_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $decrypted_list = [];
        foreach ($encrypted_list as $row) {
            $decrypted_list[] = [
                'id' => $row['id'],
                'name' => decryptData($row['name']),
                'phone' => decryptData($row['phone']),
                'service' => decryptData($row['service'])
            ];
        }
        return $decrypted_list;
    }
}

class User {
    private $db;

    public function __construct($database_connection) {
        $this->db = $database_connection;
    }

    // User Authentication na Session Management
    public function login($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $password === $user['password']) {
            $_SESSION['user'] = $user['username'];
            return true;
        }
        return false;
    }
}
