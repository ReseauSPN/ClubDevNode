<?php
require_once './dataManager.php';
$data = new dataManager();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Notification PHP Node</title>
        <link href="assets/bootstrap.min.css" rel="stylesheet">
        <script src = "assets/jquery.min.js" ></script>
        <script src="http://<?php echo $_SERVER['SERVER_NAME']?>:8080/socket.io/socket.io.js"></script>
    </head>
    <body>
        <div class="container">
            <h1>MAJ Ajax - Notification par Node.js</h1>
            <p>PHP - jQuery - Node.js</p>
        </div>

        <div class="container">
            <p>
                Votre nom : <input type="text" id="user" value="user <?php echo rand(111, 999)?>"/>
                - Nb utilisateurs : <span id="nbuser"></span>
            </p>
            <table class="table table-bordered table-hover table-striped">
                <tr>
                    <th>Clé</th>
                    <th>Value</th>
                    <th>Notification</th>
                </tr>
                <tbody>
                    <?php foreach ($data->getAll() as $key => $value): ?>
                        <tr>
                            <td style="width: 20%"><?php echo $key; ?></td>
                            <td style="width: 20%"><input type="text" name="<?php echo $key; ?>" value="<?php echo $value; ?>" class="updatable"></td>
                            <td style="width: 60%"></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="index-node.php">précédente</a>
        </div>
        
        <script>
            $(document).ready(function () {
                
                
                $('input.updatable').change(function ()
                {
                    that = $(this);
                    that.parent().append('<img src="assets/loader.gif" class="loader">');
                    $.post(
                            'update-node-2.php',
                            { name: that.attr('name'), value: that.val(), user: $('input#user').val() },
                            function (data) { 
                                that.val(data.value); 
                                that.parent().find('img.loader').remove();
                            },
                            "json"
                    );
                });
                
                
                
                
                
                
                
                if (typeof io != "undefined") {
                    var socket = io.connect('http://<?php echo $_SERVER['SERVER_NAME']?>:8080/');
                    
                    socket.on('update', function (data) { 
                        console.log(data);
                        
                        var input = $("input[name=" + data.name + "]");
                        var td_notification=input.parent().next();
                        
                        input.val(data.value);
                        $('span#nbuser').html(data.nbuser);
                        
                        td_notification.append("<span class='notification'>updated by " + data.user + "</span>");
                        
                        setInterval(function () {
                            td_notification.find("span.notification").hide(500, function () {
                                this.remove()
                            })
                        }, 2000);                        
                    });
                    
                    
                    socket.on ('nbuser', function(nb){
                        console.log(nb);
                        $('span#nbuser').html(nb);
                    });
                }
                else {
                    alert("socket.io n'est pas chargé");
                }
            });
        </script>
    </body>
</html>
