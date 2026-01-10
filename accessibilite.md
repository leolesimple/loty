# Accessibilité et Qualité Web - Projet LOTY

## <a id="wcag"></a>🌐 Accessibilité WCAG 2.1

### 1. Accessibilité visuelle

#### 1.1 Alternatives textuelles
-  **Images descriptives** : Tous les éléments visuels possèdent des attributs `alt` appropriés
  - Exemple: `<img src="LOTY_Logo.svg" alt="Revenir à l'accueil">`
  - Les images décoratives sont marquées avec `alt=""` ou `aria-hidden="true"`
  - Exemple: `<div class="cartBentoImagePlaceholder" aria-hidden="true">`

#### 1.2 Contenu multimédia
-  **Contenu alternatif** : Tous les contenus complexes ont des descriptions textuelles
-  **SVG accessibles** : Les icônes SVG incluent des textes alternatifs

#### 1.3 Responsive
-  **Responsive Design** : Le site s'adapte à tous les écrans via CSS Grid et media queries
  - Points de rupture (breakpoints): 768px, 900px, 1024px
  - Exemple CSS: `@media (max-width: 768px) { ... }`
-  **Structure HTML sémantique** :
  - Utilisation correcte des balises `<header>`, `<nav>`, `<main>`, `<footer>`
  - Hiérarchie des titres respectée: `<h1>` → `<h2>` → `<h3>`
  - Listes sémantiques avec `<ul>` et `<li>`

#### 1.4 Clarté visuelle
-  **Contraste des couleurs** :
  - Texte principal : #E94141 (rouge) sur #F9F2E8 (beige) → Ratio ≥ 4.5:1
  - Texte secondaire : #1F7A73 (teal) sur #F9F2E8 (beige) → Ratio ≥ 4.5:1
  - Texte clair : #F9F2E8 sur fond rouge/teal → Ratio ≥ 4.5:1

-  **Redimensionnement de texte** : Le site supporte le zoom jusqu'à 200% sans perte de contenu
-  **Indication visuelle du focus** :
  ```css
  *:focus {
      outline: 3px solid #075751;
      outline-offset: 2px;
  }
  ```
  Tous les éléments interactifs ont un indicateur visuel clair lors du focus clavier

---

### 2. Navigation

#### 2.1 Accessibilité au clavier
-  **Navigation complète au clavier** : Tous les éléments interactifs sont accessibles via Tab/Shift+Tab
-  **Lien de passage** (Skip Link) :
  ```php
  <a href="#content" class="skip-link">Aller au contenu principal</a>
  ```
  Permet aux utilisateurs de clavier de sauter la navigation répétitive

-  **Ordre de tabulation logique** : Navigation fluide et prévisible
-  **Pas de pièges au clavier** : Les focus peuvent être utilisés facilement

#### 2.2 Assez de temps (Sufficient Time)
-  **Pas d'expiration de session** excessive
-  **Contenu non clignotant** : Pas d'animations distrayantes

#### 2.3 Crises (Seizures)
-  **Pas de contenu clignotant** à plus de 3 fois par seconde
-  **Animations fluides** : Utilisation CSS pour animations éventuelles

#### 2.4 Navigabilité
-  **Objectif du lien clair** :
  ```php
  <a href="/recettes/add" aria-label="Ajouter une recette">
      Ajouter une recette
  </a>
  ```
-  **Fil d'Ariane / Navigation claire** : Utilisateurs toujours en contexte
-  **Prévention des erreurs** : Validations de formulaire avec messages clairs

---

### 3. Compréhension

#### 3.1 Lisibilité
-  **Langue déclarée** : `<html lang="fr">` (Français)
-  **Typographie lisible** : Utilisation de polices sans-serif (Fivo Sans)
-  **Contraste suffisant** : Respecte les ratios WCAG AA

#### 3.2 Prévisibilité
-  **Navigation cohérente** : Menu toujours au même endroit
-  **Comportement prévisible** : Les composants se comportent de manière standard

#### 3.3 Assistance pour la saisie
-  **Validation de formulaires** :
  ```php
  <input type="text" id="recette_nom" name="recette_nom" 
         required aria-required="true">
  <span class="error" id="nameError" aria-live="polite"></span>
  ```
-  **Messages d'erreur clairs** avec `aria-live="polite"` :
  ```php
  <p class='error-message' aria-live='polite' aria-atomic='true'>
      Vous avez été déconnecté avec succès.
  </p>
  ```
  Les utilisateurs sont informés des changements dynamiques sans perte de focus

