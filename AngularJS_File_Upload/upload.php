<?php  

function read(){
     echo "hi sumi";
}
function readb(){
     echo "hi jasir";
}
function olakka(){
     echo "olakka function runned";
}


 $connect = mysqli_connect("localhost", "root", "", "sumi");  
//  echo "hi sumi1";
//  echo "hi sumi2";
//  echo "hi sumi3";


 if(!empty($_FILES))  
 {  
     $path = 'upload/' . $_FILES['file']['name'];  
     // form_data.append('data', angular.toJson(daa));
     // echo $_POST['Fn']; 
     $obj =  json_decode( $_POST['data']);
     echo " object = ",$obj->Fname;
     echo " object = ",$obj->Sname;
     echo " object = ",$obj->age;

     if(move_uploaded_file($_FILES['file']['tmp_name'], $path))  
     {  
          $insertQuery = "INSERT INTO tbl_images(name) VALUES ('".$_FILES['file']['name']."')";  
          if(mysqli_query($connect, $insertQuery))  
          {  
          //  echo "$fname, File Uploaded";  
               echo " File Uploaded";  
          }  
          else  
          {  
          //  echo "$fname File Uploaded But not Saved";  
               echo "File Uploaded But not Saved";  
          }  
     }  
     //  echo "file got";
     //  echo " $obj hi";
 } 

 else  
 {  

     if(isset($_POST['data'])){
          $obj = json_decode( $_POST['data']);
          if ($obj->function == "readb"){
               read();
          }
          elseif($obj->function == "olakka"){
               olakka();
          }
          else{
               readb();
          }
          
     }
     else{
          // $obj = json_decode( $_POST['datas']);
          readb();
     }

     //echo $agesum;

     // if($obj->function == 'read' ){
     //      read();
     //      // echo " object = ",$obj->Fname;
     //      // echo " object = ",$obj->function;
     //      // echo " object = ",$obj->Sname;
     //      // echo " object = ",$obj->age;
     // }
     // else if($obj->function == 'readb'){
     //      readb();
     // }

     //  if(isset($_POST['data'])){
     //      // $_POST = array_merge($_POST, (array) json_decode(trim(file_get_contents('php://input')), true));
     //      // $firstname = $_REQUEST['firstname'];
     //      $data = $_POST['data'];
     //      //  echo "here is ur data $data ";  
     //      echo "data posted $data";
     //      $a =1;


     //  }
     //  echo "no file";
 }   

 ?> 