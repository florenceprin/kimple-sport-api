# kimple-sport

installation projet sous docker :
- git clone + l'url du projet github
se placer dans le dossier docker du projet
dans un terminal faire les commandes suivantes :
- docker-compose build
- puis docker-compose up -d
- puis docker exec -it kimple_php bash
- php bin/console d:d:c (verifier si necessare)
- php bin/console make:migration
- php bin/console d:m:m
- composer install
- php bin/console c:c
et accéder à l'api via l'url localhost:8009
(port renseigné dans le .env du dossier docker)

configuration des clefs publiques/privées poles token jwt :
- dans le dossier config créer un dossier jwt
- générer une paire de clefs publiques/privées dans le dossier config/jwt
- modifier la variable JWT_PASSPHRASE du fichier .env par la passphrase renseignée lors de la génération des clefs


fonctionnement des endpoints de l'api :

pour des raisons de sécurité, veuillez pour chaque endpoint ajouter /{token}
avec le token présent dans le .env à la place de "{token}"
afin de pouvoir communiquer à l'api