/**
 * ===========================
 * DASHBOARD ULTRA - JAVASCRIPT
 * Excellence Afrik - Dashboard Moderne
 * ===========================
 */

class DashboardUltra {
    constructor() {
        this.sidebar = null;
        this.activeSubmenu = null;
        this.init();
    }

    init() {
        this.initializeElements();
        this.setupEventListeners();
        this.setupSubmenuSystem();
        this.setupMobileMenu();
        this.setupSearch();
        this.setupNotifications();
        console.log('✅ Dashboard Ultra initialized successfully');
    }

    initializeElements() {
        this.sidebar = document.getElementById('dashboardSidebar');
        this.mobileToggle = document.getElementById('mobileMenuToggle');
        this.sidebarToggle = document.getElementById('sidebarToggle');
        this.searchInput = document.querySelector('.search-input');
    }

    setupEventListeners() {
        // Mobile menu toggle
        if (this.mobileToggle) {
            this.mobileToggle.addEventListener('click', () => {
                this.toggleMobileSidebar();
            });
        }

        // Sidebar toggle
        if (this.sidebarToggle) {
            this.sidebarToggle.addEventListener('click', () => {
                this.toggleSidebarCollapse();
            });
        }

        // Click outside to close mobile sidebar
        document.addEventListener('click', (e) => {
            this.handleOutsideClick(e);
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            this.handleKeyboardShortcuts(e);
        });
    }

