<?php

if(!function_exists('sqlValue')){
    include("lib.php");
} 

function getCurrentCompany(){
    		static $company_info = array();

		if(!$memberID){
			$memberID = getLoggedMemberID();
		}

		$ci = array();//company info

		if($memberID){
			$res = sql("select * from multyCompany where current='true'", $eo);
			if($row = db_fetch_assoc($res)){
				$ci = array(
					'companyID'      => $row['id'],
					'companyId'      => $row['idCompany'],
					'companyname'    => $row['CompanyName'],
					'companyaddress' => array(
						$row['address'], 
						$row['address2'], 
						$row['postalCode'], 
						$row['town'],
						$row['district'], 
						$row['vatNumber'] 
					),
					'companyemail'   => $row['email'],
					'pec'            => $row['pec'],
					'notes'          => $row['notes'],
				);

				// cache results
				$company_info[] = $ci;
			}
		}

		return $ci;
}

