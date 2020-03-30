<!DOCTYPE html>
<meta charset="utf8"/>
<?php

    $conexion=oci_connect ("sys", "oracle", "localhost/xe", '', OCI_SYSDBA);

    if(!$conexion){
    echo "Conexion error";
    }else{
        echo "Conexion con exito a oracle!"."<br>";
        //crearUsuario($conexion);
        conexionNuevoUsuario();

    }

    /*function crearUsuario($conexion){
        $sql1 = "CREATE USER Empleados IDENTIFIED BY ami123 DEFAULT TABLESPACE USERS TEMPORARY TABLESPACE TEMP QUOTA UNLIMITED ON USERS";
        $sql2 = "GRANT SYSDBA, SYSOPER, DBA, CREATE SESSION, CONNECT TO EMPLEADOS";

        $stmt1 = oci_parse($conexion, $sql1);
        $ok1 = oci_execute( $stmt1 );
        oci_free_statement( $stmt1 );
        
        $stmt2 = oci_parse($conexion, $sql2);
        $ok2 = oci_execute( $stmt2 );
        oci_free_statement( $stmt2 );
        return $ok1;
        return $ok2;
    }*/

    function conexionNuevoUsuario(){
        $conexion2 = oci_connect ("Empleados", "ami123", "localhost/xe");
        if(!$conexion2){
            echo "Conexion error";
        }else{
            echo "conexion a Empleados exitosa";
            crearTabla($conexion2);
        }
    }

    function crearTabla($conexion2){
       /*$sql = "create table tbl_personas (id integer, nombre varchar(50))";
        $stmt = oci_parse($conexion2, $sql);
        $ok4 = oci_execute($stmt);
        oci_free_statement( $stmt );
        return $ok4;

        $sql1 = "INSERT INTO tbl_personas VALUES (1, 'AMI')";
        $stmt2 = oci_parse($conexion2, $sql1);
        $ok3 = oci_execute($stmt2);
        oci_free_statement( $stmt2 );
        return $ok3;*/
        insertarPersona( $conexion2 );
        $sql1 = "select * from tbl_personas";
        $filas = 0;
        $stmt2 = oci_parse($conexion2, $sql1);
        $ok3 = oci_execute($stmt2);
        if($ok3 == true){
            if($obj = oci_fetch_object($stmt2)){
                echo "<p/>LISTADO DE PERSONAS<br/>";
                echo "===================<p />";
                // Recorrer el resource y mostrar los datos (HAY QUE PONER LOS NOMBRES DE LOS CAMPOS EN MAYÚSCULAS):
                 do
                 {
                     echo $obj->ID." - ".$obj->NOMBRE."<br />";
                 } while( $obj = oci_fetch_object($stmt2) );
                // Mostrar el número de registros:
                 echo "<p>(".oci_num_rows($stmt2).") fila(s) encontrado(s)</p>";
            }
            else
                echo "<p>No se encontraron personas</p>";
        }
        else
            $ok3 = false;
        oci_free_statement( $stmt2 );
        return $ok3;
    }

        function insertarPersona( $conexion2 )
        {
            $sql = "INSERT INTO tbl_personas VALUES (1,'AMI')";
             $stmt = oci_parse($conexion2, $sql);      // Preparar la sentencia
             $ok   = oci_execute( $stmt );            // Ejecutar la sentencia
             oci_free_statement($stmt);               // Liberar los recursos asociados a una sentencia o cursor
            return $ok;
        }
    
?>
