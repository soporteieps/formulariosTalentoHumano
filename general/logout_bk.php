<?php
session_start();
unset($_SESSION['usuario']); 
unset($_SESSION['username']); 
unset($_SESSION['password']);
//unset($_SESSION['username']);
unset($_SESSION['contrasena']);
unset($_SESSION['organizacion']); 
unset($_SESSION['provincia']); 
header('Location: ../index.php?token=dqq3d23i3p5f243f43f');
?>