document.addEventListener('DOMContentLoaded', function() {
    
    // Fonction pour le glissement du formulaire de la page d'accueil
    function slideFormHome() {
        const filterTitle = document.getElementById('filter-title');
        const filterCat = document.getElementById('filter-cat');

        if (filterTitle && filterCat) { // On vérifie que les éléments existent bien sinon la fonction ne marchera pas
            filterTitle.addEventListener('click', function() { 
                $(filterCat).slideToggle();
            });
        } else {
            console.log('Les éléments filterTitle ou filterCat sont manquants');
        }
    }

    // Fonction qui fait apparaître le formulaire lorsque l'on clique sur le bouton en forme de coeur
    function formLikeCat() {
        const btnLike = document.getElementById('btn-heart');
        const formEl = document.querySelectorAll('.form-catTwo');
        const formLike = document.getElementById('form-like');

        // On vérifie que les éléments existent bien 
        if (btnLike && formLike && formEl.length > 0) {

            // On cahce le formulaire et ses éléments 
            formLike.style.display = 'none';  
            formEl.forEach(function(form) {
                $(form).hide();  
            });

            // Lorsque l'on clique sur le bouton cela fait apparaitre ou disparaitre le formulaire
            btnLike.addEventListener('click', function() {

                if (formLike.style.display === 'flex') {
                    formLike.style.display = 'none';  
                } else {
                    formLike.style.display = 'flex';  
                }

                // Effet de glissement sur les éléments du formulaire
                formEl.forEach(function(form) {
                    $(form).slideToggle(); 
                });
            });

        } else {
            console.log('Le bouton btnLike ou les éléments avec la classe .form-catTwo sont manquants');
        }
    }

    function menuBurger() {
    const sidenav = document.getElementById("sideNav");
    const openBtn = document.getElementById("openBtn");
    const closeBtn = document.getElementById("closeBtn");
    
    if (sideNav && openBtn && closeBtn) {

    openBtn.onclick = openNav;
    closeBtn.onclick = closeNav;

    function openNav () {
        sidenav.classList.add("active");
    }

    function closeNav () {
        sidenav.classList.remove("active");
    }

    } else {
        console.log('Les éléments sideNav, openBtn et closeBtn sont manquants');
    }
}

    // On appelle les fonctions
    menuBurger();
    slideFormHome();
    formLikeCat();
});
