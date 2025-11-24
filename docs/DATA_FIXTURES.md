# Guide pour utilisation des DataFixtures

## 1. Données fixes, nécessaires pour l'application [INIT]

1. **Prévoir liste enum**
    - création d'une liste enum référençant les ID fixes
2. **Assigner le group "init" dans la DataFixtures**
    - utilisation de la fonction `public static function getGroups() : array`
3. **Prendre en compte les évolutions avec l'ajout possible de nouvelles datas**
    - si une entité existe => ne pas la réécrire.

## 2. Données pour le jeux d'essai [DEV]

Pour toute nouvelle fonctionnalité ou refactor : 
- **Assigner le group "dev" dans la DataFixtures**
    - utilisation de la fonction `public static function getGroups() : array`

## 3. Utilisation

  - vérifier le nouveau jeu de données :
    - `php bin/console doctrine:fixtures:load --purge-with-truncate` Supprime toutes les données
    - `php bin/console doctrine:fixtures:load --append --group=init` Ajoute sans purger les données du group init

---