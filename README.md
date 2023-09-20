# SnowTricks  

1. Installation du projet  
```
git clone https://github.com/arcausin/SnowTricks.git
```

2. Configurer les variables d'environnement de base de données et serveur SMTP dans le fichier ".env.local" à la racine du projet dériver du fichier ".env"  

### ouvrer une invite de commande et rendez-vous dans le répertoire du projet  

3. Installer les dépendances du projet  
```
composer install  
```

4. Créer la base de données.  
```
php bin/console doctrine:database:create
```

5. Générer les structures de table  
```
php bin/console doctrine:migrations:migrate
``` 

6. générer les données pré-établies pour tester le projet  
```
php bin/console doctrine:fixtures:load
```

7. Lancer le serveur local du projet
```
symfony server:start
```
