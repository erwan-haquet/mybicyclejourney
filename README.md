# My Bicycle Journey 🚴
My Bicycle Journey est un projet de plateforme web de blogging spécialisé dans le voyage à vélo.   

Pour en savoir plus sur le projet, rendez-vous sur [My Bicycle Journey - le projet](https://github.com/erwan-haquet/mybicyclejourney/wiki/My-Bicycle-Journey) !

## Quick start

### Pré-requis

Pour pouvoir lancer le projet, il est nécessaire d'avoir installé les dépendences suivantes :

- [Docker engine](https://docs.docker.com/engine/installation/)
- [Docker compose](https://docs.docker.com/compose/install/)

### Installation du project

Cloner le projet :

```bash
$ git clone git@github.com:erwan-haquet/mybicyclejourney.git mybicyclejourney
$ cd mybicyclejourney
```

Générer votre fichier `.env.local` et modifier le fichier avec vos informations :

```bash
$ cp .env .env.local
```

Construire les conteneurs docker et les lancer une première fois :

```bash
$ docker compose build 
$ docker compose up 
```

Connecter vous au conteneur php :   
```bash
$ ./scripts/run.sh console
```

Puis installer les dépendances :
```bash
$ composer install 
$ yarn install
```

And voila !

### Lancement du project

Lancer tous les services :

```bash
$ docker compose up
```

L'application est désormais accessible via [http://[::]:8080/](http://[::]:8080/).

La console php est accessible via :   
```bash
$ ./scripts/run.sh console
```

Pour la gestion des assets,  depuis la console php :    
```bash 
$ yarn encore dev # Pour compiler les assets
$ yarn encore dev --watch # Pour watch et compiler les assets
```

## À savoir

### Accéder à l'adminer postgres
L'adminer postgreSQL vous permet de visualiser facilement vos données en local.

Se rendre sur [http://[::]:8081/](http://[::]:8081/), avec pour informations de connexion :   

```
Système :        PostgreSQL
Serveur :        postgres
Utilisateur :    ${POSTGRES_USER}     # cf .env
Mot de passe :   ${POSTGRES_PASSWORD} # cf .env
Base de donnée : ${POSTGRES_DB_NAME}  # cf .env
```


