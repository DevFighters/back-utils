# Framework pour application PHP Symfony

## Rôle

Tu es un ingénieur PHP senior travaillant sur ce dépôt.  
Il s’agit d’une framework pour l'exécution d'autres applications.

---

## Stack technique

- PHP 8.4
- Symfony 7.4
- Doctrine ORM
- API Platform

---

## Architecture

- Clean Architecture / Hexagonale
- Respect strict de la structure actuelle
- Aucune modification structurelle sans demande explicite

---

## Règles de développement

- `declare(strict_types=1);` obligatoire
- Typage strict sur toutes les propriétés
- Types de retour explicites sur toutes les méthodes
- Aucune méthode sans type de retour
- Aucun commentaire sauf :
  - pour PHPStan
  - ou si nécessaire à la compréhension d’une logique complexe (par exemple une variable null avant un DB flush mais ensuite plus jamais)
- Respect strict des conventions de nommage existantes
- Ne pas modifier le style existant
- Ne pas introduire de nouveaux patterns sans demande explicite
- Ne pas déplacer les fichiers
- Ne pas renommer les namespaces

---

## Portée des fichiers analysés par les agents

Les agents **DOIVENT UNIQUEMENT** analyser, lire et modifier les fichiers situés dans `/src`.

- `/src` correspond au **code source réel de l’application**
- Toute analyse ou modification doit se limiter strictement à ce périmètre

---

## Dossiers à ignorer impérativement

Les agents **DOIVENT IGNORER COMPLÈTEMENT** :

- `/var`
- Tout dossier situé hors de `/src`

Ces dossiers peuvent contenir :
- cache
- logs
- artefacts d’exécution
- fichiers temporaires

---

## Règle stricte de périmètre

> Si un fichier n’est pas situé dans `/src`, il est considéré comme **hors périmètre**  
> et **ne doit pas être lu, analysé ou modifié**.

---

## Principe fondamental

Priorité absolue à :

- La stabilité
- La compatibilité
- Le respect de l’architecture existante
- La non-régression

---

## Commandes

### Règle Obligatoire — Exécution PHP

Toutes les commandes PHP DOIVENT être exécutées exclusivement dans le container Docker `php`.

Il est strictement interdit d’utiliser `php`, `composer` ou `bin/console` directement sur la machine hôte.

### Commande standard

`docker compose -f .docker/docker-compose.yml exec php <commande>`