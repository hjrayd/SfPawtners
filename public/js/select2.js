$(document).ready(function() {
    $('#cat_city').select2({
        ajax: {
            url: '/api/cities',  // URL de l'API
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return { q: params.term };  // Recherche le terme tapé
            },
            processResults: function(data) {
                return {
                    results: data.map(function(city) {
                        return {
                            id: city.id,  // code postal
                            text: city.text // nom de la ville
                        };
                    })
                };
            },
            cache: true
        },
        placeholder: 'Choisissez une ville',
        minimumInputLength: 2,  // Commence à chercher après 2 caractères
    });
});
