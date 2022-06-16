<?php
require_once("../dep/interface.php");
$Session->setDateDeath(date("Y-m-d H:i:s"));
$DaoSessions->update($Session);
setcookie("SessionUID", "", time() - (86400 * 2), "/");
header("Location: /login");
exit();
