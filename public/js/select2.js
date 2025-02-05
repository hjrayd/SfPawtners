
//Permet de garantir que le script ne sera executé que si la page est entièrement chargée
$(document).ready(function() {
    $('#cat_city, #filter_city').select2({
        ajax: { //La requête AJAX permet d'afficher les villes dans le select sans avoir à recharger la page
            url: '/api/cities',  // URL de l'API
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return { q: params.term };  // Recherche le terme qui à été entré
            },
            processResults: function(data) { //Formate les données de l'API pour Select2
                return {
                    results: data.map(function(city) {
                        return {
                            id: city.id,  // code INSEE
                            text: city.text // nom de la ville
                        };
                    })
                };
            },
            cache: true //Evite d'envoyer les mêmes requêtes plsuieurs fois
        },
        placeholder: 'Choisissez une ville',
        minimumInputLength: 2,  // 2 caractères minimum requis
    });

    // Fonction appelée lorsque l'utilisateur séléctionne une ville dans ces champs ciblés
    $('#filter_city, #cat_city').on('select2:select', function (e) {
        const data = e.params.data;  //Récupération des infos de la ville séléctionnée

        
        $('#filter_city, #cat_city').val(data.text).trigger('change');  //On force l'input à changer en affichant le nom de la ville
        $('.code_postal_js').val(data.id);  //Code INSEE
        $('.ville_js').val(data.text);  //Nom de la ville

        
        var newOption = new Option(data.text, data.text, true, true);  
        $('#filter_city, #cat_city').empty().append(newOption).trigger('change');
    });

    var optionEdit = new Option($('#filter_city, #cat_city').val(), $('#filter_city, #cat_city').val(), true, true);
    $('#filter_city, #cat_city').empty().append(optionEdit).trigger('change');
});
