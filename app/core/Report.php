<?php
class Report extends Model {
    public function weekly($enterprise_id, $start_date, $end_date) {
        // Récupère CA et Charges entre deux dates
        $stmt = $this->db->prepare("
            SELECT 
                SUM(CASE WHEN type='VENTE' THEN amount ELSE 0 END) AS ca,
                SUM(CASE WHEN type='ACHAT' THEN amount ELSE 0 END) AS charges
            FROM transactions 
            WHERE enterprise_id=? 
            AND DATE(created_at) BETWEEN ? AND ?
        ");
        $stmt->execute([$enterprise_id, $start_date, $end_date]);
        return $stmt->fetch();
    }

    public function save($data) {
        $stmt = $this->db->prepare("
            INSERT INTO enterprise_reports 
            (enterprise_id, start_date, end_date, chiffre_affaire, charges, benefice_net, impots, salaires, capital_final, created_at) 
            VALUES (?,?,?,?,?,?,?,?,?,NOW())
        ");
        return $stmt->execute([
            $data['enterprise_id'],
            $data['start_date'],
            $data['end_date'],
            $data['chiffre_affaire'],
            $data['charges'],
            $data['benefice_net'],
            $data['impots'],
            $data['salaires'],
            $data['capital_final']
        ]);
    }
}
