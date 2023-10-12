<?php ALLOW_ACCESS || die("Access Denied");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Luminova Page</title>
</head>
<body>
	<h1>Welcome</h1>
  <form action="<?=$this->_base;?>profile" method="post">
    <input type="text" name="name"/>
    <br/>
    <input type="email" name="email"/>
    <br/>
    <input type="number" name="age"/>
    <br/>
    <button type="submit">Update</button>
    <input type="hidden" name="id" value="1"/>
  </form>
  <a href="<?=$this->_base;?>user/Peter">Profile</a>
</body>
</html>
