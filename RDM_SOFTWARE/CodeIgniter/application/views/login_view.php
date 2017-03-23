<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Simple Login with CodeIgniter</title>
        <link id="base-style" href="<?= base_url() ?>public/css/style.css" rel="stylesheet">
        <link id="base-style" href="<?= base_url() ?>public/css/style2.css" rel="stylesheet">
    </head>
    <body>
       
       
        
        <table id="divalign" class="form-2">
            <td>   
            <?php 
            
            $attributes = array('class' => 'form-2');
            
            echo form_open('verifylogin'); 
            
            ?>
            </td></tr>
        
           <td> <h1>Login</h1></td></tr><tr>
         
            <td><label for="username">Username:</label></td></tr><tr>
                <td><input type="text" size="20" id="username" name="username"/></td></tr><tr>

                <td> <label for="password">Password:</label></td></tr><tr>
                <td><input type="password" size="20" id="passowrd" name="password"/></td></tr><tr>

                <td> <input id="loginE" type="submit" value="Login"/></td>
                </tr><tr>
                <td> <?php echo validation_errors(); ?></td>    
                </form>
        </table>
        
        
        
        
    </body>
</html>