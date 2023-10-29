<?php ALLOW_ACCESS || die("Access Denied");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Page Not Found</title>
</head>
  <body>
    <h1>404 Error Page Not Found</h1>
    <a href="<?=$this->_base;?>">Home</a>
    <p><?=$this->_error_url;?></p>
  </body>
</html>
