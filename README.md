Voici un fichier README en français pour votre projet, qui inclut des instructions pour le configurer avec XAMPP pour la base de données :

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

### 2. Installer et Lancer XAMPP

1. Téléchargez et installez **XAMPP** depuis [le site officiel](https://www.apachefriends.org/fr/index.html).
2. Lancez le **Panneau de contrôle XAMPP**.
3. Démarrez les services **Apache** et **MySQL**.

### 3. Configurer la Base de Données

1. Ouvrez **phpMyAdmin** en accédant à `http://localhost/phpmyadmin` dans un navigateur.
2. Créez une nouvelle base de données nommée par exemple `ht_auto`.

3. Importez le fichier SQL (s'il existe dans le projet) :
   - Dans **phpMyAdmin**, sélectionnez la base de données `ht_auto`.
   - Cliquez sur l'onglet **Importer**.
   - Choisissez le fichier SQL fourni dans le projet (par exemple, `database.sql` ou autre fichier similaire).
   - Cliquez sur **Exécuter**.

### 4. Configurer le Projet

Si un fichier de configuration (comme `config.php`) est présent dans le projet, mettez-le à jour avec vos informations locales. Exemple :

```php
<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'ht_auto');
define('DB_USER', 'root');
define('DB_PASS', '');
?>
```

Assurez-vous que :
- `DB_HOST` est `localhost`.
- `DB_NAME` correspond au nom de votre base de données (par exemple, `ht_auto`).
- `DB_USER` est `root` (par défaut pour XAMPP).
- `DB_PASS` est vide (par défaut pour XAMPP).

### 5. Déplacer le Projet dans le Répertoire XAMPP

Déplacez le projet dans le répertoire `htdocs` de XAMPP. Par exemple :

```bash
mv HT-Auto /path/to/xampp/htdocs/
```

Accédez au projet via votre navigateur à l'adresse :  
`http://localhost/HT-Auto`

---

## Utilisation

- **URL principale** : Rendez-vous sur `http://localhost/HT-Auto` pour interagir avec l'application.
- **phpMyAdmin** : Gérez la base de données depuis `http://localhost/phpmyadmin`.

---

## Développement

Si vous souhaitez apporter des modifications ou contribuer au projet :

1. Effectuez les modifications dans votre éditeur préféré.
2. Testez les changements localement en rechargeant la page dans votre navigateur.
3. Si tout fonctionne comme prévu, validez vos modifications avec Git :

```bash
git add .
git commit -m "Votre message de commit"
git push
```

---

## Ressources Utiles

- [Documentation officielle de XAMPP](https://www.apachefriends.org/fr/index.html)
- [Documentation PHP](https://www.php.net/manual/fr/)
- [Documentation MySQL](https://dev.mysql.com/doc/)

---


Si vous avez des questions ou des problèmes, n'hésitez pas à ouvrir une issue dans le dépôt GitHub.

--- 

Si vous avez besoin de détails supplémentaires ou de modifications, faites-le-moi savoir !
