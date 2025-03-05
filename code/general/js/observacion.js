function actualizarObservacion() {
    var id_cole = document.querySelector('input[name="id_cole"]').value;
    var nueva_observacion = document.querySelector('textarea[name="nueva_observacion"]').value;
    
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Recargar la página para mostrar la nueva observación
            location.reload();
        }
    };
    
    xhr.open("POST", "observacion.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("id_cole=" + id_cole + "&nueva_observacion=" + nueva_observacion);
    
    return false; // Evitar la redirección automática
}