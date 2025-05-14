
---

# HT-Auto

**HT-Auto** est un projet développé principalement en **PHP** avec un peu de **CSS**. Ce guide vous aidera à configurer le projet localement en utilisant **XAMPP** pour gérer le serveur web et la base de données.

---

## Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :

- **XAMPP** (inclut Apache, MySQL, PHP)
- Un éditeur de texte ou IDE (comme Visual Studio Code, PHPStorm, etc.)
- Git (pour cloner le dépôt)

---

## Installation et Configuration

### 1. Cloner le Dépôt

Commencez par cloner ce projet sur votre machine locale :

```bash
git clone https://github.com/jeremyvidocin/HT-Auto.git
cd HT-Auto
```

---

### 2. Installer et Lancer XAMPP

1. Téléchargez et installez **XAMPP** depuis [le site officiel](https://www.apachefriends.org/fr/index.html).
2. Lancez le **Panneau de contrôle XAMPP**.
3. Démarrez les services **Apache** et **MySQL**.

---

### 3. Configurer la Base de Données

1. **Accéder à phpMyAdmin** :
   - Ouvrez votre navigateur et accédez à `http://localhost/phpmyadmin`.

2. **Créer une Base de Données** :
   - Cliquez sur l'onglet **Bases de données**.
   - Entrez le nom de votre base de données, par exemple `car_dealership2`, et cliquez sur **Créer**.

3. **Importer les Tables** :
   - Utilisez le fichier SQL fourni dans le projet pour configurer la base de données :
     1. Dans phpMyAdmin, sélectionnez la base de données `car_dealership2`.
     2. Cliquez sur l'onglet **Importer**.
     3. Cliquez sur **Choisir un fichier**, sélectionnez le fichier `car_dealership2 (3).sql` situé dans le répertoire principal du projet, puis cliquez sur **Exécuter**.

4. **Vérification** :
   - Une fois l'importation terminée, vérifiez que les tables `users`, `cars`, `bookings`, et autres ont bien été créées avec leurs données.

---

### 4. Configurer la Connexion à la Base de Données

1. **Fichier de Configuration** :
   - Le fichier `config/Database.php` contient les informations de connexion à la base de données. Assurez-vous que les paramètres correspondent à votre environnement local :

```php
<?php
// config/Database.php
class Database {
    private $host = "localhost"; // Hôte de la base de données
    private $db_name = "car_dealership2"; // Nom de la base de données
    private $username = "root"; // Nom d'utilisateur (par défaut "root" pour XAMPP)
    private $password = ""; // Mot de passe (par défaut vide pour XAMPP)
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>
```

2. **Vérification de la Connexion** :
   - Créez un fichier test, par exemple `test_connection.php`, pour vérifier si la connexion à la base de données est fonctionnelle :

```php
<?php
require 'config/Database.php';

$database = new Database();
$db = $database->getConnection();

if ($db) {
    echo "Connexion réussie à la base de données !";
} else {
    echo "Échec de la connexion.";
}
?>
```

   - Placez ce fichier dans le répertoire principal du projet (dans `htdocs` si vous utilisez XAMPP).
   - Accédez à ce fichier via un navigateur : `http://localhost/HT-Auto/test_connection.php`.

---

### 5. Déplacer le Projet dans le Répertoire XAMPP

Déplacez le projet dans le répertoire `htdocs` de XAMPP. Par exemple :

```bash
mv HT-Auto /path/to/xampp/htdocs/
```

Accédez au projet via votre navigateur à l'adresse suivante :  
`http://localhost/HT-Auto`

---

## Utilisation

- **URL principale** : Rendez-vous sur `http://localhost/HT-Auto` pour interagir avec l'application.
- **phpMyAdmin** : Gérez la base de données depuis `http://localhost/phpmyadmin`.

---

## Ressources Utiles

- [Documentation officielle de XAMPP](https://www.apachefriends.org/fr/index.html)
- [Documentation PHP (PDO)](https://www.php.net/manual/fr/book.pdo.php)
- [Documentation MySQL](https://dev.mysql.com/doc/)

---


Avec ces étapes, votre projet est maintenant configuré avec succès en utilisant le fichier SQL pour la base de données. Si vous avez besoin d'autres ajustements, faites-le-moi savoir ! 😊
