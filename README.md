# My Bicycle Journey, le projet
My Bicycle Journey est un projet de plateforme web de blogging spécialisé dans le voyage à vélo.   

Pour en savoir plus sur le projet, rendez-vous sur [My Bicycle Journey - le projet](https://github.com/erwan-haquet/mybicyclejourney/wiki/My-Bicycle-Journey)

## Quick start

#### Pré-requis

Pour pouvoir lancer le projet, il est nécessaire d'avoir installé les dépendences suivantes :

- [Docker engine](https://docs.docker.com/engine/installation/)
- [Docker compose](https://docs.docker.com/compose/install/)

#### Installation du project

Cloner le projet

```bash
$ git clone git@github.com:erwan-haquet/mybicyclejourney.git mybicyclejourney
$ cd mybicyclejourney
```

générer un fichier `.env.local`

```bash
$ cp .env .env.local
```

Setup les conteneurs docker

```bash
$ docker compose build 
```

#### Lancement du project

Lancer tous les services

```bash
$ docker-compose up
```

#### Accéder à l'adminer postgres

Se rendre sur [http://[::]:8080/](http://[::]:8080/)

```
Système :        PostgreSQL
Serveur :        postgres
Utilisateur :    postgres
Mot de passe :   ${POSTGRES_ROOT_PASSWORD} # cf .env
Base de donnée : ${POSTGRES_DB_NAME}       # cf .env
```


