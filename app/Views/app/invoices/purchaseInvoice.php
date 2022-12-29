<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden de compra #<?= $id ?></title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap');
        html, body{
            font-family: 'Source Sans Pro', sans-serif !important;
        }
    </style>

</head>
<body>
	<h1 style="text-align:center">Orden de compra</h1>
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

			<td style="background-color:white; width:120px; text-align:right; color:red">Orden<br>#<?= $id ?></td>

		</tr>

	</table>
    <hr>
    <br>

	<table style="font-size:12px; padding:5px 10px;">
	
		<tr>
		
			<td style="background-color:white; width:390px; padding: 5px;">

				<p><strong>Proveedor:</strong> <?= $purchase[0]->proveedor_nombre?></p>
                <p><strong>Cédula/RIF:</strong> <?= $purchase[0]->ci_rif_proveedor?></p>
                <p><strong>Dirección:</strong> <?= $purchase[0]->direccion?></p>


			</td>

			<td style="background-color:white; width:150px; text-align:right; padding: 5px;">
			
				<strong>Fecha:</strong> <?= date("d-m-Y", strtotime($purchase[0]->creado_en))?><br>
				<strong>Hora:</strong> <?= date("H:i:s", strtotime($purchase[0]->creado_en))?><br>
                <strong>Estado:</strong> <span style="color: green"> Aprobado </span> 

			</td>

		</tr>
		<tr>
		
			<td style="background-color:white; width:540px; padding: 5px;"> 
                <p><strong>Moneda:</strong> <?= $purchase[0]->moneda?></p>
            </td>

            <td style="background-color:white; width:150px; text-align:right; padding: 5px;">
			
                <p><strong>Usuario:</strong> <?= $purchase[0]->usuario?></p>

			</td>

		</tr>
	</table>
    <hr>
    <br>
    <table style="font-size:12px; padding:5px 10px;">

		<tr>
			<td style="border-bottom: 1px solid #666; background-color:white; width:50px; text-align:center; padding: 5px">Código</td>
            <td style="border-bottom: 1px solid #666; background-color:white; width:260px; text-align:center; padding: 5px">Descripción</td>
            <td style="border-bottom: 1px solid #666; background-color:white; width:80px; text-align:center; padding: 5px">Cantidad</td>
            <td style="border-bottom: 1px solid #666; background-color:white; width:150px; text-align:center; padding: 5px">Precio unitario</td>
            <td style="border-bottom: 1px solid #666; background-color:white; width:150px; text-align:center; padding: 5px">Total</td>

		</tr>
        
        <?php 
        
        $subtotal = 0;
        foreach ($purchase as $row):
        ?>
        <tr>
			<td style="border-bottom: 0px solid #666; background-color:white; width:50px; text-align:center; padding: 5px"><?=$row->cod_producto?></td>
            <td style="border-bottom: 0px solid #666; background-color:white; width:260px; text-align:center; padding: 5px"><?=$row->nombre?> <?=$row->ancho_numero?>/<?=$row->alto_numero?> <?=$row->categoria?> Marca <?=$row->marca?></td>
            <td style="border-bottom: 0px solid #666; background-color:white; width:80px; text-align:center; padding: 5px"><?=$row->cant_producto?></td>
            <td style="border-bottom: 0px solid #666; background-color:white; width:150px; text-align:center; padding: 5px"><?=number_format($row->precio_producto, 2)?></td>
            <td style="border-bottom: 0px solid #666; background-color:white; width:150px; text-align:center; padding: 5px">
                <?php
                    $total = ($row->cant_producto * $row->precio_producto);
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
				<strong>Total</strong>
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:200px; text-align:center; padding: 5px">
                <?= $row->simbolo . ' ' . number_format($subtotal, 2); ?>
			</td>

		</tr>


	</table>

</body>
</html>