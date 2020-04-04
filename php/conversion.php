<?php
include "./conexionOracle.php";
include "./conexionServer.php";

    /////////////  SQL SERVER
    $conn = sqlsrv_connect($serverName,$connectionInfo); 

    $conexion2 = oci_connect ("Empleados", "ami123","localhost/xe");
        if(!$conexion2){
            echo "Conexion error";
        }else{
            echo "<br>"."conexion a Empleados exitosa";
        };


        
////////////////////////// CONSULTAS SQL SERVER
    $sql3 = "SELECT name FROM sys.tables WHERE name != 'sysdiagrams' ORDER BY name";
    $stmt3 = sqlsrv_query( $conn, $sql3 );


    while ($row = sqlsrv_fetch_array($stmt3,SQLSRV_FETCH_ASSOC)) {

        $name = $row['name'];

        crearTabla($conexion2,$name);


        $sql4 = "SELECT COLUMN_NAME,DATA_TYPE FROM Information_Schema.Columns WHERE TABLE_NAME='$name'";
        $stmt4 = sqlsrv_query( $conn, $sql4 );
        

        while ($row = sqlsrv_fetch_array($stmt4,SQLSRV_FETCH_ASSOC)) {
            $nombreColumna = $row['COLUMN_NAME'];
            $tipoDato = $row['DATA_TYPE'];
            cambio_datos($conexion2,$nombreColumna,$tipoDato,$name,$conn);
            revisar_llaves_pk_fk($conexion2,$name,$nombreColumna, $conn);
            
        }
        sqlsrv_free_stmt($stmt4);
    }
    sqlsrv_free_stmt($stmt3);



////////////////////////     ORACLE
function crearTabla($conexion2,$name){
    $sql1 = "CREATE TABLE $name (TEMPORAL INT)";
        $stmt1 = oci_parse($conexion2, $sql1);
        $ok1 = oci_execute( $stmt1 );
        oci_free_statement( $stmt1 );
        $msg = "tabla creada";
        return $msg;
        return $ok1;
}




function cambio_datos($conexion2,$nombreColumna,$tipoDato,$name,$conn)
{
    //////////////////        SQL SERVER
    $sql="SELECT CHARACTER_MAXIMUM_LENGTH  FROM Information_Schema.Columns 
    WHERE TABLE_NAME = '$name' AND COLUMN_NAME='$nombreColumna'";
    $stmt = sqlsrv_query( $conn, $sql );
    sqlsrv_execute( $stmt);
    sqlsrv_fetch($stmt);
    $caracter_max = sqlsrv_get_field($stmt,0);
    echo "<br>"."Nombre Col".$nombreColumna;
    echo "<br>"."CARACTER MEXIMO ORACLE".$caracter_max;
    //echo "<br>".$tipoDato;

    switch($tipoDato){
    case 'int':
        ////////////////////////     ORACLE
        $sql="ALTER TABLE $name ADD ($nombreColumna NUMBER(10))";
        $stmt = oci_parse($conexion2, $sql);
        oci_execute( $stmt);
        //echo "se inserto laa col $nombreColumna";
        oci_free_statement( $stmt);
        break;

    case 'varchar':
        ////////////////////////     ORACLE
        $sql="ALTER TABLE $name ADD ($nombreColumna VARCHAR2($caracter_max))";

        $stmt = oci_parse($conexion2, $sql);
        oci_execute( $stmt);
        //echo "se inserto laa col $nombreColumna";
        oci_free_statement( $stmt);
        break;

    case 'money':
        ////////////////////////     ORACLE
        $sql="ALTER TABLE $name ADD ($nombreColumna NUMBER(19,4))";
        $stmt = oci_parse($conexion2, $sql);
        oci_execute( $stmt);
        //echo "se inserto laa col $nombreColumna";
        oci_free_statement( $stmt);
        break;     
        
    case 'datetime':
        ////////////////////////     ORACLE
        $sql="ALTER TABLE $name ADD ($nombreColumna DATE)";
        $stmt = oci_parse($conexion2, $sql);
        oci_execute( $stmt);
        //echo "se inserto laa col $nombreColumna";
        oci_free_statement( $stmt);
        break;    
    default:
        //echo "no se inserto col";
    break;
    }
    sqlsrv_free_stmt($stmt);
}