---

### 4. Accessibilité

#### 4.1 Compatibilité
-  **Pas d'erreurs de génération** : Code HTML propre et correct
-  **Attributs ARIA valides** :
  - `aria-label` pour les boutons sans texte
  - `aria-live` pour les mises à jour dynamiques
  - `aria-required` pour les champs obligatoires
  - `aria-disabled` pour les éléments désactivés
  - `aria-hidden` pour masquer les éléments visuels aux lecteurs d'écran
  - `aria-pressed` pour les boutons bascule
- Utilisation de role pour les éléments non natifs :
  - `role="navigation"` pour les menus
  - `role="alert"` pour les messages d'erreur critiques

---

## <a id="opquast"></a> Critères Opquast implémentés

### Qualité fonctionnelle

#### Identification et clarté
-  **Logo identifiant** : LOTY_Logo.svg bien visible dans le header
-  **Titre selon la page** : `<title>{page} - LOTY</title>`
-  **Description métadonnée** : 
  ```php
  <meta name="description" content="Avec LOTY : Explorez une sélection de Bento...">
  ```

#### Navigation et structure
-  **Navigation principale claire** :
  - ACCUEIL
  - BENTO
  - RECETTES
  - PODIUM
  
-  **Structure hiérarchique cohérente** : Utilisation de balises sémantiques
-  **Lien "Retour" sur les pages détail** :
  ```php
  <a href="/bento" class="btn btn_red btn_icon">
      <img src="/assets/icons/chevron-left-white.svg" alt="">
  </a>
  ```

#### Formulaires
-  **Labels explicites** : Chaque champ possède un label associé
-  **Champs requis marqués** : `required aria-required="true"`
-  **Messages d'erreur contextualisés** : Affichage dynamique des erreurs
-  **Aide utilisateur** : Texte d'aide pour les champs complexes

#### Performance et charge
-  **CSS minifié** : `main.min.css` pour optimisation
-  **Fonts optimisées** : WOFF2 pour réduction de taille

#### Sécurité et conformité
-  **Protection CSRF** : Gestion de session sécurisée
-  **Authentification sécurisée** : 
  - Hachage des mots de passe avec `password_hash()`
  - Régénération d'ID de session
  - Cookies `httponly` et `samesite`
  
-  **Validation d'entrée** : Fonction `clean()` pour échappement XSS
-  **Canonicalisation URL** :
  ```php
  <link rel="canonical" href="<?php echo getCanonicalUrl(); ?>">
  ```

### Qualité opérationnelle

#### Compatibilité navigateurs
-  **Déclaration DOCTYPE** : `<!DOCTYPE html>`
-  **Charset déclaré** : `<meta charset="utf-8">`
-  **Viewport configuré** : 
  ```php
  <meta name="viewport" content="width=device-width, initial-scale=1, 
                                  maximum-scale=1, user-scalable=no">
  ```

#### Responsive Design
-  **Mobile-first CSS** : Breakpoints aux 768px, 900px, 1024px et utilisation des flexbox/grid pour la mise en page native
-  **Images responsives** : Utilisation de `width="auto"` et CSS
-  **Navigation adaptée** : Menu optimisé sur mobile sans utilisation de menu burger.

### Qualité présentation

