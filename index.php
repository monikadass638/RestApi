<?php
$request_method = $_SERVER['REQUEST_METHOD'];
$response= array();
switch($request_method)
{
    case "GET":
        Response(DoGet());
        break;
    
    case "PUT":
        Response(DoPut());
        break;

    case "POST":
        Response(DoPost());
        break;

    case "DELETE":
        DoDelete();
        break;


}
function DoGet()
{
    
    if($id= $_GET['id'])
    {
        $where= " where id= ".$id;
    }
    else
    {
        $id=0;
        $where = " ";
    }
    $dbconnect=mysqli_connect('localhost','root','','employee');
    $query="select * from employee".$where;
    $result=mysqli_query($dbconnect,$query);
    
    while($data=mysqli_fetch_assoc($result))
    {
        $response[] = $data;
    }
    return $response;

    //echo "Get Method is called";
}
//Method to insert new Record

function DoPut()
{
    if($_POST)
    {
    $dbconnect=mysqli_connect('localhost','root','','employee');
    echo $query= "INSERT INTO employee ('emp_name', 'emp_city','emp_status') VALUES ('".$_POST['emp_name']."' , '".$_POST['emp_city']."', '".$_POST['emp_status']."')";
    $result= mysqli_query($dbconnect, $query);
    if($result == true)
    {
        $response = array("message" => "Record Inserted");
    }
    else
    {
        $response = array("message" => "Record not inserted");
    }

    //return $response;
}

}
function DoPost()
{
    if($_POST)
    {
        $dbconnect=mysqli_connect('localhost','root','','employee');
        $query= "INSERT INTO `employee` (`emp_name`, `emp_city`,`emp_trash`) VALUES ('".$_POST['emp_name']."' , '".$_POST['emp_city']."', '".$_POST['emp_trash']."')";
        $result= mysqli_query($dbconnect, $query);
        
    if($result == 1)
    {
        $response = array("message" => "Record Inserted");
    }
    else
    {
        $response = array("message" => "Record not inserted");
    }

    return $response;
}
}
function DoDelete()
{
    echo "Delete Method is called";
}
function Response($response)
{
    echo json_encode(array("status" =>"200" ,"data" => $response ));
}
?>