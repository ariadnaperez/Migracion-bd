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
        }
        sqlsrv_free_stmt($stmt4);
    }



    sqlsrv_free_stmt($stmt3);
    revisar_llaves_pk($conexion2, $conn);
    revisar_llaves_fk($conexion2, $conn);
    insertar_datos($conexion2,$conn);
    borrar_campo_extra($conexion2, $conn);

    function borrar_campo_extra($conexion2, $conn){
        $sql3 = "SELECT name FROM sys.tables WHERE name != 'sysdiagrams'";
        $stmt3 = sqlsrv_query( $conn, $sql3 );
        while ($row = sqlsrv_fetch_array($stmt3,SQLSRV_FETCH_ASSOC)){
            $name = $row['name'];
            $sql = "ALTER TABLE $name DROP COLUMN TEMPORAL";
            $stmt1 = oci_parse($conexion2, $sql);
            $ok1 = oci_execute( $stmt1 );
            oci_free_statement( $stmt1 );
        }
        sqlsrv_free_stmt( $stmt3);
    }


    function insertar_datos($conexion2,$conn)
    {
        $sql3 = "SELECT name FROM sys.tables WHERE name != 'sysdiagrams'";
        $stmt3 = sqlsrv_query( $conn, $sql3 );
        while ($row = sqlsrv_fetch_array($stmt3,SQLSRV_FETCH_ASSOC)){
            $name = $row['name'];
            echo "tabla actual:".$name;
            //conteo de tipo de dato date
            $sql10 = "SELECT count(*) 
            FROM Information_Schema.Columns WHERE TABLE_NAME='$name'
            and DATA_TYPE like 'date%'";
            $stmt10 = sqlsrv_query($conn, $sql10);
            //sqlsrv_execute( $stmt2);
            sqlsrv_fetch( $stmt10 );
            $conteoDate = sqlsrv_get_field($stmt10,0);

            if($conteoDate > 0){
                //trae nombre columnas que son de tipo date-datetime
                $sql11 = "SELECT stuff((
                    SELECT ', ' + b.column_name
                    FROM Information_Schema.Columns b
                    WHERE b.table_name = a.table_name and b.DATA_TYPE like 'date%'
                    FOR XML PATH('')
                    ), 1, 1, '') Nombres
                    FROM Information_Schema.Columns a
                    where a.TABLE_NAME = '$name' and a.DATA_TYPE like 'date%'
                    GROUP BY a.TABLE_NAME, a.DATA_TYPE 
                    ORDER BY a.TABLE_NAME";
                $stmt11 = sqlsrv_query($conn, $sql11);
                $rowDate = sqlsrv_fetch_array($stmt11,SQLSRV_FETCH_ASSOC);
                $campos1 = implode(",", $rowDate);


                //trae nombre columnas que NO son de tipo date-datetime
                $sql12 = "SELECT stuff((
                    SELECT ', ' + b.column_name
                    FROM Information_Schema.Columns b
                    WHERE b.table_name = a.table_name and b.DATA_TYPE not like 'date%'
                    FOR XML PATH('')
                    ), 1, 1, '') Nombres
                    FROM Information_Schema.Columns a
                    where a.TABLE_NAME = '$name' and a.DATA_TYPE like 'date%'
                    GROUP BY a.TABLE_NAME, a.DATA_TYPE 
                    ORDER BY a.TABLE_NAME";
                $stmt12 = sqlsrv_query($conn, $sql12);
                $rowOtro = sqlsrv_fetch_array($stmt12,SQLSRV_FETCH_ASSOC);
                $campos2 = implode(",", $rowOtro);

                //TRAE LOS DATOS DE TIPO DATE
                $sql13 = "SELECT $campos1 FROM $name";
                $stmt13 = sqlsrv_query($conn, $sql13);
                
                //trae los datos restantes
                $sql14 = "SELECT $campos2 FROM $name";
                $stmt14 = sqlsrv_query($conn, $sql14);
                    

                    //////////// contar los registros
                    $sql16 = "SELECT * from $name";
                    $params1 = array();
                    $options1 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                    $stmt16 = sqlsrv_query($conn, $sql16, $params1, $options1);
                    $row_count1 = sqlsrv_num_rows( $stmt16 );
                    if ($row_count1 === false){
                        echo "Error in retrieveing row count.";
                    }
                   ///////////

                   ///contar el numero de columnas de tipo date
                   $sql15 = "SELECT  column_name from Information_Schema.Columns 
                   where data_type like 'date%' and TABLE_NAME = '$name'";
                   $params = array();
                   $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                   $stmt15 = sqlsrv_query($conn, $sql15, $params, $options);
                   $row_count = sqlsrv_num_rows( $stmt15 );
                   if ($row_count === false){
                       echo "Error in retrieveing row count.";
                   }
                   //////////////////

                    $tmp = 0;
                    echo "ROWCOUNT".$row_count1;

                while ( $tmp < $row_count1){
                    $valores1="";
                    $row1 = sqlsrv_fetch_array($stmt13,SQLSRV_FETCH_NUMERIC); //campos1
                    $row2 = sqlsrv_fetch_array($stmt14,SQLSRV_FETCH_ASSOC);  //campos2

                    for($i=0; $i < $row_count; $i++){
                        $valores1 = $valores1."to_date('".$row1[$i]->format('Y/m/d')."', 'YYYY/MM/DD hh24:mi:ss'),";
                    }

                    $valores1 = trim($valores1, ',');
                    $valores2 = implode("','", $row2);

                   // '12/12/12','12/12/12','12/12/12','a','b','c'
                    $sql1 = "INSERT INTO $name ($campos1,$campos2) VALUES($valores1,'$valores2')";
                    $stmt1 = oci_parse($conexion2, $sql1);
                    $ok1 = oci_execute( $stmt1 );
                    oci_free_statement( $stmt1 );
                    $tmp = $tmp + 1;
                }

                sqlsrv_free_stmt($stmt11);
                sqlsrv_free_stmt($stmt12);
                sqlsrv_free_stmt($stmt13);
                sqlsrv_free_stmt($stmt14);
                sqlsrv_free_stmt($stmt15);
                sqlsrv_free_stmt($stmt16);


            }else{
                $sql4 = "SELECT stuff((
                    SELECT ', ' + b.column_name
                    FROM Information_Schema.Columns b
                    WHERE b.table_name = a.table_name
                    FOR XML PATH('')
                    ), 1, 1, '') Nombres
                    FROM Information_Schema.Columns a
                    where a.TABLE_NAME = '$name'
                    GROUP BY a.TABLE_NAME
                    ORDER BY a.TABLE_NAME";
                $stmt4 = sqlsrv_query( $conn, $sql4 );
                $row = sqlsrv_fetch_array($stmt4,SQLSRV_FETCH_ASSOC);
                    $sql = "SELECT * FROM $name";
                    $stmt= sqlsrv_query($conn, $sql);
                    while ( $row1 = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
                        $fields = implode(",", $row);
                        $values = implode("', '", $row1);
                        //echo "<br>"." F I E L D S : ".$fields;
                        //echo "<br>"." V A L U E S : ".$values;
                        $sql1 = "INSERT INTO $name ($fields) VALUES('$values')";
                        $stmt1 = oci_parse($conexion2, $sql1);
                        $ok1 = oci_execute( $stmt1 );
                        oci_free_statement( $stmt1 );
                    }
                    sqlsrv_free_stmt( $stmt);
                sqlsrv_free_stmt( $stmt4);
            }
            sqlsrv_free_stmt($stmt10);
        }
        sqlsrv_free_stmt($stmt3);
    
}


