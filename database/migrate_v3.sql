-- Migration v3 : Ajout du stock, statistiques et bilans
ALTER TABLE enterprises 
    ADD COLUMN rp_year INT DEFAULT 1899;

CREATE TABLE IF NOT EXISTS stock (
    id INT AUTO_INCREMENT PRIMARY KEY,
    enterprise_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    quantity INT DEFAULT 0,
    FOREIGN KEY (enterprise_id) REFERENCES enterprises(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS enterprise_reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    enterprise_id INT NOT NULL,
    start_date DATE,
    end_date DATE,
    chiffre_affaire DECIMAL(10,2),
    charges DECIMAL(10,2),
    benefice_net DECIMAL(10,2),
    impots DECIMAL(10,2),
    salaires DECIMAL(10,2),
    capital_final DECIMAL(10,2),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL,
    edited_by VARCHAR(255) NULL,
    FOREIGN KEY (enterprise_id) REFERENCES enterprises(id) ON DELETE CASCADE
);
