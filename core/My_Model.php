<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/* Author: scott
 * Description: My Model class
 */
class My_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function resetSession()
    {
        $user_id = $this->session->userdata('id');
        if (DB_SUCCESS == $this->getById("users", $user_id, $user_data)) {
            $user_data["validated"] = true;
            $this->session->set_userdata($user_data);
        }
    }

    public function sql_now(){
        $sql = "select now();";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0]["now()"];
    }

    public function getTimeDiff($datetime1, $datetime2){
        $interval = $datetime1->diff($datetime2);
        $y=$interval->format('%y');
        $m=$interval->format('%m');
        $d=$interval->format('%d');
        $h=$interval->format('%h');
        $i=$interval->format('%i');
        $minutes = $y * (60 * 24 * 365)
        + $m * (60 * 24 * 30)
        + $d * (60 * 24)
        + $h * 60
        + $m;
        return $minutes;
    }

    public function getById($table_name, $id, &$row_data, $field_name = null, $order = null)
    {
        return $this->getSingleData($table_name, "id=" . $id, $row_data, $field_name, $order);
    }

    public function getByName($table_name, $name, &$row_data, $field_name = null, $order = null)
    {
        return $this->getSingleData($table_name, "name='" . $name . "'", $row_data, $field_name, $order);
    }

    public function getSingleData($table_name, $where, &$row_data, $field_name = null, $order = null)
    {
        $row_data = array();
        $this->db->where($where);
        if ($order != null) {
            $this->db->order_by($order);
        }

        try {
            $query = $this->db->get($table_name);
        } catch (Throwable $th) {
            return DB_SQL_ERR;
        }

        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            if ($field_name != null) {
                for ($i = 0; $i < count($field_name); $i++) {
                    $row_data[$field_name[$i]] = $rows[0][$field_name[$i]];
                }
            } else {
                $row_data = $rows[0];
            }
            return DB_SUCCESS;
        }
        return DB_NO_RESULT;
    }

    public function getMultiData($table_name, $where, &$rows_data, $field_name = null, $order = null)
    {
        $rows_data = array();

        $this->db->where($where);
        if ($order != null) {
            $this->db->order_by($order);
        }

        try {
            $query = $this->db->get($table_name);
        } catch (Throwable $th) {
            return DB_SQL_ERR;
        }

        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            if ($field_name != null) {
                for ($k = 0; $k < count($rows); $k++) {
                    $row_data = array();
                    for ($i = 0; $i < count($field_name); $i++) {
                        $row_data[$field_name[$i]] = $rows[$k][$field_name[$i]];
                    }
                    $rows_data[] = $row_data;
                }
            } else {
                $rows_data = $rows;
            }
            return DB_SUCCESS;
        }
        return DB_NO_RESULT;
    }
    //
    public function getLauncherInfo()
    {
        $this->getByName("tb_apk_info", "launcher", $apk_info);
        return $apk_info;
    }
    public function getSysInfo()
    {
        $this->getSingleData("tb_sys_info", "1=1", $sys_info);
        return $sys_info;
    }

    public function saveSysInfo()
    {
        $data = array();
        $data = $this->security->xss_clean($this->input->post());
        if (isset($_FILES['logo']) && !empty($_FILES['logo'])) {
            $logo_name = "logo.png";
            move_uploaded_file($_FILES["logo"]["tmp_name"], 'data/logo/' . $logo_name);
            $data["logo"] = $logo_name;
        }
        $this->db->update("tb_sys_info", $data);
    }

    public function saveLauncherInfo()
    {
        $data = array();
        $data = $this->security->xss_clean($this->input->post());
        $box_ids = $data['box_ids'];

        if (isset($box_ids) && is_array($box_ids)) {
            $data['box_ids'] = json_encode($box_ids);
        }else{
            $data['box_ids'] = "[]";
        }
        unset($data['box_update']);

        if (isset($_FILES['file_name']) && !empty($_FILES['file_name'])) {
            $file_name = "launcher._apk";
            move_uploaded_file($_FILES["file_name"]["tmp_name"], 'data/file/' . $file_name);
            $data["file_name"] = $file_name;
        }
        $this->db->where("name", "launcher");
        $this->db->update("tb_apk_info", $data);
    }
    public function saveMessage()
    {
        $no_box_msg = $this->security->xss_clean($this->input->post("no_box_msg"));
        $block_box_msg = $this->security->xss_clean($this->input->post("block_box_msg"));
        //
        $this->db->where("type", RSP_FAIL);
        $data = array("msg" => $no_box_msg);
        $this->db->update("tb_msg", $data);
        //
        $this->db->where("type", RSP_USER_BLOCK);
        $data = array("msg" => $block_box_msg);
        $this->db->update("tb_msg", $data);
    }
    public function getMessageInfo()
    {
        $this->getMultiData("tb_msg", "1=1", $msg_data);
        $msgs = array();
        for ($i = 0; $i < count($msg_data); $i++) {
            $msgs[$msg_data[$i]["type"]] = $msg_data[$i]["msg"];
        }
        return $msgs;
    }

    public function setDefaultDesktopById($desktop_id)
    {
        $data = array(
            "default_desktop_id" => $desktop_id,
        );
        $this->db->update("tb_sys_info", $data);
    }
    public function setDefaultGroupById($group_id)
    {
        $data = array(
            "default_group_id" => $group_id,
        );
        $this->db->update("tb_sys_info", $data);
    }
    //
    public function createImage($path, $ref_name, $data, $file_name = null)
    {

        // $data = preg_replace('/data:image\/(png|jpg|jpeg|gif|bmp);base64,/', '', $data);
        $data1 = substr($data, strpos($data, ",") + 1);
        $data2 = str_replace(' ', '+', $data1);
        $data3 = base64_decode($data2);

        if ($file_name == null) {
            $file_name = str_replace(" ", "_", $ref_name) . "(" . $_SERVER['REQUEST_TIME'] . ")" . "." . "png";
        }
        $file_path = $path . "/" . $file_name;
        $success = file_put_contents($file_path, $data3);
        return $success ? $file_name : '';
    }
    public function removeFile($path)
    {
        // if (file_exists($path)) {
        // unlink($path);
        // }
    }
    // relative img
    public function getGroupThumb($file_name)
    {
        if ($file_name == null || $file_name == "") {
            return base_url() . "data/group/default_thumb.png";
        } else {
            return base_url() . "data/group/thumb/" . $file_name;
        }
    }
    public function getGroupPicture($file_name)
    {
        if ($file_name == null || $file_name == "") {
            return base_url() . "data/group/default_picture.png";
        } else {
            return base_url() . "data/group/picture/" . $file_name;
        }
    }
    public function getDesktopThumb($file_name)
    {
        if ($file_name == null || $file_name == "") {
            return base_url() . "data/desktop/default_thumb.png";
        } else {
            return base_url() . "data/desktop/thumb/" . $file_name;
        }
    }
    public function getDesktopPicture($file_name)
    {
        if ($file_name == null || $file_name == "") {
            return base_url() . "data/desktop/default_picture.png";
        } else {
            return base_url() . "data/desktop/picture/" . $file_name;
        }
    }

    ///////////// get pagenation data///////////////
    public function data_output ($start_row_id, $columns, $data )
	{
        $now = new DateTime($this->sql_now());
        $out = array();
		for ( $i=0, $ien=count($data) ; $i<$ien ; $i++ ) {
			$row = array();

			for ( $j=0, $jen=count($columns) ; $j<$jen ; $j++ ) {
				$column = $columns[$j];
                if (isset($column['dt'])){
                    $data[$i]["now"] = $now;
                    // Is there a formatter?
                    if ( isset( $column['row_id'])){
                        $row[ $column['dt'] ] = $start_row_id + $i;
                    }else if ( isset( $column['formatter'] ) ) {
                        $row[ $column['dt'] ] = $column['formatter']((isset($column['db']))? $data[$i][ $column['db'] ]: "", $data[$i] );
                    }
                    else {
                        $row[ $column['dt'] ] = $data[$i][ $columns[$j]['db'] ];
                    }
                }
			}
			$out[] = $row;
		}

		return $out;
    }
    
    public function limit ( $request, $columns )
	{
		$limit = '';

		if ( isset($request['start']) && $request['length'] != -1 ) {
			$limit = "LIMIT ".intval($request['start']).", ".intval($request['length']);
		}

		return $limit;
    }
    
    public function order ( $request, $columns )
	{
		$order = '';

		if ( isset($request['order']) && count($request['order']) ) {
			$orderBy = array();
			$dtColumns = $this->pluck( $columns, 'dt' );

			for ( $i=0, $ien=count($request['order']) ; $i<$ien ; $i++ ) {
				// Convert the column index into the column data property
				$columnIdx = intval($request['order'][$i]['column']);
				$requestColumn = $request['columns'][$columnIdx];

				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];

				if ( $requestColumn['orderable'] == 'true' && isset($column['db']) ) {
					$dir = $request['order'][$i]['dir'] === 'asc' ?
						'ASC' :
						'DESC';

					$orderBy[] = '`'.$column['db'].'` '.$dir;
				}
			}

			if ( count( $orderBy ) ) {
				$order = 'ORDER BY '.implode(', ', $orderBy);
			}
		}

		return $order;
    }
    
    public function filter ( $request, $columns )
	{
		$globalSearch = array();
		$columnSearch = array();
		$dtColumns = $this->pluck( $columns, 'dt' );

		if ( isset($request['search']) && $request['search']['value'] != '' ) {
			$str = $request['search']['value'];

			for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
				$requestColumn = $request['columns'][$i];
				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];

				if ( $requestColumn['searchable'] == 'true' && isset($column['db'])) {
					// $binding = $this->bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
					$globalSearch[] = "`".$column['db']."` LIKE '".'%'.$str.'%'."'";
				}
			}
		}

		// Individual column filtering
		if ( isset( $request['columns'] ) ) {
			for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
				$requestColumn = $request['columns'][$i];
				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];

				$str = $requestColumn['search']['value'];

				if ( $requestColumn['searchable'] == 'true' &&
				 $str != '' ) {
					// $binding = $this->bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
					$columnSearch[] = "`".$column['db']."` LIKE '".'%'.$str.'%'."'";
				}
			}
		}

		// Combine the filters into a single string
		$where = '';

		if ( count( $globalSearch ) ) {
			$where = '('.implode(' OR ', $globalSearch).')';
		}

		if ( count( $columnSearch ) ) {
			$where = $where === '' ?
				implode(' AND ', $columnSearch) :
				$where .' AND '. implode(' AND ', $columnSearch);
		}

		if ( $where !== '' ) {
			$where = 'WHERE '.$where;
		}

		return $where;
    }

    public function simple ( $request, $table, $primaryKey, $columns )
	{
		// $bindings = array();
		// $db = $this->db( $conn );

		// Build the SQL query string from the request
		$limit = $this->limit( $request, $columns );
		$order = $this->order( $request, $columns );
		$where = $this->filter( $request, $columns);

		// Main query to actually get the data
		$data = $this->sql_exec(
			"SELECT `".implode("`, `", $this->pluck($columns, 'db'))."`
			 FROM `$table`
			 $where
			 $order
			 $limit"
		);

		// Data set length after filtering
		$resFilterLength = $this->sql_exec(
			"SELECT COUNT(`{$primaryKey}`) as cnt
			 FROM   `$table`
			 $where"
        );
		$recordsFiltered = $resFilterLength[0]['cnt'];

		// Total data set length
		$resTotalLength = $this->sql_exec(
			"SELECT COUNT(`{$primaryKey}`) as cnt
			 FROM   `$table`"
		);
		$recordsTotal = $resTotalLength[0]['cnt'];

		/*
		 * Output
		 */
		return array(
			"draw"            => isset ( $request['draw'] ) ?
				intval( $request['draw'] ) :
				0,
			"recordsTotal"    => intval( $recordsTotal ),
			"recordsFiltered" => intval( $recordsFiltered ),
			"data"            => $this->data_output( (isset($request['start'])) ? $request['start'] + 1: 1, $columns, $data )
		);
    }
    
    public function complex ( $request, $table, $primaryKey, $columns, $whereResult=null, $whereAll=null )
	{
		// $bindings = array();
		// $db = $this->db( $conn );
		$localWhereResult = array();
		$localWhereAll = array();
		$whereAllSql = '';

		// Build the SQL query string from the request
		$limit = $this->limit( $request, $columns );
		$order = $this->order( $request, $columns );
		$where = $this->filter( $request, $columns);

		$whereResult = $this->_flatten( $whereResult );
		$whereAll = $this->_flatten( $whereAll );

		if ( $whereResult ) {
			$where = $where ?
				$where .' AND '.$whereResult :
				'WHERE '.$whereResult;
		}

		if ( $whereAll ) {
			$where = $where ?
				$where .' AND '.$whereAll :
				'WHERE '.$whereAll;

			$whereAllSql = 'WHERE '.$whereAll;
		}

		// Main query to actually get the data
		$data = $this->sql_exec(
			"SELECT `".implode("`, `", $this->pluck($columns, 'db'))."`
			 FROM `$table`
			 $where
			 $order
			 $limit"
		);

		// Data set length after filtering
		$resFilterLength = $this->sql_exec( 
			"SELECT COUNT(`{$primaryKey}`)
			 FROM   `$table`
			 $where"
		);
		$recordsFiltered = $resFilterLength[0][0];

		// Total data set length
		$resTotalLength = $this->sql_exec(
			"SELECT COUNT(`{$primaryKey}`)
			 FROM   `$table` ".
			$whereAllSql
		);
        $recordsTotal = $resTotalLength[0][0];
        
     	/*
		 * Output
		 */
		return array(
			"draw"            => isset ( $request['draw'] ) ?
				intval( $request['draw'] ) :
				0,
			"recordsTotal"    => intval( $recordsTotal ),
			"recordsFiltered" => intval( $recordsFiltered ),
			"data"            => $this->data_output( (isset($request['start'])) ? $request['start']: 0,  $columns, $data )
		);
    }
    
    public function sql_exec ($sql)
	{
		$query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
    
    // public function fatal ( $msg )
	// {
	// 	echo json_encode( array( 
	// 		"error" => $msg
	// 	) );

	// 	exit(0);
    // }
    
    // public function bind ( &$a, $val, $type )
	// {
	// 	$key = ':binding_'.count( $a );

	// 	$a[] = array(
	// 		'key' => $key,
	// 		'val' => $val,
	// 		'type' => $type
	// 	);

	// 	return $key;
    // }
    
    public function pluck ( $a, $prop )
	{
		$out = array();

		for ( $i=0, $len=count($a) ; $i<$len ; $i++ ) {
            if (isset($a[$i][$prop])){
                $out[] = $a[$i][$prop];
            }
		}

		return $out;
    }
    
    public function _flatten ( $a, $join = ' AND ' )
	{
		if ( ! $a ) {
			return '';
		}
		else if ( $a && is_array($a) ) {
			return implode( $join, $a );
		}
		return $a;
	}
}
