function Obtener(){
    var select = document.getElementById("nombreTablas"), //El <select>
        value = select.value, //El valor seleccionado
        text = select.options[select.selectedIndex].innerText; //El texto de la opción seleccionada

        return text; 
}
