<!DOCTYPE html>
<html lang="en">
<head>
        <title>Login</title>
        <?php include "konfigurasi/header.php"; ?>
</head>
    <body>
    <div id="login_masuk"> <h1 align='center' style='margin-bottom:20;'> System Informasi Laundry Hotel A </h1>
        <form method="POST" action="proses_login.php">
            <table cellpadding="10" cellspacing="10">
                <tr>
                    <td>Username</td>
                    <td>:</td>
                    <td><input type="text" name="username" value="" /></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>:</td>
                    <td><input type="password" name="password" value="" /></td>
                </tr>
                <tr>
                    <td colspan="3" align="right"><input type="submit" value="Masuk" /></td>
                </tr>
            </table>
        </form>
    </div>
    </body>
</html>