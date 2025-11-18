## Convention de nommage des commits Git

Pour assurer la lisibilité et la cohérence des messages de commit, nous utilisons le format suivant :

```
<type>(<scope>): <sujet>

<corps_du_message>

<footer>
```

- **type** : catégorie du commit (obligatoire)
- **scope** : partie du code affectée (optionnel)
- **sujet** : description concise du changement (max. 50 caractères)
- **corps_du_message** : explication détaillée si nécessaire (max. 72 caractères par ligne)
- **footer** : métadonnées supplémentaires (ex. issues, breaking changes)

### Types disponibles

- `build`    : changements affectant le système de build ou les dépendances externes (npm, make…)
- `ci`       : changements concernant l’intégration continue ou la configuration (Travis, Ansible…)
- `feat`     : ajout d’une nouvelle fonctionnalité
- `fix`      : correction d’un bug
- `perf`     : amélioration des performances
- `refactor` : refactoring sans ajout de fonctionnalité ni amélioration de performances
- `style`    : modifications sans impact fonctionnel (formatage, indentation…)
- `docs`     : rédaction ou mise à jour de la documentation
- `test`     : ajout ou modification de tests

### Exemples

```bash
feat(auth): ajout de la connexion via OAuth2

Permet aux utilisateurs de se connecter avec leur compte Google ou Facebook.

Closes #42
```

```bash
fix(api): correction de la gestion des erreurs 500

Les erreurs internes du serveur retournent désormais un objet JSON standardisé.
```

```bash
ci: mise à jour du pipeline GitLab CI pour PHP 8.3

- Passage à l’image Docker officielle PHP 8.3
- Ajout de l’étape de tests unitaires
```

Pour plus d’infos, voir [Conventional Commits](https://www.conventionalcommits.org/).
