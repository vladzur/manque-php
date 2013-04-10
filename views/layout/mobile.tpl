<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>  
  <meta content="text/html; charset=UTF-8" http-equiv="content-type">
  <link rel="icon" href="/img/favicon.ico" type="image/x-icon">
  <title>TyniMVC</title>  
  <?php echo $html->css('mobile');?>
</head>
<body>
<div class="contenedor">
<div class="headder">
<img style="width: 252px; height: 100px;" alt="Todazu" src="/img/logo.png">
</div>
<div class="menu">
<?php $element->get('menu');?>
</div>
<div class="cuerpo">
<?php echo $content_here; ?>
</div>
<div class="footer">
<p>TyniMVC &copy;2010 (Mobile)<br/>By Vladimir Zurita M</p>
</div>
</div>
</body>
</html>
