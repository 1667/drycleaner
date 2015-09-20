<?php
/*
 * dao implements
 * include logger,
 * by lane @2010-10-03
*/

class DAOImpl {
    private static $impl; //can not be extends
    private $tablepre;

    protected function __construct($link, $tablepre) {
        $this->wrapper = DAOWrapper::getWrapper($link);
        $this->tablepre = $tablepre;
    }

    function __clone() {
        return self::$impl;
    }

    function __toString() {
        return "DAO implements.";
    }

    public function setTablePre($tablepre) {
        $this->tablepre = $tablepre;
    }

    public function getTablePre() {
        return $this->tablepre;
    }

    public static function getImpl($link, $tablepre) {
        if (empty(self::$impl)) {
            self::$impl = new DAOImpl($link, $tablepre);
        }
        return self::$impl;
    }

    //----------------------user of admin-------------------------
    function getUserByName($username)
    {
        $table = $this->tablepre . 'user';
        $fields = '*';
        $condition = "username='{$username}'";
        $order = '';
        $limit = '1';
        return $this->wrapper->select($table, $fields, $condition, $order, $limit);
    }

    function getUserById($uid)
    {
        $table = $this->tablepre . 'user';
        $fields = '*';
        $condition = "uid='{$uid}'";
        $order = '';
        $limit = '1';
        return $this->wrapper->select($table, $fields, $condition, $order, $limit);
    }

    function addUser($arrUser)
    {
        $table = $this->tablepre . 'user';
        return $this->wrapper->insert($table, $arrUser);
    }

    function deleteUserByUid($uid)
    {
        $table = $this->tablepre . 'user';
        $condition = "uid='{$uid}'";
        return $this->wrapper->del($table, $condition);
    }

    function getUsers($limit = 10)
    {
        $table = $this->tablepre . 'user';
        $fields = 'uid,username';
        $condition = '';
        $order = '';
        return $this->wrapper->select($table, $fields, $condition, $order, $limit);
    }
    //-----------------------------------------------------------

