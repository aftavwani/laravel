

<?php  
/*   $url = "https://bitpay.com/api/rates";

  $json = file_get_contents($url);
  $data = json_decode($json, TRUE);
	echo "<pre>"; print_R($data[2]['rate']); die;
 echo  $rate = $data[1]["rate"];    die;
  $usd_price = 10;     # Let cost of elephant be 10$
  $bitcoin_price = round( $usd_price / $rate , 8 );
?>

<ul>
   <li>Price: <?=$usd_price ?> $ / <?=$bitcoin_price ?> BTC
</ul> */
?>
<?php

			
			//Put your credentials here
//***************************************************************************************************
	
	$url = 'https://countertopshd.zendesk.com/api/v2/incremental/tickets.json?start_time=1332034771';
	$username = 'wani.aftav23@gmail.com';
	$password = 'Mediaz@123';
//***************************************************************************************************	
	///Curl to fetch data		
	 $ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt( $ch, CURLOPT_USERPWD, $username . ':' . $password );
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,$url);
	$result=curl_exec($ch);
	curl_close($ch);
	$final_result = json_decode($result, true);	 
	print_R($final_result); die;
 ?>
 

<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
</head>
<body>
 <h2 style="text-align: center;">Available Ticket List</h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>PO Number</th>
        <th>Type</th>
        <th>Subject</th>
        <th>Description</th>
        
        <th>Status</th>        
        <th>Requester Name</th>
        <th>User Email</th>
		<th>Phone No</th>  
		<th>Store Name</th>   
		<th>Customer Profile</th>   
		<th>AMG#</th>    
        <th>Created at</th>
        <th>Updated at</th>
        
      </tr>
    </thead>
    <tbody>
    <?php 
	$i=1; $a=1;
	$data = array();
	if(!empty($final_result['tickets'])){
		
		foreach($final_result['tickets'] as $key){ 
		if($key['status'] != 'deleted' ){
			if(!empty($key['fields'])){
			$data = '';
				foreach($key['fields'] as $custom){
					//echo $custom['value']; die('adsas');
					if(!empty($custom['value']) and  $custom['value'] != 'X') {
						$data[$custom['id']] = $custom['value'];
						//print_R($data); 
						}					
					}
				} 
				 $url = 'https://countertopshd.zendesk.com/api/v2/users/'.$key["requester_id"].'.json';				
				
				$ch = curl_init();				
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt( $ch, CURLOPT_USERPWD, $username . ':' . $password );				
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);			
				curl_setopt($ch, CURLOPT_URL,$url);				
				$result=curl_exec($ch);			
				curl_close($ch);
				$final_results = json_decode($result, true);
				?>
				<tr>
				<td><?php if(!empty($data['-774895731'])) { echo $data['-774895731']; } ?></td>
				<td><?php echo  $key['type']; ?></td>
				<td><?php echo  $key['subject']; ?></td>
				<td><?php echo  $key['description']; ?></td>
				
				<td><?php echo  $key['status']; ?></td>			
				<td><?php echo  $final_results['user']['name']; ?></td>
				<td><?php echo  $final_results['user']['email']; ?></td>
				<td><?php  if(!empty($data['-774873490'])) {  echo $data['-774873490']; } ?></td>
				<td><?php  if(!empty($data['-774895711'])) {  echo $data['-774895711']; } ?></td>
				<td><?php  if(!empty($data['-774873510'])) {  echo $data['-774873510']; } ?></td>
				<td><?php  if(!empty($data['-774293110'])) {  echo $data['-774293110']; } ?></td>
				
				<td><?php echo  $key['created_at']; ?></td>
				<td><?php echo  $key['updated_at']; ?></td>				
				</tr>
				
			<?php } 
		}
	}
	
		else{
			
			echo "<tr><td colspan='5'>No Ticket found</td></td>";
			}
		?>
		
			</tbody>
		</table>
	</body>
</html>


