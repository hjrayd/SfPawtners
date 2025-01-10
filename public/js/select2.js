
//Permet de garantir que le script ne sera executé que si la page est entièrement chargée
$(document).ready(function() {
    $('#cat_city').select2({
        ajax: { //La requête AJAX permet d'afficher les villes dans le select sans avoir à recharger la page
            url: '/api/cities',  // URL de l'API
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return { q: params.term };  // Recherche le terme qui à été entré
            },
            processResults: function(data) {
                return {
                    results: data.map(function(city) {
                        return {
                            id: city.id,  // code INSEE
                            text: city.text // nom de la ville
                        };
                    })
                };
            },
            cache: true
        },
        placeholder: 'Choisissez une ville',
        minimumInputLength: 2,  // 2 caractères minimum requis
    });
});
