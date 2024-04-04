<!DOCTYPE html>
<html>
<head>
    <?php include './Pantalles/HeadGeneric.html'; ?>
    <script type="text/javascript">
        function GeneraPDF()
        {
            var doc = new jsPDF('p', 'pt', 'letter');
            doc.fromHTML($('#contingut').html());
            doc.save('Informe.pdf');
        }
    </script>
</head>

<body>
<?php
include 'autoloader.php';
$dto = new AdminApiImpl();
session_start();
$idemp = $_SESSION["idempresa"];
$idempresa = $idemp;
$lng=0;
if(isset($_SESSION["ididioma"])) $lng = $_SESSION["ididioma"];
$dto->navResolver();
$any = intval($_GET['any']);
$mes = intval($_GET['mes']);
$taulaemp = 'empresa';
$idsubemp = $dto->getCampPerIdCampTaula("empleat",$id,"idsubempresa");
if(!empty($idsubemp)) {$idemp = $idsubemp; $taulaemp = 'subempresa';}
$nomemp = $dto->getCampPerIdCampTaula($taulaemp,$idemp,"nom");
$cifemp = $dto->getCampPerIdCampTaula($taulaemp,$idemp,"cif");
$ctremp = $dto->getCampPerIdCampTaula($taulaemp,$idemp,"centre_treball");
$cccemp = $dto->getCampPerIdCampTaula($taulaemp,$idemp,"ccc");
$pobemp = $dto->getCampPerIdCampTaula($taulaemp,$idemp,"poblacio");

$zmes = $mes;
if($mes<10) $zmes = "0".$mes;
$datafi = date('Y-m-d',strtotime($any."-".$zmes."-01"));
while(date('m',strtotime($datafi))==$zmes) {$datafi = date('Y-m-d',strtotime($datafi." + 1 days"));}
$diafi = date('d',strtotime($datafi." - 1 days"));
$chkdec = "";
$chkmin = "";
$dispcomp = "";
$chkhcp = "";

//DATA
$año_atual = intval(date('Y'));
$mes_actual = intval(date('m'));
if ( ($año_atual === $any) && ($mes_actual === $mes) ) $diafi = intval(date('d'));
if($mes<10)$mes = "0".$mes;

$data = $dto->tiempoMarcajeAutoMesTotal($mes, $any, $diafi);

