<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiBuisiness extends CI_Controller 
{


	public function index()
	{

		
  }
  
    public function add_aboutbanner(){

    $user_id=123;
    $dt = new DateTime();
    $today= $dt->format('Y-m-d H:i:s');
    $post_data = $_POST['data'];
    $data = json_decode($post_data);
  //   print_r($data);
    // $biid = $data->biid;
    $target_dir  = "./upload/";
    $oldData = $this->db->get_where('tbl_business_images',array('vchr_delete_status' => 'ban'))->result();
    // echo count($oldData);
    // return;
    if(count($oldData) < 3){
    if(isset($_FILES['image'])){
            
            $files = $_FILES['image'];
            $config['upload_path']   = $target_dir;
            $config['allowed_types'] = 'jpeg|jpg|png';
            $config['max_size']    = 2000000000;
            $this->load->library('upload',$config);
            // echo $key;
            foreach ($_FILES['image']['name'] as $key => $value) 
            {
              $coun = $key;

            }
            if($coun + count($oldData) < 3){
            foreach ($_FILES['image']['name'] as $key => $value) 
            {
              $_FILES['images[]']['name']   =$files['name'][$key];
              $_FILES['images[]']['type']   =$files['type'][$key];
              $_FILES['images[]']['tmp_name'] =$files['tmp_name'][$key];
              $_FILES['images[]']['error']  =$files['error'][$key];
              $_FILES['images[]']['size']   =$files['size'][$key];
              $file_ext    = pathinfo($_FILES["images[]"]['name'], PATHINFO_EXTENSION);
              $file_name   = ($key+1).'_'.time().'.'.$file_ext;
              $config['file_name']  = $file_name;
              $this->upload->initialize($config);
              if($this->upload->do_upload('images[]'))
              {
              $insert_data1 = array('vchr_image_name'=>$file_name,'vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today,'vchr_delete_status' => 'ban');
              $this->db->insert('tbl_business_images', $insert_data1);
              }
            }
            echo 'Success:Success';
          }else{
            echo 'Failed to add';   
            return;
          }
          }
        }
          else
          {
           echo 'Failed to add';   
            return;
          }

  }
  public function select_aboutqtr_images()
  {
    $post_data = file_get_contents('php://input');
    $data = json_decode($post_data);
    $query = $this->db->query("SELECT pk_int_image_id,vchr_image_name FROM tbl_business_images 
    WHERE vchr_delete_status='ban'");
    $result = $query->result();
    header('Content-Type: application/json');
    $json_response = json_encode($result, JSON_NUMERIC_CHECK);
    echo $json_response;
  }
  public function delete_banner_image()
  {
  $user_id=123;
  $dt = new DateTime();
  $today= $dt->format('Y-m-d H:i:s');
  $post_data = file_get_contents('php://input');
  $data = json_decode($post_data);
  $banimg = $data->banimg;
   $update_data = array('vchr_delete_status' => 'd','vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today,
  );
  $this->db->where('pk_int_image_id', $banimg);
  if ($this->db->update('tbl_business_images', $update_data))
    {
       echo $banimg;
    }
    else
    {
      return 'Failed:Failed';
    }
  }
  public function add_password_details()
{
  // session_start();
  $dt = new DateTime();
  $user_id=1;
  // echo($user_id);return;
  $today= $dt->format('Y-m-d H:i:s');
  $post_data = file_get_contents('php://input');
  // print_r($post_data);return;
  $data = json_decode($post_data);
        $max=0;
        $this->db->select_max('pk_int_user_id');
        $max_query=$this->db->get('tbl_user');
        $max =$max_query->row();
        $max=(int)$max->pk_int_user_id+1;
        // echo($max);return;
        $oldData = $this->db->get_where('tbl_user',array('pk_int_user_id' => $user_id,'vchr_delete_status'=>'n'))->result()[0];
        // print_r($oldData);return;
//  $update_data = array('vchr_delete_status' => 'm','pk_int_user_id' => $max,'vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today);
 $update_data = array('pk_int_user_id'=>$user_id,'vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today,
    'vchr_user_name' => $oldData->vchr_user_name,'vchr_user_password' => $data->password);
  
  $this->db->where('pk_int_user_id', $user_id);
//   $this->db->update('tbl_user', $update_data);
// print_r($update_data);return;

    //     $max=0;
    //     $this->db->select_max('pk_int_user_id');
    //     $max_query=$this->db->get('tbl_user');
    //     $max =$max_query->row();
    //     $max=(int)$max->pk_int_user_id+1;
       
    //     $insert_data = array('pk_int_user_id'=>$user_id,'vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today,
    // 'vchr_user_name' => $oldData->vchr_user_name,'vchr_user_password' => $data->password);
    
        if($this->db->update('tbl_user', $update_data))
        {
          echo 'Success:Success';
        }
        else
        {
         echo 'Nothing/Failed to edit';   
          return;
        }
   
}
public function get_user()
{
  $id=1;
  $query = $this->db->query("SELECT vchr_user_name,vchr_user_password FROM tbl_user WHERE vchr_delete_status='n' and pk_int_user_id = $id");
    $result = $query->result();
    $json_response = json_encode($result, JSON_NUMERIC_CHECK);
    echo $json_response;
}
public function add_enquiry()
{
  $dt = new DateTime();
  $user_id=123;
  // echo "$user_id";return;
  $today= $dt->format('Y-m-d H:i:s');
  $post_data = file_get_contents('php://input');
  $data = json_decode($post_data);
  // print_r($post_data);return;
  $insert_address =array('vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today,'vchr_name' => $data->name,'int_phone' => $data->phone,'vchr_subject' => $data->subject,'vchr_email' => $data->email,'vchr_message' => $data->message);
  if($this->db->insert('tbl_enquiry', $insert_address))
  {
  echo 'Success : success';
  }
  else
  {
    echo 'Failed : Failed';
  }
}
public function get_enquiry()
{
    $query = $this->db->query("SELECT * FROM tbl_enquiry WHERE vchr_delete_status='n'");
    $result = $query->result();
    $json_response = json_encode($result, JSON_NUMERIC_CHECK);
    echo $json_response;
}
public function add_home()
{
  $dt = new DateTime();
  $user_id=123;
  // echo "$user_id";return;
  $today= $dt->format('Y-m-d H:i:s');
  $post_data = file_get_contents('php://input');
  $data = json_decode($post_data);
  // print_r($post_data);return;
  $insert_address =array('vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today,'vchr_home_name' => $data->name,'vchr_home_name_ar' => $data->namear,'text_home_desc' => $data->desc,'text_home_desc_ar' => $data->descar);
  if($this->db->insert('tbl_home_section', $insert_address))
  {
  echo 'Success : success';
  }
  else
  {
    echo 'Failed : Failed';
  }
}
public function get_home()
{
  $post_data = file_get_contents('php://input');
  $data = json_decode($post_data);
  $token = $data->token;
  if ($token == "token") 
  {
    $query = $this->db->query("SELECT * FROM tbl_home_section WHERE vchr_delete_status='n'");
    $result = $query->result();
    header('Content-Type: application/json');
    $json_response = json_encode($result, JSON_NUMERIC_CHECK);
    echo $json_response;
  }
}
public function get_current_home()
{
  $post_data = file_get_contents('php://input');
  $data = json_decode($post_data);
  $aid = $data->id;
  $query = $this->db->query("SELECT * FROM tbl_home_section WHERE vchr_delete_status='n' and pk_int_home_id = $aid");
    $result = $query->result();
    $json_response = json_encode($result, JSON_NUMERIC_CHECK);
    echo $json_response;
}
public function edit_home()
  {
    // session_start();
    $dt = new DateTime();
    // $_SESSION['username']=123;
    $user_id=123;
  $today= $dt->format('Y-m-d H:i:s');
  $post_data = file_get_contents('php://input');
  $data = json_decode($post_data);
  $id = $data->id;

        $max=0;
        $this->db->select_max('pk_int_home_id');
        $max_query=$this->db->get('tbl_home_section');
        $max =$max_query->row();
        $max=(int)$max->pk_int_home_id+1;
  $oldData = $this->db->get_where('tbl_home_section',array("pk_int_home_id" => $id))->result()[0];
  $update_data = array('vchr_delete_status' => 'm','pk_int_home_id' => $max,'vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today);
  
  $this->db->where('pk_int_home_id', $id);
  $this->db->update('tbl_home_section', $update_data);
  
        $insert_data = array('pk_int_home_id'=>$id,'vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today,'vchr_home_name' => $data->name,'vchr_home_name_ar' => $data->namear,'text_home_desc' => $data->desc,'text_home_desc_ar' => $data->descar);
        if($this->db->insert('tbl_home_section', $insert_data)){
        echo 'Success:Success';
        }
        else
        {
         echo 'Nothing/Failed to edit';   
          return;
        }
   
    
    
  }
public function select_current_enquiry()
        {
        $post_data = file_get_contents('php://input');
        $data = json_decode($post_data);
        $id = $data->id;
        // echo "$id";return;
        $query = $this->db->query("SELECT * FROM tbl_enquiry WHERE vchr_delete_status='n' AND pk_int_enquiry_id = $id ");
        $result = $query->result();
        $json_response = json_encode($result, JSON_NUMERIC_CHECK);
        echo $json_response;
        }
        
        
        
        
        
        
        
        
        
        
 
        
        
        
public function add_Buisiness()
  {
  // session_start();
  $flagfor = true;

  $dt = new DateTime();
  $user_id=123;
  $today= $dt->format('Y-m-d H:i:s');
  $post_data = $_POST['data'];
  // $post_data = file_get_contents('php://input');
  $data = json_decode($post_data);
  // print_r($data);return;
  $target_dir  = "./upload/";
  $target_dir_pdf  = "./upload/buipdf";
  $insert_address =array(
    'vchr_last_modified_by'=>$user_id,
    'vchr_last_modified_time'=>$today,
    'int_pincode' => $data->pincode,
    'vchr_city' => $data->city,
    'vchr_state' => $data->state,
    'vchr_state_ar' => $data->statear,
    'int_mobile' => $data->mobile,
    'int_alt_mobile' => $data->alt_mobile,
    'vchr_email' => $data->email
  );
  $this->db->insert('tbl_address', $insert_address);// uncom,ment this
    $max=0;
    $this->db->select_max('pk_int_address_id');
    $max_query=$this->db->get('tbl_address');
    $max =$max_query->row();
    $max=(int)$max->pk_int_address_id;
    // echo "$max";return;
    
    // if ($data->featured == true){
        // $featured = 1;
    // }else{
    //     $featured = 0;
    // }
    
  $insert_data = array(
    'vchr_last_modified_by'=>$user_id,
    'vchr_last_modified_time'=>$today,
    'vchr_name' => $data->name,
    'vchr_name_ar' =>$data->namear, // gettype($data->featured),//$data->namear
    'fk_int_address_id' => $max,
    'fk_int_category_id' => $data->cat,
    'fk_int_location_id' => $data->locatn,
    'text_description' => $data->desc,
    'text_description_ar' => $data->descar,
    'vchr_weburl' => $data->weburl,
    'vchr_video_link' => $data->videolink,  // video link
    'vchr_cls_time' => $data->clstime,
    'vchr_opn_time' => $data->opntime,
    'float_lat' => $data->lat,
    'float_log' => $data->log,
    'vchr_status' => $data->stat,
    'vchr_tag' => $data->tag,
    'int_isfeatured' =>$data->featured,
    );
    $flagimg = true;
    $this->db->insert('tbl_business', $insert_data);  //uncomment this


    if(isset($_FILES['image'])&&isset($_FILES['pdf']))
    {          
        $flagfor = false;

        if(true){
        $files1 = $_FILES['pdf'];
        $config['upload_path']   = $target_dir_pdf;
        $config['allowed_types'] = 'jpeg|jpg|png|pdf|doc|docx';
        $config['max_size']    = 2000000000;
        $this->load->library('upload',$config);
    
        foreach ($_FILES['pdf']['name'] as $key => $value) 
        {
        $_FILES['images[]']['name']   =$files1['name'][$key];
        $_FILES['images[]']['type']   =$files1['type'][$key];
        $_FILES['images[]']['tmp_name'] =$files1['tmp_name'][$key];
        $_FILES['images[]']['error']  =$files1['error'][$key];
        $_FILES['images[]']['size']   =$files1['size'][$key];
        // echo($_FILES['images[]']['size']);return;
        $file_ext1    = pathinfo($_FILES["images[]"]['name'], PATHINFO_EXTENSION);
        $file_name1  = ($key+1).'_'.time().'.'.$file_ext1;
        $config['file_name']  = $file_name1;
        $this->upload->initialize($config);
        $this->upload->do_upload('images[]');
        
        }
    }


                $files = $_FILES['image'];
                $config['upload_path']   = $target_dir;
                $config['allowed_types'] = 'jpeg|jpg|png';
                // $config['max_size']    = 2000000000;
                $this->load->library('upload',$config);
                foreach ($_FILES['image']['name'] as $key => $value) 
                {
                $_FILES['images[]']['name']   =$files['name'][$key];
                $_FILES['images[]']['type']   =$files['type'][$key];
                $_FILES['images[]']['tmp_name'] =$files['tmp_name'][$key];
                $_FILES['images[]']['error']  =$files['error'][$key];
                $_FILES['images[]']['size']   =$files['size'][$key];
                $size = $_FILES['images[]']['size'];
                    // echo "$size";return;
                if($size < 5000000){
                $flagimg = true;
                }
                if (($size > 5000000)||($size < 1)) {
                    $flagimg = false;break;
                    // echo "$size";return;
                }
                
                }
    if ($flagimg) {
        if (true)
            {
                $max=0;
                $this->db->select_max('pk_int_business_id');
                $max_query=$this->db->get('tbl_business');
                $max =$max_query->row();
                $max=(int)$max->pk_int_business_id;
                $files = $_FILES['image'];
                $config['upload_path']   = $target_dir;
                $config['allowed_types'] = 'jpeg|jpg|png';
                $config['max_size']    = 2000000000;
                $this->load->library('upload',$config);
                foreach ($_FILES['image']['name'] as $key => $value) 
                {
                $_FILES['images[]']['name']   =$files['name'][$key];
                $_FILES['images[]']['type']   =$files['type'][$key];
                $_FILES['images[]']['tmp_name'] =$files['tmp_name'][$key];
                $_FILES['images[]']['error']  =$files['error'][$key];
                $_FILES['images[]']['size']   =$files['size'][$key];
                // echo($_FILES['images[]']['size']);return;
                $file_ext    = pathinfo($_FILES["images[]"]['name'], PATHINFO_EXTENSION);
                $file_name   = ($key+1).'_'.time().'.'.$file_ext;
                $config['file_name']  = $file_name;
                $this->upload->initialize($config);
                if($this->upload->do_upload('images[]'))
                {
                    $insert_data1 = array('fk_int_business_id'=>$max,'vchr_image_name'=>$file_name,'vchr_pdf'=>$file_name1,'vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today);
                    $this->db->insert('tbl_business_images', $insert_data1);
                }
                }
            }
            else
            {
                echo 'Failed : Failed';
            }
    }
    else
        {echo "image size donot exceed 5 mb";}
    }

  // second
    if(isset($_FILES['image'])&& $flagfor)
    {          

                $files = $_FILES['image'];
                $config['upload_path']   = $target_dir;
                $config['allowed_types'] = 'jpeg|jpg|png';
                // $config['max_size']    = 2000000000;
                $this->load->library('upload',$config);
                foreach ($_FILES['image']['name'] as $key => $value) 
                {
                    $_FILES['images[]']['name']   =$files['name'][$key];
                    $_FILES['images[]']['type']   =$files['type'][$key];
                    $_FILES['images[]']['tmp_name'] =$files['tmp_name'][$key];
                    $_FILES['images[]']['error']  =$files['error'][$key];
                    $_FILES['images[]']['size']   =$files['size'][$key];
                    $size = $_FILES['images[]']['size'];
                        // echo "$size";return;
                    if($size < 5000000){
                    $flagimg = true;
                    }
                    if (($size > 5000000)||($size < 1)) {
                        $flagimg = false;break;
                        // echo "$size";return;
                    }
                
                }
    if ($flagimg) {
        if (true)
            {
                $max=0;
                $this->db->select_max('pk_int_business_id');
                $max_query=$this->db->get('tbl_business');
                $max =$max_query->row();
                $max=(int)$max->pk_int_business_id;
                $files = $_FILES['image'];
                $config['upload_path']   = $target_dir;
                $config['allowed_types'] = 'jpeg|jpg|png';
                $config['max_size']    = 2000000000;
                $this->load->library('upload',$config);
                foreach ($_FILES['image']['name'] as $key => $value) 
                {
                $_FILES['images[]']['name']   =$files['name'][$key];
                $_FILES['images[]']['type']   =$files['type'][$key];
                $_FILES['images[]']['tmp_name'] =$files['tmp_name'][$key];
                $_FILES['images[]']['error']  =$files['error'][$key];
                $_FILES['images[]']['size']   =$files['size'][$key];
                // echo($_FILES['images[]']['size']);return;
                $file_ext    = pathinfo($_FILES["images[]"]['name'], PATHINFO_EXTENSION);
                $file_name   = ($key+1).'_'.time().'.'.$file_ext;
                $config['file_name']  = $file_name;
                $this->upload->initialize($config);
                if($this->upload->do_upload('images[]'))
                {
                    $insert_data1 = array('fk_int_business_id'=>$max,'vchr_image_name'=>$file_name,'vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today);
                    $this->db->insert('tbl_business_images', $insert_data1);// uncomment this
                }
                }
            }
            else
            {
                echo 'Failed : Failed';
            }
    }
    else
        {echo "image size donot exceed 5 mb";}
    }
  // third
    if(isset($_FILES['pdf']) && $flagfor)
    {          

        if(true){
            $max=0;
                $this->db->select_max('pk_int_business_id');
                $max_query=$this->db->get('tbl_business');
                $max =$max_query->row();
                $max=(int)$max->pk_int_business_id;
        $files1 = $_FILES['pdf'];
        $config['upload_path']   = $target_dir_pdf;
        $config['allowed_types'] = 'jpeg|jpg|png|pdf|doc|docx';
        $config['max_size']    = 2000000000;
        $this->load->library('upload',$config);
    
        foreach ($_FILES['pdf']['name'] as $key => $value) 
        {
        $_FILES['images[]']['name']   =$files1['name'][$key];
        $_FILES['images[]']['type']   =$files1['type'][$key];
        $_FILES['images[]']['tmp_name'] =$files1['tmp_name'][$key];
        $_FILES['images[]']['error']  =$files1['error'][$key];
        $_FILES['images[]']['size']   =$files1['size'][$key];
        // echo($_FILES['images[]']['size']);return;
        $file_ext1    = pathinfo($_FILES["images[]"]['name'], PATHINFO_EXTENSION);
        $file_name1  = ($key+1).'_'.time().'.'.$file_ext1;
        $config['file_name']  = $file_name1;
        $this->upload->initialize($config);
        if($this->upload->do_upload('images[]'))
        {
            $insert_data1 = array('fk_int_business_id'=>$max,'vchr_pdf'=>$file_name1,'vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today);
            $this->db->insert('tbl_business_images', $insert_data1);
        }
        
        }
    }
    
    }
  

  echo 'Success : success';
  // echo 'Success : success, ',$insert_data;
  // $json_response = json_encode($insert_data, JSON_NUMERIC_CHECK);
  // echo $json_response;
  }














public function update_Buisiness()
  {
    // session_start();
    $target_dir_pdf  = "./upload/buipdf";
    $dt = new DateTime();
    // $_SESSION['username']=$_SESSION['pk_int_user_id'];
    $user_id=123;
  $today= $dt->format('Y-m-d H:i:s');
  $post_data = $_POST['data'];
  // $post_data = file_get_contents('php://input');
  $data = json_decode($post_data);
  // print_r($data);return;
  $target_dir  = "./upload/";
  $bid = $data->bid;
  $aid = $data->aid;
  $file_name=$data->img;
  $file_name1=$data->pdf;

    $max=0;
    $this->db->select_max('pk_int_business_id');
    $max_query=$this->db->get('tbl_business');
    $max =$max_query->row();
    $max=(int)$max->pk_int_business_id+1;
  // $oldData = $this->db->get_where('tbl_business',array("pk_int_business_id" => $bid))->result()[0];
  $update_data = array('vchr_delete_status' => 'm','pk_int_business_id' => $max,'vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today);
  $this->db->where('pk_int_business_id', $bid);
  $this->db->update('tbl_business', $update_data);
    $maxa=0;
    $this->db->select_max('pk_int_address_id');
    $maxa_query=$this->db->get('tbl_address');
    $maxa =$maxa_query->row();
    $maxa=(int)$maxa->pk_int_address_id+1;
  $oldData_addr = $this->db->get_where('tbl_address',array("pk_int_address_id" => $aid))->result()[0];
  $update_data_addr = array('vchr_delete_status' => 'm','pk_int_address_id' => $maxa,'vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today);
  $this->db->where('pk_int_address_id', $aid);
  $this->db->update('tbl_address', $update_data_addr);
        $insert_data = array(
          'pk_int_business_id'=>$bid,
          'vchr_last_modified_by'=>$user_id,
          'vchr_last_modified_time'=>$today,
          'vchr_name' => $data->name,
          'vchr_name_ar' => $data->namear,
          'fk_int_address_id' => $aid,
          'fk_int_category_id' => $data->cat,
          'fk_int_location_id' => $data->locatn,
          'text_description' => $data->desc,
          'text_description_ar' => $data->descar,
          'vchr_weburl' => $data->weburl,
          'vchr_video_link' => $data->videolink,  // video link
          'vchr_cls_time' => $data->clstime,
          'vchr_opn_time' => $data->opntime,
          'float_log' => $data->log,
          'float_lat' => $data->lat,
          'vchr_status' => $data->stat,
          'vchr_tag' => $data->tag,
    'int_isfeatured' =>$data->featured,

        //   'int_isfeatured' =>$data->featured,
        );

        $insert_data_addr = array('pk_int_address_id'=>$aid,'vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today,
        'int_pincode' => $data->pincode,'vchr_city' => $data->city,'vchr_state' => $data->state,'vchr_state_ar' => $data->statear,'int_mobile' => $data->mobile,'int_alt_mobile' => $data->alt_mobile,'vchr_email' => $data->email);
        $this->db->insert('tbl_address', $insert_data_addr);
        // $this->db->insert('tbl_business', $insert_data);
        $flagimg = true;
        $singleentry = true;
        if(isset($_FILES['image'])&&isset($_FILES['pdf']))
        {
              $singleentry=false;
              $files = $_FILES['image'];
              $config['upload_path']   = $target_dir;
              $config['allowed_types'] = 'jpeg|jpg|png';
              // $config['max_size']    = 2000000000;
              $this->load->library('upload',$config);
              foreach ($_FILES['image']['name'] as $key => $value) 
              {
                $_FILES['images[]']['name']   =$files['name'][$key];
                $_FILES['images[]']['type']   =$files['type'][$key];
                $_FILES['images[]']['tmp_name'] =$files['tmp_name'][$key];
                $_FILES['images[]']['error']  =$files['error'][$key];
                $_FILES['images[]']['size']   =$files['size'][$key];
                $size = $_FILES['images[]']['size'];
                  // echo "$size";return;
                if($size < 5000000){
                $flagimg = true;
                }
                if (($size > 5000000)||($size < 1)) {
                  $flagimg = false;break;
                  // echo "$size";return;
                }
                
              }
            }
        if(isset($_FILES['image']) && $singleentry)
        {
              $files = $_FILES['image'];
              $config['upload_path']   = $target_dir;
              $config['allowed_types'] = 'jpeg|jpg|png';
              // $config['max_size']    = 2000000000;
              $this->load->library('upload',$config);
              foreach ($_FILES['image']['name'] as $key => $value) 
              {
                $_FILES['images[]']['name']   =$files['name'][$key];
                $_FILES['images[]']['type']   =$files['type'][$key];
                $_FILES['images[]']['tmp_name'] =$files['tmp_name'][$key];
                $_FILES['images[]']['error']  =$files['error'][$key];
                $_FILES['images[]']['size']   =$files['size'][$key];
                $size = $_FILES['images[]']['size'];
                  // echo "$size";return;
                if($size < 5000000){
                $flagimg = true;
                }
                if (($size > 5000000)||($size < 1)) {
                  $flagimg = false;break;
                  // echo "$size";return;
                }
                
              }
            }
  if ($flagimg) {
      if($this->db->insert('tbl_business', $insert_data))
      {
        if (isset($_FILES['image']) && $singleentry) 
        {
            $delete_old_img = array('vchr_delete_status' => 'd','vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today);
            $this->db->where('fk_int_business_id', $bid);
            $this->db->update('tbl_business_images', $delete_old_img);             
            $files = $_FILES['image'];
            $config['upload_path']   = $target_dir;
            $config['allowed_types'] = 'jpeg|jpg|png';
            $config['max_size']    = 2000000000;
            $this->load->library('upload',$config);
            foreach ($_FILES['image']['name'] as $key => $value) 
            {
              $_FILES['images[]']['name']   =$files['name'][$key];
              $_FILES['images[]']['type']   =$files['type'][$key];
              $_FILES['images[]']['tmp_name'] =$files['tmp_name'][$key];
              $_FILES['images[]']['error']  =$files['error'][$key];
              $_FILES['images[]']['size']   =$files['size'][$key];
              $file_ext    = pathinfo($_FILES["images[]"]['name'], PATHINFO_EXTENSION);
              $file_name   = ($key+1).'_'.time().'.'.$file_ext;
              $config['file_name']  = $file_name;
              $this->upload->initialize($config);
              if($this->upload->do_upload('images[]'))
              {

                $insert_data1 = array('fk_int_business_id'=>$bid,'vchr_image_name'=>$file_name,'vchr_pdf'=>$file_name1,'vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today);
                $this->db->insert('tbl_business_images', $insert_data1);
              }
            }
        }   
        if (isset($_FILES['pdf']) && $singleentry) 
        {
            $delete_old_img = array('vchr_delete_status' => 'd','vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today);
            $this->db->where('fk_int_business_id', $bid);
            $this->db->update('tbl_business_images', $delete_old_img);  

            // pdf up
            $files1 = $_FILES['pdf'];
            $config['upload_path']   = $target_dir_pdf;
            $config['allowed_types'] = 'jpeg|jpg|png|pdf|doc|docx';
            $config['max_size']    = 2000000000;
            $this->load->library('upload',$config);
          
            foreach ($_FILES['pdf']['name'] as $key => $value) 
            {
              $_FILES['images[]']['name']   =$files1['name'][$key];
              $_FILES['images[]']['type']   =$files1['type'][$key];
              $_FILES['images[]']['tmp_name'] =$files1['tmp_name'][$key];
              $_FILES['images[]']['error']  =$files1['error'][$key];
              $_FILES['images[]']['size']   =$files1['size'][$key];
              // echo($_FILES['images[]']['size']);return;
              $file_ext1    = pathinfo($_FILES["images[]"]['name'], PATHINFO_EXTENSION);
              $file_name1  = ($key+1).'_'.time().'.'.$file_ext1;
              $config['file_name']  = $file_name1;
              $this->upload->initialize($config);
             if( $this->upload->do_upload('images[]')){
              $insert_data1 = array('fk_int_business_id'=>$bid,'vchr_image_name'=>$file_name,'vchr_pdf'=>$file_name1,'vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today);
              $this->db->insert('tbl_business_images', $insert_data1);
             }
            }
        }
            if (isset($_FILES['image'])&&isset($_FILES['pdf'])) 
            {
                $delete_old_img = array('vchr_delete_status' => 'd','vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today);
                $this->db->where('fk_int_business_id', $bid);
                $this->db->update('tbl_business_images', $delete_old_img);             
                $files = $_FILES['image'];
                $config['upload_path']   = $target_dir;
                $config['allowed_types'] = 'jpeg|jpg|png';
                $config['max_size']    = 2000000000;
                $this->load->library('upload',$config);
                foreach ($_FILES['image']['name'] as $key => $value) 
                {
                  $_FILES['images[]']['name']   =$files['name'][$key];
                  $_FILES['images[]']['type']   =$files['type'][$key];
                  $_FILES['images[]']['tmp_name'] =$files['tmp_name'][$key];
                  $_FILES['images[]']['error']  =$files['error'][$key];
                  $_FILES['images[]']['size']   =$files['size'][$key];
                  $file_ext    = pathinfo($_FILES["images[]"]['name'], PATHINFO_EXTENSION);
                  $file_name   = ($key+1).'_'.time().'.'.$file_ext;
                  $config['file_name']  = $file_name;
                  $this->upload->initialize($config);
                  if($this->upload->do_upload('images[]'))
                  {
                    // pdf up
                    $files1 = $_FILES['pdf'];
                    $config['upload_path']   = $target_dir_pdf;
                    $config['allowed_types'] = 'jpeg|jpg|png|pdf|doc|docx';
                    $config['max_size']    = 2000000000;
                    $this->load->library('upload',$config);
                  
                    foreach ($_FILES['pdf']['name'] as $key => $value) 
                    {
                      $_FILES['images[]']['name']   =$files1['name'][$key];
                      $_FILES['images[]']['type']   =$files1['type'][$key];
                      $_FILES['images[]']['tmp_name'] =$files1['tmp_name'][$key];
                      $_FILES['images[]']['error']  =$files1['error'][$key];
                      $_FILES['images[]']['size']   =$files1['size'][$key];
                      // echo($_FILES['images[]']['size']);return;
                      $file_ext1    = pathinfo($_FILES["images[]"]['name'], PATHINFO_EXTENSION);
                      $file_name1  = ($key+1).'_'.time().'.'.$file_ext1;
                      $config['file_name']  = $file_name1;
                      $this->upload->initialize($config);
                      $this->upload->do_upload('images[]');
                      
                    }

                    $insert_data1 = array('fk_int_business_id'=>$bid,'vchr_image_name'=>$file_name,'vchr_pdf'=>$file_name1,'vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today);
                    $this->db->insert('tbl_business_images', $insert_data1);
                  }
                }
            }   
        echo 'Success:Success';
        }
        else
        {
         echo 'Nothing/Failed to edit';   
          return;
        }
      }
    else
    {echo "image size donot exceed 5 mb";}

  }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
public function check_brand() {
    $post_data = file_get_contents('php://input');
    $data = json_decode($post_data);
    $brand = $data->brand;
    $myCond = (isset($data->brand_id)&&$data->brand_id != '')?"and pk_int_brand_id != $data->brand_id":"";
    $query = $this->db->query("SELECT pk_int_brand_id FROM tbl_brand WHERE  vchr_delete_status='s' and vchr_brand_name='$brand' $myCond");
    echo json_encode(array("count" => $query->num_rows(),"q" => "SELECT pk_int_brand_id FROM tbl_brand WHERE  vchr_delete_status='s' and vchr_brand_name='$brand' $myCond"));
    }


        
public function count_featured(){
  $post_data = file_get_contents('php://input');
  $data = json_decode($post_data);

  if ($data->token == "token" ){
    $location = $data->location;
    $condition="AND fk_int_location_id = $location";
    $query = $this->db->query("
    
    SELECT COUNT(pk_int_business_id) AS loc_cnt
    FROM tbl_business 
    WHERE tbl_business.vchr_delete_status='n' AND tbl_business.fk_int_location_id =$location AND tbl_business.int_isfeatured =1
    ");


    $result = $query->result();
    
    $json_response = json_encode($result, JSON_NUMERIC_CHECK);

    echo $json_response;
  }

  // $insert_data = array(
  //     'int_isfeatured' => $featured,
  // );

  // $query = $this->db->insert('tbl_business', $insert_data);
  // $result = $query->result();

  // $json_response = json_encode($result, JSON_NUMERIC_CHECK);
  // echo $json_response;
}    
           

public function select_Buisiness()
{
  $post_data = file_get_contents('php://input');
  $data = json_decode($post_data);
  // print_r($data);return;
  $condition="";
  $token = $data->token;
  // echo "$token";return;
  if ($token == "token") {
  if(isset($data->locationid))
  {
    $location = $data->locationid;
    $condition="AND fk_int_location_id = $location";
    // echo "123";return;
  }
  
  if(isset($data->searchtext))
  {
  //   $location = $data->locationid;
    $text = $data->searchtext;
    $condition="AND (vchr_tag LIKE '%$text%' OR vchr_name LIKE '%$text%') "; 
  //   $condition=""; 
  }
  
  if(isset($data->locationid)&&isset($data->searchtext))
  {
    $location = $data->locationid;
    $text = $data->searchtext;
  //   $condition="AND vchr_tag LIKE '%$text%' OR vchr_name LIKE '%$text%' ";
    $condition="AND fk_int_location_id = $location AND vchr_name LIKE '%$text%'"; 
  }
  if(isset($data->locationid)&&isset($data->catid)) 
  {
    $location = $data->locationid;
    $cat = $data->catid;
    $condition="AND fk_int_location_id = $location AND fk_int_category_id = $cat ";
  }
  
  $query = $this->db->query("
    SELECT 
      int_isfeatured,
      vchr_tag,
      vchr_name,
      vchr_status,
      vchr_name_ar,
      text_description_ar,
      vchr_state_ar,
      int_mobile,
      float_lat,
      float_log,
      text_description,
      vchr_weburl,
      vchr_video_link,
      vchr_cls_time,
      vchr_opn_time,
      vchr_image_name,
      vchr_pdf,
      vchr_city,
      fk_int_address_id,
      pk_int_business_id,
      fk_int_location_id,
      vchr_category_name,
      float_latitude,
      float_longitude,
      vchr_email,
      fk_int_category_id,
      vchr_location_name 
    FROM tbl_business 
    JOIN ( SELECT * FROM tbl_location WHERE vchr_delete_status='n' ) tbl_location ON tbl_business.fk_int_location_id = tbl_location.pk_int_location_id
    JOIN ( SELECT * FROM tbl_category WHERE vchr_delete_status='n' ) tbl_category ON tbl_business.fk_int_category_id = tbl_category.pk_int_category_id
    JOIN ( SELECT * FROM tbl_address WHERE vchr_delete_status='n' ) tbl_address ON tbl_business.fk_int_address_id = tbl_address.pk_int_address_id 
    left join (SELECT vchr_image_name,vchr_pdf,fk_int_business_id FROM tbl_business_images WHERE vchr_delete_status='n' group by fk_int_business_id) tbl_business_images on tbl_business.pk_int_business_id = tbl_business_images.fk_int_business_id
    WHERE tbl_business.vchr_delete_status='n' $condition  ORDER BY vchr_name");


  $result = $query->result();

  // $result_all = [ {"data":$result }, {"featured":$featured_result} ];
  header('Content-Type: application/json');
  // echo $json_response;

  $json_response = json_encode($result, JSON_NUMERIC_CHECK);

  echo $json_response;
  
  }
}

public function select_Buisiness_with_type()
{
  $post_data = file_get_contents('php://input');
  $data = json_decode($post_data);
  // print_r($data);return;
  $condition="";
  $token = $data->token;
  // echo "$token";return;
  if ($token == "token") {
  if(isset($data->locationid))
  {
    $location = $data->locationid;
    $condition="AND fk_int_location_id = $location";
    // echo "123";return;
  }
  
  $query = $this->db->query("
    SELECT 
      int_isfeatured,
      vchr_tag,
      vchr_name,
      vchr_status,
      vchr_name_ar,
      text_description_ar,
      vchr_state_ar,
      int_mobile,
      float_lat,
      float_log,
      text_description,
      vchr_weburl,
      vchr_video_link,
      vchr_cls_time,
      vchr_opn_time,
      vchr_image_name,
      vchr_pdf,
      vchr_city,
      fk_int_address_id,
      pk_int_business_id,
      fk_int_location_id,
      vchr_category_name,
      float_latitude,
      float_longitude,
      vchr_email,
      fk_int_category_id,
      vchr_location_name 
    FROM tbl_business 
    JOIN ( SELECT * FROM tbl_location WHERE vchr_delete_status='n' ) tbl_location ON tbl_business.fk_int_location_id = tbl_location.pk_int_location_id
    JOIN ( SELECT * FROM tbl_category WHERE vchr_delete_status='n' ) tbl_category ON tbl_business.fk_int_category_id = tbl_category.pk_int_category_id
    JOIN ( SELECT * FROM tbl_address WHERE vchr_delete_status='n' ) tbl_address ON tbl_business.fk_int_address_id = tbl_address.pk_int_address_id 
    left join (SELECT vchr_image_name,vchr_pdf,fk_int_business_id FROM tbl_business_images WHERE vchr_delete_status='n' group by fk_int_business_id)
    tbl_business_images on tbl_business.pk_int_business_id = tbl_business_images.fk_int_business_id
    WHERE tbl_business.vchr_delete_status='n' $condition  ORDER BY vchr_name");


  $result = $query->result();

  $featured_query = $this->db->query("
    SELECT 
      int_isfeatured,
      vchr_tag,
      vchr_name,
      vchr_status,
      vchr_name_ar,
      text_description_ar,
      vchr_state_ar,
      int_mobile,
      float_lat,
      float_log,
      text_description,
      vchr_weburl,
      vchr_video_link,
      vchr_cls_time,
      vchr_opn_time,
      vchr_image_name,
      vchr_pdf,
      vchr_city,
      fk_int_address_id,
      pk_int_business_id,
      fk_int_location_id,
      vchr_category_name,
      float_latitude,
      float_longitude,
      vchr_email,
      fk_int_category_id,
      vchr_location_name 
    FROM tbl_business 
    JOIN ( SELECT * FROM tbl_location WHERE vchr_delete_status='n' ) tbl_location ON tbl_business.fk_int_location_id = tbl_location.pk_int_location_id
    JOIN ( SELECT * FROM tbl_category WHERE vchr_delete_status='n' ) tbl_category ON tbl_business.fk_int_category_id = tbl_category.pk_int_category_id
    JOIN ( SELECT * FROM tbl_address WHERE vchr_delete_status='n' ) tbl_address ON tbl_business.fk_int_address_id = tbl_address.pk_int_address_id 
    left join (SELECT vchr_image_name,vchr_pdf,fk_int_business_id FROM tbl_business_images WHERE vchr_delete_status='n' group by fk_int_business_id) tbl_business_images on tbl_business.pk_int_business_id = tbl_business_images.fk_int_business_id
    WHERE tbl_business.vchr_delete_status='n'  $condition AND tbl_business.int_isfeatured = 1  ORDER BY vchr_name");

  $featured_result = $featured_query -> result() ;
  header('Content-Type: application/json');
  $a = array("data"=>$result, "featured"=>$featured_result);

  $json_response = json_encode($a, JSON_NUMERIC_CHECK);

  echo $json_response;
  
  }
}





public function get_listing_type()
  {
  $query = $this->db->query("SELECT pk_int_location_id,vchr_location_name,vchr_location_name_ar FROM tbl_location WHERE vchr_delete_status='n'");
  $result = $query->result();
  $json_response = json_encode($result, JSON_NUMERIC_CHECK);
  echo $json_response;
  } 



public function select_business_images()
        {
          $post_data = file_get_contents('php://input');
          $data = json_decode($post_data);
          $id = $data->id;
          $condition="AND fk_int_business_id = $id";
          $query = $this->db->query("SELECT pk_int_image_id,vchr_image_name FROM tbl_business join (SELECT pk_int_image_id,vchr_image_name,fk_int_business_id FROM tbl_business_images WHERE vchr_delete_status='n') tbl_business_images on tbl_business.pk_int_business_id = tbl_business_images.fk_int_business_id
          WHERE tbl_business.vchr_delete_status='n' $condition");
          $result = $query->result();
          header('Content-Type: application/json');
          $json_response = json_encode($result, JSON_NUMERIC_CHECK);
          echo $json_response;
        }
public function select_current_Buisiness()
        {
        $post_data = file_get_contents('php://input');
        $data = json_decode($post_data);
        $id = $data->id;
        $query = $this->db->query("SELECT int_isfeatured,vchr_tag,vchr_image_name,vchr_pdf,vchr_status,vchr_name_ar,text_description_ar,vchr_state_ar,float_lat,float_log,text_description,vchr_weburl,vchr_video_link, vchr_cls_time,vchr_opn_time,vchr_name,int_pincode,vchr_city,vchr_state,int_mobile,vchr_email,int_alt_mobile,fk_int_address_id,pk_int_business_id,pk_int_address_id,fk_int_location_id,fk_int_category_id,vchr_category_name,vchr_location_name FROM tbl_business 
          JOIN ( SELECT * FROM tbl_address WHERE vchr_delete_status='n' ) tbl_address ON tbl_business.fk_int_address_id = tbl_address.pk_int_address_id 
          JOIN ( SELECT * FROM tbl_location WHERE vchr_delete_status='n' ) tbl_location ON tbl_business.fk_int_location_id = tbl_location.pk_int_location_id
          JOIN ( SELECT * FROM tbl_category WHERE vchr_delete_status='n' ) tbl_category ON tbl_business.fk_int_category_id = tbl_category.pk_int_category_id
         
          left join (SELECT vchr_image_name,vchr_pdf,fk_int_business_id FROM tbl_business_images WHERE vchr_delete_status='n' group by fk_int_business_id) tbl_business_images on tbl_business.pk_int_business_id = tbl_business_images.fk_int_business_id

          WHERE tbl_business.vchr_delete_status='n' AND pk_int_business_id = $id ");
        $result = $query->result();
        $json_response = json_encode($result, JSON_NUMERIC_CHECK);
        echo $json_response;
        }

public function select_category()
{
  $query = $this->db->query("SELECT pk_int_category_id,vchr_category_name,vchr_category_name_ar FROM tbl_category WHERE vchr_delete_status='n' order by  vchr_category_name");
  $result = $query->result();
  $json_response = json_encode($result, JSON_NUMERIC_CHECK);
  echo $json_response;
}








public function select_category_with_location()
{

  
  $post_data = file_get_contents('php://input');
  $data = json_decode($post_data);
  $token = $data->token;
  if($token == "token"){
    $locid = $data->locationid;

    $query = $this->db->query("
    SELECT 
    pk_int_category_id,
    vchr_category_name,
    vchr_category_name_ar 
    FROM tbl_category 
    INNER JOIN tbl_business ON tbl_business.fk_int_category_id = tbl_category.pk_int_category_id 
    WHERE tbl_business.vchr_delete_status='n' AND tbl_business.fk_int_location_id = $locid
    GROUP BY vchr_category_name 
    ");
    
    
    $result = $query->result();
    $json_response = json_encode($result, JSON_NUMERIC_CHECK);
    echo $json_response;
  }
  else{
    echo "Invalid token";
  }
  
}












public function select_location()
  {
  $query = $this->db->query("SELECT pk_int_location_id,vchr_location_name,vchr_location_name_ar FROM tbl_location WHERE vchr_delete_status='n'");
  $result = $query->result();
  $json_response = json_encode($result, JSON_NUMERIC_CHECK);
  echo $json_response;
  } 
  
public function select_featured_list()
  {
      
  $query = $this->db->query("SELECT pk_int_location_id) AS cnt,vchr_location_name,vchr_location_name_ar FROM tbl_location WHERE vchr_delete_status='n'");
  $result = $query->result();
  $json_response = json_encode($result, JSON_NUMERIC_CHECK);
  echo $json_response;
  
  } 
  
  public function delete_business_image()
  {
      $user_id=123;
      $dt = new DateTime();
      $today= $dt->format('Y-m-d H:i:s');
  $post_data = file_get_contents('php://input');
  $data = json_decode($post_data);
  $biid = $data->biid;
   $update_data = array('vchr_delete_status' => 'd','vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today,
  );
  $this->db->where('pk_int_image_id', $biid);
  if ($this->db->update('tbl_business_images', $update_data))
    {
       echo $biid;
    }
    else
    {
      return 'Failed:Failed';
    }
  }
  public function edit_bui_img(){

  $user_id=123;
  $dt = new DateTime();
  $today= $dt->format('Y-m-d H:i:s');
  $post_data = $_POST['data'];
  // $post_data = file_get_contents('php://input');
  $data = json_decode($post_data);
//   print_r($data);
  $biid = $data->biid;
  
  $target_dir  = "./upload/";
  
  if(isset($_FILES['image'])){
          
          $files = $_FILES['image'];
          $config['upload_path']   = $target_dir;
          $config['allowed_types'] = 'jpeg|jpg|png';
          $config['max_size']    = 2000000000;
          $this->load->library('upload',$config);
          foreach ($_FILES['image']['name'] as $key => $value) 
          {
            $_FILES['images[]']['name']   =$files['name'][$key];
            $_FILES['images[]']['type']   =$files['type'][$key];
            $_FILES['images[]']['tmp_name'] =$files['tmp_name'][$key];
            $_FILES['images[]']['error']  =$files['error'][$key];
            $_FILES['images[]']['size']   =$files['size'][$key];
            $file_ext    = pathinfo($_FILES["images[]"]['name'], PATHINFO_EXTENSION);
            $file_name   = ($key+1).'_'.time().'.'.$file_ext;
            $config['file_name']  = $file_name;
            $this->upload->initialize($config);
            if($this->upload->do_upload('images[]'))
            {

            // $update_data = array('vchr_image_name'=>$file_name,'vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today,
            // ); 
            // $this->db->where('pk_int_image_id', $biid);
            // $this->db->insert('tbl_business_images', $update_data);

            $insert_data1 = array('fk_int_business_id'=>$biid,'vchr_image_name'=>$file_name,'vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today);
            $this->db->insert('tbl_business_images', $insert_data1);

            }
          }
        
        echo 'Success:Success';
        }
        else
        {
         echo 'Nothing/Failed to edit';   
          return;
        }
      
  }
public function delete_business()
  {
    // session_start();
      // $_SESSION['username']=$_SESSION['pk_int_user_id'];
      $user_id=123;
      $dt = new DateTime();
      $today= $dt->format('Y-m-d H:i:s');
  $post_data = file_get_contents('php://input');
  $data = json_decode($post_data);
  $bid = $data->bid;
  $aid = $data->aid;
   $update_data = array('vchr_delete_status' => 'd','vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today,
  );
  $update_data_addr = array('vchr_delete_status' => 'd','vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today,
  );
  $this->db->where('pk_int_address_id', $aid);
  $this->db->update('tbl_address', $update_data_addr);
  $this->db->where('pk_int_business_id', $bid);
  if ($this->db->update('tbl_business', $update_data))
    {
      return 'Deleted Successfully';
    }
    else
    {
      return 'Failed:Failed';
    }
  }
  


  public function delete_enquiry()
  {
    $user_id=123;
    $dt = new DateTime();
    $today= $dt->format('Y-m-d H:i:s');
  $post_data = file_get_contents('php://input');
  $data = json_decode($post_data);
  $aid = $data->id;
   $update_data = array('vchr_delete_status' => 'd','vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today,
  );
  $this->db->where('pk_int_enquiry_id', $aid);
  if ($this->db->update('tbl_enquiry', $update_data))
    {
      return 'Deleted Successfully';
    }
    else
    {
      return 'Failed:Failed';
    }
  }

  public function delete_home()
  {
    $user_id=123;
    $dt = new DateTime();
    $today= $dt->format('Y-m-d H:i:s');
    $post_data = file_get_contents('php://input');
    $data = json_decode($post_data);
    $aid = $data->id;
    $update_data = array('vchr_delete_status' => 'd','vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today,
    );
    $this->db->where('pk_int_home_id', $aid);
    if ($this->db->update('tbl_home_section', $update_data))
    {
      return 'Deleted Successfully';
    }
    else
    {
      return 'Failed:Failed';
    }
  }
}
?>