
2. **Créer la base de données** :
- Démarrer **XAMPP** (Apache + MySQL)
- Ouvrir [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
- Créer une base :
  ```sql
  CREATE DATABASE rp_shop_manager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  ```

3. **Importer le schéma** :
- Dans `phpMyAdmin` → onglet **Importer**
- Sélectionner `database/schema.sql`
- Exécuter.

4. **(Optionnel) Migration v3**  
- Importer `database/migrate_v3.sql` pour activer Stock + Bilans.

5. **Créer le super admin** :
- Exécuter dans le navigateur :
  ```
  http://localhost/rp-shop-manager/database/seed_admin.php
  ```
- Cela crée :  
  - **Email** : `admin@local`  
  - **Mot de passe** : `admin`  
- ⚠️ À modifier ensuite directement dans la DB.

6. **Données de démonstration (facultatif)** :
- Exécuter :
  ```
  http://localhost/rp-shop-manager/database/seed_demo.php
  http://localhost/rp-shop-manager/database/seed_enterprises.php
  ```

---

## 🔑 Connexion

- Page de login : [http://localhost/rp-shop-manager/public/login.php](http://localhost/rp-shop-manager/public/login.php)
- Identifiants par défaut :  
- Email : `admin@local`  
- Mot de passe : `admin`

---

## 📂 Structure du projet

rp-shop-manager/
├── app/ # Noyau PHP (core + config)
├── database/ # Schéma, migrations, seeds
├── public/ # Point d'entrée (login, index, assets)
├── resources/views/ # Vues (layouts + modules)
└── README_FR.md


---

## 🧭 Navigation

- **Dashboard** : stats rapides + dernières transactions
- **Articles** : gestion des produits (prix, catégorie)
- **Catégories** : gestion des familles de produits
- **Transactions** : ventes/achats avec historique
- **Stock** : inventaire entreprise
- **Membres** : employés (patron, co-patron, employé, salaires, taux horaire)
- **Entreprises** :
  - Paramètres financiers (capital, taux imposition, année RP)
  - Bilans hebdomadaires archivés (vendredi → jeudi)
- **Statistiques** : CA global, charges, bénéfice net, top produits vendus

---

## 📊 Bilan hebdomadaire (RP)

- **Semaine** : du **vendredi au jeudi**
- **Calculs automatiques** :
  - Bénéfice net = CA – Charges
  - Impôts = Bénéfice net × taux d’imposition
  - Capital final = Capital précédent + Bénéfice net – Impôts – Salaires
- Chaque bilan est **archivé** et modifiable.
- Le **capital final** devient le **capital de départ** pour la semaine suivante.

---

## 🎨 UI / UX

- **Thème sombre pro**
- **Cartes chiffrées** pour stats rapides
- **Toasts** (encarts flottants en bas à droite) pour confirmations et erreurs
- Navigation simple via header

---

## ⚠️ Sécurité

- Sessions PHP sécurisées
- Protection **CSRF** sur tous les formulaires
- Hashage des mots de passe avec `password_hash`

---

## ✅ Prochaines évolutions (v5)

- Paramétrage avancé de la comptabilité
- Édition collaborative multi-utilisateurs
- Graphiques (Recharts.js)
- Personnalisation complète du thème

---

👤 Auteur : **Ton projet RP 1899**