    //----------------------others-------------------------
	function getServiceTypeCount()
	{
		$table = 'service_types';
		$fields = 'count(*)';
		$condition = '';
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getServiceTypeCountEx($parentServiceTypeID)
	{
		$table = 'service_types';
		$fields = 'count(*)';
		if($parentServiceTypeID <= 0)
		{
			$condition = 'ParentID <= 0';
		}
		else
		{
			$condition = 'ParentID = ' . $parentServiceTypeID;
		}
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getServiceTypes($page = 1, $number_per_page = 10)
	{
		$table = 'service_types';
		$fields = '*';
		$condition = '';
		$order = '';
		$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getServiceTypesEx($page = 1, $number_per_page = 10, $parentServiceTypeID = -1)
	{
		$table = 'service_types';
		$fields = '*';
		if($parentServiceTypeID <= 0)
		{
			$condition = 'ParentID <= 0';
		}
		else
		{
			$condition = 'ParentID = ' . $parentServiceTypeID;
		}
		$order = '';
		if($number_per_page < 0)
		{
			$limit = '';
		}
		else
		{
			$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		}
		
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getServiceType($typeid)
	{
		$table = 'service_types';
		$fields = '*';
		$condition = 'id = ' . $typeid;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addServiceType($arrServiceType)
    {
        $table = 'service_types';
        return $this->wrapper->insert($table, $arrServiceType);
    }
	
	function updateServiceType($typeId, $values)
	{
		$table = 'service_types';
		$condition = 'id=' . $typeId;
		$limit = '';
		
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteServiceType($typeId)
	{
        $table = 'service_types';
		$condition = 'id=' . $typeId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getTopServiceTypes()
	{
		$table = 'service_types';
		$fields = '*';
		$condition = 'ParentID = 0';
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		$arr = array();
		
		for($i = 0 ; $i < mysql_num_rows($rs) ; $i++)
		{
			$row = mysql_fetch_array($rs);
			$arr = array_merge($arr,array(count($arr)=>array("id"=>$row["id"], "ParentID"=>$row["ParentID"], "typeName"=>$row["TypeName"])));
		}
		
		return $arr;
	}
	
	function getSubServiceTypes($ParentID)
	{
		$table = 'service_types';
		$fields = '*';
		$condition = 'ParentID = ' . $ParentID;
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		$arr = array();
		
		for($i = 0 ; $i < mysql_num_rows($rs) ; $i++)
		{
			$row = mysql_fetch_array($rs);
			$arr = array_merge($arr,array(count($arr)=>array("id"=>$row["id"], "ParentID"=>$row["ParentID"], "typeName"=>$row["TypeName"])));
		}
		
		return $arr;
	}
	
	function getServiceTypeNames()
	{
		$table = 'service_types';
		$fields = 'id,ParentID,TypeName';
		$condition = '';
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		$arr = array();
		
		for($i = 0 ; $i < mysql_num_rows($rs) ; $i++)
		{
			$row = mysql_fetch_array($rs);
			$arr = array_merge($arr,array(count($arr)=>array("id"=>$row["id"], "ParentID"=>$row["ParentID"], "typeName"=>$row["TypeName"])));
		}
		
		return $arr;
	}
	
	function getGoodsCount()
	{
		$table = 'clothing_goodss';
		$fields = 'count(*)';
		$condition = '';
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getGoodsCountEx($TypeID = 0, $MaterialQuality = 0x3F, $Style = 0x3F)
	{
		$table = 'clothing_goodss';
		$fields = 'count(*)';
		$condition = '((MaterialQuality & ' . $MaterialQuality . ') != 0 or (MaterialQuality = 0)) and ((Style & ' . $Style . ') != 0 or (Style = 0))';
		$order = '';
		$limit = '';
		
		if($TypeID > 0)
		{
			$rs = $this->wrapper->select("service_types", "ParentID", "id = " . $TypeID, "", "");
			
			if(mysql_num_rows($rs) > 0)
			{
				$row = mysql_fetch_row($rs);
				if($row[0] > 0)
				{
					$condition = $condition . " and ServiceTypeID = " . $TypeID;
				}
				else
				{
					$rs = $this->wrapper->select("service_types", "id", "ParentID = " . $TypeID, "", "");
					if(mysql_num_rows($rs) > 0)
					{
						$condition = $condition . " and (";
							
						for($i = 0 ; $i < mysql_num_rows($rs) ; $i++)
						{
							if($i != 0)
							{
								$condition = $condition . " or ";
							}
							$row = mysql_fetch_row($rs);
							$condition = $condition . "ServiceTypeID = " . $row[0];
						}
						
						$condition = $condition . ")";
					}
					else
					{
						return 0;
					}
				}
			}
			else
			{
				return 0;
			}
		}
		
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function goodsIsExist($goodsId)
	{
		$table = 'clothing_goodss';
		$fields = 'count(*)';
		$condition = 'ID=' . $goodsId;
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return ($row[0] != 0);
	}
	
	function getGoodss($page = 1, $number_per_page = 10)
	{
		$table = 'clothing_goodss';
		$fields = '*';
		$condition = '';
		$order = '';
		if($number_per_page < 0)
		{
			$limit = '';
		}
		else
		{
			$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		}
		
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getGoodssEx($page = 1, $number_per_page = 10, $TypeID = 0, $MaterialQuality = 0x3F, $Style = 0x3F)
	{
		$table = 'clothing_goodss';
		$fields = '*';
		$condition = '((MaterialQuality & ' . $MaterialQuality . ') != 0 or (MaterialQuality = 0)) and ((Style & ' . $Style . ') != 0 or (Style = 0))';
		$order = '';
		if($number_per_page < 0)
		{
			$limit = '';
		}
		else
		{
			$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		}
		
		if($TypeID > 0)
		{
			$rs = $this->wrapper->select("service_types", "ParentID", "id = " . $TypeID, "", "");
			if(mysql_num_rows($rs) > 0)
			{
				$row = mysql_fetch_row($rs);
				if($row[0] > 0)
				{
					$condition = $condition . " and ServiceTypeID = " . $TypeID;	
				}
				else
				{
					$rs = $this->wrapper->select("service_types", "id", "ParentID = " . $TypeID, "", "");
					if(mysql_num_rows($rs) > 0)
					{
						$condition = $condition . " and (";
							
						for($i = 0 ; $i < mysql_num_rows($rs) ; $i++)
						{
							if($i != 0)
							{
								$condition = $condition . " or ";
							}
							$row = mysql_fetch_row($rs);
							$condition = $condition . "ServiceTypeID = " . $row[0];
						}
						
						$condition = $condition . ")";
					}
					else
					{
						return array();
					}
				}
			}
			else
			{
				return array();
			}
		}
		
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getGoods($goodsId)
	{
		$table = 'clothing_goodss';
		$fields = '*';
		$condition = 'ID = ' . $goodsId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addGoods($arrGoods)
    {
        $table = 'clothing_goodss';
        return $this->wrapper->insert($table, $arrGoods);
    }
	
	function updateGoods($goodsId, $values)
	{
		$table = 'clothing_goodss';
		$condition = 'ID=' . $goodsId;
		$limit = '';
		
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteGoods($goodsId)
	{
        $table = 'clothing_goodss';
		$condition = 'ID=' . $goodsId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getGoodsNames()
	{
		$table = 'clothing_goodss';
		$fields = 'ID,GoodsName';
		$condition = '';
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		$arr = array();
		
		for($i = 0 ; $i < mysql_num_rows($rs) ; $i++)
		{
			$row = mysql_fetch_array($rs);
			$arr = array_merge($arr,array(count($arr)=>array("id"=>$row["ID"], "goodsName"=>$row["GoodsName"])));
		}
		
		return $arr;
	}
	
	function getOrderCount($status = 0x01FF, $userId = -1)
	{
		$table = 'orders';
		$fields = 'count(*)';
		
		$condition = '';
		$status_1 = 0x0001;
		$condition = '(';
		for($i = 0 ; $i < 9 ; $i++)
		{
			$status_1 << $i;
			if($status & ($status_1 << $i))
			{
				if($condition != '(')
				{
					$condition = $condition . " or ";
				}
				$condition = $condition . 'Status = ' . ($status_1 << $i);
			}
		}
		$condition = $condition . ')';
		if($userId > 0)
		{
			$condition = $condition . " and UserID = " . $userId;
		}
		
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getOrders($status = 0x01FF, $page = 1, $number_per_page = 10, $userId = -1)
	{
		$table = 'orders';
		$fields = '*';
		$condition = '';
		$status_1 = 0x0001;
		$condition = '(';
		for($i = 0 ; $i < 9 ; $i++)
		{
			$status_1 << $i;
			if($status & ($status_1 << $i))
			{
				if($condition != '(')
				{
					$condition = $condition . " or ";
				}
				$condition = $condition . 'Status = ' . ($status_1 << $i);
			}
		}
		$condition = $condition . ')';
		if($userId > 0)
		{
			$condition = $condition . " and UserID = " . $userId;
		}
		
		$order = '';
		if($number_per_page < 0)
		{
			$limit = '';
		}
		else
		{
			$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		}
		
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getOrder($orderId)
	{
		$table = 'orders';
		$fields = '*';
		$condition = 'id = ' . $orderId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
	function getOrderBySerial($orderSerial)
	{
		$table = 'orders';
		$fields = '*';
		$condition = 'OrderSerial = ' . $orderSerial;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addOrder($arrOrder)
    {
        $table = 'orders';
        return $this->wrapper->insert($table, $arrOrder);
    }
	
	function updateOrder($orderId, $values)
	{
		$table = 'orders';
		$condition = 'ID=' . $orderId;
		$limit = '';
		
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteOrder($orderId)
	{
        $table = 'orders';
		$condition = 'ID=' . $orderId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getOrderDescription($orderStatus)
	{
		if($orderStatus & 0x0001)
		{
			return "待付款";
		}
		else if($orderStatus & 0x0002)
		{
			return "待收件";
		}
		else if($orderStatus & 0x0004)
		{
			return "洗护中";
		}
		else if($orderStatus & 0x0008)
		{
			return "待送回";
		}
		else if($orderStatus & 0x0010)
		{
			return "待自提";
		}
		else if($orderStatus & 0x0020)
		{
			return "未评价";
		}
		else if($orderStatus & 0x0040)
		{
			return "已评价";
		}
		else if($orderStatus & 0x0080)
		{
			return "客户取消";
		}
		else if($orderStatus & 0x0100)
		{
			return "系统取消";
		}
		
		return "";
	}
	
	function getUserCountEx()
	{
		$table = 'users';
		$fields = 'count(*)';
		$condition = '';
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getUsersEx($page = 1, $number_per_page = 10)
	{
		$table = 'users';
		$fields = '*';
		$condition = '';
		$order = '';
		$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getUserEx($userId)
	{
		$table = 'users';
		$fields = '*';
		$condition = 'ID = ' . $userId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addUserEx($arrUser)
    {
        $table = 'users';
        return $this->wrapper->insert($table, $arrUser);
    }
	
	function updateUserEx($userId, $values)
	{
		$table = 'users';
		$condition = 'ID=' . $userId;
		$limit = '';
		
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteUserEx($userId)
	{
        $table = 'users';
		$condition = 'ID=' . $userId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getRemandCount($status = 0x03)
	{
		$table = 'remand_times';
		$fields = 'count(*)';
		$condition = '';
		$status_1 = 0x01;
		for($i = 0 ; $i < 2 ; $i++)
		{
			$status_1 << $i;
			if($status & ($status_1 << $i))
			{
				if($condition != '')
				{
					$condition = $condition . " or ";
				}
				$condition = $condition . 'Status = ' . ($status_1 << $i);
			}
		}
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getRemands($status = 0x03 , $page = 1, $number_per_page = 10)
	{
		$table = 'remand_times';
		$fields = '*';
		$condition = '';
		$status_1 = 0x01;
		for($i = 0 ; $i < 2 ; $i++)
		{
			$status_1 << $i;
			if($status & ($status_1 << $i))
			{
				if($condition != '')
				{
					$condition = $condition . " or ";
				}
				$condition = $condition . 'Status = ' . ($status_1 << $i);
			}
		}
		$order = '';
		$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getRemand($remandId)
	{
		$table = 'remand_times';
		$fields = '*';
		$condition = 'ID = ' . $remandId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
	function getRemandByOrderID($orderId)
	{
		$table = 'remand_times';
		$fields = '*';
		$condition = 'OrderID = ' . $orderId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addRemand($arrRemand)
    {
        $table = 'remand_times';
        return $this->wrapper->insert($table, $arrRemand);
    }
	
	function updateRemand($remandId, $values)
	{
		$table = 'remand_times';
		$condition = 'ID=' . $remandId;
		$limit = '';
		
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteRemand($remandId)
	{
        $table = 'remand_times';
		$condition = 'ID=' . $remandId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getRemandStatusDescription($status)
	{
		if($status & 0x01)
		{
			return "待处理";
		}
		else if($status & 0x02)
		{
			return "已处理";
		}
		
		return "";
	}
	
	function getEvaluationCount()
	{
		$table = 'evaluations';
		$fields = 'count(*)';
		$condition = '';
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getEvaluations($page = 1, $number_per_page = 10)
	{
		$table = 'evaluations';
		$fields = '*';
		$condition = '';
		$order = '';
		$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getEvaluation($evaluationId)
	{
		$table = 'evaluations';
		$fields = '*';
		$condition = 'ID = ' . $evaluationId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addEvaluation($arrEvaluation)
    {
        $table = 'evaluations';
        return $this->wrapper->insert($table, $arrEvaluation);
    }
	
	function updateEvaluation($evaluationId, $values)
	{
		$table = 'evaluations';
		$condition = 'ID=' . $evaluationId;
		$limit = '';
		
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteEvaluation($evaluationId)
	{
        $table = 'evaluations';
		$condition = 'ID=' . $evaluationId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getEvaluationDescription($evaluation)
	{
		switch($evaluation)
		{
			case 1:
				return "非常满意";
			case 2:
				return "满意";
			case 3:
				return "一般";
			case 4:
				return "不满意";
			case 5:
				return "非常不满意";
		}
		
		return "";
	}
	
	function getActionCount($type)
	{
		$table = 'action_items';
		$fields = 'count(*)';
		$condition = 'Type=' . $type;
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function actionIsExist($type, $goodsId)
	{
		$table = 'action_items';
		$fields = 'count(*)';
		$condition = 'Type=' . $type . " and ClothingGoodsID=" . $goodsId;
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return ($row[0] != 0);
	}
	
	function getActions($type = 1, $page = 1, $number_per_page = 10)
	{
		$table = 'action_items';
		$fields = '*';
		$condition = 'Type=' . $type;
		$order = '';
		if($number_per_page < 0)
		{
			$limit = '';
		}
		else
		{
			$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		}
		
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getAction($actionId)
	{
		$table = 'action_items';
		$fields = '*';
		$condition = 'ID = ' . $actionId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addAction($arrAction)
    {
        $table = 'action_items';
        return $this->wrapper->insert($table, $arrAction);
    }
	
	function updateAction($actionId, $values)
	{
		$table = 'action_items';
		$condition = 'ID=' . $actionId;
		$limit = '';
		
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteAction($actionId)
	{
        $table = 'action_items';
		$condition = 'ID=' . $actionId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getMemberCount($from_where = 0)
	{
		$table = 'users';
		$fields = 'count(*)';
		$condition = '';
		if($from_where != 0)
		{
			$condition = 'FromWhere = ' . $from_where;
		}
		
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function memberUserNameIsExist($userName)
	{
		$table = 'users';
		$fields = 'count(*)';
		$condition = "UserName = '" . $userName . "' or PhoneNumber = '" . $userName. "' or Email = '" . $userName . "'";
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return ($row[0] != 0);
	}
	
	function thirdPartyAccountIsExist($Channel, $openid)
	{
		$bRtn = true;
		
		$table = 'users';
		$fields = 'count(*)';
		if($Channel == 1)
		{
			$condition = "qq_openid = '" . $openid . "'";
		}
		else if($Channel == 2)
		{
			$condition = "weibo_openid = '" . $openid . "'";
		}
		else
		{
			$bRtn = false;
		}
		
		if($bRtn)
		{
			$order = '';
			$limit = '';
			$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
			$row = mysql_fetch_row($rs);
			$bRtn = ($row[0] != 0);
		}
		
		return $bRtn;
	}
	
	function getMemberByThirdPartyAccount($Channel, $openid)
	{
		$table = 'users';
		$fields = '*';
		if($Channel == 1)
		{
			$condition = "qq_openid = '" . $openid . "'";
		}
		else if($Channel == 2)
		{
			$condition = "weibo_openid = '" . $openid . "'";
		}
		else
		{
			return array();
		}
		
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_array($rs);
		return $row;
	}
	
	function getMemberByName($userName)
	{
		$table = 'users';
		$fields = '*';
		$condition = "UserName = '" . $userName . "' or PhoneNumber = '" . $userName. "' or Email = '" . $userName . "'";
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
	function updateMemberPassword($memberId, $type, $password)
	{
		$table = 'users';
		$condition = 'id=' . $memberId;
		$limit = '';
		if($type == 1)
		{
			$values = array("LoginPassword"=>$password);
		}
		else if($type == 2)
		{
			$values = array("PayPassword"=>$password);
		}
		
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function getMembers($from_where = 0, $page = 1, $number_per_page = 10)
	{
		$table = 'users';
		$fields = '*';
		$condition = '';
		if($from_where != 0)
		{
			$condition = 'FromWhere = ' . $from_where;
		}
		$order = '';
		if($number_per_page < 0)
		{
			$limit = '';
		}
		else
		{
			$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		}
		
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getMember($memberId)
	{
		$table = 'users';
		$fields = '*';
		$condition = 'id = ' . $memberId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addMember($arrMember)
    {
        $table = 'users';
        return $this->wrapper->insert($table, $arrMember);
    }
	
	function updateMember($memberId, $values)
	{
		$table = 'users';
		$condition = 'id=' . $memberId;
		$limit = '';
		
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteMember($memberId)
	{
        $table = 'users';
		$condition = 'id=' . $memberId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getMemberFromWhereDescription($fromWhere)
	{
		switch($fromWhere)
		{
			case 1:
				return "网站";
			case 2:
				return "APP";
			case 3:
				return "系统";
		}
		
		return "";
	}
	
	function getMemberSexDescription($sex)
	{
		switch($sex)
		{
			case 1:
				return "保密";
			case 2:
				return "男";
			case 3:
				return "女";
		}
		
		return "";
	}
	
	function getMemberMarryDescription($marry)
	{
		switch($marry)
		{
			case 1:
				return "保密";
			case 2:
				return "已婚";
			case 3:
				return "未婚";
		}
		
		return "";
	}
	
	function getMemberMonthIncomeDescription($income)
	{
		switch($income)
		{
			case 1:
				return "低于3K";
			case 2:
				return "3K ～ 5K";
			case 3:
				return "5K ～ 8K";
			case 4:
				return "8K ～ 10K";
			case 5:
				return "10K以上";
		}
		
		return "";
	}
	
	function getComplainCount($complain_type = 100, $complain_status = 3)
	{
		$table = 'complain_infos';
		$fields = 'count(*)';
		$condition = '';
		$condition = '';
		if($complain_type != 100)
			$condition = "Type = " . $complain_type;
		if($complain_status != 3)
		{
			if($condition == "")
				$condition = "Status = " . $complain_status;
			else
				$condition = $condition . " and Status = " . $complain_status; 
		} 
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getComplains($complain_type = 100, $complain_status = 3, $page = 1, $number_per_page = 10)
	{
		$table = 'complain_infos';
		$fields = '*';
		$condition = '';
		if($complain_type != 100)
			$condition = "Type = " . $complain_type;
		if($complain_status != 3)
		{
			if($condition == "")
				$condition = "Status = " . $complain_status;
			else
				$condition = $condition . " and Status = " . $complain_status; 
		}
		$order = '';
		$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getComplain($complainId)
	{
		$table = 'complain_infos';
		$fields = '*';
		$condition = 'ID = ' . $complainId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addComplain($arrComplain)
    {
        $table = 'complain_infos';
        return $this->wrapper->insert($table, $arrComplain);
    }
	
	function updateComplain($complainId, $values)
	{
		$table = 'complain_infos';
		$condition = 'ID=' . $complainId;
		$limit = '';
		
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteComplain($complainId)
	{
        $table = 'complain_infos';
		$condition = 'ID=' . $complainId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getComplainTypeDescription($type)
	{
		switch($type)
		{
			case 1:
				return "服务产品问题";
			case 2:
				return "订单问题";
			case 3:
				return "物流问题";
			case 4:
				return "洗后问题";
			case 5:
				return "活动问题";
			case 6:
				return "投诉客服";
			case 7:
				return "其他";
		}
		
		return "";
	}
	
	function getComplainStatusDescription($status)
	{
		switch($status)
		{
			case 1:
				return "未处理";
			case 2:
				return "已处理";
		}
		
		return "";
	}
	
	function getSuggestionCount()
	{
		$table = 'suggestions';
		$fields = 'count(*)';
		$condition = '';
		$condition = '';
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getSuggestions($page = 1, $number_per_page = 10)
	{
		$table = 'suggestions';
		$fields = '*';
		$condition = '';
		$order = '';
		$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getSuggestion($suggestionId)
	{
		$table = 'suggestions';
		$fields = '*';
		$condition = 'ID = ' . $suggestionId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addSuggestion($arrSuggestion)
    {
        $table = 'suggestions';
        return $this->wrapper->insert($table, $arrSuggestion);
    }
	
	function updateSuggestion($suggestionId, $values)
	{
		$table = 'suggestions';
		$condition = 'ID=' . $suggestionId;
		$limit = '';
		
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteSuggestion($suggestionId)
	{
        $table = 'suggestions';
		$condition = 'ID=' . $suggestionId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getDryTipCount()
	{
		$table = 'dry_tips';
		$fields = 'count(*)';
		$condition = '';
		$condition = '';
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getDryTips($page = 1, $number_per_page = 10)
	{
		$table = 'dry_tips';
		$fields = '*';
		$condition = '';
		$order = '';
		if($number_per_page < 0)
		{
			$limit = '';
		}
		else
		{
			$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		}
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getDryTip($tipId)
	{
		$table = 'dry_tips';
		$fields = '*';
		$condition = 'ID = ' . $tipId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addDryTip($arrTips)
    {
        $table = 'dry_tips';
        return $this->wrapper->insert($table, $arrTips);
    }
	
	function updateDryTip($tipId, $values)
	{
		$table = 'dry_tips';
		$condition = 'ID=' . $tipId;
		$limit = '';
		
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteDryTip($tipId)
	{
        $table = 'dry_tips';
		$condition = 'ID=' . $tipId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getEventCount()
	{
		$table = 'event_items';
		$fields = 'count(*)';
		$condition = '';
		$condition = '';
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getEvents($page = 1, $number_per_page = 10)
	{
		$table = 'event_items';
		$fields = '*';
		$condition = '';
		$order = '';
		if($number_per_page < 0)
		{
			$limit = '';
		}
		else
		{
			$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		}
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getEvent($eventId)
	{
		$table = 'event_items';
		$fields = '*';
		$condition = 'id = ' . $eventId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addEvent($arrEvents)
    {
        $table = 'event_items';
        return $this->wrapper->insert($table, $arrEvents);
    }
	
	function updateEvent($eventId, $values)
	{
		$table = 'event_items';
		$condition = 'ID=' . $eventId;
		$limit = '';
		
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteEvent($eventId)
	{
        $table = 'event_items';
		$condition = 'ID=' . $eventId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getLoginInfoCount()
	{
		$table = 'login_user_info';
		$fields = 'count(*)';
		$condition = '';
		$condition = '';
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getLoginInfos($page = 1, $number_per_page = 10)
	{
		$table = 'login_user_info';
		$fields = '*';
		$condition = '';
		$order = '';
		$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getLoginInfo($loginInfoId)
	{
		$table = 'login_user_info';
		$fields = '*';
		$condition = 'ID = ' . $loginInfoId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addLoginInfo($arrLoginInfos)
    {
        $table = 'login_user_info';
        return $this->wrapper->insert($table, $arrLoginInfos);
    }
	
	function updateLoginInfo($loginInfoId, $values)
	{
		$table = 'login_user_info';
		$condition = 'ID=' . $loginInfoId;
		$limit = '';
		
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteLoginInfo($loginInfoId)
	{
        $table = 'login_user_info';
		$condition = 'ID=' . $loginInfoId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getCouponCount($userId = -1, $status = 2)
	{
		$table = 'coupons';
		$fields = 'count(*)';
		$condition = '';
		if($userId > 0)
		{
			$condition = 'UserID = ' . $userId;
			if($status != 2)
			{
				$condition = $condition . ' and Status = ' . $status;
			}
		}
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getCoupons($page = 1, $number_per_page = 10, $userId = -1, $status = 2)
	{
		$table = 'coupons';
		$fields = '*';
		$condition = '';
		if($userId > 0)
		{
			$condition = 'UserID = ' . $userId;
			if($status != 2)
			{
				$condition = $condition . ' and Status = ' . $status;
			}
		}
		$order = '';
		if($number_per_page < 0)
		{
			$limit = '';
		}
		else
		{
			$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		}
		
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getCoupon($couponId)
	{
		$table = 'coupons';
		$fields = '*';
		$condition = 'id = ' . $couponId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addCoupon($arrCoupons)
    {
        $table = 'coupons';
        return $this->wrapper->insert($table, $arrCoupons);
    }
	
	function updateCoupon($couponId, $values)
	{
		$table = 'coupons';
		$condition = 'id=' . $couponId;
		$limit = '';
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteCoupon($couponId)
	{
        $table = 'coupons';
		$condition = 'id=' . $couponId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getOrderClothingCount($orderId = -1)
	{
		$table = 'orders_clothing';
		$fields = 'count(*)';
		$condition = '';
		if($orderId > 0)
		{
			$condition = 'OrderID = ' . $orderId;
		}
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getOrderClothings($page = 1, $number_per_page = 10, $orderId = -1)
	{
		$table = 'orders_clothing';
		$fields = '*';
		$condition = '';
		
		if($orderId > 0)
		{
			$condition = 'OrderID = ' . $orderId;
		}
		$order = '';
		
		if($number_per_page < 0)
		{
			$limit = '';
		}
		else
		{
			$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		}
		
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getOrderClothing($orderClothingId)
	{
		$table = 'orders_clothing';
		$fields = '*';
		$condition = 'id = ' . $orderClothingId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addOrderClothing($arrOrderClothings)
    {
        $table = 'orders_clothing';
        return $this->wrapper->insert($table, $arrOrderClothings);
    }
	
	function updateOrderClothing($orderClothingId, $values)
	{
		$table = 'orders_clothing';
		$condition = 'id=' . $orderClothingId;
		$limit = '';
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteOrderClothing($orderClothingId)
	{
        $table = 'orders_clothing';
		$condition = 'id=' . $orderClothingId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function deleteOrderClothingEx($orderId)
	{
        $table = 'orders_clothing';
		$condition = 'OrderID=' . $orderId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getArticleCount($type = 1)
	{
		$table = 'article';
		$fields = 'count(*)';
		if($type >= 1)
			$condition = 'Cate = ' . $type;
		else
			$condition = '';
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getArticles($type = 1, $page = 1, $number_per_page = 10)
	{
		$table = 'article';
		$fields = '*';
		if($type >= 1)
			$condition = 'Cate = ' . $type;
		else
			$condition = '';
		$order = '';
		if($number_per_page < 0)
		{
			$limit = '';
		}
		else
		{
			$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		}
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getArticle($articleId)
	{
		$table = 'article';
		$fields = '*';
		$condition = 'id = ' . $articleId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addArticle($arrArticles)
    {
        $table = 'article';
        return $this->wrapper->insert($table, $arrArticles);
    }
	
	function updateArticle($articleId, $values)
	{
		$table = 'article';
		$condition = 'id=' . $articleId;
		$limit = '';
		
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteArticle($articleId)
	{
        $table = 'article';
		$condition = 'id=' . $articleId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getArticleTypes()
	{
		return array(1=>"服务承诺",2=>"使用说明",3=>"支付方式",4=>"配送说明",5=>"洗后服务",6=>"关于我们",7=>"门店分布",8=>"招贤纳士",9=>"客服中心",10=>"媒体报道",11=>"隐私说明",12=>"用户协议",13=>"版权说明",14=>"特色服务",15=>"加盟合作");
	}
	
	function getArticleCateTypeDescription($type)
	{
		switch($type)
		{
			case 1:
				return "服务承诺";
			case 2:
				return "使用说明";
			case 3:
				return "支付方式";
			case 4:
				return "配送说明";
			case 5:
				return "洗后服务";
			case 6:
				return "关于我们";
			case 7:
				return "门店分布";
			case 8:
				return "招贤纳士";
			case 9:
				return "客服中心";
			case 10:
				return "媒体报道";
			case 11:
				return "隐私说明";
			case 12:
				return "用户协议";
			case 13:
				return "版权说明";
			case 14:
				return "特色服务";
			case 15 :
				return "加盟合作";
		}
		
		return "";
	}
	
	function getFacevalueCount()
	{
		$table = 'face_values';
		$fields = 'count(*)';
		$condition = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getFacevalues($page = 1, $number_per_page = 10)
	{
		$table = 'face_values';
		$fields = '*';
		$condition = '';
		
		if($number_per_page < 0)
		{
			$limit = '';
		}
		else
		{
			$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		}
		$order = 'id asc';
		
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getFacevalue($facevalueId)
	{
		$table = 'face_values';
		$fields = '*';
		$condition = 'id = ' . $facevalueId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addFacevalue($arrFacevalues)
    {
        $table = 'face_values';
        return $this->wrapper->insert($table, $arrFacevalues);
    }
	
	function updateFacevalue($facevalueId, $values)
	{
		$table = 'face_values';
		$condition = 'id=' . $facevalueId;
		$limit = '';
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteFacevalue($facevalueId)
	{
        $table = 'face_values';
		$condition = 'id=' . $facevalueId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getTimeperiodCount()
	{
		$table = 'time_period';
		$fields = 'count(*)';
		$condition = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getTimeperiods($page = 1, $number_per_page = 10)
	{
		$table = 'time_period';
		$fields = '*';
		$condition = '';
		
		if($number_per_page < 0)
		{
			$limit = '';
		}
		else
		{
			$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		}
		$order = 'id asc';
		
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getTimeperiod($timeperoidId)
	{
		$table = 'time_period';
		$fields = '*';
		$condition = 'id = ' . $timeperoidId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addTimeperiod($arrtimeperoid)
    {
        //$table = 'time_period';
        $table = 'time_period';
        return $this->wrapper->insert($table, $arrtimeperoid);
    }
	
	function updateTimeperiod($timeperoidId, $values)
	{
		$table = 'time_period';
		$condition = 'id=' . $timeperoidId;
		$limit = '';
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteTimeperiod($timeperoidId)
	{
        $table = 'time_period';
		$condition = 'id=' . $timeperoidId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getAddressCount($userId)
	{
		$table = 'delivery_addresses';
		$fields = 'count(*)';
		$condition = 'UserID = ' . $userId;
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getAddresses($userId, $page = 1, $number_per_page = 10)
	{
		$table = 'delivery_addresses';
		$fields = '*';
		$condition = 'UserID = ' . $userId;
		
		if($number_per_page < 0)
		{
			$limit = '';
		}
		else
		{
			$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		}
		$order = 'id asc';
		
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getAddress($userId, $addressId)
	{
		$table = 'delivery_addresses';
		$fields = '*';
		$condition = 'id = ' . $addressId . " and UserID = " . $userId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addAddress($arrAddress)
    {
        $table = 'delivery_addresses';
        return $this->wrapper->insert($table, $arrAddress);
    }
	
	function updateAddress($userId, $addressId, $values)
	{
		$table = 'delivery_addresses';
		$condition = 'id = ' . $addressId . " and UserID = " . $userId;
		$limit = '';
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteAddress($userId, $addressId)
	{
        $table = 'delivery_addresses';
		$condition = 'id = ' . $addressId . " and UserID = " . $userId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getInfundHistoryCount($userId = -1)
	{
		$table = 'infund_history';
		$fields = 'count(*)';
		if($userId > 0)
		{
			$condition = 'UserID = ' . $userId;
		}
		else
		{
			$condition = '';
		}
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getInfundHistorys($userId, $page = 1, $number_per_page = 10)
	{
		$table = 'infund_history';
		$fields = '*';
		if($userId > 0)
		{
			$condition = 'UserID = ' . $userId;
		}
		else
		{
			$condition = '';
		}
		if($number_per_page < 0)
		{
			$limit = '';
		}
		else
		{
			$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		}
		$order = 'id asc';
		
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getInfundHistory($infundHistoryId)
	{
		$table = 'infund_history';
		$fields = '*';
		$condition = 'id = ' . $infundHistoryId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addInfundHistory($arrInfundHistory)
    {
        $table = 'infund_history';
        return $this->wrapper->insert($table, $arrInfundHistory);
    }
	
	function updateInfundHistory($infundHistoryId, $values)
	{
		$table = 'infund_history';
		$condition = 'id = ' . $infundHistoryId;
		$limit = '';
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteInfundHistory($infundHistoryId)
	{
        $table = 'infund_history';
		$condition = 'id = ' . $infundHistoryId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getAccountAmountHistoryCount($userId = -1)
	{
		$table = 'account_amount_history';
		$fields = 'count(*)';
		if($userId > 0)
		{
			$condition = 'UserID = ' . $userId;
		}
		else
		{
			$condition = '';
		}
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getAccountAmountHistorys($userId, $page = 1, $number_per_page = 10)
	{
		$table = 'account_amount_history';
		$fields = '*';
		if($userId > 0)
		{
			$condition = 'UserID = ' . $userId;
		}
		else
		{
			$condition = '';
		}
		if($number_per_page < 0)
		{
			$limit = '';
		}
		else
		{
			$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		}
		$order = 'id asc';
		
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getAccountAmountHistory($accountAmountHistoryId)
	{
		$table = 'account_amount_history';
		$fields = '*';
		$condition = 'id = ' . $accountAmountHistoryId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addAccountAmountHistory($arrAccountAmountHistory)
    {
        $table = 'account_amount_history';
        return $this->wrapper->insert($table, $arrAccountAmountHistory);
    }
	
	function updateAccountAmountHistory($accountAmountHistoryId, $values)
	{
		$table = 'account_amount_history';
		$condition = 'id = ' . $accountAmountHistoryId;
		$limit = '';
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteAccountAmountHistory($accountAmountHistoryId)
	{
        $table = 'account_amount_history';
		$condition = 'id = ' . $accountAmountHistoryId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getProvinceCount()
	{
		$table = 'province';
		$fields = 'count(*)';
		$condition = '';
		$limit = '';
		$order = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getProvinces()
	{
		$table = 'province';
		$fields = '*';
		$condition = '';
		$limit = '';
		$order = 'id asc';
		
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getProvince($code)
	{
		$table = 'province';
		$fields = '*';
		$condition = "code = '" . $code . "'";
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
	function getCityCount($provinceCode)
	{
		$table = 'city';
		$fields = 'count(*)';
		$condition = 'provincecode = "' . $provinceCode . '"';
		$limit = '';
		$order = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getCitys($provinceCode)
	{
		$table = 'city';
		$fields = '*';
		$condition = 'provincecode = "' . $provinceCode . '"';
		$limit = '';
		$order = 'id asc';
		
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getCity($code)
	{
		$table = 'city';
		$fields = '*';
		$condition = "code = '" . $code . "'";
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
	function getRegionCount($cityCode)
	{
		$table = 'area';
		$fields = 'count(*)';
		$condition = 'citycode = "' . $cityCode . '"';
		$limit = '';
		$order = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getRegions($cityCode)
	{
		$table = 'area';
		$fields = '*';
		$condition = 'citycode = "' . $cityCode . '"';
		$limit = '';
		$order = 'id asc';
		
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getRegion($code)
	{
		$table = 'area';
		$fields = '*';
		$condition = "code = '" . $code . "'";
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
	function getQuickOrderCount($status = 0x000F)
	{
		$table = 'orders_temp';
		$fields = 'count(*)';
		
		$condition = '';
		$status_1 = 0x0001;
		$condition = '(';
		for($i = 0 ; $i < 4 ; $i++)
		{
			$status_1 << $i;
			if($status & ($status_1 << $i))
			{
				if($condition != '(')
				{
					$condition = $condition . " or ";
				}
				$condition = $condition . 'Status = ' . ($status_1 << $i);
			}
		}
		$condition = $condition . ')';
		
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getQuickOrders($status = 0x000F, $page = 1, $number_per_page = 10)
	{
		$table = 'orders_temp';
		$fields = '*';
		$condition = '';
		$status_1 = 0x0001;
		$condition = '(';
		for($i = 0 ; $i < 4 ; $i++)
		{
			$status_1 << $i;
			if($status & ($status_1 << $i))
			{
				if($condition != '(')
				{
					$condition = $condition . " or ";
				}
				$condition = $condition . 'Status = ' . ($status_1 << $i);
			}
		}
		$condition = $condition . ')';
		
		$order = '';
		if($number_per_page < 0)
		{
			$limit = '';
		}
		else
		{
			$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		}
		
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getQuickOrder($orderId)
	{
		$table = 'orders_temp';
		$fields = '*';
		$condition = 'id = ' . $orderId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addQuickOrder($arrOrder)
    {
        $table = 'orders_temp';
        return $this->wrapper->insert($table, $arrOrder);
    }
	
	function updateQuickOrder($orderId, $values)
	{
		$table = 'orders_temp';
		$condition = 'ID=' . $orderId;
		$limit = '';
		
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteQuickOrder($orderId)
	{
        $table = 'orders_temp';
		$condition = 'ID=' . $orderId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getQuickOrderDescription($orderStatus)
	{
		if($orderStatus & 0x0001)
		{
			return "待收件";
		}
		else if($orderStatus & 0x0002)
		{
			return "洗护中";
		}
		else if($orderStatus & 0x0004)
		{
			return "待送回";
		}
		else if($orderStatus & 0x0008)
		{
			return "已完成";
		}
		
		return "";
	}
	
	function getPointsHistoryCount()
	{
		$table = 'points_history';
		$fields = 'count(*)';
		$condition = '';
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getPointsHistorys($page = 1, $number_per_page = 10)
	{
		$table = 'points_history';
		$fields = '*';
		$condition = '';
		$order = '';
		if($number_per_page < 0)
		{
			$limit = '';
		}
		else
		{
			$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		}
		
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getPointsHistory($pointsHistoryId)
	{
		$table = 'points_history';
		$fields = '*';
		$condition = 'ID = ' . $pointsHistoryId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addPointsHistory($arrPointsHistory)
    {
        $table = 'points_history';
        return $this->wrapper->insert($table, $arrPointsHistory);
    }
	
	function updatePointsHistory($pointsHistoryId, $values)
	{
		$table = 'points_history';
		$condition = 'ID=' . $pointsHistoryId;
		$limit = '';
		
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deletePointsHistory($pointsHistoryId)
	{
        $table = 'points_history';
		$condition = 'ID=' . $pointsHistoryId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getCodeTokenCount()
	{
		$table = 'code_token';
		$fields = 'count(*)';
		$condition = '';
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getCodeTokens($page = 1, $number_per_page = 10)
	{
		$table = 'code_token';
		$fields = '*';
		$condition = '';
		$order = '';
		if($number_per_page < 0)
		{
			$limit = '';
		}
		else
		{
			$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		}
		
		return $this->wrapper->select($table, $fields, $condition, $order, $limit);
	}
	
	function getCodeToken($codeTokenId)
	{
		$table = 'code_token';
		$fields = '*';
		$condition = 'ID = ' . $codeTokenId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
	function codeTokenIsExist($type , $code , $token)
	{
		$table = 'code_token';
		$fields = 'count(*)';
		$condition = 'Type = ' . $type . ' and Code = "' . $code . '" and Token = "' . $token . '"';
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return ($row[0] > 0);
	}
	
    function addCodeToken($arrCodeToken)
    {
        $table = 'code_token';
        return $this->wrapper->insert($table, $arrCodeToken);
    }
	
	function updateCodeToken($codeTokenId, $values)
	{
		$table = 'code_token';
		$condition = 'ID=' . $codeTokenId;
		$limit = '';
		
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function updateCodeTokenEx($type , $code , $token, $values)
	{
		$table = 'code_token';
		$condition = 'Type = ' . $type . ' and Code = "' . $code . '" and Token = "' . $token . '"';
		$limit = '';
		
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteCodeToken($codeTokenId)
	{
        $table = 'code_token';
		$condition = 'ID=' . $codeTokenId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getLastID($table)
	{
		$fields = 'max(id)';
		$condition = '';
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function SendHttpPost($sURL,$aPostVars,$sessid,$nMaxReturn)
	{ 
		$srv_ip = '219.136.252.188';
		$srv_port = 80;
		$url = $sURL;
		$fp = '';
		$resp_str = '';
		$errno = 0;
		$errstr = '';
		$timeout = 300;
		$post_str = $aPostVars;

		$fp = fsockopen($srv_ip,$srv_port,$errno,$errstr,$timeout);
		if (!$fp)
		{
			return false;
		}

		$content_length = strlen($post_str);
		$post_header = "POST $url HTTP/1.1\r\n";
		$post_header .= "Content-Type:application/x-www-form-urlencoded\r\n";
		$post_header .= "User-Agent: MSIE\r\n";
		$post_header .= "Host: ".$srv_ip."\r\n";
		$post_header .= "Cookie: ".$sessid."\r\n";
		$post_header .= "Content-Length: ".$content_length."\r\n";
		$post_header .= "Connection: close\r\n\r\n";
		$post_header .= $post_str."\r\n\r\n";

		fwrite($fp,$post_header);

		$inheader = 1;
		while(!feof($fp))
		{
			$resp_str .= fgets($fp,4096);
			if ($inheader && ($resp_str == "\n" || $resp_str == "\r\n"))
			{        
				$inheader = 0;     
			}
		}

		if($nMaxReturn == 0)
		{
			$_SESSION["session_id"] = substr( $resp_str,strpos($resp_str,"Set-Cookie: ")+12,45);
		
			if( substr( $resp_str,strpos($resp_str,"<ErrorNum>")+10,strpos($resp_str,"</ErrorNum>") -strpos($resp_str,"<ErrorNum>")-10) ==0)
			{
				$_SESSION["activeid"] = substr( $resp_str,strpos($resp_str,"<ActiveID>")+10,strpos($resp_str,"</ActiveID>")-strpos($resp_str,"<ActiveID>")-10);
			}
		}
		else
		{
			if( substr( $resp_str,strpos($resp_str,"<ErrorNum>")+10,strpos($resp_str,"</ErrorNum>") -strpos($resp_str,"<ErrorNum>")-10) ==0)
			{
		
			}
			else
			{
				$_SESSION["ReturnString"] = substr( $resp_str,strpos($resp_str,"<ErrorNum>")+10,strpos($resp_str,"</ErrorNum>")-strpos($resp_str,"<ErrorNum>")-10);
			} 
		}  
		fclose($fp);
		return true;
	 }
	
	function sendSms($phoneNumber, $content)
	{
		//ZC835N
	    if(!$this->SendHttpPost("/LANZGateway/Login.asp","UserID=857675&Account=wnxy666&Password=FC3B0F189DD1D252C0BD8B41073247FD0BAF8A3B","",0))
			return false;
	    if(!$this->SendHttpPost("/LANZGateway/SendSMS.asp","SMSType=1&Phone=" . $phoneNumber . "&Content=" . $content . "&ActiveID=".$_SESSION["activeid"],$_SESSION["session_id"],1))
			return false;
	    if(!$this->SendHttpPost("/LANZGateway/Logoff.asp","ActiveID=".$_SESSION["activeid"],$_SESSION["session_id"],2))
			return false;
		return true;
	}
	
	function isLogin($account, $token)
	{
		return true;
	}
	
	function generateToken()
	{
		$arr = array("0","1","2","3","4","5","6","7","8","9",
					 "a","b","c","d","e","f","g","h","i","j",
				 	 "k","l","m","n","o","p","q","r","s","t",
				 	 "u","v","w","x","y","z","A","B","C","D",
				 	 "E","F","G","H","I","J","K","L","M","N",
				 	 "O","P","Q","R","S","T","U","V","W","X",
				 	 "Y","Z");
		$Token = "";
		for($i = 0 ; $i < 32 ; $i++)
		{
			$Token = $Token . $arr[rand(0, count($arr) - 1)];
		}
		return $Token;
	}
}