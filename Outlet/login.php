<?php
require_once '../include/common.php';

?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="include/styles.css">
    </head>

    <body>
        <h1>Login to the Ultimate Bubble Tea Store</h1>
        <form method='POST' action='process_login.php'>
            <table align = "left">
                <tr>
                    <td>Username</td>
                    <td>
                        <input name='userid' placeholder ='User ID' value='outlet'/>
                    </td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>
                        <input name='password' type='password' placeholder = 'Password' value = '123' />
                    </td>
                </tr>
                <tr>
                    <td colspan='2'>
                        <input name='Login' type='submit' value='Login'/>
                    </td>
                </tr>
            </table>             
        </form>

        <p>
            <?=printErrors();?>
        </p>
        
    </body>
</html>