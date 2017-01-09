<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>title</title>
	
	<style>
		.btn{
			border:1px solid black;
			padding:10px;
			display:inline-block;
		}
	</style>
  </head>
  <body>
  
  XID:<br><input type="number" name="xid" id="xid" value="1"/><br>
  Name:<br><input type="text" name="name" id="name" value="tester"/><br>
  Company:<br><input type="text" name="company" id="company" value="company"/><br>
  Cost:<br><input type="number" name="cost" id="cost" value="10"/><br>
  <div class="btn" id="btn1">Add Data</div>
  <div class="btn" id="btn2">Get Data</div>
  <div id="output"></div>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
  <script>
  
  jQuery(document).ready(function(){
	    
	  $('#btn1').on('click',function(){
	  
		  var vars={
			 xid:$('#xid').val(),
			 name:$('#name').val(),
			 company:$('#company').val(),
			 cost:$('#cost').val(),
			  action:"ADD"
		  };
		  jQuery.ajax({
			  url:"api.php",
			  type:"POST",
			  data:vars,
			  dataType:"json"
		  }).done(function(data){
			  console.log(data);
			   var output='';
			  if(data.status=='added'){
				 output+="You added new item to the database <br>New database id is "+data.xid; 
				  $("#output").html(output);
			  }
			  if(data.status=='updated'){
				 output+="You updated new item to the database <br>XID= "+data.xid+
				 "<br>"; 
				  $("#output").html(output);
			  }
			 
		  }).fail(function(xhr,textstatus){
			  console.log(xhr);
			  console.log(textstatus);
		  })
		  
		  
	  });
	  
	  $('#btn2').on('click',function(){
	  
		  var vars={
			 xid:$('#xid').val(), 
			  action:"GET"
		  };
		  jQuery.ajax({
			  url:"api.php",
			  type:"GET",
			  data:vars,
			  dataType:"json"
		  }).done(function(data){
			  console.log(data);
			  var res=data.responce[0];
			  var output='';
			  if(res){
			 
				 output+="Output is id="+res.id+
				 "<br> xid="+res.xid+
				 "<br> cost="+res.cost+
				 "<br> name="+res.name+"<br> company="+res.company; 
			 
			  $("#output").html(output);
			  }
		  }).fail(function(xhr,textstatus){
			  console.log(xhr);
			  console.log(textstatus);
		  })
		  
		  
	  });
	  	  // $('#name').keypress(function(){
		 // console.dir($('#name').val()); 
		  // var name=$('#name').val();
		  
		  // jQuery.ajax({
			  // url:"api.php",
			  // type:"GET",
			  // dataType:"json"
		  // }).done(function(data){
			  // console.log(data);
		  // }).fail(function(xhr,textstatus){
			  // console.log(xhr);
			  // console.log(textstatus);
		  // })
		  
		 // console.dir($('#name').val()); 
			// });
	 // console.dir(name);
  });
  </script>
  </body>
</html>