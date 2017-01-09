<?php

$con=new mysqli("localhost","root","","gmap");


$arr=[];

if($con->ping()){
	$arr['connected']=true;
}else{
	$arr['connected']=false;
}
if($_SERVER['REQUEST_METHOD']==='POST'){
	$arr['xid']=$_POST['xid'];
	
	$arr['action']='ADD';
	 
}else{
	$arr['xid']=$_GET['xid'];
	$arr['action']='GET';
}

if($arr['action']=='ADD'){
	$arr['name']=$_POST['name'];
	$arr['company']=$_POST['company'];
	$arr['cost']=$_POST['cost'];
	$arr['action']=$_POST['action'];

	$sqls="SELECT xid FROM api WHERE xid=?";
	$sqla=$con->prepare($sqls);
	$rsa=$sqla->bind_param('i',$arr['xid']);
	$sqla->execute();
	$result=$sqla->get_result();
	
	
	if($result->num_rows==0){	
		$sql=$con->prepare("INSERT INTO api (xid,name,company,cost)
		VALUES (?,?,?,?)");
		$rs=$sql->bind_param('issi',$arr['xid'],$arr['name'],$arr['company'],$arr['cost']);
		$sql->execute();
		if($rs){
			 
			$arr['id']=$con->insert_id;
			$arr['status']="added";
		}
	}else{
		$sql=$con->prepare("UPDATE api SET  name=?,company=?,cost=? WHERE xid=?");
		$rs=$sql->bind_param('ssii',$arr['name'],$arr['company'],$arr['cost'],$arr['xid']);
		$sql->execute();
		if($rs){
		 
			$arr['id']=$con->insert_id;
			$arr['status']="updated";
		}
	}
}


if($arr['action']=='GET'){
	$sql="SELECT * FROM api WHERE xid=?";
	$sqlb=$con->prepare($sql);
	$sqlb->bind_param('i',$arr['xid']);
	$sqlb->execute();
	$result=$sqlb->get_result();
	$data=[];
	if($result->num_rows > 0){
		while($row=$result->fetch_assoc()){
			$data[]=$row;
		}
		$arr['responce']=$data;
	}
}
 
echo json_encode($arr);


// $input=['j'=>1,'d'=>2,'t'=>3 ];

// function takes_array($input)
// {
    // echo "$input[j] + $input[d] = ", $input['j']+$input['d'];
// }

// takes_array($input);
