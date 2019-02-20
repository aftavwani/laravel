<?php
							//Put your credentials here
//***************************************************************************************************		
	if(!empty($_GET['startdate'])){
		$startdate = $_GET['startdate'];			
	}else{		
		$date	= '';
		$startdate = '1332034771';
	}
	
		$url = 'https://awinfotech.zendesk.com/api/v2/incremental/tickets.json?start_time='. 		$startdate.'';		
		$username = 'wani.aftav23@gmail.com';
		$password = 'aftavlove@123';
//***************************************************************************************************	
		
		
				$ch = curl_init();		
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt( $ch, CURLOPT_USERPWD, $username . ':' . $password );		
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);		
				curl_setopt($ch, CURLOPT_URL,$url);		
				$result=curl_exec($ch);		
				curl_close($ch);
				$final_result = json_decode($result, true);
				
	$filename = "ticket".rand()."csv";
	$fp = fopen('php://output', 'w');
	$header = array('Id','Type','Subject','Description','Time Spent','Priority','Status','Requester Id','User Email','Organization','Created at','Updated at');
	header('Content-type: application/csv');
	header('Content-Disposition: attachment; filename='.$filename);
	fputcsv($fp, $header);
	if(!empty($final_result['tickets'])){
	foreach($final_result['tickets'] as $key){
		if(!empty($key['fields'])){
				foreach($key['fields'] as $custom){
					$data = $custom['value'];
				}
			}
			$url = 'https://awinfotech.zendesk.com/api/v2/users/'.$key["requester_id"].'/identities.json';				
						
				//user email
				$ch = curl_init();				
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt( $ch, CURLOPT_USERPWD, $username . ':' . $password );				
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);			
				curl_setopt($ch, CURLOPT_URL,$url);				
				$result=curl_exec($ch);			
				curl_close($ch);
				$final_results = json_decode($result, true);
				
				//organization
				$url = 'https://awinfotech.zendesk.com/api/v2/users/'.$final_results["identities"][0]['user_id'].'/organizations.json';				
				
				$ch = curl_init();				
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt( $ch, CURLOPT_USERPWD, $username . ':' . $password );				
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);			
				curl_setopt($ch, CURLOPT_URL,$url);				
				$result=curl_exec($ch);			
				curl_close($ch);
				$org = json_decode($result, true);
				
				if(!empty($org['organizations'][0]['name'])){ 
					$orgname =   $org['organizations'][0]['name']; 
				}else{ 
					$orgname = "";
				} 
				
		$delimiter = ",";       
		$lineData = array($key['id'], $key['type'],$key['subject'],$key['description'],$data,$key['priority'],$key['status'],$key['requester_id'], $final_results['identities'][0]['value'],$orgname,$key['created_at'],$key['updated_at']);
		fputcsv($fp, $lineData, $delimiter);
		}
	}
	exit;
?>