#### Cohérence visuelle
-  **Design cohérent** : Palette de couleurs unifiée (#E94141, #1F7A73, #F9F2E8)
-  **Typographie unifiée** : 
  - SHRIMP pour les titres
  - Fivo Sans pour le corps
  
-  **Espacement cohérent** : Marges et padding standardisées
-  **Icônes explicites** : SVG avec descriptions textuelles si nécéssaire

#### Utilisation des couleurs
-  **Pas de dépendance à la couleur seule** : Texte descriptif accompagne les visuels
-  **Symboles complémentaires** : Flèches (→) et icônes chevron pour clarifier
-  **Contraste minimum AA** : Tous les éléments respectent 4.5:1 (grâce à l'outil Figma)

#### Interactions
-  **États clairs des éléments interactifs** :
  - `:hover` avec changement de couleur
  - `:focus` avec outline visible
  - Boutons avec visuels clairs

#### Contenu textuel
-  **Absence de justification** : Textes alignés à gauche pour meilleure lisibilité
-  **Interlignage suffisant** : Line-height approprié
-  **Pas de bruit visuel** : Fond épuré (#F9F2E8)
-  **Soulignement réservé aux liens** : Pas de texte souligné.

---

## <a id="architecture"></a>🏗️ Architecture technique accessible

### Implémentation côté serveur (PHP)

#### Gestion des sessions
```php
// Session sécurisée avec attributs httponly
session_set_cookie_params([
    'lifetime' => $lifetime,
    'path' => $cookieParams['path'],
    'domain' => $cookieParams['domain'],
    'secure' => $secure,
    'httponly' => true,  // Protection XSS
    'samesite' => 'Lax'  // Protection CSRF
]);
```

#### Validation et échappement
```php
// Fonction clean() utilisée pour tous les outputs
echo clean($title);  // Échappe les caractères spéciaux
```

### Structure HTML sémantique

#### Landmark regions (régions repères)
```php
<header>
    <nav><!-- Navigation principale --></nav>
</header>
<main id="content">
    <!-- Contenu principal -->
</main>
<footer>
    <!-- Pied de page -->
</footer>
```

#### Rôles et propriétés ARIA (appris en autodidacte par Léo)
```php
<!-- Navigation secondaire -->
<nav class="navigationAction" aria-label="Navigation secondaire">
    <a href="/recettes" class="backButton" aria-label="Retour aux recettes">
        <img src="..." alt="">
    </a>
</nav>

<!-- Groupe de sélection -->
<div class="stepSelector" role="group" aria-label="Sélection des étapes">
    <button type="button" class="stepButton" data-step="1" aria-pressed="false">
        Étape 1
    </button>
</div>

<!-- Conteneur de banneau -->
<div class="termsHeader" role="banner">
    <!-- Contenu important -->
</div>
```

#### Textes masqués mais accessibles
```php
<!-- Utilisé dans nav.php pour icônes sans texte -->
<span class="sr-only">Aller à l'accueil</span>
<span class="sr-only">Voir mon compte</span>
<span class="sr-only">Éditer le profil</span>
<span class="sr-only">Se déconnecter</span>

<!-- CSS correspondant -->
.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0,0,0,0);
    white-space: nowrap;
    border: 0;
}
```

### CSS accessible

#### Focus visible
```css
*:focus {
    outline: 3px solid #075751;  
    outline-offset: 2px;          
}

```

#### Skip link
```css
.skip-link {
    position: absolute;
    top: -40px;             
    left: 0;
    background: #000;
    color: #fff;
    padding: 8px;
    z-index: 10000;
}

.skip-link:focus {
    top: 0;
}
```

#### Responsive design
```css
@media (max-width: 768px) {
    main {
        min-height: auto;
    }
    
    footer {
        flex-direction: column;
        text-align: center;
    }
}

@media (max-width: 1024px) {
    .bentoMainContent {
        flex-direction: column;
        align-items: center;
    }
}
```

### Métadonnées et SEO

```php
<!-- Déclaration de langue -->
<html lang="fr">

<!-- Charset UTF-8 -->
<meta charset="utf-8">

<!-- Viewport pour responsive -->
<meta name="viewport" content="width=device-width, initial-scale=1, 
                               maximum-scale=1, user-scalable=no">

<!-- Descriptions métadonnées -->
<meta name="description" content="...">
<meta name="keywords" content="...">
<meta name="robots" content="index,follow">

<!-- Open Graph pour partage social -->
<meta property="og:title" content="LOTY">
<meta property="og:description" content="...">
<meta property="og:image" content="...">
<meta property="og:image:alt" content="LOTY - Description">

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="/assets/img/favicon.ico">

<!-- Web app capable -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">

<!-- Canonical URL -->
<link rel="canonical" href="<?php echo getCanonicalUrl(); ?>">
```

---

## Règles non implémentées dans le MVP

### Améliorations opquast supplémentaires
1. **Indicateurs de chargement** : Ajouter spinner/loader pour actions longues
2. **Pagination accessible** : Si applicable, ajouter `aria-current="page"`
3. **Mappage de site** : Ajouter un sitemap XML pour meilleur référencement
4. **Temps de réponse** : Optimiser vitesse serveur (Core Web Vitals)
5. **Monitoring de disponibilité** : Ajouter vérification de statut du serveur

### Fonctionnalités accessibilité recommandées
1. **Mode sombre** : ajouter `prefers-color-scheme`
2. **Réduction des animations** : Faire évoluer `prefers-reduced-motion` pour avoir moins d'animations
3. **Aide contextuelle** : Infobulles accessibles pour éléments complexes
