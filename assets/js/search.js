var empresa = document.getElementById('empresa');
var search = document.getElementById('pesquisar');
var tipo = document.getElementById('select-tipo');

search.addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        searchData();
    }
});

function searchData() {
        window.location = 'estoque.php?empresa=' + empresa.value + '&tipo=' + tipo.value + '&search=' + search.value;
}