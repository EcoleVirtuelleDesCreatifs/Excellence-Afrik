@extends('layouts.dashboard')

@section('title', 'Analytics')
@section('page_title', 'Analytics')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Analytics</li>
@endsection

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1">Analytics & Statistiques</h2>
        <p class="text-muted mb-0">Analysez les performances de votre contenu</p>
    </div>
    <div class="btn-group">
        <button class="btn btn-outline-secondary" onclick="exportReport()">
            <i class="fas fa-download me-2"></i>Exporter
        </button>
        <button class="btn btn-primary" onclick="refreshData()">
            <i class="fas fa-sync me-2"></i>Actualiser
        </button>
    </div>
</div>

<!-- Time Period Filter -->
<div class="dashboard-card mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label class="form-label mb-0">Période :</label>
            </div>
            <div class="col-auto">
                <select class="form-select" id="timePeriod" onchange="updateCharts()">
                    <option value="7">7 derniers jours</option>
                    <option value="30" selected>30 derniers jours</option>
                    <option value="90">3 derniers mois</option>
                    <option value="365">12 derniers mois</option>
                </select>
            </div>
            <div class="col-auto">
                <input type="date" class="form-control" id="startDate">
            </div>
            <div class="col-auto">à</div>
            <div class="col-auto">
                <input type="date" class="form-control" id="endDate">
            </div>
        </div>
    </div>
</div>

<!-- Key Metrics -->
<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(37, 99, 235, 0.1); color: var(--primary-color);">
                <i class="fas fa-eye"></i>
            </div>
            <div class="stat-value">125,430</div>
            <div class="stat-label">Vues totales</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> +15.2% vs mois dernier
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--success-color);">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value">8,542</div>
            <div class="stat-label">Visiteurs uniques</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> +8.7% vs mois dernier
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: var(--warning-color);">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-value">3:24</div>
            <div class="stat-label">Temps moyen</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> +12.3% vs mois dernier
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: var(--danger-color);">
                <i class="fas fa-percentage"></i>
            </div>
            <div class="stat-value">68.5%</div>
            <div class="stat-label">Taux de rebond</div>
            <div class="stat-change negative">
                <i class="fas fa-arrow-down"></i> -2.1% vs mois dernier
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title">Évolution du trafic</h3>
            </div>
            <div class="card-body">
                <canvas id="trafficChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title">Sources de trafic</h3>
            </div>
            <div class="card-body">
                <canvas id="sourcesChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Content Performance -->
<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title">Articles les plus populaires</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Article</th>
                                <th>Vues</th>
                                <th>Engagement</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="fw-semibold">Aminata Traoré : La révolution fintech</div>
                                    <small class="text-muted">Portrait</small>
                                </td>
                                <td>12,456</td>
                                <td>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" style="width: 85%"></div>
                                    </div>
                                    <small>85%</small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="fw-semibold">L'agritech ivoirienne qui nourrit l'Afrique</div>
                                    <small class="text-muted">Startup</small>
                                </td>
                                <td>9,234</td>
                                <td>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-primary" style="width: 72%"></div>
                                    </div>
                                    <small>72%</small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="fw-semibold">Les néobanques africaines défient les géants</div>
                                    <small class="text-muted">Finance</small>
                                </td>
                                <td>7,891</td>
                                <td>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-warning" style="width: 68%"></div>
                                    </div>
                                    <small>68%</small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title">Géolocalisation des visiteurs</h3>
            </div>
            <div class="card-body">
                <div class="country-stats">
                    <div class="country-item">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><i class="fas fa-flag me-2"></i>Côte d'Ivoire</span>
                            <span class="fw-semibold">35.2%</span>
                        </div>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 35.2%"></div>
                        </div>
                    </div>
                    <div class="country-item">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><i class="fas fa-flag me-2"></i>Sénégal</span>
                            <span class="fw-semibold">22.8%</span>
                        </div>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar bg-primary" style="width: 22.8%"></div>
                        </div>
                    </div>
                    <div class="country-item">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><i class="fas fa-flag me-2"></i>Mali</span>
                            <span class="fw-semibold">15.6%</span>
                        </div>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar bg-warning" style="width: 15.6%"></div>
                        </div>
                    </div>
                    <div class="country-item">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><i class="fas fa-flag me-2"></i>Burkina Faso</span>
                            <span class="fw-semibold">12.4%</span>
                        </div>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar bg-info" style="width: 12.4%"></div>
                        </div>
                    </div>
                    <div class="country-item">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><i class="fas fa-flag me-2"></i>Autres</span>
                            <span class="fw-semibold">14.0%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-secondary" style="width: 14%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Device & Browser Stats -->