    setupSubmenuSystem() {
        const submenuToggles = document.querySelectorAll('.submenu-toggle');
        
        submenuToggles.forEach(toggle => {
            toggle.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                const navItem = toggle.closest('.nav-item.has-submenu');
                const isCurrentlyOpen = navItem.classList.contains('open');
                
                // Close all other submenus
                this.closeAllSubmenus();
                
                // Toggle current submenu
                if (!isCurrentlyOpen) {
                    this.openSubmenu(navItem);
                }
            });

            // Add hover effects
            toggle.addEventListener('mouseenter', () => {
                const arrow = toggle.querySelector('.submenu-arrow');
                if (arrow) {
                    arrow.style.transform = 'translateY(-50%) scale(1.1)';
                }
            });

            toggle.addEventListener('mouseleave', () => {
                const arrow = toggle.querySelector('.submenu-arrow');
                const navItem = toggle.closest('.nav-item.has-submenu');
                if (arrow && !navItem.classList.contains('open')) {
                    arrow.style.transform = 'translateY(-50%) scale(1)';
                }
            });
        });

        // Setup submenu links
        const submenuLinks = document.querySelectorAll('.nav-sublink');
        submenuLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                this.handleSubmenuClick(e, link);
            });
        });
    }

    setupMobileMenu() {
        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768 && this.sidebar) {
                this.sidebar.classList.remove('open');
            }
        });
    }

    setupSearch() {
        if (this.searchInput) {
            this.searchInput.addEventListener('input', (e) => {
                this.handleSearch(e.target.value);
            });

            this.searchInput.addEventListener('focus', () => {
                this.showSearchSuggestions();
            });

            this.searchInput.addEventListener('blur', () => {
                setTimeout(() => this.hideSearchSuggestions(), 200);
            });
        }
    }

    setupNotifications() {
        const notificationBtn = document.querySelector('.notification-btn');
        const messageBtn = document.querySelector('.message-btn');

        if (notificationBtn) {
            notificationBtn.addEventListener('click', () => {
                this.showNotifications();
            });
        }

        if (messageBtn) {
            messageBtn.addEventListener('click', () => {
                this.showMessages();
            });
        }
    }

    // Sidebar Methods
    toggleMobileSidebar() {
        if (this.sidebar) {
            this.sidebar.classList.toggle('open');
        }
    }

    toggleSidebarCollapse() {
        if (this.sidebar) {
            this.sidebar.classList.toggle('collapsed');
        }
    }

    handleOutsideClick(e) {
        if (window.innerWidth <= 768 && 
            this.sidebar && 
            !this.sidebar.contains(e.target) && 
            !this.mobileToggle.contains(e.target) && 
            this.sidebar.classList.contains('open')) {
            this.sidebar.classList.remove('open');
        }
    }

    // Submenu Methods
    openSubmenu(navItem) {
        navItem.classList.add('open');
        this.activeSubmenu = navItem;
        this.addRippleEffect(navItem.querySelector('.submenu-toggle'));
    }

    closeAllSubmenus() {
        const openSubmenus = document.querySelectorAll('.nav-item.has-submenu.open');
        openSubmenus.forEach(item => {
            item.classList.remove('open');
        });
        this.activeSubmenu = null;
    }

    handleSubmenuClick(e, link) {
        const href = link.getAttribute('href');
        const section = link.getAttribute('data-section');

        // Si le lien a une vraie URL Laravel (commence par http ou /), permettre la navigation normale
        if (href && (href.startsWith('http') || href.startsWith('/')) && !href.startsWith('#')) {
            // Ne pas empêcher la navigation par défaut - laisser Laravel gérer
            console.log('🔗 Navigating to Laravel route:', href);
            return;
        }

        // Sinon, gérer comme avant pour les sections internes
        e.preventDefault();

        // Remove active state from all submenu items
        document.querySelectorAll('.nav-subitem.active').forEach(item => {
            item.classList.remove('active');
        });

        // Add active state to clicked item
        const subItem = link.closest('.nav-subitem');
        if (subItem) {
            subItem.classList.add('active');
        }

        // Handle section switching if data-section exists
        if (section) {
            this.showSection(section);
            this.updateBreadcrumb(section);
        }

        console.log('📄 Submenu item clicked:', section || 'no-section');
    }

    // Search Methods
    handleSearch(query) {
        if (query.length > 2) {
            this.performSearch(query);
        } else {
            this.hideSearchResults();
        }
    }

    performSearch(query) {
        // Simulate search results
        const results = this.getSearchResults(query);
        this.displaySearchResults(results);
    }

    getSearchResults(query) {
        const mockResults = [
            { type: 'article', title: 'Innovation Fintech en Afrique', url: '#' },
            { type: 'user', title: 'Deza Auguste César', url: '#' },
            { type: 'stats', title: 'Statistiques mensuelles', url: '#' }
        ];

        return mockResults.filter(result => 
            result.title.toLowerCase().includes(query.toLowerCase())
        );
    }

    displaySearchResults(results) {
        // Implementation for displaying search results
        console.log('Search results:', results);
    }

    showSearchSuggestions() {
        const suggestions = document.getElementById('searchSuggestions');
        if (suggestions) {
            suggestions.style.display = 'block';
        }
    }

    hideSearchSuggestions() {
        const suggestions = document.getElementById('searchSuggestions');
        if (suggestions) {
            suggestions.style.display = 'none';
        }
    }

    hideSearchResults() {
        // Hide search results
    }

    // Notification Methods
    showNotifications() {
        console.log('Showing notifications...');
        // Implementation for showing notifications
    }

    showMessages() {
        console.log('Showing messages...');
        // Implementation for showing messages
    }

    // Utility Methods
    addRippleEffect(element) {
        if (!element) return;

        const ripple = document.createElement('span');
        const rect = element.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);

        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: 50%;
            top: 50%;
            background: rgba(242, 203, 5, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            animation: ripple 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none;
            z-index: 1;
        `;

        element.style.position = 'relative';
        element.style.overflow = 'hidden';
        element.appendChild(ripple);

        setTimeout(() => ripple.remove(), 600);
    }

    showSection(sectionName) {
        // Hide all sections
        document.querySelectorAll('.content-section').forEach(section => {
            section.classList.remove('active');
        });

        // Show target section
        const targetSection = document.getElementById(`${sectionName}-section`);
        if (targetSection) {
            targetSection.classList.add('active');
        }
    }

    updateBreadcrumb(sectionName) {
        const breadcrumbItem = document.querySelector('.breadcrumb-item.active');
        if (breadcrumbItem) {
            breadcrumbItem.textContent = this.getSectionTitle(sectionName);
        }
    }

    getSectionTitle(sectionName) {
        const titles = {
            'dashboard': 'Tableau de Bord',
            'analytics': 'Analytics',
            'content': 'Contenu',
            'add-article': 'Ajouter un Article',
            'list-articles': 'Liste des Articles',
            'add-article-category': 'Ajouter une Catégorie',
            'settings': 'Paramètres',
            'profile': 'Profil'
        };
        return titles[sectionName] || 'Dashboard';
    }

    handleKeyboardShortcuts(e) {
        // Ctrl/Cmd + K for search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            if (this.searchInput) {
                this.searchInput.focus();
            }
        }

        // Escape to close modals/menus
        if (e.key === 'Escape') {
            this.closeAllSubmenus();
            if (window.innerWidth <= 768 && this.sidebar) {
                this.sidebar.classList.remove('open');
            }
        }
    }

    // Public API Methods
    refreshData() {
        console.log('Refreshing dashboard data...');
        // Implementation for refreshing data
    }

    exportData() {
        console.log('Exporting dashboard data...');
        // Implementation for exporting data
    }
}

/**
 * Statistics Manager Class
 */
class StatisticsManager {
    constructor() {
        this.charts = {};
        this.init();
    }

    init() {
        this.setupStatCards();
        this.setupTimeFilters();
        this.initializeCharts();
        console.log('📊 Statistics Manager initialized');
    }

    setupStatCards() {
        const statCards = document.querySelectorAll('.primary-stat-card');
        statCards.forEach(card => {
            card.addEventListener('click', () => {
                this.handleStatCardClick(card);
            });

            // Add hover animations
            card.addEventListener('mouseenter', () => {
                this.animateStatCard(card, 'enter');
            });

            card.addEventListener('mouseleave', () => {
                this.animateStatCard(card, 'leave');
            });
        });

        // Setup view more buttons
        const viewMoreBtns = document.querySelectorAll('.stat-view-more-btn');
        viewMoreBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const statType = btn.getAttribute('data-stat');
                this.showDetailedStats(statType);
            });
        });
    }

    setupTimeFilters() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                this.handleTimeFilterChange(btn);
            });
        });
    }

    initializeCharts() {
        // Initialize Chart.js charts if available
        if (typeof Chart !== 'undefined') {
            this.createPerformanceChart();
        }
    }

    handleStatCardClick(card) {
        const statType = card.dataset.stat;
        console.log(`Stat card clicked: ${statType}`);
        // Implementation for stat card click
    }

    animateStatCard(card, type) {
        const sparklines = card.querySelectorAll('.sparkline-bar');
        if (type === 'enter') {
            sparklines.forEach((bar, index) => {
                setTimeout(() => {
                    bar.style.transform = 'scaleY(1.2)';
                }, index * 50);
            });
        } else {
            sparklines.forEach(bar => {
                bar.style.transform = 'scaleY(1)';
            });
        }
    }

    showDetailedStats(statType) {
        console.log(`Showing detailed stats for: ${statType}`);
        // Implementation for showing detailed statistics
    }

    handleTimeFilterChange(btn) {
        // Remove active class from all buttons
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('active');
        });

        // Add active class to clicked button
        btn.classList.add('active');

        const period = btn.getAttribute('data-period');
        this.updateStatsForPeriod(period);
    }

    updateStatsForPeriod(period) {
        console.log(`Updating stats for period: ${period}`);
        // Implementation for updating statistics based on time period
    }

    createPerformanceChart() {
        const ctx = document.getElementById('performanceChart');
        if (!ctx) return;

        this.charts.performance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
                datasets: [{
                    label: 'Vues',
                    data: [12000, 19000, 15000, 25000, 22000, 30000],
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    tension: 0.4,
                    fill: true
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
    }
}

/**
 * Initialize Dashboard when DOM is loaded
 */
document.addEventListener('DOMContentLoaded', function() {
    // Initialize main dashboard
    window.dashboardUltra = new DashboardUltra();
    
    // Initialize statistics manager
    window.statisticsManager = new StatisticsManager();
    
    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: translate(-50%, -50%) scale(4);
                opacity: 0;
            }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    `;
    document.head.appendChild(style);
    
    console.log('🚀 Dashboard Ultra fully loaded and ready!');
});

/**
 * Global utility functions
 */
window.DashboardUtils = {
    formatNumber: (num) => {
        if (num >= 1000000) {
            return (num / 1000000).toFixed(1) + 'M';
        } else if (num >= 1000) {
            return (num / 1000).toFixed(1) + 'K';
        }
        return num.toString();
    },
    
    formatDate: (date) => {
        return new Intl.DateTimeFormat('fr-FR', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        }).format(new Date(date));
    },
    
    showToast: (message, type = 'info') => {
        console.log(`Toast [${type}]: ${message}`);
        // Implementation for toast notifications
    }
};
