<!DOCTYPE html>
<html lang="en" charset="utf-8">
  
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> <?= $this->siteTitle();?> </title>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">    
    <link rel="stylesheet" href="<?=PROOT?>css/theme1.css" />
    <?= $this->content('head'); ?>
  </head>

  <body>
    <div class="global-container">
      <?php include('global_header.php'); ?>
      <div class="main-container">
        <?= $this->content('body'); ?>
      </div>    
      <?php include('global_footer.php'); ?>    
    </div>
    <script src="<?=PROOT?>js/global.js"></script>
    <?= $this->content('script'); ?>
  </body>

</html>