////////////////////////     ORACLE
//// CREACION DE TABLA
function crearTabla($conexion2,$name){
    $sql1 = "CREATE TABLE $name (TEMPORAL INT)";
        $stmt1 = oci_parse($conexion2, $sql1);
        $ok1 = oci_execute( $stmt1 );
        oci_free_statement( $stmt1 );
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

    switch($tipoDato){
    case 'int':
        ////////////////////////     ORACLE
        $sql="ALTER TABLE $name ADD ($nombreColumna NUMBER(10))";
        $stmt = oci_parse($conexion2, $sql);
        oci_execute( $stmt);
        oci_free_statement( $stmt);
        break;

    case 'varchar':
        ////////////////////////     ORACLE
        $sql="ALTER TABLE $name ADD ($nombreColumna VARCHAR2($caracter_max))";
        $stmt = oci_parse($conexion2, $sql);
        oci_execute( $stmt);
        oci_free_statement( $stmt);
        break;

    case 'money':
        ////////////////////////     ORACLE
        $sql="ALTER TABLE $name ADD ($nombreColumna NUMBER(19,4))";
        $stmt = oci_parse($conexion2, $sql);
        oci_execute( $stmt);
        oci_free_statement( $stmt);
        break;     
        
    case 'datetime':
        ////////////////////////     ORACLE
        $sql="ALTER TABLE $name ADD ($nombreColumna DATE)";
        $stmt = oci_parse($conexion2, $sql);
        oci_execute( $stmt);
        oci_free_statement( $stmt);
        break;    
    default:
        break;
    }
    sqlsrv_free_stmt($stmt);
}


