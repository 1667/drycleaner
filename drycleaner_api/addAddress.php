<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;
	if(!isset($_REQUEST["Account"]) ||
	   !isset($_REQUEST["Token"]) ||
	   !isset($_REQUEST["UserName"]) ||
	   !isset($_REQUEST["MobileNumber"]) ||
	   !isset($_REQUEST["Telphone"]) ||
	   !isset($_REQUEST["ProvinceCode"]) ||
	   !isset($_REQUEST["CityCode"]) ||
	   !isset($_REQUEST["RegionCode"]) ||
	   !isset($_REQUEST["AddressDetail"]) ||
	   !isset($_REQUEST["PostalCode"]) ||
	   !isset($_REQUEST["Default"]) ||
	   !isset($_REQUEST["PreTel"]) ||
	   !isset($_REQUEST["Tel"]) ||
	   !isset($_REQUEST["LaterTel"]))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}

	$ApiType = "addAddress";

	if($bCheckSuccess)
	{
		$Account = $_REQUEST["Account"];
		$Token = $_REQUEST["Token"];
		$UserName = $_REQUEST["UserName"];
		$PhoneNumber = $_REQUEST["MobileNumber"];
		$Telphone = $_REQUEST["Telphone"];
		$ProvinceCode = $_REQUEST["ProvinceCode"];
		$CityCode = $_REQUEST["CityCode"];
		$RegionCode = $_REQUEST["RegionCode"];
		$DetailAddress = $_REQUEST["AddressDetail"];
		$PostalCode = $_REQUEST["PostalCode"];
		$IsDefault = intval($_REQUEST["Default"]);
		$PreTel = $_REQUEST["PreTel"];
		$Tel = $_REQUEST["Tel"];
		$LaterTel = $_REQUEST["LaterTel"];
	
		$member = $config[DAOIMPL]->getMemberByName($Account);
		if(count($member) <= 0)
		{
			$Result = -2;
			$ErrDescription = "用户不存在";
		}
		else
		{
			$config[DAOIMPL]->addAddress(array("UserID"=>$member["id"],"UserName"=>$UserName, "PhoneNumber"=>$PhoneNumber, "Telphone"=>$Telphone, "Province"=>$ProvinceCode, "City"=>$CityCode, "Region"=>$RegionCode, "DetailAddress"=>$DetailAddress, "PostalCode"=>$PostalCode, "IsDefault"=>$IsDefault, "PreTel"=>$PreTel, "Tel"=>$Tel, "LaterTel"=>$LaterTel));
			
			$ID = $config[DAOIMPL]->getLastID("delivery_addresses");
			
			if($IsDefault != 0)
			{
				$address_count = $config[DAOIMPL]->getAddressCount($member["id"], 1, -1);
				$address_rs = $config[DAOIMPL]->getAddresses($member["id"], 1, -1);
				for($i = 0 ; $i < $address_count ; $i++)
				{
					$address_arr = mysql_fetch_array($address_rs);
					if($address_arr["id"] != $ID)
					{
						$config[DAOIMPL]->updateAddress($member["id"], $address_arr["id"], array("IsDefault"=>0));
					}
				}
			}
			
			$Result = 0;
			$ErrDescription = "添加收货地址成功";
		}
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "ID"=>$ID));
?>