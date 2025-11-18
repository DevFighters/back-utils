# Guide pour l'amélioration de code (SOLID + TDD + Clean Code)

Ce document décrit les bonnes pratiques à appliquer pour chaque amélioration de code dans nos projets Git, en s'appuyant systématiquement sur les principes **SOLID**, la méthodologie **TDD** et les préceptes de **Clean Code**.

---

## 1. Processus Git

1. **Création de branche**
    - Nommer la branche de façon explicite : `MGF-XXX-ZZ` 
    - XXX = numéro de ticker
    - ZZ = initiales du créateur
2. **Commits atomiques**
    - Un seul objectif par commit.
    - Messages impératifs, e.g. `Add validation for User.email`.
    - Voir [Convention GIT](./CONVENTIONS_GIT_NAMING.md)
3. **Pull Request**
    - Lien vers le ticket.
    - Description claire du besoin et des changements.
    - PR uniquement vers recette

---

## 2. Test Driven Development (TDD)

Pour toute nouvelle fonctionnalité ou refactor :

1. **Red**
    - Écrire un test unitaire qui échoue (PHPUnit/Pest).
2. **Green**
    - Implémenter le code minimal pour passer le test.
3. **Refactor**
    - Nettoyer et optimiser sans casser les tests.
4. **Coverage**
    - Vérifier la couverture et cas limites.

> *Rappel* : ne jamais coder en dehors de ce cycle (Red → Green → Refactor).

---

## 3. Principes SOLID

- **S**ingle Responsibility : une classe/fonction = une responsabilité.
- **O**pen/Closed : ouvert à l'extension, fermé à la modification (interfaces).
- **L**iskov Substitution : sous-types substituables à leurs bases.
- **I**nterface Segregation : plusieurs interfaces fines plutôt qu'une interface large.
- **D**ependency Inversion : dépendre d'abstractions, pas d'implémentations.

---

## 4. Clean Code

### 4.1 Nommage
- Fonctions et variables claires, verbes pour méthodes.
- Longueur adaptée : ni trop courtes, ni verbeuses.

### 4.2 Fonctions
- Courtes (max 20 lignes), une seule tâche.
- Paramètres limités (idéalement ≤ 3).

### 4.3 Lisibilité
- Indentation cohérente, pas de logique imbriquée > 2 niveaux.
- Supprimer le code mort et les commentaires obsolètes.

### 4.4 Structure
- Regrouper logique similaire.
- Utiliser des exceptions pour gérer les erreurs.

### 4.5 Tests comme documentation
- Nom de test explicite : `test_WhenCondition_ExpectResult()`.
- Scénarios clairs, arrange-act-assert.

---

## 5. Data Fixtures

Pour toute nouvelle entité ou modification d'entité :
  - Créer/modifier la DataFixture correspondante
  - Vérifier le nouveau jeu de données :
    - `php bin/console doctrine:fixtures:load --purge-with-truncate` Supprime toutes les données
    - `php bin/console doctrine:fixtures:load --append` Ajoute sans purger


---