const filterTitle = document.getElementById('filter-title');
const filterCat = document.getElementById('filter-cat');

filterTitle.addEventListener('click', function() {
    if (filterCat.style.display === "none") {
        filterCat.style.display = "flex";
    } else {
        filterCat.style.display = "none"
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const arrow = document.getElementById('arrow');
    const cats = document.getElementById('cats-user');

    arrow.addEventListener('click', function () {
        if (cats.style.display === "none") {
            cats.style.display = "flex";
        } else {
            cats.style.display = "none";
        }
    });
})





