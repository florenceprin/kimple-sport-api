# kimple-sport

installation projet sous docker :
docker-compose build
puis docker-compose up -d
puis docker exec -it kimple_php
php bin/console d:d:c
php bin/console make:migration
php bin/console d:m:m
et accéder à l'api via l'url localhost:8009
(port renseigné dans le .env du dossier docker)

fonctionnement des endpoints de l'api :

pour des raisons de sécurité, veuillez pour chaque endpoint ajouter /{token}
avec le token présent dans le .env à la place de "{token}"
afin de pouvoir communiquer à l'api