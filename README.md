# LOTY

## Accès au site
- https://loty.leolesimple.fr  
- https://getloty.fr  

---

## Description du projet
LOTY est un site web de gestion et de consultation de contenus culinaires (recettes, bentos, utilisateurs), développé en PHP avec une base de données relationnelle MariaDB/MySQL.  
Le site est conçu pour fonctionner sur un hébergement mutualisé classique, sans dépendances serveur avancées.

---

## Prérequis serveur (hébergement mutualisé)
- Serveur web Apache
- PHP 8.0 ou supérieur
- MySQL ≥ 5.7
- Accès FTP ou gestionnaire de fichiers
- Accès phpMyAdmin ou ligne de commande MySQL
- Extension PHP PDO activée

---

## Procédure de réinstallation du site

### 1. Déploiement des fichiers
1. Copier l’ensemble des fichiers du projet dans le dossier public du serveur (`public_html`, `www` ou équivalent).
2. Vérifier que les droits en lecture sont correctement définis (644 pour les fichiers, 755 pour les dossiers).

---

### 2. Création de la base de données
1. Créer une base de données via le panel d’hébergement ou phpMyAdmin.
2. Noter :
   - nom de la base
   - utilisateur MySQL
   - mot de passe
   - hôte (souvent `localhost`)

---

### 3. Import de la base de données
1. Ouvrir phpMyAdmin
2. Sélectionner la base créée `loty`
3. Importer le fichier SQL fourni dans `data/`:
```

loty_v4.sql

````
4. Vérifier que les tables sont bien présentes après import

---

### 4. Configuration de la connexion à la base
1. Ouvrir le fichier de configuration PHP (ex : `assets/includes/utilities/db.php`)
2. Adapter les informations de connexion :
```php
$host = 'localhost';
$db   = 'loty';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
````

3. Sauvegarder et tester l’accès au site

---

## Dimensionnement (hébergement mutualisé)

Configuration adaptée pour :

* 100 à 500 utilisateurs
* Quelques milliers de recettes
* Trafic modéré (projet pédagogique / vitrine)

Recommandations :

* 1 base SQL de 500 Mo minimum
* 1 Go de stockage minimum
* PHP

Pour un trafic plus élevé :

* migration vers un VPS
* cache
* séparation base de données / web