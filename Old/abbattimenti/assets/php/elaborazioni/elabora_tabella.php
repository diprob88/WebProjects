

<?php include("../core.php");
$anno=$_GET['anno'];

function convertiData2($dataEur)
{
$rsl = explode ('-',$dataEur);
$rsl = array_reverse($rsl);
return implode($rsl,'/');
}
?>
<table class="table">
<tr>
<th bgcolor='#6495ED'><p class="text-center">Numero Cartella</p></th>
<th bgcolor='#6495ED'><p class="text-center">Unit&agrave; Operativa</p></th>
<th bgcolor='#6495ED'><p class="text-center">Data Calcolo</p></th>
<th bgcolor='#6495ED'><p class="text-center">DRG</p></th>
<th bgcolor='#6495ED'><p class="text-center">Selezione</p></th>
<th bgcolor='#6495ED'><p class="text-center">Valore</p></th>
<th bgcolor='#6495ED'><p class="text-center">Giorni Appropriati</p></th>
<th bgcolor='#6495ED'><p class="text-center">Giorni Non Appropriati</p></th>
<th bgcolor='#6495ED'><p class="text-center">Punteggio Abbattimento</p></th>
<th bgcolor='#6495ED'><p class="text-center">Abbattimento</p></th>
<th bgcolor='#6495ED'><p class="text-center">Rimborso</p></th>           
</tr>			
				<?php	
				$sql="select * from calcolo WHERE anno_calcolo LIKE '$anno' order by numero_cartella ";
				$result = mysql_query($sql);								
				while ($row = mysql_fetch_array($result)) 
				{		
					$numcart = $row["numero_cartella"];
					$codunita = $row["coduo"];
					$sql2="select * from unitaoperativa WHERE coduo LIKE '$codunita'";
					$ris = mysql_query($sql2);
					$row2=mysql_fetch_array($ris);
					$unitadesc=$row2[1];
					$datacal=$row["data_calcolo"];
					$datacal=convertiData2($datacal);
					$drgcalcolo=$row["drg"];
					$selezione=$row["selezione"];
					$valore=$row["valore"];
					$ga=$row["giorni_app"];
					$gna=$row["giorni_non_app"];
					$pa=$row["punteggio_abbattimento"];
					$abb=$row["abbattimento"];
					$rim=$row["rimborso"];
					
					?>					
				<tr>
		
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $numcart;?></p></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $unitadesc;?></p></td>
        <td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $datacal;?></p></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $drgcalcolo;?></p></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $selezione;?></p></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $valore;?></p></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $ga;?></p></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $gna;?></p></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $pa;?></p></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $abb;?></p></td>
		<td bgcolor="<?php echo ($i%2==0?'lightsteelblue':'lavender');?>"><p class="text-center"><?php echo $rim;?></p></td>

        </tr>
		<?php	
		$i++;			
				}
				?>	
			</table>
            <br> <br> 