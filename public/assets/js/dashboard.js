/**
 * Dashboard Ultra - Modern, Clean, Dynamic, Revolutionary JavaScript
 * Excellence Afrik - Dashboard Management System
 * No shadows, clean, impactful, minimalist design
 */

class DashboardUltra {
    constructor() {
        this.currentSection = 'dashboard';
        this.charts = {};
        this.sidebarCollapsed = false;
        this.init();
    }

    init() {
        this.initSidebar();
        this.initNavigation();
        this.initCharts();
        this.initFilters();
        this.initSearch();
        this.initNotifications();
        this.initResponsive();
        this.initAnimations();
        
        // Initialize default section
        this.showSection('dashboard');
        
        console.log('🚀 Dashboard Ultra initialized - Modern, Clean, Revolutionary!');
    }

    // Sidebar Management
    initSidebar() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.querySelector('.dashboard-sidebar');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                this.toggleSidebar();
            });
        }

        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', () => {
                this.toggleMobileSidebar();
            });
        }

        // Close sidebar on outside click (mobile)
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 992) {
                if (!sidebar.contains(e.target) && !e.target.closest('.mobile-menu-toggle')) {
                    sidebar.classList.remove('active');
                }
            }
        });
    }

    toggleSidebar() {
        this.sidebarCollapsed = !this.sidebarCollapsed;
        const sidebar = document.querySelector('.dashboard-sidebar');
        const main = document.querySelector('.dashboard-main');
        
        if (this.sidebarCollapsed) {
            sidebar.style.width = '80px';
            main.style.marginLeft = '80px';
            sidebar.classList.add('collapsed');
        } else {
            sidebar.style.width = '280px';
            main.style.marginLeft = '280px';
            sidebar.classList.remove('collapsed');
        }
    }

    toggleMobileSidebar() {
        const sidebar = document.querySelector('.dashboard-sidebar');
        sidebar.classList.toggle('active');
    }

    // Navigation Management (Updated for optimized submenu system)
    initNavigation() {
        // Only handle main nav links that are not submenu toggles
        const navLinks = document.querySelectorAll('.nav-link[data-section]:not(.submenu-toggle)');
        
        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const section = link.getAttribute('data-section');
                this.showSection(section);
                this.updateActiveNav(link);
                this.updateBreadcrumb(section);
                
                // Add ripple effect
                this.addRippleEffect(link, e);
            });
        });

        // Note: Submenu functionality is now handled by the optimized SubmenuManager class
        // This prevents conflicts and provides better performance
        console.log('🔧 Navigation initialized (submenu handling delegated to SubmenuManager)');
    }

    showSection(sectionId) {
        // Hide all sections
        const sections = document.querySelectorAll('.content-section');
        sections.forEach(section => {
            section.classList.remove('active');
        });

        // Show target section
        const targetSection = document.getElementById(`${sectionId}-section`);
        if (targetSection) {
            targetSection.classList.add('active');
            this.currentSection = sectionId;
            
            // Initialize section-specific features
            this.initSectionFeatures(sectionId);
        }
    }

    updateActiveNav(activeLink) {
        // Remove active class from all nav items
        const navItems = document.querySelectorAll('.nav-item');
        navItems.forEach(item => item.classList.remove('active'));
        
        // Add active class to clicked item
        activeLink.closest('.nav-item').classList.add('active');
    }

    updateActiveSubNav(activeSubLink) {
        // Remove active class from all nav items and subitems
        const navItems = document.querySelectorAll('.nav-item');
        const subItems = document.querySelectorAll('.nav-subitem');
        navItems.forEach(item => item.classList.remove('active'));
        subItems.forEach(item => item.classList.remove('active'));
        
        // Add active class to clicked subitem and its parent
        const subItem = activeSubLink.closest('.nav-subitem');
        const parentNavItem = activeSubLink.closest('.nav-item');
        
        if (subItem) subItem.classList.add('active');
        if (parentNavItem) parentNavItem.classList.add('active');
    }

    updateBreadcrumb(section) {
        const breadcrumb = document.querySelector('.breadcrumb-item.active');
        const sectionNames = {
            'dashboard': 'Tableau de Bord',
            'analytics': 'Analytics',
            'content': 'Contenu',
            'users': 'Utilisateurs',
            'magazines': 'Magazines',
            'newsletter': 'Newsletter',
            'settings': 'Paramètres',
            'profile': 'Profil'
        };
        
        if (breadcrumb) {
            breadcrumb.textContent = sectionNames[section] || 'Dashboard';
        }
    }

    // Charts Management
    initCharts() {
        this.initTrafficChart();
        this.initAudienceChart();
    }

    initTrafficChart() {
        const ctx = document.getElementById('trafficChart');
        if (!ctx) return;

        this.charts.traffic = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
                datasets: [{
                    label: 'Visiteurs',
                    data: [1200, 1900, 3000, 5000, 2300, 3200, 4100, 3800, 4500, 3900, 4200, 4800],
                    borderColor: '#F2CB05',
                    backgroundColor: 'rgba(242, 203, 5, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#F2CB05',
                    pointBorderColor: '#D99923',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(242, 203, 5, 0.1)'
                        },
                        ticks: {
                            color: '#8C5B30'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(242, 203, 5, 0.1)'
                        },
                        ticks: {
                            color: '#8C5B30'
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    }

    initAudienceChart() {
        const ctx = document.getElementById('audienceChart');
        if (!ctx) return;

        this.charts.audience = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Desktop', 'Mobile', 'Tablette'],
                datasets: [{
                    data: [45, 35, 20],
                    backgroundColor: ['#F2CB05', '#D99923', '#8C5B30'],
                    borderWidth: 0,
                    hoverOffset: 10
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
                            color: '#0D0D0D',
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    }
                },
                cutout: '60%'
            }
        });
    }

    // Filters Management
    initFilters() {
        // Chart period filters
        const chartFilters = document.querySelectorAll('.filter-btn[data-period]');
        chartFilters.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                this.updateChartPeriod(btn);
                this.addRippleEffect(btn, e);
            });
        });

        // Content status filters
        const statusFilters = document.querySelectorAll('.filter-btn[data-status]');
        statusFilters.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                this.filterContent(btn.getAttribute('data-status'));
                this.updateActiveFilter(btn, statusFilters);
                this.addRippleEffect(btn, e);
            });
        });
    }

    updateChartPeriod(btn) {
        const period = btn.getAttribute('data-period');
        const filterGroup = btn.closest('.chart-filters');
        
        // Update active state
        filterGroup.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        
        // Update chart data based on period
        this.updateTrafficData(period);
    }

    updateTrafficData(period) {
        if (!this.charts.traffic) return;
        
        const data = {
            '7d': [800, 1200, 1500, 1800, 2100, 1900, 2300],
            '30d': [1200, 1900, 3000, 5000, 2300, 3200, 4100, 3800, 4500, 3900, 4200, 4800],
            '90d': [800, 1200, 1800, 2400, 3200, 2800, 3600, 4200, 3800, 4400, 5100, 4800]
        };
        
        const labels = {
            '7d': ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
            '30d': ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
            '90d': ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12']
        };
        
        this.charts.traffic.data.labels = labels[period];
        this.charts.traffic.data.datasets[0].data = data[period];
        this.charts.traffic.update('active');
    }

    filterContent(status) {
        const rows = document.querySelectorAll('.data-table tbody tr');
        
        rows.forEach(row => {
            const statusBadge = row.querySelector('.status-badge');
            if (!statusBadge) return;
            
            if (status === 'all') {
                row.style.display = '';
                row.style.animation = 'fadeInUp 0.3s ease';
            } else {
                const rowStatus = statusBadge.classList.contains(status);
                row.style.display = rowStatus ? '' : 'none';
                if (rowStatus) {
                    row.style.animation = 'fadeInUp 0.3s ease';
                }
            }
        });
    }

    updateActiveFilter(activeBtn, filterGroup) {
        filterGroup.forEach(btn => btn.classList.remove('active'));
        activeBtn.classList.add('active');
    }

    // Search Management
    initSearch() {
        const searchInputs = document.querySelectorAll('.search-input, .filter-search');
        
        searchInputs.forEach(input => {
            let searchTimeout;
            
            input.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.performSearch(e.target.value, e.target);
                }, 300);
            });
            
            input.addEventListener('focus', (e) => {
                e.target.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', (e) => {
                e.target.parentElement.classList.remove('focused');
            });
        });
    }

    performSearch(query, input) {
        if (input.classList.contains('filter-search')) {
            this.searchContent(query);
        } else {
            this.globalSearch(query);
        }
    }

    searchContent(query) {
        const rows = document.querySelectorAll('.data-table tbody tr');
        const searchTerm = query.toLowerCase();
        
        rows.forEach(row => {
            const title = row.querySelector('.article-title')?.textContent.toLowerCase() || '';
            const author = row.cells[1]?.textContent.toLowerCase() || '';
            const category = row.querySelector('.category-tag')?.textContent.toLowerCase() || '';
            
            const matches = title.includes(searchTerm) || 
                          author.includes(searchTerm) || 
                          category.includes(searchTerm);
            
            row.style.display = matches ? '' : 'none';
            if (matches) {
                row.style.animation = 'fadeInUp 0.3s ease';
            }
        });
    }

    globalSearch(query) {
        // Global search functionality
        console.log('Global search:', query);
        // Implement global search logic here
    }

    // Notifications Management
    initNotifications() {
        const notificationBtn = document.querySelector('.notification-btn');
        const messageBtn = document.querySelector('.message-btn');
        
        if (notificationBtn) {
            notificationBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.showNotifications();
                this.addRippleEffect(notificationBtn, e);
            });
        }
        
        if (messageBtn) {
            messageBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.showMessages();
                this.addRippleEffect(messageBtn, e);
            });
        }
    }

    showNotifications() {
        // Show notifications dropdown/modal
        console.log('📢 Showing notifications');
        // Implement notifications display
    }

    showMessages() {
        // Show messages dropdown/modal
        console.log('💬 Showing messages');
        // Implement messages display
    }

    // Section-specific Features
    initSectionFeatures(sectionId) {
        switch (sectionId) {
            case 'content':
                this.initContentManagement();
                break;
            case 'analytics':
                this.initAnalyticsFeatures();
                break;
            case 'users':
                this.initUserManagement();
                break;
            case 'magazines':
                this.initMagazineManagement();
                break;
        }
    }

    initContentManagement() {
        const actionBtns = document.querySelectorAll('.action-btn-small');
        
        actionBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const action = btn.classList.contains('edit-btn') ? 'edit' :
                              btn.classList.contains('view-btn') ? 'view' : 'delete';
                
                this.handleContentAction(action, btn);
                this.addRippleEffect(btn, e);
            });
        });
    }

    handleContentAction(action, btn) {
        const row = btn.closest('tr');
        const title = row.querySelector('.article-title')?.textContent || '';
        
        switch (action) {
            case 'edit':
                console.log('✏️ Editing article:', title);
                this.showEditModal(row);
                break;
            case 'view':
                console.log('👁️ Viewing article:', title);
                this.showViewModal(row);
                break;
            case 'delete':
                console.log('🗑️ Deleting article:', title);
                this.showDeleteConfirm(row);
                break;
        }
    }

    showEditModal(row) {
        // Show edit modal
        console.log('Opening edit modal');
    }

    showViewModal(row) {
        // Show view modal
        console.log('Opening view modal');
    }

    showDeleteConfirm(row) {
        // Show delete confirmation
        if (confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) {
            row.style.animation = 'fadeOut 0.3s ease';
            setTimeout(() => row.remove(), 300);
        }
    }

    initAnalyticsFeatures() {
        console.log('📊 Analytics features initialized');
        // Initialize analytics-specific features
    }

    initUserManagement() {
        console.log('👥 User management features initialized');
        // Initialize user management features
    }

    initMagazineManagement() {
        console.log('📚 Magazine management features initialized');
        // Initialize magazine management features
    }

    // Responsive Management
    initResponsive() {
        window.addEventListener('resize', () => {
            this.handleResize();
        });
        
        this.handleResize(); // Initial check
    }

    handleResize() {
        const width = window.innerWidth;
        const sidebar = document.querySelector('.dashboard-sidebar');
        const main = document.querySelector('.dashboard-main');
        
        if (width <= 992) {
            // Mobile layout
            sidebar.classList.remove('active');
            main.style.marginLeft = '0';
        } else {
            // Desktop layout
            if (!this.sidebarCollapsed) {
                main.style.marginLeft = '280px';
            }
        }
        
        // Update charts on resize
        Object.values(this.charts).forEach(chart => {
            if (chart) chart.resize();
        });
    }

    // Animations and Effects
    initAnimations() {
        // Initialize intersection observer for fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                }
            });
        }, observerOptions);
        
        // Observe all cards and sections
        const elements = document.querySelectorAll('.stat-card, .chart-card, .activity-section, .analytics-card, .content-management');
        elements.forEach(el => observer.observe(el));
    }

    addRippleEffect(element, event) {
        const ripple = document.createElement('span');
        const rect = element.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            background: rgba(242, 203, 5, 0.3);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none;
            z-index: 1;
        `;
        
        element.style.position = 'relative';
        element.style.overflow = 'hidden';
        element.appendChild(ripple);
        
        setTimeout(() => ripple.remove(), 600);
    }

    // Utility Methods
    formatNumber(num) {
        if (num >= 1000000) {
            return (num / 1000000).toFixed(1) + 'M';
        } else if (num >= 1000) {
            return (num / 1000).toFixed(1) + 'K';
        }
        return num.toString();
    }

    formatDate(date) {
        return new Intl.DateTimeFormat('fr-FR', {
            day: 'numeric',
            month: 'short',
            year: 'numeric'
        }).format(new Date(date));
    }
}

// CSS Animations
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    @keyframes fadeOut {
        to {
            opacity: 0;
            transform: translateX(-20px);
        }
    }
    
    .focused .search-icon {
        color: #F2CB05 !important;
        transform: translateY(-50%) scale(1.1);
    }
`;
document.head.appendChild(style);

// Initialize Dashboard when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.dashboardUltra = new DashboardUltra();
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = DashboardUltra;
}
