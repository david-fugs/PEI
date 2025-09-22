
window.onload = function() {
    let checkbox = document.getElementById("cbox1");
    let elementosParaOcultarOMostrar = document.querySelectorAll(".oculto");
    
    let elementosOcultos = true;

   
    

    // Función para alternar la visibilidad de los elementos y cambiar el colspan de los encabezados
    function alternarVisibilidad() {
        elementosParaOcultarOMostrar.forEach(function(elemento) {
            if (elementosOcultos) {
                elemento.style.display = "block"; 
               
            } else {
                elemento.style.display = "none";
               
            }
        });


        elementosOcultos = !elementosOcultos;
    
        if (elementosOcultos) {
            //ocultar archivos
            document.querySelector(".encabezado1").colSpan = 2;
            document.querySelector(".encabezado2").colSpan = 1;
            document.querySelector(".encabezado3").colSpan = 2;
            document.querySelector(".encabezado4").colSpan = 4;
            document.querySelector(".encabezado5").colSpan = 3;
            document.querySelector(".encabezado6").colSpan = 3;
            
        } else {
            //mostrar archivos
        
            document.querySelector(".encabezado1").colSpan = 3;
            document.querySelector(".encabezado2").colSpan = 2;
            document.querySelector(".encabezado3").colSpan = 4;
            document.querySelector(".encabezado4").colSpan = 8;
            document.querySelector(".encabezado5").colSpan = 6;
            document.querySelector(".encabezado6").colSpan = 6;
        }
    }


    checkbox.addEventListener("change", function() {
        alternarVisibilidad();
    });


  

}




