// Obter a URL atual
const url = new URL(window.location.href);

// Criar um objeto URLSearchParams a partir dos parâmetros da URL
const params = new URLSearchParams(url.search);

// Obter o valor do parâmetro "alert"
const alertValue = params.get('alert');

// Exibir o valor
if(alertValue !== null){
    alert(alertValue);
}
