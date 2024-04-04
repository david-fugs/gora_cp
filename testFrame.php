<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Visor de Informe de Marcaje</title>
</head>

<style>
    
</style>

<body>
<?php
$any_actual = intval($_GET['any']);
$mes_actual = intval($_GET['mes']);
$id = intval($_GET['id']);
?>
<div style="display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;">
<iframe id="iframe" width="900px"  height="100%"  frameborder="0" scrolling="no" src="EmpleatInformValidaMarcatge.php?setmana=Todas&id=<?php echo urlencode($id); ?>&any=<?php echo urlencode($any_actual); ?>&mes=<?php echo urlencode($mes_actual); ?>" width="100%" height="600px" frameborder="0"></iframe>

</div>

</body>
</html>