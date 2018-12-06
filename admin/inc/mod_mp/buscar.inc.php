 <?php
require_once "../pagos/includes/mercadopago.php";

$mp = new MP("7983482666444983", "NlnHgQqmKRYJIY4tfy0fDcGsNrMe7Flw");

// Sets the filters you want
$filters = array("site_id" => "MLA");

// Search payment data according to filters
$searchResult = $mp -> search_payment($filters);

// Show payment information
        ?>
        <div class="col-lg-12">
	<table class="table  table-bordered table-striped text-center">
        	
            <thead><th class="text-center">ID</th><th class="text-center">CREADO</th><th class="text-center">NOMBRE Y APELLIDO</th><th class="text-center">MONTO ORIGINAL</th><th class="text-center">MONTO ACREDITADO</th><th class="text-center">DETALLE</th><th class="text-center">ESTADO</th><th class="text-center">LISTO?</th><th class="text-center">A DEPOSITAR</th></thead>
            <tbody>
            <?php
            foreach (array_reverse($searchResult["response"]["results"]) as $payment) {
            	switch($payment["collection"]["status"]) {            	
					case "approved":
						$estadoPago = '<span class="ESTADOPAGOS">APROVADO</span>';	
						break;
					case "in_process":
						$estadoPago = '<span class="ESTADOPAGOS" style="background:#2980b9">Proceso</span>';
						break;	
					case "rejected":
						$estadoPago = '<span class="ESTADOPAGOS" style="background:#c0392b">rechazado</span>';
						break;
					case "cancelled":
						$estadoPago = '<span class="ESTADOPAGOS" style="background:#c0392b">cancelado</span>';
						break;
					case "refunded":
						$estadoPago = '<span class="ESTADOPAGOS" style="background:#95a5a6">reintegro</span>';
						break;
					case "in_mediation":
						$estadoPago = '<span class="ESTADOPAGOS" style="background:#e74c3c">en mediación</span>';
						break;
            	} 
				
				switch($payment["collection"]["payment_type"]) {            	
					case "account_money":
						$tipoPago = "mercadopago";	
						break;
					case "credit_card":
						$tipoPago = "crÉdito";
						break;	
					case "debit_card":
						$tipoPago = "dÉbito";
						break;
					case "ticket":
						$tipoPago = "ticket";
						break;
					case "bank_transfer":
						$tipoPago = "transferencia";
						break;					
            	} 
				
				switch($payment["collection"]["released"]) {
					case "yes":
						$sacar = '<span class="ESTADOPAGOS">SI</span>';
						break;
					case "no":
						$sacar = '<span class="ESTADOPAGOS" style="background:#e74c3c">NO</span>';
						break;	
						
						
				}
				
				$acreditacion = explode("T",$payment["collection"]["money_release_date"]);
				$fechaAcreditacion = explode("-",$acreditacion[0]);
				
				
				$fecha = explode("T",$payment["collection"]["date_created"]);
				$fechaCreacion = explode("-",$fecha[0]);
				
				
                ?>
                
                <tr>
                    <td><?php echo $payment["collection"]["id"]; ?></td>
                    <td><?php echo $fechaCreacion[2]."/".$fechaCreacion[1]."/".$fechaCreacion[0] ?></td>
                    <td><?php echo strtoupper($payment["collection"]["payer"]["first_name"] . "  " . $payment["collection"]["payer"]["last_name"]); ?></td>
                    <td><?php echo "$ " . $payment["collection"]["total_paid_amount"]; ?></td>
                    <td><?php echo "$ " . $payment["collection"]["net_received_amount"] ?></td>
                    
                    <td><span class="ESTADOPAGOS" style="background:#34495e"><?php echo strtoupper($tipoPago) ?></td>                    
                    <td><?php echo $estadoPago ?> </td>
                    <td><?php echo $sacar ?></td>
                    <td><?php echo $fechaAcreditacion[2]."/".$fechaAcreditacion[1]."/".$fechaAcreditacion[0] ?> </td>
                </tr>
                
                <?php
				}
            ?>
            </tbody>
            
        </table>
        </div>