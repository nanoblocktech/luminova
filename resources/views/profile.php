<?php ALLOW_ACCESS || die("Access Denied"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Luminova User</title>
</head>
<body>
	<h1>Welcome {<?=$this->_userInfo->name;?>}</h1>
    <a href="<?=$this->_base;?>">Home</a>
</body>
</html>
