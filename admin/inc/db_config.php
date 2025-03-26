<?php
$hname = 'localhost';
$uname = 'root';
$pass = ''; 
$db = 'hotel';


$con = mysqli_connect($hname, $uname, $pass, $db);
if (!$con) {
    die("Cannot connect to database: " . mysqli_connect_error());
}

function filteration($data) {
    foreach ($data as $key => $value) {
        $value = trim($value); 
        $value = stripslashes($value); 
        $value = strip_tags($value); 
        $value = htmlspecialchars($value); 
        $data[$key] = $value;
    }
    return $data;
}




function selectAll($table) {
    global $con;
    $sql = "SELECT * FROM `$table`"; 
    $res = mysqli_query($con, $sql);
    if (!$res) {
        die("Query failed: " . mysqli_error($con));
    }
    return $res;
}



function select($sql, $values, $datatypes) {
    global $con;
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query execution failed - Select: " . mysqli_error($con));
        }
    } else {
        die("Query preparation failed - Select: " . mysqli_error($con));
    }
}



function update($sql, $values, $datatypes) {
    global $con;

    // Debugging: Print received values
    error_log("SQL: $sql");
    error_log("Values: " . print_r($values, true));
    error_log("Datatypes: $datatypes");

    if ($stmt = mysqli_prepare($con, $sql)) {
        if (count($values) !== strlen($datatypes)) {
            die("Error: Mismatch in placeholders and values!");
        }

        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query execution failed - Update: " . mysqli_error($con));
        }
    } else {
        die("Query preparation failed - Update: " . mysqli_error($con));
    }
}



function insert($sql, $values, $datatypes) {
    global $con;
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query execution failed - Insert: " . mysqli_error($con));
        }
    } else {
        die("Query preparation failed - Insert: " . mysqli_error($con));
    }
}



function delete($sql, $values, $datatypes) {
    global $con;
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query execution failed - Delete: " . mysqli_error($con));
        }
    } else {
        die("Query preparation failed - Delete: " . mysqli_error($con));
    }
}


?>