// Obter a URL atual
const url = new URL(window.location.href);

// Criar constante params a partir dos parâmetros da URL
const params = new URLSearchParams(url.search);

// Obter o valor do parâmetro "alert"
const alertValue = params.get('alert');

// Exibir o valor se for diferente de null
if(alertValue !== null){
    alert(alertValue);
}
