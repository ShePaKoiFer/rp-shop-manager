<?php
class Transaction extends Model {
    public function allByEnterprise($enterprise_id) {
        $stmt = $this->db->prepare("SELECT * FROM transactions WHERE enterprise_id=? ORDER BY created_at DESC");
        $stmt->execute([$enterprise_id]);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO transactions (enterprise_id, type, description, amount, created_at) VALUES (?,?,?,?,NOW())");
        return $stmt->execute([
            $data['enterprise_id'],
            $data['type'], // VENTE ou ACHAT
            $data['description'],
            $data['amount']
        ]);
    }
}
