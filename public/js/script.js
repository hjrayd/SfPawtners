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
        const btnLike = document.getElementById('btn-like');
        const formEl = document.querySelectorAll('.form-catTwo'); 
        const formLike = document.getElementById('form-like');

        if (btnLike && formLike && formEl.length > 0) { // on vérifie que les éléments existent bien
            btnLike.addEventListener('click', function() {
                if (formLike.style.display === 'flex') {
                    formLike.style.display = 'none';  
                } else {
                    formLike.style.display = 'flex';  
                }
                formEl.forEach(function(form) { // pour tous les éléments qui ont la classe .form-catTwo on applique la fonction formLike
                        $(form).slideToggle();
                                
                    });
            });
        } else {
            console.log('Le bouton btnLike ou les éléments avec la classe .form-catTwo sont manquants');
        }
    }

    // On appelle les fonctions
    slideFormHome();
    formLikeCat();
});
