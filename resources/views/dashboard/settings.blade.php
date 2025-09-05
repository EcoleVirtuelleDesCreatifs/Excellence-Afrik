@extends('layouts.dashboard')

@section('title', 'Paramètres')
@section('page_title', 'Paramètres')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Paramètres</li>
@endsection

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1">Paramètres du système</h2>
        <p class="text-muted mb-0">Configurez votre application Excellence Afrik</p>
    </div>
    <button class="btn btn-success" onclick="saveAllSettings()">
        <i class="fas fa-save me-2"></i>Sauvegarder tout
    </button>
</div>

<div class="row g-4">
    <!-- Settings Navigation -->
    <div class="col-lg-3">
        <div class="dashboard-card">
            <div class="card-body p-0">
                <nav class="settings-nav">
                    <a href="#general" class="settings-nav-link active" onclick="showSettingsSection('general', this)">
                        <i class="fas fa-cog me-2"></i>Général
                    </a>
                    <a href="#profile" class="settings-nav-link" onclick="showSettingsSection('profile', this)">
                        <i class="fas fa-user me-2"></i>Profil
                    </a>
                    <a href="#security" class="settings-nav-link" onclick="showSettingsSection('security', this)">
                        <i class="fas fa-shield-alt me-2"></i>Sécurité
                    </a>
                    <a href="#notifications" class="settings-nav-link" onclick="showSettingsSection('notifications', this)">
                        <i class="fas fa-bell me-2"></i>Notifications
                    </a>
                    <a href="#appearance" class="settings-nav-link" onclick="showSettingsSection('appearance', this)">
                        <i class="fas fa-palette me-2"></i>Apparence
                    </a>
                    <a href="#advanced" class="settings-nav-link" onclick="showSettingsSection('advanced', this)">
                        <i class="fas fa-tools me-2"></i>Avancé
                    </a>
                </nav>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="dashboard-card mt-4">
            <div class="card-header">
                <h5 class="card-title">Actions rapides</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary btn-sm" onclick="clearCache()">
                        <i class="fas fa-broom me-2"></i>Vider le cache
                    </button>
                    <button class="btn btn-outline-info btn-sm" onclick="backupData()">
                        <i class="fas fa-download me-2"></i>Sauvegarder
                    </button>
                    <button class="btn btn-outline-warning btn-sm" onclick="resetSettings()">
                        <i class="fas fa-undo me-2"></i>Réinitialiser
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Content -->
    <div class="col-lg-9">
        <!-- General Settings -->
        <div class="settings-section" id="general-section">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title">Paramètres généraux</h3>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nom du site</label>
                                <input type="text" class="form-control" value="Excellence Afrik">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Slogan</label>
                                <input type="text" class="form-control" value="L'excellence entrepreneuriale africaine">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" rows="3">Magazine dédié à l'excellence entrepreneuriale africaine, mettant en lumière les success stories et innovations du continent.</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email de contact</label>
                                <input type="email" class="form-control" value="contact@excellenceafrik.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Téléphone</label>
                                <input type="tel" class="form-control" value="+225 01 02 03 04 05">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Fuseau horaire</label>
                                <select class="form-select">
                                    <option value="UTC">UTC</option>
                                    <option value="Africa/Abidjan" selected>Africa/Abidjan</option>
                                    <option value="Africa/Dakar">Africa/Dakar</option>
                                    <option value="Africa/Lagos">Africa/Lagos</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Langue par défaut</label>
                                <select class="form-select">
                                    <option value="fr" selected>Français</option>
                                    <option value="en">English</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Profile Settings -->
        <div class="settings-section" id="profile-section" style="display: none;">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title">Profil utilisateur</h3>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row g-3">
                            <div class="col-12 text-center mb-4">
                                <div class="user-avatar-large mb-3" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-camera me-2"></i>Changer la photo
                                </button>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nom complet</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->name ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ Auth::user()->email ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Téléphone</label>
                                <input type="tel" class="form-control" placeholder="+225 XX XX XX XX XX">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Poste</label>
                                <input type="text" class="form-control" placeholder="Directeur de publication">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Biographie</label>
                                <textarea class="form-control" rows="4" placeholder="Parlez-nous de vous..."></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Security Settings -->
        <div class="settings-section" id="security-section" style="display: none;">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title">Sécurité</h3>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row g-4">
                            <div class="col-12">
                                <h5>Changer le mot de passe</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Mot de passe actuel</label>
                                        <input type="password" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Nouveau mot de passe</label>
                                        <input type="password" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Confirmer le mot de passe</label>
                                        <input type="password" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr>
                                <h5>Authentification à deux facteurs</h5>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="twoFactorAuth">
                                    <label class="form-check-label" for="twoFactorAuth">
                                        Activer l'authentification à deux facteurs
                                    </label>
                                </div>
                                <small class="text-muted">Ajoutez une couche de sécurité supplémentaire à votre compte</small>
                            </div>
                            <div class="col-12">
                                <hr>
                                <h5>Sessions actives</h5>
                                <div class="session-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>Session actuelle</strong>
                                            <br>
                                            <small class="text-muted">Chrome sur Mac - IP: 192.168.1.1</small>
                                        </div>
                                        <span class="badge bg-success">Actuelle</span>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-danger btn-sm mt-2">
                                    <i class="fas fa-sign-out-alt me-2"></i>Déconnecter toutes les autres sessions
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Notifications Settings -->
        <div class="settings-section" id="notifications-section" style="display: none;">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title">Notifications</h3>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-12">
                            <h5>Notifications par email</h5>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                <label class="form-check-label" for="emailNotifications">
                                    Recevoir les notifications par email
                                </label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="newArticles" checked>
                                <label class="form-check-label" for="newArticles">
                                    Nouveaux articles publiés
                                </label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="newComments">
                                <label class="form-check-label" for="newComments">
                                    Nouveaux commentaires
                                </label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="systemUpdates" checked>
                                <label class="form-check-label" for="systemUpdates">
                                    Mises à jour système
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr>
                            <h5>Notifications push</h5>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="pushNotifications">
                                <label class="form-check-label" for="pushNotifications">
                                    Activer les notifications push
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Appearance Settings -->
        <div class="settings-section" id="appearance-section" style="display: none;">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title">Apparence</h3>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-12">
                            <h5>Thème</h5>
                            <div class="theme-options">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="theme" id="lightTheme" value="light" checked>
                                    <label class="form-check-label" for="lightTheme">
                                        <i class="fas fa-sun me-2"></i>Clair
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="theme" id="darkTheme" value="dark">
                                    <label class="form-check-label" for="darkTheme">
                                        <i class="fas fa-moon me-2"></i>Sombre
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="theme" id="autoTheme" value="auto">
                                    <label class="form-check-label" for="autoTheme">
                                        <i class="fas fa-adjust me-2"></i>Automatique
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr>
                            <h5>Couleur d'accent</h5>
                            <div class="color-options">
                                <div class="color-option active" data-color="#2563eb" style="background: #2563eb;"></div>
                                <div class="color-option" data-color="#10b981" style="background: #10b981;"></div>
                                <div class="color-option" data-color="#f59e0b" style="background: #f59e0b;"></div>
                                <div class="color-option" data-color="#ef4444" style="background: #ef4444;"></div>
                                <div class="color-option" data-color="#8b5cf6" style="background: #8b5cf6;"></div>
                                <div class="color-option" data-color="#06b6d4" style="background: #06b6d4;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advanced Settings -->
        <div class="settings-section" id="advanced-section" style="display: none;">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title">Paramètres avancés</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Attention :</strong> Ces paramètres sont destinés aux utilisateurs avancés. 
                        Une mauvaise configuration peut affecter le fonctionnement du site.
                    </div>
                    
                    <div class="row g-4">
                        <div class="col-12">
                            <h5>Performance</h5>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="enableCache" checked>
                                <label class="form-check-label" for="enableCache">
                                    Activer la mise en cache
                                </label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="enableCompression" checked>
                                <label class="form-check-label" for="enableCompression">
                                    Compression des ressources
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr>
                            <h5>Développement</h5>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="debugMode">
                                <label class="form-check-label" for="debugMode">
                                    Mode débogage
                                </label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="maintenanceMode">
                                <label class="form-check-label" for="maintenanceMode">
                                    Mode maintenance
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.settings-nav {
    display: flex;
    flex-direction: column;
}

