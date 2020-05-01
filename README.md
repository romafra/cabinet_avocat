
Bienvenue 



Installation :
------------------
Il s'agit d'un projet réalisé sous Symfony 5
- Installer composer : https://getcomposer.org/download/
- Cloner le projet sur votre ordinateur dans un dossier de votre serveur local
- Installer les bundle nécessaires : rendez-vous dans le dossier du projet et executez la commande : composer install
- Si besoin créer le fichier .env nécessaire au bon fonctionnement du site

Fichier .env :
---------------
Pour des raisons de sécurité, le fichier .env n'est pas présent sur le repository GITHUB
Vous devrez modifier son contenu pour faire appel à votre base de données en local.

Une fois l'ensemble des bundles installés. Le fichier .env devrait voir apparaitre une configuration de SwiftMailer que vous devrez modifier en fonction de vos besoins.

Base de données et utilisateur par défaut :
--------------------------------------------

Possibilité 1 : 
- Conformément au tutoriel livré lors du dépot de notre dossier, un utilisateur par défaut est présent en base pour permettre l'administration du site internet (gestion des articles, gestion des utilisateurs, gestion des dossiers...).

Pour que celui-ci soit directement fonctionnel, vous trouverez à la racine du repository la base de données du site (avocats.sql) que vous pourrez importer dans votre gestionnaire de base de données (ex. PHPMyAdmin)
Nous vous invitons à lire le tutoriel livré par notre équipe pour prendre connaissance du mot de passe de l'administrateur par défaut.

Possibilité 2 :
- Effectuez la mise à jour de la base de données avec Doctrine
- Créez un compte depuis le site internet
- Modifier le role de l'utilisateur en base de données en ["ROLE_AVOCAT"]
- Créez une nouvelle entrée dans la table "avocats" en reportant la l'id de l'utilisateur dans le champ "USER_ID"
# avocat_project
