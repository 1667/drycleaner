<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	$bCheckSuccess = true;
	if(!isset($_REQUEST["Account"]) ||
	   !isset($_REQUEST["Token"]) ||
       !isset($_REQUEST["ID"]) ||
	   !isset($_REQUEST["UserName"]) ||
	   !isset($_REQUEST["MobileNumber"]) ||
	   !isset($_REQUEST["Telphone"]) ||
	   !isset($_REQUEST["ProvinceCode"]) ||
	   !isset($_REQUEST["CityCode"]) ||
	   !isset($_REQUEST["RegionCode"]) ||
	   !isset($_REQUEST["DetailAddress"]) ||
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

	$ApiType = "updateAddress";

	if($bCheckSuccess)
	{
		$Account = $_REQUEST["Account"];
		$Token = $_REQUEST["Token"];
		$ID = $_REQUEST["ID"];
		$UserName = $_REQUEST["UserName"];
		$PhoneNumber = $_REQUEST["MobileNumber"];
		$Telphone = $_REQUEST["Telphone"];
		$ProvinceCode = $_REQUEST["ProvinceCode"];
		$CityCode = $_REQUEST["CityCode"];
		$RegionCode = $_REQUEST["RegionCode"];
		$DetailAddress = $_REQUEST["DetailAddress"];
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
			if(count($config[DAOIMPL]->getAddress($member["id"], $ID)) > 0)
			{
				$config[DAOIMPL]->updateAddress($member["id"], $ID, array("UserName"=>$UserName, "PhoneNumber"=>$PhoneNumber, "Telphone"=>$Telphone, "Province"=>$ProvinceCode, "City"=>$CityCode, "Region"=>$RegionCode, "DetailAddress"=>$DetailAddress, "PostalCode"=>$PostalCode, "IsDefault"=>$IsDefault, "PreTel"=>$PreTel, "Tel"=>$Tel, "LaterTel"=>$LaterTel));
				
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
				$ErrDescription = "更新收货地址成功";
			}
			else
			{
				$Result = -3;
				$ErrDescription = "此收货地址不属于该用户";
			}
		}
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "ID"=>$ID));
?>