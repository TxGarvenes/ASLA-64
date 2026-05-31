/* Fichier : /script.js */

/* ====================================== ENTETE DYNAMIQUE ====================================== */
document.addEventListener('DOMContentLoaded', function() {
    const body = document.body;
    
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            body.classList.add('is-scrolled');
        } else {
            body.classList.remove('is-scrolled');
        }
    });
});

/* ====================================== MENU PRIORITAIRE (SUITE...) ====================================== */
document.addEventListener('DOMContentLoaded', function() {
    const navContainer = document.querySelector('.desktop-only-menu');
    const menuList = document.querySelector('.nav-list-desktop');
    
    if (!navContainer || !menuList) return;

    // 1. CORRECTION ICI : On empêche le bouton de faire sauter la page en haut quand on clique/tape dessus !
    const moreItem = document.createElement('li');
    moreItem.className = 'menu-item-more';
    moreItem.innerHTML = '<a href="#" onclick="event.preventDefault();">Suite <span class="arrow-dropdown">▼</span></a><ul class="more-dropdown"></ul>';    
    
    // Détection des éléments fixes (Accueil, Contact, Documents)
    let contactItem = null;
    let accueilItem = menuList.firstElementChild; 

    Array.from(menuList.children).forEach(li => {
        const a = li.querySelector('a');
        if (a && a.textContent.toLowerCase().includes('contact')) {
            contactItem = li;
        }
    });
    
    const docsItem = document.getElementById('custom-docs');

    if (contactItem) {
        menuList.insertBefore(moreItem, contactItem);
    } else if (docsItem) {
        menuList.insertBefore(moreItem, docsItem);
    } else {
        menuList.appendChild(moreItem);
    }
    
    const moreDropdown = moreItem.querySelector('.more-dropdown');

    function checkMenuOverflow() {
        if (window.innerWidth <= 767) return; 

        // On remet TOUS les sports cachés dans la barre principale pour pouvoir les compter !
        const hiddenItems = Array.from(moreDropdown.children);
        hiddenItems.forEach(item => {
            menuList.insertBefore(item, moreItem);
        });

        // Isoler les sports (maintenant qu'ils sont bien tous là)
        const allSports = Array.from(menuList.children).filter(item => 
            item !== contactItem && item !== moreItem && item !== docsItem && item !== accueilItem
        );

        let activeSport = allSports.find(sport => sport.classList.contains('current-menu-item'));
        const regularSports = allSports.filter(sport => sport !== activeSport);

        const moreLink = moreItem.querySelector('a');
        moreLink.innerHTML = 'Activités <span class="arrow-dropdown">▼</span>';
        moreItem.style.display = 'flex';
        
        Array.from(menuList.children).forEach(li => li.style.flexShrink = '0');

        // Mesure stricte des tailles
        const trueContainerWidth = navContainer.clientWidth;
        const contactW = contactItem ? contactItem.offsetWidth : 0;
        const docsW = docsItem ? docsItem.offsetWidth : 0;
        const accueilW = accueilItem ? accueilItem.offsetWidth : 0;
        const activeW = activeSport ? activeSport.offsetWidth : 0;
        const moreW = moreItem.offsetWidth;

        moreItem.style.display = 'none';

        // Espace dispo
        let availableForSports = trueContainerWidth - accueilW - contactW - docsW - activeW - moreW - 120;
        let visibleCount = 0;
        let overflow = false;

        regularSports.forEach(sport => {
            const sportW = sport.offsetWidth;
            // 2. CORRECTION ICI : On ajoute "!overflow" pour bloquer le comptage dès qu'un sport dépasse
            if (!overflow && sportW <= availableForSports) {
                availableForSports -= sportW;
                visibleCount++;
            } else {
                overflow = true;
            }
        });

        let finalVisibleSports = [];
        
        if (!overflow) {
            finalVisibleSports = regularSports;
            moreItem.style.display = 'none';
        } else {
            moreItem.style.display = 'flex';
            
            if (visibleCount <= 2) {
                finalVisibleSports = [];
                moreLink.innerHTML = 'Activités <span class="arrow-dropdown">▼</span>';
            } else {
                finalVisibleSports = regularSports.slice(0, visibleCount);
                moreLink.innerHTML = 'Suite <span class="arrow-dropdown">▼</span>';
            }
        }

        // Replace les éléments
        allSports.forEach(sport => {
            if (sport === activeSport || finalVisibleSports.includes(sport)) {
                menuList.insertBefore(sport, moreItem);
            } else {
                moreDropdown.appendChild(sport);
            }
        });

        // L'alignement "Aimant" vers la droite
        moreItem.style.marginLeft = '0'; 
        if(contactItem) {
            contactItem.style.marginLeft = 'auto'; 
        } else if (docsItem) {
            docsItem.style.marginLeft = 'auto'; 
        }
    }

    setTimeout(checkMenuOverflow, 150);
    
    // ANTI-BUG 1 : Redimensionnement de la fenêtre
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(checkMenuOverflow, 50);
    });

    // ANTI-BUG 2 (Scroll) : On écoute si le Header change de taille via la classe "is-scrolled"
    // On force le Javascript à attendre 350ms (la fin de l'animation CSS) avant de calculer la place !
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.attributeName === 'class') {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(checkMenuOverflow, 350); 
            }
        });
    });
    observer.observe(document.body, { attributes: true });
});

