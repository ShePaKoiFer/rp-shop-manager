<?php
namespace Core;

class Dashboard
{
    public static function getStats($enterprise_id = null)
    {
        $db = Database::get();

        // Si aucune entreprise choisie, prendre la première
        if (!$enterprise_id) {
            $enterprise_id = $db->query("SELECT id FROM enterprises ORDER BY id ASC LIMIT 1")->fetchColumn();
        }

        $stmt = $db->prepare("
            SELECT 
                SUM(CASE WHEN type='VENTE' THEN amount ELSE 0 END) AS revenus,
                SUM(CASE WHEN type='ACHAT' THEN amount ELSE 0 END) AS depenses
            FROM transactions 
            WHERE enterprise_id=?
        ");
        $stmt->execute([$enterprise_id]);
        $data = $stmt->fetch();

        return [
            'revenus'  => $data['revenus'] ?? 0,
            'depenses' => $data['depenses'] ?? 0,
            'benefice' => ($data['revenus'] ?? 0) - ($data['depenses'] ?? 0),
        ];
    }
}
