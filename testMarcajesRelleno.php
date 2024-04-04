<!DOCTYPE html>
<html>

<head>
    <?php
    session_start();
    include './Pantalles/HeadGeneric.html';
    include 'autoloader.php';
    $dto = new AdminApiImpl();
    $dto->navResolver();
    ?>
    <script>
    </script>
  
</head>

<body >

<div>
    <?php
    $lng = 0;
    if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
    $idempresa = $_SESSION["idempresa"];
    $d = strtotime("now");
    if(!isset($_GET["any"]))$_GET["any"]=date("Y",$d);
    $any = $_GET["any"];
    if(!isset($_GET["mes"]))$_GET["mes"]=abs(date("m",$d));
    $mes = $_GET["mes"];
    $zmes = "";
    if($mes<10){$zmes="0".$mes;}
    else {$zmes=$mes;}
    if(!isset($_GET["dpt"]))$_GET["dpt"]="Tots";
    $dpt = $_GET["dpt"];
    if(!isset($_GET["rol"]))$_GET["rol"]="Tots";
    $rol = $_GET["rol"];
    $idsubempdef = 0;
    $rssbe = $dto->getDb()->executarConsulta('select idsubempresa from subempresa where idempresa='.$idempresa.' limit 1');
    foreach($rssbe as $se) {$idsubempdef = $se["idsubempresa"];}
    if(!isset($_GET["idsubemp"])){
        if(isset($_SESSION["filtidsubempq"])) $_GET["idsubemp"] = $_SESSION["filtidsubempq"];
        else if(isset($_SESSION["idsubempresa"])) $_GET["idsubemp"] = $_SESSION["idsubempresa"];
        else $_GET["idsubemp"]=$idsubempdef;//"Totes";
    }
    $idsubemp = $_GET["idsubemp"];
    $_SESSION["filtidsubempq"] = $idsubemp;
    $dispnec = "";
    if($idsubemp=="Totes") $dispnec = "display: none";
    if(!isset($_GET["tipusexcep"]))$tipusexcep="Tots";
    else if($_GET["tipusexcep"]!="Tots")$tipusexcep = $dto->mostraNomExcep($_GET["tipusexcep"]);
    else $tipusexcep=$_GET["tipusexcep"];
    $anys = $dto->mostraAnysMarcatges();


    $dto->sendMailApi($idempresa, $lng);
    
    ?>
    
</div>

</body>
</html>