//Funcion 
function revisar_llaves_pk_fk($conexion2,$name,$nombreColumna, $conn)
{
    //////////////////        SQL SERVER
    // cuenta las llaves primarias 
    $sql="SELECT COUNT(*) 
    FROM sys.indexes AS i
    INNER JOIN sys.index_columns AS ic ON i.OBJECT_ID = ic.OBJECT_ID
    AND i.index_id = ic.index_id and i.is_primary_key = 1 
    WHERE COL_NAME(ic.OBJECT_ID,ic.column_id) = '$nombreColumna' AND OBJECT_NAME(ic.OBJECT_ID) = '$name'";
    $stmt = sqlsrv_query($conn, $sql);
    //sqlsrv_execute( $stmt);
    sqlsrv_fetch( $stmt );
    $conteoPK=sqlsrv_get_field($stmt,0);

    
    //////////////////        SQL SERVER
    // cuenta las llaves foraneas
    $sql2="SELECT COUNT(*) as conteoFK FROM INFORMATION_SCHEMA.CONSTRAINT_COLUMN_USAGE WHERE COLUMN_NAME='$nombreColumna' 
    and CONSTRAINT_NAME like 'fk%' and TABLE_NAME='$name'";
    $stmt2 = sqlsrv_query($conn, $sql2);
    //sqlsrv_execute( $stmt2);
    sqlsrv_fetch( $stmt2 );
    $conteoFK=sqlsrv_get_field($stmt2,0);
    //echo "<br>"."C O N T E O O O O O O O  O: ".$conteoFK;
    //echo "<br>".$nombreColumna;

    //////////////////        SQL SERVER
    // devuelve nombres de llaves pk y fk
    $sql3="SELECT CONSTRAINT_NAME as consulta1 from INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE COLUMN_NAME='$nombreColumna'
    and TABLE_NAME='$name'";
    $stmt3 = sqlsrv_query($conn, $sql3);
    //sqlsrv_execute( $stmt3);
    sqlsrv_fetch($stmt3);
    $consulta1=sqlsrv_get_field($stmt3,0);
    //echo "<br>".$consulta1."CONSULTA 1"; 


    //////////////////        SQL SERVER
    // trae nombre de llaves primarias
    $sql4="SELECT UNIQUE_CONSTRAINT_NAME as consulta2 from INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS WHERE CONSTRAINT_NAME='$consulta1' ";
    $stmt4 = sqlsrv_query($conn, $sql4);
    //sqlsrv_execute( $stmt4);
    sqlsrv_fetch($stmt4);
    $consulta2=sqlsrv_get_field($stmt4,0);
    //echo "<br>".$consulta2."CONSULTA 1";

    //////////////////        SQL SERVER
    // trae nombres de la tabla de donde hace referencia la llave foranea
    $sql5="SELECT TABLE_NAME as consulta5 from INFORMATION_SCHEMA.TABLE_CONSTRAINTS WHERE CONSTRAINT_NAME='$consulta2' 
    and CONSTRAINT_TYPE='PRIMARY KEY'";
    $stmt5 = sqlsrv_query($conn, $sql5);
    //sqlsrv_execute( $stmt5);
    sqlsrv_fetch($stmt5);
    $consulta5 = sqlsrv_get_field($stmt5,0);
    //echo "<br>".$consulta5."CONSULTA 1";

   /// crear llave primaria
    IF($conteoPK=1){
        ////////////////////////     ORACLE
        $sql = "ALTER TABLE $name add primary key ($nombreColumna)";
        //echo "<br>".$name;
        //echo "<br>".$nombreColumna;
        $stmt = oci_parse($conexion2, $sql);
        $ok1 = oci_execute( $stmt );
        oci_free_statement( $stmt );
        return $ok1;   
    }
   
    // crear llave foranea y realizar la relacion entre tablas
    IF($conteoFK=1){
        ////////////////////////     ORACLE
        //echo "<br>"."T A B L A:".$consulta5;
        $sql2 = "ALTER TABLE $name ADD CONSTRAINT $nombreColumna
        FOREIGN KEY( $nombreColumna ) REFERENCES $consulta5";
        $stmt2 = oci_parse($conexion2, $sql2);
        $ok1 = oci_execute( $stmt2 );
        oci_free_statement( $stmt2 );
        return $ok1; 
    }


    sqlsrv_free_stmt( $stmt);
    sqlsrv_free_stmt( $stmt2);
    sqlsrv_free_stmt( $stmt3);
    sqlsrv_free_stmt( $stmt4);
    sqlsrv_free_stmt( $stmt5);


}

?>