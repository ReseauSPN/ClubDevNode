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
    </head>
    <body>
        <div class="container">
            <h1>MAJ Ajax Standard</h1>
            <p>PHP - jQuery</p>
        </div>

        <div class="container">
            <table class="table table-bordered table-hover table-striped">
                <tr>
                    <th>Clé</th>
                    <th>Value</th>
                </tr>
                <tbody>
                    <?php foreach ($data->getAll() as $key => $value): ?>
                        <tr>
                            <td><?php echo $key; ?></td>
                            <td><input type="text" name="<?php echo $key; ?>" value="<?php echo $value; ?>" class="updatable"></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="index-node.php">suivante</a>
        </div>
        
        <script>
            $(document).ready(function () {
                $('input.updatable').change(function ()
                {
                    that = $(this);
                    that.parent().append('<img src="assets/loader.gif" class="loader">');
                    $.post(
                            'update.php',
                            { name: that.attr('name'), value: that.val(), user: $('input#name').val() },
                            function (data) { 
                                that.val(data.value); 
                                that.parent().find('img.loader').remove();
                            },
                            "json"
                    );
                });
            });
        </script>
    </body>
</html>
