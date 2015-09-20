<?php
	$incPath = dirname(__FILE__);
	require_once "{$incPath}/../dryadmin/inc/init_api.php";

	// input
	$bCheckSuccess = true;
	
	if((!isset($_REQUEST["Account"]) || $_REQUEST["Account"] == "") ||
	   (!isset($_REQUEST["Token"]) || $_REQUEST["Token"] == "") ||
	   (!isset($_REQUEST["ID"]) || $_REQUEST["ID"] == ""))
	{
		$bCheckSuccess = false;
		$Result = -1;
		$ErrDescription = "参数错误";
	}
	
	// output
	$ApiType = "getAddressDetail";
	
	if($bCheckSuccess)
	{
		$Result = 0;
		$ErrDescription = "获取收货地址成功";
		
		$Account = $_REQUEST["Account"];
		$Token = $_REQUEST["Token"];
		$ID = $_REQUEST["ID"];
		
		if(!$config[DAOIMPL]->memberUserNameIsExist($Account))
		{
			$bCheckSuccess = false;
			$Result = -2;
	        $ErrDescription = '账户不存在！';
		}
		else
		{
		    $member = $config[DAOIMPL]->getMemberByName($Account);
			$address = $config[DAOIMPL]->getAddress($member["id"], $ID);
	
			if(count($address) > 0)
			{
				$ErrDescription = "获取收货地址成功";
				$UserName = $address["UserName"];
				$PhoneNumber = $address["PhoneNumber"];
				$Telephone = $address["Telphone"];
				$p = $config[DAOIMPL]->getProvince($address["Province"]);
				if(count($p) > 0)
				{
					$Province = $p["name"];
					$ProvinceCode = $p["code"];
				}
				else
				{
					$Province = "";
					$CityCode = "";
				}
				$c = $config[DAOIMPL]->getCity($address["City"]);
				if(count($c) > 0)
				{
					$City = $p["name"];
					$CityCode = $c["code"];
				}
				else
				{
					$City = "";
					$CityCode = "";
				}
				$r = $config[DAOIMPL]->getRegion($address["Region"]);
				if(count($c) > 0)
				{
					$Region = $r["name"];
					$RegionCode = $r["code"];
				}
				else
				{
					$Region = "";
					$RegionCode = "";
				}
				
				$AddressDetail = $address["DetailAddress"];
				$PostalCode = $address["PostalCode"];
				$Default = $address["IsDefault"];
			}
			else
			{
				$bCheckSuccess = false;
				$Result = -3;
		        $ErrDescription = '无权访问！';
			}
		}
	}
	
	echo json_encode(array("ApiType"=>$ApiType, "Result"=>$Result, "ErrDescription"=>$ErrDescription, "ID"=>intval($ID), "UserName"=>$UserName, "PhoneNumber"=>$PhoneNumber, "Telephone"=>$Telephone,"Province"=>$Province, "City"=>$City, "Region"=>$Region,"ProvinceCode"=>$ProvinceCode, "CityCode"=>$CityCode, "RegionCode"=>$RegionCode, "AddressDetail"=>$AddressDetail, "PostalCode"=>$PostalCode, "Default"=>$Default));
?>