/* ====================================== SOUS-MENU DYNAMIQUE ====================================== */
document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('section, #top');
    const navLi = document.querySelectorAll('.sub-menu-links a');

    function onScroll() {
        let current = '';
        const offset = window.innerHeight * 0.5; 

        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;

            if (window.scrollY >= (sectionTop - offset)) {
                current = section.getAttribute('id');
            }
        });

        navLi.forEach(a => {
            a.classList.remove('active');
            if (a.getAttribute('href') && a.getAttribute('href').includes(current)) {
                if(current !== null && current !== '') { 
                    a.classList.add('active');
                    if (window.innerWidth < 768) {
                        a.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                    }
                }
            }
        });
    }

    window.addEventListener('scroll', onScroll);
});

/* ====================================== BOUTON BTN-TOP ====================================== */
document.addEventListener('DOMContentLoaded', function() {
    const btnTop = document.getElementById('back-to-top');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 200) {
            btnTop.classList.add('show');
        } else {
            btnTop.classList.remove('show');
        }
    });
    btnTop.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});

/* ====================================== CARROUSEL SPORTS ====================================== */
document.addEventListener('DOMContentLoaded', function() {
    
    const track = document.querySelector('.slider-track');
    if(!track) return;

    const slides = Array.from(track.children);
    const nextButton = document.querySelector('.next-arrow');
    const prevButton = document.querySelector('.prev-arrow');
    const dotsNav = document.querySelector('.slider-indicators');
    const dots = Array.from(dotsNav.children);
    let currentIndex = 0;
    let autoPlayInterval;

    const moveToSlide = (index) => {
        if (index < 0) index = slides.length - 1;
        if (index >= slides.length) index = 0;
        track.style.transform = 'translateX(-' + (index * 100) + '%)';
        currentIndex = index;
        
        dots.forEach(dot => dot.classList.remove('active'));
        if(dots[index]) dots[index].classList.add('active');

        slides.forEach(slide => slide.classList.remove('active'));
        
        setTimeout(() => {
            slides[index].classList.add('active');
        }, 50);
    }

    if(nextButton) {
        nextButton.addEventListener('click', () => {
            moveToSlide(currentIndex + 1);
            resetTimer();
        });
    }
    if(prevButton) {
        prevButton.addEventListener('click', () => {
            moveToSlide(currentIndex - 1);
            resetTimer();
        });
    }
    if(dotsNav) {
        dotsNav.addEventListener('click', e => {
            const targetDot = e.target.closest('.indicator-dash');
            if (!targetDot) return;
            const targetIndex = parseInt(targetDot.dataset.slideTo);
            moveToSlide(targetIndex);
            resetTimer();
        });
    }

    const startTimer = () => {
        autoPlayInterval = setInterval(() => {
            moveToSlide(currentIndex + 1);
        }, 7000); 
    };
    const resetTimer = () => {
        clearInterval(autoPlayInterval);
        startTimer();
    };

    moveToSlide(0);
    startTimer();
    window.addEventListener('resize', () => {
        moveToSlide(currentIndex);
    });
});


/* ====================================== MENU BURGER MOBILE ====================================== */
document.addEventListener('DOMContentLoaded', function() {
    const burger = document.querySelector('.burger-menu');
    const nav = document.querySelector('.main-nav');

    if(burger && nav) {
        burger.addEventListener('click', () => {
            nav.classList.toggle('open');
            burger.classList.toggle('open');
            document.body.classList.toggle('no-scroll');
        });

        const navLinks = document.querySelectorAll('.main-nav a');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                nav.classList.remove('open');
                burger.classList.remove('open');
                document.body.classList.remove('no-scroll');
            });
        });

        document.addEventListener('click', (e) => {
            if (document.body.classList.contains('no-scroll') && e.target.tagName === 'BODY') {
                nav.classList.remove('open');
                burger.classList.remove('open');
                document.body.classList.remove('no-scroll');
            }
        });
    }
});