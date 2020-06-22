<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>前台注册页面</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
    <center><form action="regdo" method="post">
    @csrf
    用户名:<input type="text" name="user_name"><br>
    Email:<input type="text" name="user_email"><br>
    密码:<input type="password" name="password"><br>
    确认密码:<input type="password" name="passwords"><br>
    <input type="submit" value="注册">
    </form></center>
</body>
</html>