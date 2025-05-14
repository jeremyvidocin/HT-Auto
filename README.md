
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
   - Entrez le nom de votre base de données, par exemple `ht_auto`, et cliquez sur **Créer**.

3. **Importer les Tables** :
   - Si le projet contient un fichier SQL (comme `database.sql`), suivez ces étapes :
     1. Sélectionnez la base de données `ht_auto`.
     2. Cliquez sur l'onglet **Importer**.
     3. Cliquez sur **Choisir un fichier**, sélectionnez le fichier SQL fourni dans le projet, puis cliquez sur **Exécuter**.

4. **Structure Exemple de la Base de Données** *(si aucun fichier SQL n'est fourni)* :
   - Si le fichier `database.sql` n'est pas disponible, créez manuellement les tables nécessaires via phpMyAdmin ou un script SQL. Voici un exemple de table `users` :

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

### 4. Configurer la Connexion à la Base de Données

1. **Fichier de Configuration** :
   - Vérifiez si un fichier `config.php` est présent dans le projet.
   - Si ce fichier n'existe pas, créez-en un dans le répertoire principal du projet avec le contenu suivant :

```php
<?php
// Configuration de la base de données
define('DB_HOST', 'localhost'); // L'hôte de la base de données
define('DB_NAME', 'ht_auto');   // Le nom de la base de données
define('DB_USER', 'root');      // L'utilisateur de la base de données (par défaut "root" pour XAMPP)
define('DB_PASS', '');          // Le mot de passe (par défaut vide pour XAMPP)

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
```

2. **Vérification de la Connexion** :
   - Ajoutez un fichier simple, par exemple `test_connection.php`, pour vérifier si la connexion fonctionne :

```php
<?php
require 'config.php';

if ($pdo) {
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



Si vous avez des questions ou des problèmes, n'hésitez pas à ouvrir une issue dans le dépôt GitHub.

---

