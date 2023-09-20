# SnowTricks  

## Installation  
git clone https://github.com/arcausin/SnowTricks.git  

configurer les variables d'environnement de base de données et serveur SMTP dans le fichier ".env.local" à la racine du projet dériver du fichier ".env"  

composer install  

Créer la base de données.  
php bin/console doctrine:database:create  

Générer les structures de table  
php bin/console doctrine:migrations:migrate  

générer les données pré-établies pour tester le projet  
php bin/console doctrine:fixtures:load  
