<?php 
require_once(__DIR__ .'/../includes/autoload.php');
                                       
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value
 
$searchQuery = " ";

if ($_GET['fetch'] == 'payment') {
  if($searchValue != ''){
     $searchQuery = " AND email like '%".$searchValue."%' OR  
          country like '%".$searchValue."%' OR  
          concat_ws(' ', `pf_name`, `pl_name`) like '%".$searchValue."%'";
  }

  ## Total number of records without filtering 
  $sel = "SELECT COUNT(*) AS allcount FROM " . TABLE_PAYMENTS;
  $totalRecords = $framework->dbProcessor($sel, 1)[0]['allcount'];

  // ## Total number of record with filtering
  $sel = sprintf("SELECT COUNT(*) AS allcount FROM " . TABLE_PAYMENTS . " WHERE 1%s", $searchQuery);
  $totalRecordwithFilter = $framework->dbProcessor($sel, 1)[0]['allcount'];
   
  ## Fetch records
  $sql = sprintf("SELECT * FROM " . TABLE_PAYMENTS . " WHERE 1%s ORDER BY %s %s LIMIT %s,%s", $searchQuery, $columnName, $columnSortOrder, $row, $rowperpage);

  $empRecords = $framework->dbProcessor($sql, 1);
  $data = array(); 

  if ($empRecords) {
    foreach ($empRecords as $value) {
      $us = $framework->userData($value['user_id'], 1);
      $user_url = cleanUrls($SETT['url'] . '/index.php?page=profile&profile=view&username='.$us['username']);
      $username_url = simpleButtons(null, $value['pf_name']. ' ' .$value['pl_name'], $user_url, 1);
      $data[] = array( 
        "id" => $value['user_id'],
        "pl_name" => '<i class="fa fa-trash delete-trash" id="delete_pay_'.$value['user_id'].'"></i>',
        "pf_name" => $username_url,
        "email" => $value['email'],
        "amount" => $value['amount'],
        "payment_id" => $value['payment_id'],
        "order_ref" => $value['order_ref'], 
        "date" => $value['date']
      );
    }
  }
} elseif ($_GET['fetch'] == 'users') {
  if($searchValue != ''){
     $searchQuery = " AND email like '%".$searchValue."%' OR  
          country like '%".$searchValue."%' OR 
          concat_ws(' ', `f_name`, `l_name`) like '%".$searchValue."%'";
  }

  ## Total number of records without filtering 
  $sel = "SELECT COUNT(*) AS allusers FROM " . TABLE_PAYMENTS;
  $totalRecords = $framework->dbProcessor($sel, 1)[0]['allusers'];

  // ## Total number of record with filtering
  $sel = sprintf("SELECT COUNT(*) AS allusers FROM " . TABLE_USERS . " WHERE 1%s", $searchQuery);
  $totalRecordwithFilter = $framework->dbProcessor($sel, 1)[0]['allusers'];
   
  ## Fetch records
  $sql = sprintf("SELECT * FROM " . TABLE_USERS . " WHERE 1%s ORDER BY %s %s LIMIT %s,%s", $searchQuery, $columnName, $columnSortOrder, $row, $rowperpage);

  $empRecords = $framework->dbProcessor($sql, 1);
  $data = array(); 

  if ($empRecords) {
    foreach ($empRecords as $value) { 
      $user_url = cleanUrls($SETT['url'] . '/index.php?page=profile&profile=view&username='.$value['username']);
      $username_url = simpleButtons(null, strtoupper($value['username']), $user_url, 1);
      $data[] = array( 
        "id" => $value['id'],
        "l_name" => '<a href="#user_table" onclick="deleteIt(1, '.$value['id'].')"><i class="fa fa-trash delete-trash"></i></a>',
        "username" => $username_url,
        "f_name" => $value['f_name']. ' ' .$value['l_name'],
        "email" => $value['email'],
        "phone" => $value['phone'],
        "city" => $value['city'],
        "state" => $value['state'],
        "country" => $value['country'], 
        "role" => strtoupper($value['role'])
      );
    }
  }
} elseif ($_GET['fetch'] == 'learner') {
  if($searchValue != ''){
     $searchQuery = " AND id like '%".$searchValue."%' OR  
          user_id like '%".$searchValue."%' OR 
          course_id like '%".$searchValue."%'";
  }

  ## Total number of records without filtering 
  $sel = "SELECT COUNT(*) AS allearners FROM " . TABLE_COMPLETED;
  $totalRecords = $framework->dbProcessor($sel, 1)[0]['allearners'];

  // ## Total number of record with filtering
  $sel = sprintf("SELECT COUNT(*) AS allearners FROM " . TABLE_COMPLETED . " WHERE 1%s", $searchQuery);
  $totalRecordwithFilter = $framework->dbProcessor($sel, 1)[0]['allearners'];
   
  ## Fetch records
  $sql = sprintf("SELECT * FROM " . TABLE_COMPLETED . " WHERE 1%s LIMIT %s", $searchQuery, $rowperpage);

  $empRecords = $framework->dbProcessor($sql, 1);
  $data = array(); 

  if ($empRecords) {
    foreach ($empRecords as $value) { 
      $us = $framework->userData($value['user_id'], 1);
      $cs = getCourses(1, $value['course_id'])[0];
      $user_url = cleanUrls($SETT['url'] . '/index.php?page=profile&profile=view&username='.$us['username']);
      $username_url = simpleButtons(null, ucfirst($us['username']), $user_url, 1);
      $data[] = array( 
        "user_id" => $value['id'],
        "delete" => '<i class="fa fa-trash delete-trash" id="delete_user_'.$value['id'].'"></i>',
        "username" => $username_url,
        "f_name" => $us['f_name']. ' ' .$us['l_name'],
        "course_id" => $cs['title'],
        "date" => $value['date'], 
      );
    }
  }
}
 
// ## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecordwithFilter,
  "iTotalDisplayRecords" => $totalRecords,
  "aaData" => $data
);

echo json_encode($response);
