<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=PROOT?>css/admin.css">
    <?=$this->content('head');?>
    <title>
        <?=$this->siteTitle();?>
    </title>
</head>

<body>
    <div class="topnav" id="myTopnav">
        <div class="float-right">
            <a href="<?=PROOT?>admin">Home</a>
            <a href="<?=PROOT?>admin/user">Users</a>
            <a href="<?=PROOT?>admin/role">Roles</a>
            <a href="<?=PROOT?>user/logout">Logout</a>
            <a href="javascript:void(0);" class="icon" onclick="toggleResp()">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    </div>
    <div class="global-container">
        <?=$this->content('body');?>
    </div>
    <script src="<?=PROOT?>js/admin.js"></script>
    <script>
        function toggleResp() {
            var x = document.getElementById("myTopnav");
            if (x.className === "topnav") {
                x.className += " responsive";
            } else {
                x.className = "topnav";
            }
        }
    </script>
</body>

</html>