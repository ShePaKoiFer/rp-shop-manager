<?php
class Member extends Model {
    public function allByEnterprise($enterprise_id) {
        $stmt = $this->db->prepare("SELECT * FROM members WHERE enterprise_id=?");
        $stmt->execute([$enterprise_id]);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO members (enterprise_id, name, role, salary, hourly_rate) VALUES (?,?,?,?,?)");
        return $stmt->execute([
            $data['enterprise_id'],
            $data['name'],
            $data['role'],
            $data['salary'] ?? 0,
            $data['hourly_rate'] ?? 0
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE members SET name=?, role=?, salary=?, hourly_rate=? WHERE id=?");
        return $stmt->execute([
            $data['name'],
            $data['role'],
            $data['salary'] ?? 0,
            $data['hourly_rate'] ?? 0,
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM members WHERE id=?");
        return $stmt->execute([$id]);
    }
}
