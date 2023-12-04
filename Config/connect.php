<?php 
session_start();

$conn = mysqli_connect('localhost', 'mikeuser', '12345678', 'librarie');
if (!$conn)
{
    echo 'Connection error:' . mysqli_connection_error();
}
?>