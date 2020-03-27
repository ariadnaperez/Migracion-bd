function nombreBds() {
    var combo = document.getElementById("nombreBds");
    var base_datos = combo.options[combo.selectedIndex].text;

    if (base_datos == 'Empleados') {
        select_tabla();
        habilita();
    } else {
        alert("La Base de Datos seleccionada no esta disponible para migrarse");
        deshabilita();
    }
}

function select_tabla() {
    var name = $("#select_tabla").val();
    var ob = { name: name };

    $.ajax({
        type: "POST",
        url: "./modelo_mostrar_datos.php",
        data: ob,
        success: function(data) {

            $("#panel_selector").html(data);

        }
    });
}

function deshabilita() {
    document.getElementById('btn-tablas').disabled = true;
}

function habilita() {
    document.getElementById('btn-tablas').disabled = false;
}