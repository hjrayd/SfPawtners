const filterTitle = document.getElementById('filter-title');
const filterCat = document.getElementById('filter-cat');

filterTitle.addEventListener('click', function() {
    if (filterCat.style.display === "none") {
        filterCat.style.display = "flex";
    } else {
        filterCat.style.display = "none"
    }
});





