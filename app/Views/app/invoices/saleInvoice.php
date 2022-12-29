<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de venta #<?= $id ?></title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap');
        html, body{
            font-family: 'Source Sans Pro', sans-serif !important;
        }
    </style>

</head>
<body>
	<h1 style="text-align:center">Factura</h1>
    <table>
		
		<tr>
			
			<td style="width:150px;">
				<img src="<?=base_url('assets/images/brands/logo_digenca.jpg')?>" width="150px">
            </td>

			<td style="background-color:white; width:210px">
				
				<div style="font-size:12px; text-align:right; line-height:15px;">
					
					<br>
					<strong>RIF:</strong> <?=$businessIdentification?>

					<br>
					<strong>Dirección:</strong> <?=$businessAddress?>

				</div>

			</td>

			<td style="background-color:white; width:140px">

				<div style="font-size:12px; text-align:right; line-height:15px; margin-left: 50px">
					
					<br>
					<strong>Teléfono:</strong> 04121546367
					
					<br>
					

				</div>
				
			</td>

			<td style="background-color:white; width:120px; text-align:right; color:red">Factura<br>#<?= $id ?></td>

		</tr>

	</table>
    <hr>
    <br>

	<table style="font-size:12px; padding:5px 10px;">
	
		<tr>
		
			<td style="background-color:white; width:390px; padding: 5px;">

				<p><strong>Cliente:</strong> <?= $venta[0]->clienteNom?></p>
                <p><strong>Cédula/RIF:</strong> <?= $venta[0]->clienteId?></p>
                <p><strong>Dirección:</strong> <?= $venta[0]->direccion?></p>


			</td>

			<td style="background-color:white; width:150px; text-align:right; padding: 5px;">
			
				<strong>Fecha:</strong> <?= date("d-m-Y", strtotime($venta[0]->creado_en))?><br>
				<strong>Hora:</strong> <?= date("H:i:s", strtotime($venta[0]->creado_en))?>

			</td>

		</tr>
		<tr>
		
			<td style="background-color:white; width:540px; padding: 5px;"> 
                <p><strong>Tasa de cambio:</strong> <?= $venta[0]->tasa?></p>
            </td>

            <td style="background-color:white; width:150px; text-align:right; padding: 5px;">
			
                <p><strong>Vendedor:</strong> <?= $venta[0]->vendedor?></p>

			</td>

		</tr>
	</table>
    <hr>
    <br>
    <table style="font-size:12px; padding:5px 0px;">

		<tr>
			<td style="border-bottom: 1px solid #666; background-color:white; width:50px; text-align:center; padding: 5px">Código</td>
            <td style="border-bottom: 1px solid #666; background-color:white; width:150px; text-align:center; padding: 5px">Descripción</td>
            <td style="border-bottom: 1px solid #666; background-color:white; width:50px; text-align:center; padding: 5px">Cantidad</td>
            <td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:center; padding: 5px">Precio <?=$nationalCoinSymbol?></td>
            <td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:center; padding: 5px">Monto <?=$nationalCoinSymbol?></td>
            <td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:center; padding: 5px">Precio divisa</td>
            <td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:center; padding: 5px">Monto divisa</td>

		</tr>
        
        <?php 
        
        $subtotalNationalCoin = 0;
        $subtotalPrincipalCoin = 0;
        foreach ($venta as $row):

            if($row->idMoneda == $nationalCoin){
                $coinSymbol = $symbol;
            }else{
                $coinSymbol = $row->simbolo;
            }
        ?>
        <tr>
			<td style="border-bottom: 0px solid #666; background-color:white; width:50px; text-align:center; padding: 5px"><?=$row->codigo?></td>
            <td style="border-bottom: 0px solid #666; background-color:white; width:150px; text-align:center; padding: 5px"><?=$row->producto?> <?=$row->ancho_numero?>/<?=$row->alto_numero?> <?=$row->categoria?> Marca <?=$row->marca?></td>
            <td style="border-bottom: 0px solid #666; background-color:white; width:50px; text-align:center; padding: 5px"><?=$row->cantidad?></td>
            <td style="border-bottom: 0px solid #666; background-color:white; width:100px; text-align:center; padding: 5px"><?=$nationalCoinSymbol . " " . number_format($row->precio * $row->tasa, 2)?></td>
            <td style="border-bottom: 0px solid #666; background-color:white; width:100px; text-align:center; padding: 5px">
                <?php
                    $total = ($row->cantidad * $row->precio) * $row->tasa;
                    $subtotalNationalCoin += $total;
                    echo $nationalCoinSymbol . " " . number_format($total, 2);
                ?>
            </td>
            <td style="border-bottom: 0px solid #666; background-color:white; width:100px; text-align:center; padding: 5px"><?=$coinSymbol . " " . number_format($row->precio, 2)?></td>
            <td style="border-bottom: 0px solid #666; background-color:white; width:100px; text-align:center; padding: 5px">
                <?php
                    $total = ($row->cantidad * $row->precio);
                    $subtotalPrincipalCoin += $total;
                    echo $coinSymbol . " " .  number_format($total, 2);
                ?>
            </td>

		</tr>

        <?php endforeach; ?>
		
		<tr>
			<td style="background-color:white; width:25px; text-align:center; padding: 5px"></td>
            <td style="background-color:white; width:150px; text-align:center; padding: 5px"></td>
            <td style="background-color:white; width:50px; text-align:center; padding: 5px"></td>
            <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center; padding: 5px;">Subtotal</td>
            <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center; padding: 5px;"><?= $nationalCoinSymbol . " " . number_format($subtotalNationalCoin, 2)?></td>
            <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center; padding: 5px;">Subtotal</td>
            <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center; padding: 5px;"><?= $coinSymbol . " " . number_format($subtotalPrincipalCoin, 2)?></td>
		</tr>
		<tr>
			<td style="background-color:white; width:25px; text-align:center; padding: 5px"></td>
            <td style="background-color:white; width:150px; text-align:center; padding: 5px"></td>
            <td style="background-color:white; width:50px; text-align:center; padding: 5px"></td>
            <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center; padding: 5px">IVA</td>
            <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center; padding: 5px"><?= $nationalCoinSymbol . " " . number_format(($subtotalNationalCoin * $venta[0]->porcentaje)/100, 2)?></td>
            <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center; padding: 5px">IVA</td>
            <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center; padding: 5px"><?= $coinSymbol . " " . number_format(($subtotalPrincipalCoin * $venta[0]->porcentaje)/100, 2)?></td>
		</tr>
		<tr>
			<td style="background-color:white; width:25px; text-align:center; padding: 5px"></td>
            <td style="background-color:white; width:150px; text-align:center; padding: 5px"></td>
            <td style="background-color:white; width:50px; text-align:center; padding: 5px"></td>
            <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center; padding: 5px">Total</td>
            <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center; padding: 5px"><?= $nationalCoinSymbol . " " . number_format((($subtotalNationalCoin * $venta[0]->porcentaje)/100)+$subtotalNationalCoin, 2)?></td>
            <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center; padding: 5px">Total</td>
            <td style="border: 1px solid #666; background-color:white; width:100px; text-align:center; padding: 5px"><?= $coinSymbol . " " . number_format((($subtotalPrincipalCoin * $venta[0]->porcentaje)/100)+$subtotalPrincipalCoin, 2)?></td>
		</tr>

	</table>

</body>
</html>