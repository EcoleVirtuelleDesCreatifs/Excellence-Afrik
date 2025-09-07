# Système de Rôles - Excellence Afrik

Ce document détaille les rôles utilisateurs et leurs permissions dans le système de gestion de contenu Excellence Afrik.

## 👥 Rôles Disponibles

Le système comprend trois rôles principaux :
- **Admin** (Administrateur)
- **Directeur de Publication** 
- **Journaliste**

---

## 🛡️ Admin (Administrateur)

### **Utilisateur Type**
- **Email** : `admin@excellenceafrik.com`
- **Rôle** : `admin`
- **Niveau d'accès** : Maximum

### **Permissions - Gestion des Articles**
- ✅ **Créer** : Nouveaux articles avec tous les statuts
- ✅ **Voir** : TOUS les articles (sauf brouillons privés des journalistes)
- ✅ **Modifier** : Tous les articles existants
- ✅ **Supprimer** : Tous les articles (sans restriction)
- ✅ **Publier** : Publication directe sans validation
- ✅ **Approuver** : Validation des articles en attente (`pending`)
- ✅ **Actions groupées** : Toutes les actions sur multiple articles

### **Permissions - Gestion des Catégories**
- ✅ **Créer** : Nouvelles catégories
- ✅ **Voir** : Toutes les catégories
- ✅ **Modifier** : Toutes les catégories
- ✅ **Supprimer** : Toutes les catégories

### **Permissions - Gestion des Utilisateurs**
- ✅ **Voir** : Liste complète des utilisateurs
- ✅ **Gérer** : Rôles et permissions
- ✅ **Créer** : Nouveaux comptes utilisateurs

### **Permissions - Système**
- ✅ **Analytics** : Accès aux statistiques complètes
- ✅ **Paramètres** : Configuration du système
- ✅ **Magazines** : Gestion complète des magazines PDF
- ✅ **WebTV** : Gestion complète du contenu vidéo

---

## 📋 Directeur de Publication

### **Utilisateur Type**
- **Nom** : Venance Kokora
- **Email** : `venance.kokora@excellenceafrik.com`
- **Rôle** : `directeur_publication`
- **Niveau d'accès** : Élevé

### **Permissions - Gestion des Articles**
- ✅ **Créer** : Nouveaux articles avec tous les statuts
- ✅ **Voir** : TOUS les articles (sauf brouillons privés des journalistes)
- ✅ **Modifier** : Tous les articles existants
- ✅ **Supprimer** : Tous les articles (sans restriction)
- ✅ **Publier** : Publication directe sans validation
- ✅ **Approuver** : Validation des articles en attente (`pending`)
- ✅ **Actions groupées** : Toutes les actions sur multiple articles

### **Permissions - Gestion des Catégories**
- ✅ **Créer** : Nouvelles catégories
- ✅ **Voir** : Toutes les catégories
- ✅ **Modifier** : Toutes les catégories
- ✅ **Supprimer** : Toutes les catégories

### **Permissions - Contenu**
- ✅ **Analytics** : Accès aux statistiques éditoriales
- ✅ **Magazines** : Gestion complète des magazines PDF
- ✅ **WebTV** : Gestion complète du contenu vidéo

### **Restrictions**
- ❌ **Paramètres système** : Pas d'accès aux configs techniques
- ❌ **Gestion utilisateurs** : Ne peut pas créer/modifier les comptes

---

## ✍️ Journaliste

### **Utilisateur Type**
- **Nom** : Ange Ire Lou
- **Email** : `ange.irelou@excellenceafrik.com`
- **Rôle** : `journaliste`
- **Niveau d'accès** : Standard

### **Permissions - Gestion des Articles**

#### **Création d'Articles**
- ✅ **Créer** : Nouveaux articles
- ✅ **Statuts autorisés** : `draft` (brouillon), `pending` (soumission)
- ❌ **Publication directe** : Ne peut pas publier (`published`)

#### **Visibilité des Articles**
- ✅ **Ses propres brouillons** : Privés, visibles uniquement par lui
- ✅ **Articles soumis/publiés des autres** : Visible (statuts `pending`, `published`)
- ❌ **Brouillons des autres journalistes** : Confidentiels

#### **Modification des Articles**
- ✅ **Tous les articles visibles** : Peut modifier n'importe quel article accessible
- ✅ **Articles publiés** : Peut éditer le contenu même après publication

#### **Suppression des Articles**
- ✅ **Ses propres brouillons** : Suppression libre
- ✅ **Ses articles en attente** : Suppression autorisée
- ❌ **Ses articles publiés** : Plus de suppression après validation admin