function revisar_llaves_fk($conexion2, $conn){
    $sql3 = "SELECT name FROM sys.tables WHERE name != 'sysdiagrams'";
    $stmt3 = sqlsrv_query( $conn, $sql3 );
    while ($row = sqlsrv_fetch_array($stmt3,SQLSRV_FETCH_ASSOC)){
        $name = $row['name'];
        $sql4 = "SELECT COLUMN_NAME FROM Information_Schema.Columns WHERE TABLE_NAME='$name'";
        $stmt4 = sqlsrv_query( $conn, $sql4 );
        while ($row = sqlsrv_fetch_array($stmt4,SQLSRV_FETCH_ASSOC)){
            $nombreColumna = $row['COLUMN_NAME'];

            //////////////////        SQL SERVER
            // cuenta las llaves foraneas
            $sql2="SELECT count(*)
            FROM sys.foreign_keys FK
            INNER JOIN sys.objects PFK ON PFK.object_id = FK.parent_object_id
            INNER JOIN sys.objects RFK ON RFK.object_id = FK.referenced_object_id
            INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE kcu  ON FK.name = kcu.CONSTRAINT_NAME
            WHERE kcu.COLUMN_NAME = '$nombreColumna' AND PFK.name = '$name'";
            $stmt2 = sqlsrv_query($conn, $sql2);
            //sqlsrv_execute( $stmt2);
            sqlsrv_fetch( $stmt2 );
            $conteoFK=sqlsrv_get_field($stmt2,0);

            ///// nombre de la llave foranea
            $sql6="SELECT fk.name
            FROM sys.foreign_keys FK
            INNER JOIN sys.objects PFK ON PFK.object_id = FK.parent_object_id
            INNER JOIN sys.objects RFK ON RFK.object_id = FK.referenced_object_id
            INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE kcu  ON FK.name = kcu.CONSTRAINT_NAME
            WHERE kcu.COLUMN_NAME = '$nombreColumna' AND PFK.name = '$name'";
            $stmt6 = sqlsrv_query($conn, $sql6);
            //sqlsrv_execute( $stmt2);
            sqlsrv_fetch( $stmt6 );
            $nombreFk=sqlsrv_get_field($stmt6,0);
            $numCarac = strlen($nombreFk);

            if($numCarac > 30){
                $nuevaFk = substr($nombreFk, 0, 29);
            }else{
                $nuevaFk = $nombreFk;
            }

            //////////////////        SQL SERVER
            // trae nombres de la tabla de donde hace referencia la llave foranea
            $sql5="SELECT RFK.name AS referencedTable
            FROM sys.foreign_keys FK
            INNER JOIN sys.objects PFK ON PFK.object_id = FK.parent_object_id
            INNER JOIN sys.objects RFK ON RFK.object_id = FK.referenced_object_id
            INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE kcu  ON FK.name = kcu.CONSTRAINT_NAME
            WHERE kcu.COLUMN_NAME = '$nombreColumna' AND PFK.name = '$name'";
            $stmt5 = sqlsrv_query($conn, $sql5);
            //sqlsrv_execute( $stmt5);
            sqlsrv_fetch($stmt5);
            $consulta5 = sqlsrv_get_field($stmt5,0);
        
            // crear llave foranea y realizar la relacion entre tablas
            IF($conteoFK==1){
                ////////////////////////     ORACLE
                
                $sql2 = "ALTER TABLE $name ADD CONSTRAINT $nuevaFk
                FOREIGN KEY( $nombreColumna ) REFERENCES $consulta5";
                $stmt2 = oci_parse($conexion2, $sql2);
                $ok2 = oci_execute( $stmt2 );
                oci_free_statement( $stmt2 );
            }
            sqlsrv_free_stmt( $stmt2);
            sqlsrv_free_stmt( $stmt6);
            sqlsrv_free_stmt( $stmt5);
        }
        sqlsrv_free_stmt( $stmt4);
    }
    sqlsrv_free_stmt( $stmt3);
}


