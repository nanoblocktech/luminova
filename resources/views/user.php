<?php ALLOW_ACCESS or die("Access Denied"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Luminova User</title>
</head>
<body>
	<h1>Welcome {<?php echo $this->name;?>}</h1>
    <a href="<?php echo $this->base;?>">Home</a>
</body>
</html>
