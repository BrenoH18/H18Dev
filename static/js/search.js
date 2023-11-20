var id_user = document.getElementById('id_user');
var search = document.getElementById('pesquisar');
var tipo = document.getElementById('select-tipo');

search.addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        searchData();
    }
});

function searchData() {
        window.location = 'estoque.php?id=' + id_user.value + '&tipo=' + tipo.value + '&search=' + search.value;
}