<!DOCTYPE html>
<meta charset="utf8"/>
<?php
    $conexion=oci_connect ("sys", "1234", "localhost/xe", '', OCI_SYSDBA);

    if(!$conexion){
    echo "Conexion error";
    }else{
        echo "Conexion con exito a oracle!"."<br>";
         //revisar_exis_usuario($conexion);
        //conexionNuevoUsuario();
    }

    function revisar_exis_usuario($conexion)
    {
        $sql="SELECT COUNT(*) AS CONTEO_USER FROM DBA_USERS WHERE USERNAME='EMPLEADOS'";
        $stmt = oci_parse($conexion, $sql);
        oci_execute( $stmt);
        oci_fetch($stmt);
        $conteo=strval(oci_result($stmt,"CONTEO_USER"));
        if($conteo=1){
            borrarUsuario($conexion);
            crearUsuario($conexion);
        }
        else{
            crearUsuario($conexion);
        }
        
        oci_free_statement( $stmt);

    }

    function borrarUsuario($conexion){
        $sql1 = "DROP USER Empleados CASCADE";

        $stmt1 = oci_parse($conexion, $sql1);
        $ok1 = oci_execute( $stmt1 );
        oci_free_statement( $stmt1 );
        return $ok1;

    }

    function crearUsuario($conexion){
        $sql1 = "CREATE USER Empleados IDENTIFIED BY ami123 DEFAULT TABLESPACE USERS TEMPORARY TABLESPACE TEMP 
        QUOTA UNLIMITED ON USERS";
        $sql2 = "GRANT SYSDBA, SYSOPER, DBA, CREATE SESSION, CONNECT TO EMPLEADOS";

        $stmt1 = oci_parse($conexion, $sql1);
        $ok1 = oci_execute( $stmt1 );
        oci_free_statement( $stmt1 );
        
        $stmt2 = oci_parse($conexion, $sql2);
        $ok2 = oci_execute( $stmt2 );
        oci_free_statement( $stmt2 );
        return $ok1;
        return $ok2;
    }


    function conexionNuevoUsuario(){
        $conexion2 = oci_connect ("Empleados", "ami123","localhost/xe");
        if(!$conexion2){
            echo "Conexion error";
        }else{
            echo "conexion a Empleados exitosa";
            return $conexion2;
        }
    }

?>