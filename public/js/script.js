const filterTitle = document.getElementById('filter-title');
const filterCat = document.getElementById('filter-cat');

filterTitle.addEventListener('click', function() {
    // Utilisation de jQuery pour un effet de glissement (slide)
    $(filterCat).slideToggle();
});






