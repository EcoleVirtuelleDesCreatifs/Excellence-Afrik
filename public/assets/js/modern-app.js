/* Excellence Afrik - Modern Bootstrap 5 JavaScript */

class ExcellenceAfrikApp {
    constructor() {
        this.init();
        this.bindEvents();
        this.initAnimations();
        this.initTheme();
    }

    init() {
        // Initialize Bootstrap components
        this.initBootstrapComponents();
        
        // Initialize all components
        this.initAnimations();
        this.initHoverDropdowns();
        this.initMobileMenu();
        this.initSearchToggle();
        this.initCarousels();
        this.initNewsletterForms();
        this.initVideoPlayers();
        this.initSmoothScrolling();
        this.initLazyLoading();
        this.initTabs();
        this.initModals();
        this.initTooltips();
        this.initDiasporaFilters();
        this.initAnalyseExpertsFilters();
        this.initAnalyseExpertsUltraFilters();
        this.initMagazinesFilters();
        this.initWebTVFilters();
        
        console.log('Excellence Afrik - Modern UI initialized successfully');
    }

    initBootstrapComponents() {
        // Initialize all tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

        // Initialize all popovers
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));

        // Initialize modals
        const modalElements = document.querySelectorAll('.modal');
        modalElements.forEach(modal => {
            new bootstrap.Modal(modal, {
                backdrop: 'static',
                keyboard: true
            });
        });

        // Initialize hover dropdowns
        this.initHoverDropdowns();
        
        // Initialize modern navigation
        this.initModernNavigation();
        
        // Initialize topbar dropdowns
        this.initTopbarDropdowns();
    }

    initHoverDropdowns() {
        const dropdowns = document.querySelectorAll('.dropdown');
        
        dropdowns.forEach(dropdown => {
            const dropdownMenu = dropdown.querySelector('.dropdown-menu');
            const dropdownToggle = dropdown.querySelector('.dropdown-toggle');
            
            if (!dropdownMenu || !dropdownToggle) return;
            
            let hoverTimeout;
            
            // Show dropdown on hover
            dropdown.addEventListener('mouseenter', () => {
                clearTimeout(hoverTimeout);
                
                // Close other open dropdowns
                document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                    if (menu !== dropdownMenu) {
                        menu.classList.remove('show');
                        menu.style.opacity = '0';
                        menu.style.visibility = 'hidden';
                        menu.style.transform = 'translateY(-10px)';
                    }
                });
                
                // Show current dropdown
                dropdownMenu.classList.add('show');
                
                // Trigger reflow for smooth animation
                dropdownMenu.offsetHeight;
                
                // Apply show styles
                dropdownMenu.style.opacity = '1';
                dropdownMenu.style.visibility = 'visible';
                dropdownMenu.style.transform = 'translateY(0)';
                dropdownMenu.style.pointerEvents = 'all';
                
                // Add active state to toggle
                dropdownToggle.classList.add('show');
                dropdownToggle.setAttribute('aria-expanded', 'true');
            });
            
            // Hide dropdown on mouse leave with delay
            dropdown.addEventListener('mouseleave', () => {
                hoverTimeout = setTimeout(() => {
                    dropdownMenu.classList.remove('show');
                    dropdownMenu.style.opacity = '0';
                    dropdownMenu.style.visibility = 'hidden';
                    dropdownMenu.style.transform = 'translateY(-10px)';
                    dropdownMenu.style.pointerEvents = 'none';
                    
                    // Remove active state from toggle
                    dropdownToggle.classList.remove('show');
                    dropdownToggle.setAttribute('aria-expanded', 'false');
                }, 150); // Small delay to prevent flickering
            });
            
            // Keep dropdown open when hovering over menu items
            dropdownMenu.addEventListener('mouseenter', () => {
                clearTimeout(hoverTimeout);
            });
            
            // Handle keyboard navigation
            dropdownToggle.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    
                    if (dropdownMenu.classList.contains('show')) {
                        // Hide dropdown
                        dropdownMenu.classList.remove('show');
                        dropdownMenu.style.opacity = '0';
                        dropdownMenu.style.visibility = 'hidden';
                        dropdownMenu.style.transform = 'translateY(-10px)';
                        dropdownToggle.classList.remove('show');
                        dropdownToggle.setAttribute('aria-expanded', 'false');
                    } else {
                        // Show dropdown
                        dropdownMenu.classList.add('show');
                        dropdownMenu.style.opacity = '1';
                        dropdownMenu.style.visibility = 'visible';
                        dropdownMenu.style.transform = 'translateY(0)';
                        dropdownToggle.classList.add('show');
                        dropdownToggle.setAttribute('aria-expanded', 'true');
                        
                        // Focus first menu item
                        const firstItem = dropdownMenu.querySelector('.dropdown-item');
                        if (firstItem) firstItem.focus();
                    }
                }
                
                if (e.key === 'Escape') {
                    dropdownMenu.classList.remove('show');
                    dropdownMenu.style.opacity = '0';
                    dropdownMenu.style.visibility = 'hidden';
                    dropdownMenu.style.transform = 'translateY(-10px)';
                    dropdownToggle.classList.remove('show');
                    dropdownToggle.setAttribute('aria-expanded', 'false');
                    dropdownToggle.focus();
                }
            });
            
            // Handle dropdown item keyboard navigation
            const dropdownItems = dropdownMenu.querySelectorAll('.dropdown-item');
            dropdownItems.forEach((item, index) => {
                item.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        const nextItem = dropdownItems[index + 1] || dropdownItems[0];
                        nextItem.focus();
                    }
                    
                    if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        const prevItem = dropdownItems[index - 1] || dropdownItems[dropdownItems.length - 1];
                        prevItem.focus();
                    }
                    
                    if (e.key === 'Escape') {
                        dropdownMenu.classList.remove('show');
                        dropdownMenu.style.opacity = '0';
                        dropdownMenu.style.visibility = 'hidden';
                        dropdownMenu.style.transform = 'translateY(-10px)';
                        dropdownToggle.classList.remove('show');
                        dropdownToggle.setAttribute('aria-expanded', 'false');
                        dropdownToggle.focus();
                    }
                });
            });
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                    menu.classList.remove('show');
                    menu.style.opacity = '0';
                    menu.style.visibility = 'hidden';
                    menu.style.transform = 'translateY(-10px)';
                    menu.style.pointerEvents = 'none';
                });
                
                document.querySelectorAll('.dropdown-toggle.show').forEach(toggle => {
                    toggle.classList.remove('show');
                    toggle.setAttribute('aria-expanded', 'false');
                });
            }
        });
        
        console.log('🎯 Hover dropdowns initialized successfully!');
    }

    initScrollEffects() {
        let lastScrollTop = 0;
        const navbar = document.querySelector('.navbar');
        
        window.addEventListener('scroll', () => {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Add scrolled class for backdrop effect
            if (scrollTop > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
            
            // Hide/show navbar on scroll
            if (scrollTop > lastScrollTop && scrollTop > 200) {
                navbar.style.transform = 'translateY(-100%)';
            } else {
                navbar.style.transform = 'translateY(0)';
            }
            
            lastScrollTop = scrollTop;
        }, { passive: true });
    }

    initAnimations() {
        // Intersection Observer for fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    
                    // Stagger animation for child elements
                    const children = entry.target.querySelectorAll('.stagger-item');
                    children.forEach((child, index) => {
                        setTimeout(() => {
                            child.classList.add('visible');
                        }, index * 100);
                    });
                }
            });
        }, observerOptions);

        // Observe all fade-in elements
        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });
    }

    initLazyLoading() {
        // Lazy loading for images
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    
                    // Add loading placeholder
                    img.classList.add('loading');
                    
                    // Load the actual image
                    const actualImg = new Image();
                    actualImg.onload = () => {
                        img.src = actualImg.src;
                        img.classList.remove('loading');
                        img.classList.add('loaded');
                    };
                    actualImg.src = img.dataset.src || img.src;
                    
                    observer.unobserve(img);
                }
            });
        }, {
            rootMargin: '50px 0px',
            threshold: 0.1
        });

        // Observe all images with data-src
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    initTheme() {
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;
        
        // Get saved theme or default to light
        const savedTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-bs-theme', savedTheme);
        this.updateThemeIcon(savedTheme);

        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                const currentTheme = html.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                html.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                this.updateThemeIcon(newTheme);
                
                // Add transition effect
                document.body.style.transition = 'background-color 0.3s, color 0.3s';
                setTimeout(() => {
                    document.body.style.transition = '';
                }, 300);
            });
        }

        // Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!localStorage.getItem('theme')) {
                const systemTheme = e.matches ? 'dark' : 'light';
                html.setAttribute('data-bs-theme', systemTheme);
                this.updateThemeIcon(systemTheme);
            }
        });
    }

    updateThemeIcon(theme) {
        const themeToggle = document.getElementById('themeToggle');
        if (themeToggle) {
            const icon = themeToggle.querySelector('i');
            icon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
        }
    }

    initSearch() {
        const searchModal = document.getElementById('searchModal');
        const searchInput = document.getElementById('searchInput');
        
        if (searchModal && searchInput) {
            searchModal.addEventListener('shown.bs.modal', () => {
                searchInput.focus();
            });

            searchInput.addEventListener('input', this.debounce((e) => {
                const query = e.target.value.trim();
                if (query.length > 2) {
                    this.performSearch(query);
                }
            }, 300));
        }
    }

    performSearch(query) {
        // Simulate search functionality
        console.log(`Searching for: ${query}`);
        
        // In a real application, this would make an API call
        const searchResults = document.getElementById('searchResults');
        if (searchResults) {
            searchResults.innerHTML = `
                <div class="list-group">
                    <div class="list-group-item">
                        <h6 class="mb-1">Résultat de recherche pour "${query}"</h6>
                        <p class="mb-1">Description du résultat...</p>
                        <small class="text-muted">Il y a 2 heures</small>
                    </div>
                </div>
            `;
        }
    }

    initNewsletter() {
        const newsletterForms = document.querySelectorAll('.newsletter-form');
        
        newsletterForms.forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                
                const email = form.querySelector('input[type="email"]').value;
                const button = form.querySelector('button[type="submit"]');
                
                if (this.validateEmail(email)) {
                    // Simulate newsletter subscription
                    button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Inscription...';
                    button.disabled = true;
                    
                    setTimeout(() => {
                        button.innerHTML = '<i class="fas fa-check me-2"></i>Inscrit!';
                        button.classList.remove('btn-primary');
                        button.classList.add('btn-success');
                        
                        // Show success toast
                        this.showToast('Inscription réussie!', 'Vous recevrez bientôt notre newsletter.', 'success');
                        
                        setTimeout(() => {
                            button.innerHTML = 'S\'abonner';
                            button.disabled = false;
                            button.classList.remove('btn-success');
                            button.classList.add('btn-primary');
                            form.reset();
                        }, 3000);
                    }, 2000);
                } else {
                    this.showToast('Email invalide', 'Veuillez entrer une adresse email valide.', 'error');
                }
            });
        });
    }

    validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    showToast(title, message, type = 'info') {
        // Create toast element
        const toastContainer = document.getElementById('toastContainer') || this.createToastContainer();
        
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type === 'error' ? 'danger' : type === 'success' ? 'success' : 'primary'} border-0`;
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <strong>${title}</strong><br>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        toastContainer.appendChild(toast);
        
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        // Remove toast after it's hidden
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    }

    createToastContainer() {
        const container = document.createElement('div');
        container.id = 'toastContainer';
        container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        container.style.zIndex = '1055';
        document.body.appendChild(container);
        return container;
    }

    initModernNavigation() {
        // Handle modern navigation dropdowns
        const navDropdowns = document.querySelectorAll('.nav-dropdown');
        
        navDropdowns.forEach(dropdown => {
            const trigger = dropdown.querySelector('.nav-link-modern');
            const submenu = dropdown.querySelector('.nav-submenu');
            
            if (!trigger || !submenu) return;
            
            let hoverTimeout;
            
            // Show submenu on hover
            dropdown.addEventListener('mouseenter', () => {
                clearTimeout(hoverTimeout);
                
                // Close other open submenus
                document.querySelectorAll('.nav-submenu').forEach(menu => {
                    if (menu !== submenu) {
                        menu.style.opacity = '0';
                        menu.style.visibility = 'hidden';
                        menu.style.transform = 'translateY(-15px)';
                    }
                });
                
                // Show current submenu
                submenu.style.opacity = '1';
                submenu.style.visibility = 'visible';
                submenu.style.transform = 'translateY(0)';
                
                // Add active state
                trigger.setAttribute('aria-expanded', 'true');
            });
            
            // Hide submenu on mouse leave with delay
            dropdown.addEventListener('mouseleave', () => {
                hoverTimeout = setTimeout(() => {
                    submenu.style.opacity = '0';
                    submenu.style.visibility = 'hidden';
                    submenu.style.transform = 'translateY(-15px)';
                    
                    // Remove active state
                    trigger.setAttribute('aria-expanded', 'false');
                }, 150);
            });
            
            // Keep submenu open when hovering over it
            submenu.addEventListener('mouseenter', () => {
                clearTimeout(hoverTimeout);
            });
            
            // Handle keyboard navigation
            trigger.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    
                    const isVisible = submenu.style.visibility === 'visible';
                    
                    if (isVisible) {
                        // Hide submenu
                        submenu.style.opacity = '0';
                        submenu.style.visibility = 'hidden';
                        submenu.style.transform = 'translateY(-15px)';
                        trigger.setAttribute('aria-expanded', 'false');
                    } else {
                        // Show submenu
                        submenu.style.opacity = '1';
                        submenu.style.visibility = 'visible';
                        submenu.style.transform = 'translateY(0)';
                        trigger.setAttribute('aria-expanded', 'true');
                        
                        // Focus first submenu item
                        const firstItem = submenu.querySelector('.nav-submenu-item');
                        if (firstItem) firstItem.focus();
                    }
                }
                
                if (e.key === 'Escape') {
                    submenu.style.opacity = '0';
                    submenu.style.visibility = 'hidden';
                    submenu.style.transform = 'translateY(-15px)';
                    trigger.setAttribute('aria-expanded', 'false');
                    trigger.focus();
                }
            });
            
            // Handle arrow key navigation within submenu
            const submenuItems = submenu.querySelectorAll('.nav-submenu-item');
            submenuItems.forEach((item, index) => {
                item.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        const nextIndex = (index + 1) % submenuItems.length;
                        submenuItems[nextIndex].focus();
                    }
                    
                    if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        const prevIndex = index === 0 ? submenuItems.length - 1 : index - 1;
                        submenuItems[prevIndex].focus();
                    }
                    
                    if (e.key === 'Escape') {
                        submenu.style.opacity = '0';
                        submenu.style.visibility = 'hidden';
                        submenu.style.transform = 'translateY(-15px)';
                        trigger.setAttribute('aria-expanded', 'false');
                        trigger.focus();
                    }
                });
            });
        });
        
        // Handle mobile navigation toggle
        const mobileToggle = document.querySelector('.nav-mobile-toggle');
        const navCollapse = document.querySelector('#navbarModern');
        
        if (mobileToggle && navCollapse) {
            mobileToggle.addEventListener('click', () => {
                const isExpanded = navCollapse.classList.contains('show');
                
                // Toggle collapse
                if (isExpanded) {
                    navCollapse.classList.remove('show');
                    mobileToggle.setAttribute('aria-expanded', 'false');
                } else {
                    navCollapse.classList.add('show');
                    mobileToggle.setAttribute('aria-expanded', 'true');
                }
                
                // Animate toggle lines
                const lines = mobileToggle.querySelectorAll('.nav-toggle-line');
                lines.forEach((line, index) => {
                    if (!isExpanded) {
                        if (index === 0) line.style.transform = 'rotate(45deg) translate(5px, 5px)';
                        if (index === 1) line.style.opacity = '0';
                        if (index === 2) line.style.transform = 'rotate(-45deg) translate(7px, -6px)';
                    } else {
                        line.style.transform = '';
                        line.style.opacity = '';
                    }
                });
            });
        }
        
        // Close navigation when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.nav-modern')) {
                // Close all submenus
                document.querySelectorAll('.nav-submenu').forEach(submenu => {
                    submenu.style.opacity = '0';
                    submenu.style.visibility = 'hidden';
                    submenu.style.transform = 'translateY(-15px)';
                });
                
                // Reset all triggers
                document.querySelectorAll('.nav-link-modern').forEach(trigger => {
                    trigger.setAttribute('aria-expanded', 'false');
                });
                
                // Close mobile menu
                if (navCollapse && navCollapse.classList.contains('show')) {
                    navCollapse.classList.remove('show');
                    if (mobileToggle) {
                        mobileToggle.setAttribute('aria-expanded', 'false');
                        const lines = mobileToggle.querySelectorAll('.nav-toggle-line');
                        lines.forEach(line => {
                            line.style.transform = '';
                            line.style.opacity = '';
                        });
                    }
                }
            }
        });
        
        console.log('Modern Navigation initialized successfully! 🎯');
    }

    initTopbarDropdowns() {
        // Handle topbar dropdown interactions
        const topbarDropdowns = document.querySelectorAll('.topbar-dropdown');
        
        topbarDropdowns.forEach(dropdown => {
            const trigger = dropdown.querySelector('.topbar-link');
            const menu = dropdown.querySelector('.topbar-menu');
            
            if (!trigger || !menu) return;
            
            let hoverTimeout;
            
            // Show dropdown on hover
            dropdown.addEventListener('mouseenter', () => {
                clearTimeout(hoverTimeout);
                
                // Close other open topbar menus
                document.querySelectorAll('.topbar-menu').forEach(otherMenu => {
                    if (otherMenu !== menu) {
                        otherMenu.style.opacity = '0';
                        otherMenu.style.visibility = 'hidden';
                        otherMenu.style.transform = 'translateY(-10px)';
                        otherMenu.style.pointerEvents = 'none';
                    }
                });
                
                // Show current menu
                menu.style.opacity = '1';
                menu.style.visibility = 'visible';
                menu.style.transform = 'translateY(0)';
                menu.style.pointerEvents = 'all';
                
                // Add active state
                trigger.setAttribute('aria-expanded', 'true');
            });
            
            // Hide dropdown on mouse leave with delay
            dropdown.addEventListener('mouseleave', () => {
                hoverTimeout = setTimeout(() => {
                    menu.style.opacity = '0';
                    menu.style.visibility = 'hidden';
                    menu.style.transform = 'translateY(-10px)';
                    menu.style.pointerEvents = 'none';
                    
                    // Remove active state
                    trigger.setAttribute('aria-expanded', 'false');
                }, 150);
            });
            
            // Keep menu open when hovering over it
            menu.addEventListener('mouseenter', () => {
                clearTimeout(hoverTimeout);
            });
            
            // Handle keyboard navigation
            trigger.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    
                    const isVisible = menu.style.visibility === 'visible';
                    
                    if (isVisible) {
                        // Hide menu
                        menu.style.opacity = '0';
                        menu.style.visibility = 'hidden';
                        menu.style.transform = 'translateY(-10px)';
                        menu.style.pointerEvents = 'none';
                        trigger.setAttribute('aria-expanded', 'false');
                    } else {
                        // Show menu
                        menu.style.opacity = '1';
                        menu.style.visibility = 'visible';
                        menu.style.transform = 'translateY(0)';
                        menu.style.pointerEvents = 'all';
                        trigger.setAttribute('aria-expanded', 'true');
                        
                        // Focus first menu item
                        const firstItem = menu.querySelector('.topbar-menu-item');
                        if (firstItem) firstItem.focus();
                    }
                }
                
                if (e.key === 'Escape') {
                    menu.style.opacity = '0';
                    menu.style.visibility = 'hidden';
                    menu.style.transform = 'translateY(-10px)';
                    menu.style.pointerEvents = 'none';
                    trigger.setAttribute('aria-expanded', 'false');
                    trigger.focus();
                }
            });
            
            // Handle arrow key navigation within menu
            const menuItems = menu.querySelectorAll('.topbar-menu-item');
            menuItems.forEach((item, index) => {
                item.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        const nextIndex = (index + 1) % menuItems.length;
                        menuItems[nextIndex].focus();
                    }
                    
                    if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        const prevIndex = index === 0 ? menuItems.length - 1 : index - 1;
                        menuItems[prevIndex].focus();
                    }
                    
                    if (e.key === 'Escape') {
                        menu.style.opacity = '0';
                        menu.style.visibility = 'hidden';
                        menu.style.transform = 'translateY(-10px)';
                        menu.style.pointerEvents = 'none';
                        trigger.setAttribute('aria-expanded', 'false');
                        trigger.focus();
                    }
                });
            });
        });
        
        // Close topbar dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.topbar-dropdown')) {
                // Close all topbar menus
                document.querySelectorAll('.topbar-menu').forEach(menu => {
                    menu.style.opacity = '0';
                    menu.style.visibility = 'hidden';
                    menu.style.transform = 'translateY(-10px)';
                    menu.style.pointerEvents = 'none';
                });
                
                // Reset all triggers
                document.querySelectorAll('.topbar-link').forEach(trigger => {
                    trigger.setAttribute('aria-expanded', 'false');
                });
            }
        });
        
        console.log('Topbar Dropdowns initialized successfully! 🔝');
    }

    initDiasporaFilters() {
        const filterButtons = document.querySelectorAll('.diaspora-filter-btn');
        const diasporaCards = document.querySelectorAll('.diaspora-card');
        
        if (!filterButtons.length || !diasporaCards.length) return;
        
        // Filter functionality
        filterButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                button.classList.add('active');
                
                // Get filter value
                const filterValue = button.getAttribute('data-filter');
                
                // Filter cards with smooth animation
                diasporaCards.forEach((card, index) => {
                    const cardCategory = card.getAttribute('data-category');
                    
                    // Add delay for staggered animation
                    setTimeout(() => {
                        if (filterValue === 'all' || cardCategory === filterValue) {
                            // Show card
                            card.classList.remove('hidden');
                            card.style.opacity = '0';
                            card.style.transform = 'translateY(20px)';
                            
                            // Animate in
                            setTimeout(() => {
                                card.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                                card.style.opacity = '1';
                                card.style.transform = 'translateY(0)';
                            }, 50);
                        } else {
                            // Hide card
                            card.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                            card.style.opacity = '0';
                            card.style.transform = 'translateY(-20px)';
                            
                            setTimeout(() => {
                                card.classList.add('hidden');
                            }, 300);
                        }
                    }, index * 50); // Staggered animation
                });
                
                // Add visual feedback to button
                button.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    button.style.transform = '';
                }, 150);
            });
            
            // Add hover effects
            button.addEventListener('mouseenter', () => {
                if (!button.classList.contains('active')) {
                    button.style.transform = 'translateY(-2px)';
                }
            });
            
            button.addEventListener('mouseleave', () => {
                if (!button.classList.contains('active')) {
                    button.style.transform = '';
                }
            });
        });
        
        // Newsletter form functionality
        const newsletterForm = document.querySelector('.diaspora-newsletter-form');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', (e) => {
                e.preventDefault();
                
                const emailInput = newsletterForm.querySelector('.diaspora-newsletter-input');
                const submitBtn = newsletterForm.querySelector('.diaspora-newsletter-btn');
                
                if (emailInput && submitBtn) {
                    // Add loading state
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    submitBtn.disabled = true;
                    
                    // Simulate API call
                    setTimeout(() => {
                        // Success state
                        submitBtn.innerHTML = '<i class="fas fa-check"></i>';
                        submitBtn.style.background = 'linear-gradient(135deg, #28a745 0%, #20c997 100%)';
                        emailInput.value = '';
                        emailInput.placeholder = 'Inscription réussie!';
                        
                        // Reset after 3 seconds
                        setTimeout(() => {
                            submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
                            submitBtn.style.background = '';
                            submitBtn.disabled = false;
                            emailInput.placeholder = 'votre@email.com';
                        }, 3000);
                    }, 1500);
                }
            });
        }
        
        // Add scroll animations for diaspora cards
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const cardObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 100);
                }
            });
        }, observerOptions);
        
        // Initially hide cards for animation
        diasporaCards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
            cardObserver.observe(card);
        });
        
        console.log('Diaspora & Investissement filters initialized successfully! 🌍');
    }

    initScrollAnimations() {
        // Initialize scroll animations for fade-in elements
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe all fade-in elements
        document.querySelectorAll('.fade-in').forEach(element => {
            observer.observe(element);
        });

        console.log('Scroll animations initialized successfully! 🎬');
    }

    initHeroCarousel() {
        // Initialize hero carousel if exists
        const carousel = document.querySelector('#heroCarousel');
        if (carousel) {
            new bootstrap.Carousel(carousel, {
                interval: 5000,
                wrap: true
            });
        }
    }

    initNewsletterForm() {
        // Initialize newsletter forms
        const forms = document.querySelectorAll('.newsletter-form, .newsletter-form-centered');
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const input = form.querySelector('input[type="email"]');
                const button = form.querySelector('button[type="submit"]');
                
                if (input && button) {
                    // Add loading state
                    button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Inscription...';
                    button.disabled = true;
                    
                    // Simulate API call
                    setTimeout(() => {
                        button.innerHTML = '<i class="fas fa-check me-2"></i>Inscrit!';
                        button.classList.add('btn-success');
                        input.value = '';
                        
                        // Reset after 3 seconds
                        setTimeout(() => {
                            button.innerHTML = '<i class="fas fa-paper-plane me-2"></i>S\'abonner';
                            button.classList.remove('btn-success');
                            button.disabled = false;
                        }, 3000);
                    }, 1500);
                }
            });
        });
    }

    initVideoPlayers() {
        // Initialize video players
        const videos = document.querySelectorAll('.video-player video');
        videos.forEach(video => {
            video.addEventListener('loadstart', () => {
                video.style.opacity = '0';
            });
            
            video.addEventListener('loadeddata', () => {
                setTimeout(() => {
                    video.style.opacity = '1';
                }, 200);
            });
        });
    }

    initMobileMenu() {
        // Initialize mobile menu toggle
        const mobileToggle = document.querySelector('.navbar-toggler');
        const navCollapse = document.querySelector('.navbar-collapse');
        
        if (mobileToggle && navCollapse) {
            mobileToggle.addEventListener('click', () => {
                navCollapse.classList.toggle('show');
            });
        }
        
        
    }

    initSearchToggle() {
        // Initialize search toggle functionality
        const searchToggle = document.querySelector('.nav-search-btn');
        const searchForm = document.querySelector('.nav-search-form');
        
        if (searchToggle && searchForm) {
            searchToggle.addEventListener('click', (e) => {
                e.preventDefault();
                searchForm.classList.toggle('active');
                const input = searchForm.querySelector('input');
                if (input && searchForm.classList.contains('active')) {
                    input.focus();
                }
            });
        }
    }

    initSmoothScrolling() {
        // Initialize smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    initLazyLoading() {
        // Initialize lazy loading for images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src || img.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[loading="lazy"]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }

    initCarousels() {
        // Initialize all carousels
        const carousels = document.querySelectorAll('.carousel');
        carousels.forEach(carousel => {
            new bootstrap.Carousel(carousel, {
                interval: 5000,
                wrap: true
            });
        });
    }

    initTabs() {
        // Initialize tab functionality
        document.querySelectorAll('.nav-tabs .nav-link').forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Remove active class from all tabs and content
                document.querySelectorAll('.nav-tabs .nav-link').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));
                
                // Add active class to clicked tab
                tab.classList.add('active');
                
                // Show corresponding content
                const targetId = tab.getAttribute('data-bs-target');
                const targetPane = document.querySelector(targetId);
                if (targetPane) {
                    targetPane.classList.add('show', 'active');
                }
            });
        });
    }

    initModals() {
        // Initialize modal functionality
        const modalElements = document.querySelectorAll('.modal');
        modalElements.forEach(modal => {
            new bootstrap.Modal(modal, {
                backdrop: 'static',
                keyboard: true
            });
        });
    }

    initTooltips() {
        // Initialize all tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    }

    bindEvents() {
        // Enhanced card interactions
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                if (!card.classList.contains('hero-card')) {
                    card.style.transform = 'translateY(-8px)';
                }
            });
            
            card.addEventListener('mouseleave', () => {
                if (!card.classList.contains('hero-card')) {
                    card.style.transform = 'translateY(0)';
                }
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Video player interactions
        document.querySelectorAll('.video-player').forEach(player => {
            player.addEventListener('click', () => {
                // Simulate video play
                player.style.opacity = '0.8';
                setTimeout(() => {
                    player.style.opacity = '1';
                }, 200);
            });
        });

        // Tab functionality
        document.querySelectorAll('.nav-tabs .nav-link').forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Remove active class from all tabs and content
                document.querySelectorAll('.nav-tabs .nav-link').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));
                
                // Add active class to clicked tab
                tab.classList.add('active');
                
                // Show corresponding content
                const targetId = tab.getAttribute('data-bs-target');
                const targetPane = document.querySelector(targetId);
                if (targetPane) {
                    targetPane.classList.add('show', 'active');
                }
            });
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
                document.body.classList.add('keyboard-navigation');
            }
        });

        document.addEventListener('mousedown', () => {
            document.body.classList.remove('keyboard-navigation');
        });
    }

    // Utility functions
    debounce(func, wait, immediate) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                timeout = null;
                if (!immediate) func(...args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func(...args);
        };
    }

    throttle(func, limit) {
        let inThrottle;
        return function(...args) {
            if (!inThrottle) {
                func.apply(this, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    // Analyse & Experts Filters
    initAnalyseExpertsFilters() {
        const filterTabs = document.querySelectorAll('.analyse-filter-tabs .filter-tab');
        const contentItems = document.querySelectorAll('.analyse-content-grid [data-category]');
        
        if (filterTabs.length === 0 || contentItems.length === 0) return;

        filterTabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Remove active class from all tabs
                filterTabs.forEach(t => t.classList.remove('active'));
                
                // Add active class to clicked tab
                tab.classList.add('active');
                
                // Get filter value
                const filterValue = tab.getAttribute('data-filter');
                
                // Filter content with staggered animation
                this.filterAnalyseContent(contentItems, filterValue);
                
                // Add ripple effect
                this.addRippleEffect(tab, e);
            });
        });

        // Newsletter CTA button
        const newsletterBtn = document.querySelector('.newsletter-cta-btn');
        if (newsletterBtn) {
            newsletterBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleAnalyseNewsletter(newsletterBtn);
            });
        }

        // Enhanced card interactions for analyse section
        const analyseCards = document.querySelectorAll('.analyse-featured-card, .analyse-quick-card, .analyse-standard-card');
        analyseCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = card.classList.contains('analyse-featured-card') ? 
                    'translateY(-8px)' : 
                    card.classList.contains('analyse-quick-card') ? 'translateX(5px)' : 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = card.classList.contains('analyse-quick-card') ? 
                    'translateX(0)' : 'translateY(0)';
            });
        });
    }

    filterAnalyseContent(items, filterValue) {
        items.forEach((item, index) => {
            const shouldShow = filterValue === 'all' || item.getAttribute('data-category') === filterValue;
            
            // Add staggered animation delay
            setTimeout(() => {
                if (shouldShow) {
                    item.classList.remove('hidden');
                    item.style.opacity = '1';
                    item.style.transform = 'scale(1)';
                } else {
                    item.classList.add('hidden');
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.8)';
                }
            }, index * 50);
        });
    }

    handleAnalyseNewsletter(button) {
        const originalText = button.innerHTML;
        
        // Show loading state
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Inscription...';
        button.disabled = true;
        
        // Simulate API call
        setTimeout(() => {
            button.innerHTML = '<i class="fas fa-check me-2"></i>Inscrit !';
            button.style.background = 'linear-gradient(135deg, #22C55E, #16A34A)';
            
            // Reset after 3 seconds
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
                button.style.background = '';
            }, 3000);
        }, 2000);
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
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        `;
        
        // Add ripple animation keyframes if not exists
        if (!document.querySelector('#ripple-styles')) {
            const style = document.createElement('style');
            style.id = 'ripple-styles';
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(2);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }
        
        element.style.position = 'relative';
        element.style.overflow = 'hidden';
        element.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    }

    // Initialize Analyse & Experts Ultra Filters (Revolutionary Design)
    initAnalyseExpertsUltraFilters() {
        const filterPills = document.querySelectorAll('.filter-pill');
        const contentItems = document.querySelectorAll('.analyse-content-matrix [data-category]');
        const streamTrack = document.querySelector('.stream-track');
        const streamControls = document.querySelectorAll('.control-btn');
        
        if (filterPills.length === 0) return;

        // Filter Pills Functionality
        filterPills.forEach(pill => {
            pill.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Remove active class from all pills
                filterPills.forEach(p => p.classList.remove('active'));
                pill.classList.add('active');
                
                const filterValue = pill.getAttribute('data-filter');
                this.filterUltraContent(contentItems, filterValue);
                
                // Add ripple effect
                this.addUltraRippleEffect(pill, e);
            });
        });

        // Stream Controls (Previous/Next)
        if (streamControls.length >= 2 && streamTrack) {
            const prevBtn = streamControls[0];
            const nextBtn = streamControls[1];
            let currentOffset = 0;
            const itemWidth = 330; // 300px + 30px gap
            const maxOffset = (streamTrack.children.length - 3) * itemWidth;

            prevBtn.addEventListener('click', () => {
                currentOffset = Math.max(0, currentOffset - itemWidth);
                streamTrack.style.transform = `translateX(-${currentOffset}px)`;
            });

            nextBtn.addEventListener('click', () => {
                currentOffset = Math.min(maxOffset, currentOffset + itemWidth);
                streamTrack.style.transform = `translateX(-${currentOffset}px)`;
            });
        }

        // Newsletter Integration Button
        const integrationBtn = document.querySelector('.integration-btn');
        if (integrationBtn) {
            integrationBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleUltraNewsletter(integrationBtn);
            });
        }

        // Enhanced Card Interactions
        const allCards = document.querySelectorAll('.secondary-card, .stream-item');
        allCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                const isStreamItem = card.classList.contains('stream-item');
                if (isStreamItem) {
                    card.style.transform = 'translateY(-5px) scale(1.02)';
                } else {
                    card.style.transform = 'translateY(-8px)';
                }
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Action Button Enhanced Interaction
        const actionBtns = document.querySelectorAll('.action-btn, .expert-cta');
        actionBtns.forEach(btn => {
            btn.addEventListener('mouseenter', () => {
                btn.style.transform = 'translateX(8px) scale(1.05)';
            });

            btn.addEventListener('mouseleave', () => {
                btn.style.transform = 'translateX(0) scale(1)';
            });
        });
    }

    // Filter content for Ultra design
    filterUltraContent(contentItems, filterValue) {
        contentItems.forEach((item, index) => {
            const categories = item.getAttribute('data-category').split(' ');
            const shouldShow = filterValue === 'all' || categories.includes(filterValue);
            
            setTimeout(() => {
                if (shouldShow) {
                    item.classList.remove('hidden');
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0) scale(1)';
                } else {
                    item.classList.add('hidden');
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(20px) scale(0.95)';
                }
            }, index * 50); // Staggered animation
        });
    }

    // Ultra ripple effect for filter pills
    addUltraRippleEffect(element, event) {
        const rect = element.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;
        
        const ripple = document.createElement('div');
        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            background: rgba(242, 203, 5, 0.3);
            border-radius: 50%;
            transform: scale(0);
            animation: ultra-ripple 0.6s ease-out;
            pointer-events: none;
            z-index: 1;
        `;
        
        element.style.position = 'relative';
        element.appendChild(ripple);
        
        // Add animation keyframes if not already added
        if (!document.querySelector('#ultra-ripple-styles')) {
            const style = document.createElement('style');
            style.id = 'ultra-ripple-styles';
            style.textContent = `
                @keyframes ultra-ripple {
                    to {
                        transform: scale(2);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }
        
        setTimeout(() => ripple.remove(), 600);
    }

    // Handle Ultra Newsletter subscription
    handleUltraNewsletter(button) {
        const originalText = button.querySelector('.btn-text').textContent;
        const btnText = button.querySelector('.btn-text');
        
        // Loading state
        btnText.textContent = 'INSCRIPTION...';
        button.style.background = '#F2B90C';
        button.style.transform = 'translateY(-4px) scale(1.05)';
        
        // Simulate API call
        setTimeout(() => {
            btnText.textContent = 'INSCRIT ✓';
            button.style.background = '#22C55E';
            button.style.color = '#FFFFFF';
            
            // Add success pulse
            const pulse = button.querySelector('.btn-pulse');
            if (pulse) {
                pulse.style.animation = 'pulse-btn 1s ease-out';
            }
            
            setTimeout(() => {
                btnText.textContent = originalText;
                button.style.background = '#0D0D0D';
                button.style.color = '#FFFFFF';
                button.style.transform = 'translateY(0) scale(1)';
            }, 2000);
        }, 1500);
    }

    // Initialize Magazines Ultra Filters (Revolutionary Design)
    initMagazinesUltraFilters() {
        const filterPills = document.querySelectorAll('.filter-pill-magazine');
        const contentItems = document.querySelectorAll('.magazines-content-matrix [data-category]');
        
        if (filterPills.length === 0) return;

        // Filter Pills Functionality
        filterPills.forEach(pill => {
            pill.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Remove active class from all pills
                filterPills.forEach(p => p.classList.remove('active'));
                pill.classList.add('active');
                
                const filterValue = pill.getAttribute('data-filter');
                this.filterMagazineContent(contentItems, filterValue);
                
                // Add ripple effect
                this.addMagazineRippleEffect(pill, e);
            });
        });

        // Quick Action Buttons
        const quickDownloadBtns = document.querySelectorAll('.quick-download-btn');
        const quickPreviewBtns = document.querySelectorAll('.quick-preview-btn');
        const quickShareBtns = document.querySelectorAll('.quick-share-btn');

        quickDownloadBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                this.handleMagazineDownload(btn);
            });
        });

        quickPreviewBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                this.handleMagazinePreview(btn);
            });
        });

        quickShareBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                this.handleMagazineShare(btn);
            });
        });

        // Featured Magazine Actions
        const downloadPrimaryBtns = document.querySelectorAll('.download-btn-primary');
        const previewSecondaryBtns = document.querySelectorAll('.preview-btn-secondary');

        downloadPrimaryBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleFeaturedDownload(btn);
            });
        });

        previewSecondaryBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleFeaturedPreview(btn);
            });
        });

        // Newsletter Magazine Button
        const newsletterMagazineBtn = document.querySelector('.newsletter-btn-magazine');
        if (newsletterMagazineBtn) {
            newsletterMagazineBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleMagazineNewsletter(newsletterMagazineBtn);
            });
        }

        // Enhanced Card Hover Effects
        const magazineCards = document.querySelectorAll('.magazine-card-ultra');
        magazineCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-12px) scale(1.02)';
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Featured Magazine Block Hover
        const featuredBlock = document.querySelector('.featured-magazine-block');
        if (featuredBlock) {
            featuredBlock.addEventListener('mouseenter', () => {
                featuredBlock.style.transform = 'scale(1.01)';
            });

            featuredBlock.addEventListener('mouseleave', () => {
                featuredBlock.style.transform = 'scale(1)';
            });
        }
    }

    // Filter magazine content
    filterMagazineContent(contentItems, filterValue) {
        contentItems.forEach((item, index) => {
            const categories = item.getAttribute('data-category').split(' ');
            const shouldShow = filterValue === 'all' || categories.includes(filterValue);
            
            setTimeout(() => {
                if (shouldShow) {
                    item.classList.remove('hidden');
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0) scale(1)';
                } else {
                    item.classList.add('hidden');
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(20px) scale(0.95)';
                }
            }, index * 60); // Staggered animation
        });
    }

    // Magazine ripple effect
    addMagazineRippleEffect(element, event) {
        const rect = element.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;
        
        const ripple = document.createElement('div');
        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            background: rgba(242, 203, 5, 0.25);
            border-radius: 50%;
            transform: scale(0);
            animation: magazine-ripple 0.6s ease-out;
            pointer-events: none;
            z-index: 1;
        `;
        
        element.style.position = 'relative';
        element.appendChild(ripple);
        
        // Add animation keyframes if not already added
        if (!document.querySelector('#magazine-ripple-styles')) {
            const style = document.createElement('style');
            style.id = 'magazine-ripple-styles';
            style.textContent = `
                @keyframes magazine-ripple {
                    to {
                        transform: scale(2.5);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }
        
        setTimeout(() => ripple.remove(), 600);
    }

    // Handle magazine download
    handleMagazineDownload(button) {
        const originalIcon = button.innerHTML;
        
        // Loading state
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.style.background = '#F2B90C';
        button.style.transform = 'scale(1.2)';
        
        // Simulate download
        setTimeout(() => {
            button.innerHTML = '<i class="fas fa-check"></i>';
            button.style.background = '#22C55E';
            
            setTimeout(() => {
                button.innerHTML = originalIcon;
                button.style.background = 'rgba(255, 255, 255, 0.95)';
                button.style.transform = 'scale(1)';
            }, 1500);
        }, 1000);
    }

    // Handle magazine preview
    handleMagazinePreview(button) {
        const originalIcon = button.innerHTML;
        
        button.innerHTML = '<i class="fas fa-search"></i>';
        button.style.background = '#8C5B30';
        button.style.color = '#FFFFFF';
        button.style.transform = 'scale(1.2)';
        
        setTimeout(() => {
            button.innerHTML = originalIcon;
            button.style.background = 'rgba(255, 255, 255, 0.95)';
            button.style.color = '#0D0D0D';
            button.style.transform = 'scale(1)';
        }, 1000);
    }

    // Handle magazine share
    handleMagazineShare(button) {
        const originalIcon = button.innerHTML;
        
        button.innerHTML = '<i class="fas fa-link"></i>';
        button.style.background = '#D99923';
        button.style.color = '#FFFFFF';
        button.style.transform = 'scale(1.2)';
        
        setTimeout(() => {
            button.innerHTML = '<i class="fas fa-check"></i>';
            button.style.background = '#22C55E';
            
            setTimeout(() => {
                button.innerHTML = originalIcon;
                button.style.background = 'rgba(255, 255, 255, 0.95)';
                button.style.color = '#0D0D0D';
                button.style.transform = 'scale(1)';
            }, 1000);
        }, 800);
    }

    // Handle featured magazine download
    handleFeaturedDownload(button) {
        const btnText = button.querySelector('.btn-text-magazine');
        const originalText = btnText.textContent;
        
        // Loading state
        btnText.textContent = 'TÉLÉCHARGEMENT...';
        button.style.background = '#F2B90C';
        button.style.transform = 'translateY(-4px) scale(1.05)';
        
        // Add pulse effect
        const pulse = button.querySelector('.btn-pulse-magazine');
        if (pulse) {
            pulse.style.animation = 'pulse-btn-magazine 1s ease-out infinite';
        }
        
        // Simulate download
        setTimeout(() => {
            btnText.textContent = 'TÉLÉCHARGÉ ✓';
            button.style.background = '#22C55E';
            button.style.color = '#FFFFFF';
            
            setTimeout(() => {
                btnText.textContent = originalText;
                button.style.background = '#0D0D0D';
                button.style.color = '#FFFFFF';
                button.style.transform = 'translateY(0) scale(1)';
                if (pulse) {
                    pulse.style.animation = 'pulse-btn-magazine 2.5s infinite';
                }
            }, 2500);
        }, 2000);
    }

    // Handle featured magazine preview
    handleFeaturedPreview(button) {
        const btnText = button.querySelector('.btn-text-magazine');
        const originalText = btnText.textContent;
        
        btnText.textContent = 'OUVERTURE...';
        button.style.borderColor = '#F2CB05';
        button.style.color = '#F2CB05';
        button.style.transform = 'translateY(-4px) scale(1.05)';
        
        setTimeout(() => {
            btnText.textContent = 'APERÇU OUVERT ✓';
            button.style.borderColor = '#22C55E';
            button.style.color = '#22C55E';
            
            setTimeout(() => {
                btnText.textContent = originalText;
                button.style.borderColor = 'rgba(13, 13, 13, 0.2)';
                button.style.color = '#0D0D0D';
                button.style.transform = 'translateY(0) scale(1)';
            }, 2000);
        }, 1200);
    }

    // Handle magazine newsletter subscription
    handleMagazineNewsletter(button) {
        const btnText = button.querySelector('.btn-text-newsletter');
        const originalText = btnText.textContent;
        
        // Loading state
        btnText.textContent = 'INSCRIPTION...';
        button.style.background = '#F2B90C';
        button.style.transform = 'translateY(-4px) scale(1.05)';
        
        // Add pulse effect
        const pulse = button.querySelector('.btn-pulse-newsletter');
        if (pulse) {
            pulse.style.animation = 'pulse-btn-magazine 1s ease-out infinite';
        }
        
        // Simulate subscription
        setTimeout(() => {
            btnText.textContent = 'ABONNÉ AUX MAGAZINES ✓';
            button.style.background = '#22C55E';
            button.style.color = '#FFFFFF';
            
            setTimeout(() => {
                btnText.textContent = originalText;
                button.style.background = '#0D0D0D';
                button.style.color = '#FFFFFF';
                button.style.transform = 'translateY(0) scale(1)';
                if (pulse) {
                    pulse.style.animation = 'pulse-btn-magazine 2.5s infinite';
                }
            }, 3000);
        }, 1800);
    }

    // Performance monitoring
    logPerformance() {
        if ('performance' in window) {
            window.addEventListener('load', () => {
                const perfData = performance.getEntriesByType('navigation')[0];
                console.log('📊 Performance Metrics:');
                console.log(`⚡ Page Load Time: ${Math.round(perfData.loadEventEnd - perfData.fetchStart)}ms`);
                console.log(`🎨 DOM Content Loaded: ${Math.round(perfData.domContentLoadedEventEnd - perfData.fetchStart)}ms`);
                console.log(`🖼️ First Paint: ${Math.round(performance.getEntriesByType('paint')[0]?.startTime || 0)}ms`);
            });
        }
    }
}

// Initialize the app when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    const app = new ExcellenceAfrikApp();
    app.logPerformance();
    
    // Make app globally available for debugging
    window.ExcellenceAfrikApp = app;
});

// Service Worker registration for PWA capabilities
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(registration => {
                console.log('🔧 SW registered: ', registration);
            })
            .catch(registrationError => {
                console.log('❌ SW registration failed: ', registrationError);
            });
    });
}