//Funcion 
function revisar_llaves_pk($conexion2, $conn){
    $sql3 = "SELECT name FROM sys.tables WHERE name != 'sysdiagrams'";
    $stmt3 = sqlsrv_query( $conn, $sql3 );
    while ($row = sqlsrv_fetch_array($stmt3,SQLSRV_FETCH_ASSOC)){
        $name = $row['name'];
        $sql4 = "SELECT COLUMN_NAME FROM Information_Schema.Columns WHERE TABLE_NAME='$name'";
        $stmt4 = sqlsrv_query( $conn, $sql4 );
        while ($row = sqlsrv_fetch_array($stmt4,SQLSRV_FETCH_ASSOC)){
            $nombreColumna = $row['COLUMN_NAME'];

            //////////////////        SQL SERVER
            // cuenta las llaves primarias 
            $sql="SELECT COUNT(*) 
            FROM sys.indexes AS i
            INNER JOIN sys.index_columns AS ic ON i.OBJECT_ID = ic.OBJECT_ID
            WHERE COL_NAME(ic.OBJECT_ID,ic.column_id) = '$nombreColumna' AND OBJECT_NAME(ic.OBJECT_ID) = '$name'
            AND i.index_id = ic.index_id and i.is_primary_key = 1";
            $stmt = sqlsrv_query($conn, $sql);
            //sqlsrv_execute( $stmt);
            sqlsrv_fetch( $stmt );
            $conteoPK=sqlsrv_get_field($stmt,0);

            //// obtener nombre de la llave primaria
            $sql1="SELECT name
            FROM sys.indexes AS i
            INNER JOIN sys.index_columns AS ic ON i.OBJECT_ID = ic.OBJECT_ID
            WHERE COL_NAME(ic.OBJECT_ID,ic.column_id) = '$nombreColumna' AND OBJECT_NAME(ic.OBJECT_ID) = '$name'
            AND i.index_id = ic.index_id and i.is_primary_key = 1";
            $stmt1 = sqlsrv_query($conn, $sql1);
            //sqlsrv_execute( $stmt);
            sqlsrv_fetch( $stmt1 );
            $llavepk=sqlsrv_get_field($stmt1,0);
            $numCaracP = strlen($llavepk);
            echo "<br>".$name;
            if($numCaracP > 30){
                $nuevaPk = substr($llavepk, 0, 29);
            }else{
                $nuevaPk = $llavepk;
            }

            /// crear llave primaria
            IF ($conteoPK==1){
                ////////////////////////     ORACLE
                $sql = "ALTER TABLE $name ADD CONSTRAINT $nuevaPk PRIMARY KEY ($nombreColumna)";
                $stmt = oci_parse($conexion2, $sql);
                $ok1 = oci_execute( $stmt );
                oci_free_statement( $stmt );
            }
            sqlsrv_free_stmt( $stmt);
            sqlsrv_free_stmt( $stmt1);
        }
        sqlsrv_free_stmt( $stmt4);
    }
    sqlsrv_free_stmt( $stmt3);
}


?>