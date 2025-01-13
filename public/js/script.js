document.addEventListener('DOMContentLoaded', function() {
    
    
    //Fonction pour le glissement du formulaire de la page d'accueil
    function slideFormHome() {
        const filterTitle = document.getElementById('filter-title');
        const filterCat = document.getElementById('filter-cat');

        if (filterTitle && filterCat) { //On vérifie que les élements existent bien sinon la fonctionne ne marchera pas
            filterTitle.addEventListener('click', function() { 
            $(filterCat).slideToggle();
            });
        } else {
            console.log('Les éléments filterTitle ou filterCat sont manquants');
        }
    }

    //Fonction qui faire apparaitre le formulaire lorsque l'on clique sur le bouton en forme de coeur
    function formLikeCat() {
        const btnLike = document.getElementById('btn-like');
        const formLikeEl = document.querySelectorAll('.form-catTwo'); 
    
        if (btnLike && formLikeEl.length > 0) {
            btnLike.addEventListener('click', function() {
                formLikeEl.forEach(function(formLike) {
                    
                    if (formLike.style.display === 'flex') {
                        formLike.style.display = 'none';  
                    } else {
                        formLike.style.display = 'flex';  
                    }
                });
            });
        } else {
            console.log('Le bouton btnLike ou les éléments avec la classe like-catTwo sont manquants');
        }
    }

    //On appelle les fonctions
    slideFormHome();
    formLikeCat();
});







