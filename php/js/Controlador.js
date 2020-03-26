function select_tabla()
{ 
  
 
 var name =  $("#select_tabla").val();

 //alert("Hola select = "+ object_id);

    var ob = {name:name};

     $.ajax({
                type: "POST",
                url:"./modelo_mostrar_datos.php",
                data: ob,
                beforeSend: function(objeto){
                
                },
                success: function(data)
                { 
                 
                 $("#panel_selector").html(data);
            
                }
             });
}

