<?php

class Notification {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($memberId, $message) {
        $query = "INSERT INTO notifications (member_id, message) VALUES (:member_id, :message)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':member_id', $memberId);
        $stmt->bindParam(':message', $message);
        return $stmt->execute();
    }

    public function getAll() {
        $query = "SELECT n.*, m.first_name, m.last_name FROM notifications n
                  JOIN members m ON n.member_id = m.id
                  ORDER BY n.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
