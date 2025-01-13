const filterTitle = document.getElementById('filter-title');
const filterCat = document.getElementById('filter-cat');

filterTitle.addEventListener('click', function() {
    // Utilisation de jQuery pour un effet de glissement (slide)
    $(filterCat).slideToggle();
});

// const btnLike = document.getElementById('btnLike');
// const formLike = document.getElementById('like-catTwo');

// btnLike.addEventListener('click', function(){
   
//     if (formLike.style.display === 'flex') {
//         formLike.style.display = 'none';  
//     } else {
//         formLike.style.display = 'flex';  
//     }
// });







