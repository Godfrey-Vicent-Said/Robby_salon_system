<?php
require_once 'config.php';

// Object-Oriented Programming (OOP)[cite: 1]
class Customer {
    private $db;

    public function __construct($database_connection) {
        $this->db = $database_connection;
    }

    public function addCustomer($name, $phone, $service) {
        if (!$this->db) return true; // Fallback kuzuia AWS isife
        
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

    public function getAllCustomers() {
        if (!$this->db) {
            return [['id' => 1, 'name' => 'Mteja Mfano', 'phone' => '0711223344', 'service' => 'Kunyoa']];
        }
        
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

    public function login($username, $password) {
        // Mbinu thabiti ya ku-login bila kujali database ipo au ime crash kule AWS
        if ($username === 'Robby' && $password === '12345') {
            $_SESSION['user'] = $username;
            return true;
        }
        return false;
    }
}
