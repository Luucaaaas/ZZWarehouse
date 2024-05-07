## Hébergement

Ce projet est hébergé sur un VPS Ubuntu 23.04 accessible depuis : https://alazary.fr.

### Étape 1 : Installation

```sh
sudo apt update
```
```sh
sudo apt upgrade
```
##### Installation d'Apache2 
```sh
sudo apt install apache2 -y
```
```
sudo systemctl start apache2
```
```
sudo systemctl enable apache2
```

##### Installation de Mariadb 
```sh
mariadb-server -y
```
##### Sécuriser la base de données

```sh
sudo mysql_secure_installation
```

##### Installation de PHP (ici, on installe PHP avec les extensions Apache et MySQL)
```ssh
sudo apt install php libapache2-mod-php php-mysql -y
```
##### Relancer apache
```ssh
sudo systemctl restart apache2
```

### Étape 2 : Configuration de la base de données
##### Connexion à MariaDB
```ssh
sudo mysql -u root -p
```
##### Création de la base de données
```ssh
CREATE DATABASE nom_de_la_base;
```
##### Utiliser la base de données
```ssh
USE nom_de_la_base;
```
##### Création d'un utilisateur
```ssh
GRANT ALL PRIVILEGES ON nom_de_la_base.* TO 'nom_de_l'utilisateur@'localhost' IDENTIFIED BY 'mot_de_passe'; FLUSH PRIVILEGES;
```
##### Importation de la base de données
```ssh
source /chemin/vers/le/script.sql;
```
### Étape 3 : Configuration du serveur (Apache)

##### Création des dossiers
```sh
sudo mkdir -p /var/www/nom_de_domaine.com/html
```

##### Attribution des permissions
```sh
sudo chown -R $USER:$USER /var/www/nom_de_domaine.com/html
```

##### Modification des permissions pour permettre à Apache de lire les fichiers

```sh
sudo chmod -R 755 /var/www
```
#### Creation des fichiers de configuration

##### Copie de la configuration par defaut pour le domaine
```sh
sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/nom_de_domaine.com.conf
```

##### Modification du fichier de configuration corentin.isitech.conf (/etc/apache2/sites-available/nom_de_domaine.com.conf)

```
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    ServerName nom_de_domaine.com
    ServerAlias www.nom_de_domaine.com
    DocumentRoot /var/www/nom_de_domaine.com/html
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

##### Activation des fichiers de configuration
```sh
sudo a2ensite nom_de_domaine.com.conf
```

##### Desactivation de la configuration par defaut

```sh
sudo a2dissite 000-default.conf
```

## Verification de la configuration
```sh
sudo apache2ctl configtest
```
```sh
sudo systemctl restart apache2
```

## Etape 4 : Installation de certbot pour générer un certificat SSL avec Let's Encrypt
```sh
sudo apt install certbot python3-certbot-apache -y
```
```sh
sudo certbot --apache
```
## Technologies

Voici la liste des technologies utilisées :

| Technologie | Site |
| ------ | ------ |
| Xampp | https://www.apachefriends.org/ |
| Apache | https://httpd.apache.org/ |
| PHP | https://www.php.net/ |
| GitHub | https://github.com/ |
| Mariadb | https://mariadb.org/ |
