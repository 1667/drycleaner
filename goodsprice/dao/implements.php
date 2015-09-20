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
	
	function getServiceTypeNames()
	{
		$table = 'service_types';
		$fields = 'id,TypeName';
		$condition = '';
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		$arr = array();
		
		for($i = 0 ; $i < mysql_num_rows($rs) ; $i++)
		{
			$row = mysql_fetch_array($rs);
			$arr = array_merge($arr,array(count($arr)=>array("id"=>$row["ID"], "typeName"=>$row["TypeName"])));
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
	
	function getGoodsCountEx($TypeID, $MaterialQuality, $Style)
	{
		$table = 'clothing_goodss';
		$fields = 'count(*)';
		$condition = 'MaterialQuality & ' . $MaterialQuality . '!= 0' . ' and Style & ' . $Style . '!= 0';
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
		$condition = 'MaterialQuality & ' . $MaterialQuality . '!= 0' . ' and Style & ' . $Style . '!= 0';
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
		for($i = 0 ; $i < 9 ; $i++)
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
		for($i = 0 ; $i < 9 ; $i++)
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
		$condition = 'ID = ' . $orderId;
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
		$condition = 'ID = ' . $eventId;
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
		if($number_per_page < 0)
		{
			$limit = '';
		}
		else
		{
			$limit = ($page - 1)*$number_per_page . ',' . $number_per_page;
		}
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
	
	function getGoodsPriceCount()
	{
		$table = 'goodsprice';
		$fields = 'count(*)';
		$condition = '';
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getGoodsPrices($page = 1, $number_per_page = 10)
	{
		$table = 'goodsprice';
		$fields = '*';
		$condition = '';
		$order = 'id desc';
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
	
	function getGoodsPrice($goodsPriceId)
	{
		$table = 'goodsprice';
		$fields = '*';
		$condition = 'id = ' . $goodsPriceId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addGoodsPrice($arrGoodsPrices)
    {
        $table = 'goodsprice';
        return $this->wrapper->insert($table, $arrGoodsPrices);
    }
	
	function updateGoodsPrice($goodsPriceId, $values)
	{
		$table = 'goodsprice';
		$condition = 'id=' . $goodsPriceId;
		$limit = '';
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteGoodsPrice($goodsPriceId)
	{
        $table = 'goodsprice';
		$condition = 'id=' . $goodsPriceId;
		$limit = '';
        $this->wrapper->del($table, $condition, $limit);
	}
	
	function getGoodsPriceShareCount()
	{
		$table = 'goodspriceshare';
		$fields = 'count(*)';
		$condition = '';
		$order = '';
		$limit = '';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}
	
	function getGoodsPriceShares($page = 1, $number_per_page = 10)
	{
		$table = 'goodspriceshare';
		$fields = '*';
		$condition = '';
		$order = 'id desc';
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
	
	function getGoodsPriceShare($goodsPriceShareId)
	{
		$table = 'goodspriceshare';
		$fields = '*';
		$condition = 'id = ' . $goodsPriceShareId;
		$order = '';
		$limit = '0,1';
		$rs = $this->wrapper->select($table, $fields, $condition, $order, $limit);
		
		if(mysql_num_rows($rs) > 0)
		{
			return mysql_fetch_array($rs);
		}
		
		return array();
	}
	
    function addGoodsPriceShare($arrGoodsPriceShares)
    {
        $table = 'goodspriceshare';
        return $this->wrapper->insert($table, $arrGoodsPriceShares);
    }
	
	function updateGoodsPriceShare($goodsPriceShareId, $values)
	{
		$table = 'goodspriceshare';
		$condition = 'id=' . $goodsPriceShareId;
		$limit = '';
		$this->wrapper->update($table, $values, $condition, $limit);
	}
	
	function deleteGoodsPriceShare($goodsPriceShareId)
	{
        $table = 'goodspriceshare';
		$condition = 'id=' . $goodsPriceShareId;
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
}