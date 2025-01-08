<?php

require_once 'ProfilePicture.php';

class Member {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data, $profilePicture) {
        $query = "INSERT INTO members 
            (first_name, last_name, email, profession, company, expertise, linkedin_profile, profile_picture) 
            VALUES (:first_name, :last_name, :email, :profession, :company, :expertise, :linkedin_profile, :profile_picture)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(array_merge($data, ['profile_picture' => $profilePicture]));
    }

    public function update($id, $data, $profilePicture) {
        $query = "UPDATE members 
            SET first_name = :first_name, last_name = :last_name, email = :email, 
                profession = :profession, company = :company, expertise = :expertise, 
                linkedin_profile = :linkedin_profile, profile_picture = :profile_picture 
            WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $data['profile_picture'] = $profilePicture;
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete($id) {
        $memberData = $this -> getById($id);
        
        $profilePicture = new ProfilePicture();
        $profilePicture -> deleteIfExists($memberData['profile_picture']);

        $query = "DELETE FROM members WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }


    public function getAll($filterProfession = '', $filterCompany = '', $sortBy = 'created_at', $perPage = 6, $offset = 0) {
        $queryStart = "SELECT * FROM members WHERE profession LIKE :profession AND company LIKE :company ";
        $querySort = $sortBy == 'created_at' || $sortBy == null ? " ORDER BY created_at desc " : " ORDER BY last_name asc, first_name asc ";
        $queryEnd = " LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($queryStart . $querySort . $queryEnd);
        $stmt->bindValue(':profession', "%$filterProfession%", PDO::PARAM_STR);
        $stmt->bindValue(':company', "%$filterCompany%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error in getAll: " . $e->getMessage();
            return []; 
        }
    }

    public function getTotal($filterProfession = '') {
        $query = "SELECT COUNT(*) as total FROM members WHERE profession LIKE :profession";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':profession', "%$filterProfession%", PDO::PARAM_STR);

        try {
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return isset($result['total']) ? (int)$result['total'] : 0; 
        } catch (PDOException $e) {
            echo "Error in getTotal: " . $e->getMessage();
            return 0; 
        }
    }


    public function getById($id) {
        $query = "SELECT * FROM members WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            echo "Error in getById: " . $e->getMessage();
            return null; 
        }
    }
    
}
?>