?>
<center>
    <div class="row">
        <div class="col-lg-2">
            <form method="get" action="AdminMarcatgesEmpleat.php">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="any" value="<?php echo $any; ?>">
                <input type="hidden" name="mes" value="<?php echo abs($mes); ?>">
                <input type="hidden" name="setmana" value="<?php echo $setmana; ?>">
                <button type="submit" class="btn btn-default hidden-print" onclick="this.form.submit()">
                    <span class="glyphicon glyphicon-repeat" style="height: 15px; width: 15px"></span> <?php echo $dto->__($lng,"Tornar"); ?></button>
            </form>
            <button class="btn btn-primary" onclick="printElem('resumhores');"><span class="glyphicon glyphicon-print"></span> <?php echo $dto->__($lng,"Imprimir"); ?></button>
            <br><br>

        </div>
        <div class="col-lg-8" id="resumhores" style="border: solid 1px; border-radius: 3px;">
            <?php
            foreach ($data as $table)
            {
                $id =  $table['id'];
                $data_table = $table['data'];
                $total_hours = $table['total_hours'];
            ?>
            <div id="contingut">
                <h3 style="font-weight: bolder; text-align: center"><?php echo $dto->__($lng,"Llistat Resum mensual del registre de jornada (complet)"); ?></h3>
                <div>
                    <section style="width:50%; float:left;">
                        <table class="table table-bordered" style="text-align: left; width: 100%; border-collapse: collapse;">
                            <tbody>
                            <tr>
                                <th style="border: solid 1px"><?php echo $dto->__($lng, "Empresa"); ?>:</th>
                                <td style="border: solid 1px"><?php echo $nomemp; ?></td>
                            </tr>
                            <tr>
                                <th style="border: solid 1px">C.I.F./N.I.F.:</th>
                                <td style="border: solid 1px"><?php echo $cifemp; ?></td>
                            </tr>
                            <tr>
                                <th style="border: solid 1px"><?php echo $dto->__($lng, "Centre de Treball"); ?>:</th>
                                <td style="border: solid 1px"><?php echo $ctremp; ?></td>
                            </tr>
                            <tr>
                                <th style="border: solid 1px">C.C.C.:</th>
                                <td style="border: solid 1px"><?php echo $cccemp; ?></td>
                            </tr>
                            <tr>
                                <th style="border: solid 1px"><?php echo $dto->__($lng, "Poblacio"); ?>:</th>
                                <td style="border: solid 1px"> Ódena </td>
                            </tr>
                            </tbody>
                        </table>
                    </section>
                    <section style="width:50%; float:right;">
                        <table class="table table-bordered" style="text-align: left; width: 100%; border-collapse: collapse;">
                            <tbody>
                            <tr>
                                <th style="border: solid 1px"><?php echo $dto->__($lng, "Treballador"); ?>:</th>
                                <td style="border: solid 1px"><?php echo $dto->mostraNomEmpPerId($id); ?></td>
                            </tr>
                            <tr>
                                <th style="border: solid 1px">N.I.F.:</th>
                                <td style="border: solid 1px"><?php echo $dto->getEmpDni($id); ?></td>
                            </tr>
                            <tr>
                                <th style="border: solid 1px"><?php echo $dto->__($lng, "Nº Afiliació"); ?>:</th>
                                <td style="border: solid 1px"><?php echo $dto->getEmpAfil($id); ?></td>
                            </tr>

                            <tr>
                                <th style="border: solid 1px"><?php echo $dto->__($lng, "Departament"); ?>:</th>
                                <td style="border: solid 1px"><?php echo $dto->mostraNomDptPerIdEmp($id); ?></td>
                            </tr>

                            <tr>
                                <th style="border: solid 1px"><?php echo $dto->__($lng, "Mes i any"); ?>:</th>
                                <td style="border: solid 1px"><?php echo $dto->__($lng, $dto->mostraNomMes($mes)) . " " . $any; ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </section>
                </div>
                <br>
                <table class="table table-bordered" style="text-align: center; font-size: 12px; border-collapse: collapse; width: 100%">
                    <thead>
                    <tr style="background-color: white; color: black">
                        <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"DIA"); ?></th>
                        <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"HORA ENTRADA"); ?></th>
                        <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"HORA SORTIDA"); ?></th>
                        <th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"HORAS TRABAJADAS"); ?></th>
						<th rowspan="2" style="text-align: center; align-content: center; border: solid 1px;"><?php echo $dto->__($lng,"OBSERVACIONES"); ?></th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    foreach ($data_table as $item)
                    {
                        echo '<tr>';
                        echo '<td>'.$item['dayOfMonth'].'</td>';
                        echo '<td>'.$item['start_time'].'</td>';
                        echo '<td>'.$item['end_time'].'</td>';
                        echo '<td>'.$item['work_hours'].'</td>';
						echo '<td>'.$item['observations'].'</td>';
                        echo '</tr>';
                    }
                    ?>
                    <tr></tr><td></td>
                    <td colspan="2"><?php echo $dto->__($lng,"TOTAL"); ?> <?php echo $dto->__($lng,"HORES"); ?></td>
                    <td><?php echo $total_hours; ?></td><td style="display:<?php echo $dispcomp;?>;"></td>
                    </tbody>

                </table><br>
                <section style="width:50%; float:left; height: 100px;"><?php echo $dto->__($lng,"Firma de l'empresa"); ?>:</section>
                <section style="width:50%; float:right; height: 100px;"><?php echo $dto->__($lng,"Firma del treballador"); ?>:</section>
                <br><p style="font-size: 18px;"><?php echo $dto->__($lng,"A "); ?> <?php echo $pobemp;?>, <?php echo $dto->__($lng,"a"); ?> <?php echo $diafi;?> <?php echo $dto->__($lng,"de"); ?> <?php echo $dto->__($lng,$dto->mostraNomMes($mes));?> <?php echo $dto->__($lng,"de"); ?> <?php echo $any;?></p>
            </div>
            <br>
            <br>
            <p style="font-size: 9px; text-align: left">
                Resum mensual de la jornada del treballador a temps complert en compliment de l'obligació establerta en l'article 35.5) del Text Refós de la Llei de l'Estatut dels Treballadors modificat pel Reial Decret Llei 2/2015 de 23 d'Octubre
            </p>
            <div id="editor"></div>
            <?php
            }
            ?>
        </div>
        <br><br>
    </div>

</center>
</body>
</html>
