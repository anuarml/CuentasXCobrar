//Se debe usar cuando se tengan numeros que tengan menos de 3 decimales
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

//Se debe usar cuando se tengan numeros que tengan mas de 3 decimales
/*function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}*/