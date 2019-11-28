<!DOCTYPE html>
<html lang="en" charset="utf-8">
  
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="<?=PROOT?>css/default.css" />
    <title> <?= $this->siteTitle();?> </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?= $this->content('head'); ?>
  </head>

  <body>
  <?php Helper::currentPage(); ?>

    <?= $this->content('body'); ?>
    <script src="<?=PROOT?>js/default.js"></script>
  </body>

</html>
