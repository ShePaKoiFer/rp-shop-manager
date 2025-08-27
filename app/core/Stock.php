<?php
class Stock extends Model {
    public function allByEnterprise($enterprise_id) {
        $stmt = $this->db->prepare("SELECT * FROM stock WHERE enterprise_id=? ORDER BY name");
        $stmt->execute([$enterprise_id]);
        return $stmt->fetchAll();
    }

    public function add($data) {
        $stmt = $this->db->prepare("INSERT INTO stock (enterprise_id, name, quantity) VALUES (?,?,?)");
        return $stmt->execute([
            $data['enterprise_id'],
            $data['name'],
            $data['quantity'] ?? 0
        ]);
    }

    public function update($id, $quantity) {
        $stmt = $this->db->prepare("UPDATE stock SET quantity=? WHERE id=?");
        return $stmt->execute([$quantity, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM stock WHERE id=?");
        return $stmt->execute([$id]);
    }
}
