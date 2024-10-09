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
        Response(DoDelete());
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
    parse_str(file_get_contents('php://input'),$_PUT);
    print_r($_PUT);
    if($_PUT)
    {
    $dbconnect=mysqli_connect('localhost','root','','employee');
     $query= "UPDATE  employee SET `emp_name` = '".$_PUT['emp_name']."' , `emp_city` = '".$_PUT['emp_city']."' ,emp_trash = '".$_PUT['emp_trash']."' where id = " .$_GET['id'];
    $result= mysqli_query($dbconnect, $query);
    if($result == 1)
    {
        $response = array("message" => " Record has been updated");
    }
    else
    {
        $response = array("message" => "Record not updated");
    }

    return $response;
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
//How to delete the record with API
function DoDelete()
{
    if($_GET['id'])
    {
        $dbconnect=mysqli_connect('localhost','root','','employee');
        $query= "DElETE FROM employee where id =".$_GET['id'];
        $result=mysqli_query($dbconnect, $query);
        
        if($result == 1)
        {
            $response = array("message" => "Record Deleted");
        }
        else
        {
            $response = array("message" => "Record not Deleted");

        }
        return $response;
    }
    
}
function Response($response)
{
    echo json_encode(array("status" =>"200" ,"data" => $response ));
}
?>