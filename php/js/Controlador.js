function nombreBds() {
    document.getElementById('btn-tablas').style.display = 'inline';
    document.getElementById('btn-conversion').style.display = 'inline';
    document.getElementById('btn-MIGRACION').style.display = 'inline';

    var base_datos = document.getElementById("nombreBds").value;

    if (base_datos == 'Empleados') {
        select_tabla();
        habilita();
        $.ajax({
            type: "POST",
            data: { "nombre": base_datos },
            dataType: 'json',
            success: function(data) {
                console.log(data);
            }
        });
    } else {
        swal({
            title: '¡ERROR!',
            text: 'La BD seleccionada no esta disponible para migrarse',
            type: 'error',
          })
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
    document.getElementById('btn-conversion').disabled = true;
    document.getElementById('btn-MIGRACION').disabled = true;
}


function habilita() {
    document.getElementById('btn-tablas').disabled = false;
    document.getElementById('btn-conversion').disabled = false;
    document.getElementById('btn-MIGRACION').disabled = false;
}

