<?php
    /* cara mysql 
    * mysql_connect("localhost","user","password");
    * 
    * oracle Way
    * oci_connect("user","password","localhost/XE");
    */

   $username = "laundry";
   $password = "laundry";
   $host     = "localhost/XE";
   
   $koneksi = oci_connect($username,$password,$host);
   if (!$koneksi) {
       
        $e = oci_error();
        trigger_error(htmlentities($e['message'], 
        ENT_QUOTES), E_USER_ERROR);
   }
?>
