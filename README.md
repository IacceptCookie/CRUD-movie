# SAE 2-01

## Auteurs :

__DURAND Raphaël__ : __dura0074__

__PHILIPPE Alexandre__ : __phil0105__

## Installation du projet :

* pour cloner le [dépôt](https://iut-info.univ-reims.fr/gitlab/phil0105/sae2-01.git)
```
git clone https://iut-info.univ-reims.fr/gitlab/phil0105/sae2-01.git
```

* pour installer les éléments composer :
```
composer install
```

## Scripts composer :

### Lancement du serveur local : (scripts dans le répertoire bin)

* pour lancer sous linux
```
composer start:linux
```

* pour lancer sous windows
```
composer start:windows
```

* commande réduite sous linux uniquement
```
composer start
```

### PHP CS Fixer

* pour tester le formatage du code : 
```
composer test:cs
```

* pour corriger le formatage du code :
```
composer fix:cs
```

## Description du projet

### Classes 
Notre projet est composé de cinq classes qui se situent dans src/Database/Entity :

* La classe People qui contient les informations des acteurs, des accesseurs à ces informations et une méthode ``findById`` qui permet de retourner les informations d'une personne à partir de son id.
* La classe Movie qui contient les informations sur les films avec des accesseurs et des modificateurs ainsi qu'une méthode ``findById`` qui permet de retourner les informations d'un film à partir de son id. Cette classe possède aussi des opérations CRUD qui permettent de supprimer, créer, mettre à jour, modifier et sauvegarder un film.
* La classe Image qui contient deux paramètres d'instance (id et jpeg), leurs accesseurs, et une méthode ``findById`` qui permet de retourner un objet image à partir de son id.
* La classe Genre qui contient deux paramètres d'instance (id et name) ainsi que leurs accesseurs. Elle contient également une méthode ``findById`` qui permet de retrouver le nom d'un genre à l'aide de l'id passé en paramètre
* La classe Cast qui est décrite par cinq attributs et qui contient une méthode ``getRoleById`` et qui permet d'obtenir la valeur du rôle à parti de l'id d'un film et l'id d'une personne.

### Collections
Notre projet contient également trois collections qui se situent dans src/Database/Entity/Collection :

* GenreCollection qui contient uniquement une méthode ``findAll`` qui permet de retourner un tableau contenant tous les genres. 
* MovieCollection qui contient trois méthodes. ``findAll`` qui retourne tous les films, ``findByPeopleId`` qui retourne les films dans lesquels une personne a joué et ``findByGenreId`` qui retourne tous les films d'un genre passé en paramètre.
* PeopleCollection qui contient uniquement une méthode ``findByMovieId`` qui permet de récupérer tous les acteurs d'un film passé en paramètre.

### Pages
Nous avons réalisé trois pages lors de ce projet. 


Une première, index.php qui constitue la page principale de notre site avec la liste de tous les films, la possibilité de réaliser un tri par genre de film
ou encore la fonction "ajouter" pour ajouter un nouveau film. Il est accessible en saisissant l'adresse localhost/index.php dans le navigateur. Chaque film de cette page
est un lien cliquable qui renvoie à la deuxième page.

La deuxième page, movie.php est une page secondaire qui contient le film sur lequel on a cliqué avec des informations sur celui-ci telles que
son titre, sa date de sortie, ou encore son résumé. On a aussi deux boutons qui nous permette soit de modifier les informations du film soit de la supprimer. Elle contient également la liste des tous les acteurs qui ont joué dans ce film avec leur rôle. Cette liste
est sous forme de liens cliquables qui mènent vers la troisième page.

La troisième page, people.php est également une page secondaire qui contient l'acteur sur lequel on a cliqué avec des informations sur celui-ci telles que son nom, sa date de naissance ou encore sa biographie.
Elle contient également la liste des film dans lesquels cette acteur a joué. Cette liste est faite de liens cliquables qui mènent vers la deuxième page.


### Utilisation du site

Pour utiliser ce site, il suffit de démarrer le serveur local en saisissant dans un terminal à la racine du projet `composer start` si vous êtes sur linux ou bien `composer start:windows` si vous êtes sur windows.
Ensuite, il faut se rendre sur un naviguateur web, par exemple google chrome et taper `localhost:8000/index.php` pour ouvrir la première page. Ensuite, vous pouvez cliquer sur des films pour découvrir la deuxième page et sur des artistes pour découvrir la dernière.
Pour revenir simplement à la page d'accueil, vous avez juste à cliquer sur le logo représentant une maison en haut à gauche de votre écran.
Si vous souhaitez modifier la page, vous pouvez cliquer sur les différents boutons. Pour la modification et l'ajout d'un film il ne faut pas oublier d'appuyer sur le bouton "enregistrer" pour valider mais pour la suppression il n'y a pas d'étapes intermédiaires d'où le fait d'être prudent avec ce bouton.