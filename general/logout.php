<?php
session_start();
unset($_SESSION['usuario']); 
unset($_SESSION['username']); 
unset($_SESSION['password']);
//unset($_SESSION['username']);
unset($_SESSION['contrasena']);
unset($_SESSION['organizacion']); 
unset($_SESSION['provincia']); 

header('Location: //apps.ieps.gob.ec/redireccion/getToken.php?app=TH');?>