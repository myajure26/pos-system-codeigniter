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
    <table>
		
		<tr>
			
			<td style="width:150px;">
                
                <h2 style="font-size: 20px">Digenca, C.A.</h2>
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
					Teléfono: 04121546367
					
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

				<p><strong>Cliente:</strong>: <?= $venta[0]->clienteNom?></p>
                <p><strong>Cédula/RIF:</strong> <?= $venta[0]->clienteId?></p>

			</td>

			<td style="background-color:white; width:150px; text-align:right; padding: 5px;">
			
				Fecha: <?= $venta[0]->creado_en?></p>

			</td>

		</tr>
		<tr>
		
			<td style="background-color:white; width:540px; padding: 5px;"> 
                <p><strong>Moneda:</strong> <?= $venta[0]->moneda?></p>
                <p><strong>Tasa:</strong> <?= $venta[0]->tasa?></p>
            </td>

            <td style="background-color:white; width:150px; text-align:right; padding: 5px;">
			
                <p><strong>Vendedor:</strong> <?= $venta[0]->vendedor?></p>

			</td>

		</tr>
	</table>
    <hr>
    <br>
    <table style="font-size:12px; padding:5px 10px;">

		<tr>
		
            <td style="border-bottom: 1px solid #666; background-color:white; width:260px; text-align:center; padding: 5px">Descripción</td>
            <td style="border-bottom: 1px solid #666; background-color:white; width:80px; text-align:center; padding: 5px">Cantidad</td>
            <td style="border-bottom: 1px solid #666; background-color:white; width:150px; text-align:center; padding: 5px">Precio unitario</td>
            <td style="border-bottom: 1px solid #666; background-color:white; width:150px; text-align:center; padding: 5px">Total</td>

		</tr>
        
        <?php 
        
        $subtotal = 0;
        foreach ($venta as $row):
        ?>
        <tr>
		
            <td style="border-bottom: 0px solid #666; background-color:white; width:260px; text-align:center; padding: 5px"><?=$row->producto?> <?=$row->ancho_numero?>/<?=$row->alto_numero?> <?=$row->categoria?> Marca <?=$row->marca?></td>
            <td style="border-bottom: 0px solid #666; background-color:white; width:80px; text-align:center; padding: 5px"><?=$row->cantidad?></td>
            <td style="border-bottom: 0px solid #666; background-color:white; width:150px; text-align:center; padding: 5px"><?=number_format($row->precio * $row->tasa, 2)?></td>
            <td style="border-bottom: 0px solid #666; background-color:white; width:150px; text-align:center; padding: 5px">
                <?php
                    $total = ($row->cantidad * $row->precio) * $row->tasa;
                    $subtotal = $subtotal + $total;
                    echo number_format($total, 2);
                ?>
            </td>

		</tr>

        <?php endforeach; ?>

	</table>

    <table style="font-size:12px; padding:5px 10px; margin-left: 70px; margin-top: 30px;">

		
		
		<tr>
		
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:240px; text-align:center; padding: 5px"></td>

			<td style="border: 1px solid #666;  background-color:white; width:150px; text-align:center; padding: 5px">
				<strong>Subtotal</strong>
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:200px; text-align:center; padding: 5px">
                <?= $row->simbolo . ' ' . number_format($subtotal, 2); ?>
			</td>

		</tr>

		<tr>

			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:240px; text-align:center; padding: 5px""></td>

			<td style="border: 1px solid #666; background-color:white; width:150px; text-align:center; padding: 5px"">
				<strong><?=$venta[0]->impuesto?></strong>
			</td>
		
			<td style="border: 1px solid #666; color:#333; background-color:white; width:200px; text-align:center; padding: 5px"">
                <?php 
                    $tax = ($subtotal * $venta[0]->porcentaje)/100;
                    echo $row->simbolo . ' ' . number_format($tax, 2);
					$total = number_format($subtotal + $tax , 2);
                ?>
			</td>

		</tr>

		<tr>
		
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:240px; text-align:center; padding: 5px""></td>

			<td style="border: 1px solid #666; background-color:white; width:150px; text-align:center; padding: 5px"">
				<strong>Total</strong>
			</td>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:200px; text-align:center; padding: 5px"">

                <?= $row->simbolo . ' ' . $total?>
			</td>

		</tr>


	</table>

</body>
</html>