### **Permissions - Interface Spécialisée**

#### **Menu "Mes Articles"**
- ✅ **Vue personnelle** : Tous ses articles (brouillons, en attente, publiés)
- ✅ **Actions groupées** : 
  - "Soumettre" (draft → pending)
  - "Brouillon" (retour en draft)
  - "Supprimer" (articles non-publiés uniquement)

#### **Workflow de Publication**
1. **Création** : Article en brouillon (`draft`) - Privé
2. **Rédaction** : Modification libre - Toujours privé
3. **Soumission** : Passage en `pending` - Devient visible par admin/directeur
4. **Validation** : Admin/directeur approuve → `published`
5. **Post-publication** : Plus de suppression possible, modification du contenu ok

### **Permissions - Lecture Seule**
- ✅ **Catégories** : Consultation de toutes les catégories
- ❌ **Création/Modification catégories** : Réservé aux admin/directeurs

### **Restrictions**
- ❌ **Analytics** : Pas d'accès aux statistiques
- ❌ **Gestion utilisateurs** : Aucun accès
- ❌ **Paramètres** : Aucun accès
- ❌ **Magazines/WebTV** : Lecture seule uniquement

---

## 🔒 Règles de Confidentialité

### **Brouillons Journalistes**
- **Principe** : Les brouillons sont **strictement privés**
- **Visibilité** : Seul l'auteur peut voir ses propres brouillons
- **Admin/Directeur** : N'ont **PAS** accès aux brouillons
- **Transition** : Dès qu'un article passe en `pending`, il devient visible

### **Articles Soumis (`pending`)**
- **Visibilité** : Admin, Directeur, tous les journalistes
- **Modification** : Tous peuvent éditer
- **Validation** : Seuls admin/directeur peuvent approuver

### **Articles Publiés (`published`)**
- **Visibilité** : Publique, tous les utilisateurs dashboard
- **Modification** : Contenu modifiable par tous
- **Suppression** : Seuls admin/directeur (journalistes bloqués)

---

## 🎯 Middleware et Sécurité

### **Middleware Personnalisé**
```php
// app/Http/Middleware/VerifierRole.php
public function handle(Request $request, Closure $next, string $rolesAutorises = ''): Response
{
    $rolesPermis = explode('|', $rolesAutorises);
    
    if (!in_array(auth()->user()->role_utilisateur, $rolesPermis)) {
        abort(403, 'Accès non autorisé');
    }
    
    return $next($request);
}
```

### **Protection des Routes**
```php
// Admin uniquement
Route::middleware(['auth', 'verifier.role:admin'])->group(function () {
    Route::get('/dashboard/settings', [DashboardController::class, 'settings']);
});

// Admin + Directeur
Route::middleware(['auth', 'verifier.role:admin|directeur_publication'])->group(function () {
    Route::post('/dashboard/articles/{id}/approve', [DashboardController::class, 'approveArticle']);
});

// Tous les utilisateurs authentifiés
Route::middleware(['auth', 'verifier.role'])->group(function () {
    Route::get('/dashboard/articles', [DashboardController::class, 'articles']);
});
```

### **Méthodes Helper dans User Model**
```php
public function estAdmin(): bool {
    return $this->role_utilisateur === 'admin';
}

public function estDirecteurPublication(): bool {
    return $this->role_utilisateur === 'directeur_publication';
}

public function estJournaliste(): bool {
    return $this->role_utilisateur === 'journaliste';
}
```

---

## 🔄 Workflow Complet

### **Création et Publication d'Article**

1. **Journaliste** se connecte au dashboard
2. **Crée un article** → Statut `draft` (privé)
3. **Rédige et modifie** librement (invisible aux autres)
4. **Soumet pour validation** → Statut `pending` (visible aux admin/directeurs)
5. **Admin/Directeur** voit l'article dans la liste
6. **Admin/Directeur** approuve → Statut `published` (public)
7. **Journaliste** ne peut plus supprimer mais peut modifier le contenu

### **Gestion des Permissions par Interface**

#### **Liste Principale des Articles**
- **Admin/Directeur** : Articles `pending` et `published` uniquement
- **Journaliste** : Ses brouillons + articles `pending`/`published` des autres

#### **Menu "Mes Articles" (Journalistes)**
- **Contenu** : Tous ses propres articles (tous statuts)
- **Actions** : Modification, soumission, suppression conditionnelle

Cette architecture garantit un workflow éditorial professionnel avec confidentialité et validation appropriées.