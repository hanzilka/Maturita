<?php

class html {

public static function head()
{
?>
<!-- ?xml version="1.0" encoding="utf-8"? -->
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
  <title>Ukázková aplikace SSO</title>
</head>
<body>
<h1>Ukázková aplikace SSO</h1>
<p>
<a href='?'>Index</a> | <a href='?page=userinfo'>Informace o uživateli</a>
</p>

<?php
}


public static function foot()
{
?>
</body>
</html>
<?php
}

}

?>