<div class="row g-4">
    <div class="col-lg-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title">Appareils</h3>
            </div>
            <div class="card-body">
                <canvas id="devicesChart" height="200"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title">Navigateurs</h3>
            </div>
            <div class="card-body">
                <div class="browser-stats">
                    <div class="browser-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fab fa-chrome me-2"></i>Chrome</span>
                            <span class="fw-semibold">58.3%</span>
                        </div>
                    </div>
                    <div class="browser-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fab fa-safari me-2"></i>Safari</span>
                            <span class="fw-semibold">23.7%</span>
                        </div>
                    </div>
                    <div class="browser-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fab fa-firefox me-2"></i>Firefox</span>
                            <span class="fw-semibold">12.1%</span>
                        </div>
                    </div>
                    <div class="browser-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fab fa-edge me-2"></i>Edge</span>
                            <span class="fw-semibold">5.9%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title">Réseaux sociaux</h3>
            </div>
            <div class="card-body">
                <div class="social-stats">
                    <div class="social-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fab fa-facebook text-primary me-2"></i>Facebook</span>
                            <span class="fw-semibold">2,456</span>
                        </div>
                    </div>
                    <div class="social-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fab fa-linkedin text-info me-2"></i>LinkedIn</span>
                            <span class="fw-semibold">1,892</span>
                        </div>
                    </div>
                    <div class="social-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fab fa-twitter text-primary me-2"></i>Twitter</span>
                            <span class="fw-semibold">1,234</span>
                        </div>
                    </div>
                    <div class="social-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fab fa-instagram text-danger me-2"></i>Instagram</span>
                            <span class="fw-semibold">892</span>
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
.country-item,
.browser-item,
.social-item {
    padding: 0.75rem 0;
    border-bottom: 1px solid #f3f4f6;
}

.country-item:last-child,
.browser-item:last-child,
.social-item:last-child {
    border-bottom: none;
}

.progress {
    background-color: #f3f4f6;
}

.stat-change.negative {
    color: var(--danger-color);
}

.stat-change.positive {
    color: var(--success-color);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
});

function initializeCharts() {
    // Traffic Chart
    const trafficCtx = document.getElementById('trafficChart').getContext('2d');
    new Chart(trafficCtx, {
        type: 'line',
        data: {
            labels: ['1 Jan', '5 Jan', '10 Jan', '15 Jan', '20 Jan', '25 Jan', '30 Jan'],
            datasets: [{
                label: 'Vues',
                data: [3200, 4100, 3800, 5200, 4800, 6100, 5900],
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Visiteurs uniques',
                data: [2100, 2800, 2600, 3400, 3100, 3900, 3700],
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f3f4f6'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Sources Chart
    const sourcesCtx = document.getElementById('sourcesChart').getContext('2d');
    new Chart(sourcesCtx, {
        type: 'doughnut',
        data: {
            labels: ['Recherche organique', 'Direct', 'Réseaux sociaux', 'Référents', 'Email'],
            datasets: [{
                data: [45, 25, 15, 10, 5],
                backgroundColor: [
                    '#2563eb',
                    '#10b981',
                    '#f59e0b',
                    '#ef4444',
                    '#8b5cf6'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });

    // Devices Chart
    const devicesCtx = document.getElementById('devicesChart').getContext('2d');
    new Chart(devicesCtx, {
        type: 'pie',
        data: {
            labels: ['Mobile', 'Desktop', 'Tablet'],
            datasets: [{
                data: [65, 30, 5],
                backgroundColor: [
                    '#2563eb',
                    '#10b981',
                    '#f59e0b'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true
                    }
                }
            }
        }
    });
}

function updateCharts() {
    const period = document.getElementById('timePeriod').value;
    console.log('Updating charts for period:', period);
    // Implement chart update logic here
}

function exportReport() {
    alert('Export du rapport analytics en cours...');
}

function refreshData() {
    alert('Actualisation des données...');
    // Implement data refresh logic here
}
</script>
@endpush