.settings-nav-link {
    display: flex;
    align-items: center;
    padding: 1rem 1.5rem;
    color: #6b7280;
    text-decoration: none;
    border-bottom: 1px solid #f3f4f6;
    transition: all 0.3s ease;
}

.settings-nav-link:hover {
    background: #f8fafc;
    color: var(--primary-color);
}

.settings-nav-link.active {
    background: var(--primary-color);
    color: white;
    border-left: 4px solid var(--accent-color);
}

.user-avatar-large {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 2rem;
    margin: 0 auto;
}

.session-item {
    padding: 1rem;
    background: #f8fafc;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
}

.theme-options .form-check {
    margin-bottom: 1rem;
}

.color-options {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.color-option {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    border: 3px solid transparent;
    transition: all 0.3s ease;
}

.color-option.active {
    border-color: #fff;
    box-shadow: 0 0 0 2px var(--primary-color);
}

.color-option:hover {
    transform: scale(1.1);
}

.form-switch .form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}
</style>
@endpush

@push('scripts')
<script>
// Settings Navigation
function showSettingsSection(sectionId, element) {
    // Hide all sections
    document.querySelectorAll('.settings-section').forEach(section => {
        section.style.display = 'none';
    });
    
    // Show selected section
    document.getElementById(sectionId + '-section').style.display = 'block';
    
    // Update navigation
    document.querySelectorAll('.settings-nav-link').forEach(link => {
        link.classList.remove('active');
    });
    element.classList.add('active');
}

// Settings Actions
function saveAllSettings() {
    alert('Paramètres sauvegardés avec succès !');
}

function clearCache() {
    if (confirm('Êtes-vous sûr de vouloir vider le cache ?')) {
        alert('Cache vidé avec succès !');
    }
}

function backupData() {
    alert('Sauvegarde en cours...');
}

function resetSettings() {
    if (confirm('Êtes-vous sûr de vouloir réinitialiser tous les paramètres ?')) {
        alert('Paramètres réinitialisés !');
    }
}

// Color Theme Selection
document.addEventListener('DOMContentLoaded', function() {
    const colorOptions = document.querySelectorAll('.color-option');
    
    colorOptions.forEach(option => {
        option.addEventListener('click', function() {
            colorOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            
            const color = this.getAttribute('data-color');
            document.documentElement.style.setProperty('--primary-color', color);
        });
    });
});
</script>
@endpush
