<?php
$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe'); //workspace name, admin-paassword ,last ko samee


if(!$conn)
{
   echo"Not Connected to oracle";
}

else
{
   echo"Connected to oracle";
} 
oci_close($conn); 
?>
   