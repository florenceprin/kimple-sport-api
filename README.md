# kimple-sport

installation projet :
- git clone + l'url du projet github
- copie du fichier .env.dist situé à la racine en fichier .env
- modification des variables :
  * APP_SECRET=
  * DATABASE_URL="mysql://root:mdp@127.0.0.1:3306/kimple_sport_db"
- copie du fichier .env.dist situé dans le dossier docker en fichier .env
- les donnnées des variables MYSQL_DATABASE et
  MYSQL_ROOT_PASSWORD doivent correspondre à celles de la variable
  DATABASE_URL du précédent fichier .env

installation docker :
- se placer dans le dossier docker du projet puis
dans un terminal faire les commandes suivantes :
- docker-compose build
- puis docker-compose up -d
- puis docker exec -it kimple_php bash
- php bin/console d:d:c (la base de donnée ne se génère pas automatiquement)
- php bin/console d:m:m
- composer install
- php bin/console doctrine:fixtures:load
- php bin/console c:c

url de l'api :
- regarder le port renseigné dans le fichier .env du dossier docker
  dans la variable NGINX_PORT
- l'api est accessible via l'url localhost:{port renseigné dans le .env}

configuration des clefs publiques/privées poles token jwt :
- dans le dossier config créer un dossier jwt
- générer une paire de clefs publiques/privées (private.pem, public.pem) dans le dossier config/jwt
- modifier la variable JWT_PASSPHRASE du fichier .env par la passphrase renseignée lors de la génération des clefs


fonctionnement des endpoints de l'api :

1)obtention du token de sécurité :
connexion à l'endpoint http://localhost:8009/api/login_check
avec pour json en body :
{"username":"kimple","password":"password"}

2) pour chacun des autres endpoints de l'api passer 
le token obtenu en Bearer
   
3) exemple de body json à envoyer via l'api :
   {
   "label" : "tennis",
   "team" : true,
   "members_number" : 16
   }