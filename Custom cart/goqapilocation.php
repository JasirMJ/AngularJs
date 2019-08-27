 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apilocation extends CI_Controller 
{


	public function index()
	{

		
	}

public function add_location()
  {
  // session_start();
  $dt = new DateTime();
  $user_id=123;
  $today= $dt->format('Y-m-d H:i:s');
  // $post_data = file_get_contents('php://input');
  $post_data = $_POST['data'];
  $data = json_decode($post_data);
  // print_r($data);return;
  $target_dir  = "./upload/";
  $insert_address =array(
      'vchr_last_modified_by'=>$user_id,
      'vchr_last_modified_time'=>$today,
      'vchr_location_name' => $data->location,
      'vchr_location_name_ar' => $data->locationar,
      'int_is_premium' => $data->is_premium,
      'float_latitude' => $data->lat,
      'float_longitude' => $data->lng,
      'text_strtview' => $data->strtview
    );

 if($this->db->insert('tbl_location', $insert_address))
    {
         if (isset($_FILES['image']))
            {
              $max=0;
              $this->db->select_max('pk_int_location_id');
              $max_query=$this->db->get('tbl_location');
              $max =$max_query->row();
              $max=(int)$max->pk_int_location_id;
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
                  $insert_data1 = array('fk_int_location_id'=>$max,'vchr_image_name'=>$file_name,'vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today);
                  $this->db->insert('tbl_business_images', $insert_data1);
                }
              }
            }
    echo 'Success : success';
    }
    else
    {
      echo 'Failed : Failed';
    }
  }
public function update_location()
  {
    // session_start();
    $dt = new DateTime();
    $user_id=123;
  $today= $dt->format('Y-m-d H:m:s');
  // $post_data = file_get_contents('php://input');
  $post_data = $_POST['data'];
  $data = json_decode($post_data);
  // print_r($data);return;
  $id = $data->id;
  $target_dir  = "./upload/";
    $max=0;
    $this->db->select_max('pk_int_location_id');
    $max_query=$this->db->get('tbl_location');
    $max =$max_query->row();
    $max=(int)$max->pk_int_location_id+1;
  $oldData = $this->db->get_where('tbl_location',array("pk_int_location_id" => $id))->result()[0];
  $update_data = array(
      'vchr_delete_status' => 'm',
      'pk_int_location_id' => $max,
      'vchr_last_modified_by'=>$user_id,
      'vchr_last_modified_time'=>$today
    );
  $this->db->where('pk_int_location_id', $id);
  $this->db->update('tbl_location', $update_data);
    $insert_data = array(
        'pk_int_location_id' => $id,
        'vchr_location_name' => $data->location,
        'float_latitude' => $data->lat,
        'float_longitude' => $data->lng,
        'vchr_last_modified_by'=>$user_id,
        'vchr_last_modified_time'=>$today,
        'vchr_location_name_ar' => $data->locationar,
        'int_is_premium' => $data->is_premium,
        'text_strtview' => $data->strtview
    );
      if($this->db->insert('tbl_location', $insert_data))
      {
        if (isset($_FILES['image'])) 
        {
          $delete_old_img = array('vchr_delete_status' => 'd','vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today);
          $this->db->where('fk_int_location_id', $id);
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
              $insert_data1 = array('fk_int_location_id'=>$id,'vchr_image_name'=>$file_name,'vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today);
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
public function check_location()
{
    $post_data = file_get_contents('php://input');
    $data = json_decode($post_data);
    $location = $data->location;
    // echo "$location";return;
    $myCond = (isset($data->location_id)&&$data->location_id != '')?"and pk_int_location_id != $data->location_id":"";
    $query = $this->db->query("SELECT pk_int_location_id FROM tbl_location WHERE  vchr_delete_status='n' and vchr_location_name='$location' $myCond");
    echo json_encode(array("count" => $query->num_rows(),"q" => "SELECT pk_int_location_id FROM tbl_location WHERE  vchr_delete_status='n' and vchr_location_name='$location' $myCond"));
}
public function select_current_location()
{
    $post_data = file_get_contents('php://input');
    $data = json_decode($post_data);
    $id = $data->id;
    // echo "$id";return;
    $query = $this->db->query("SELECT pk_int_location_id,vchr_location_name,vchr_location_name_ar,int_is_premium FROM tbl_location WHERE vchr_delete_status='n' AND pk_int_location_id = $id ");
    $result = $query->result();
    $json_response = json_encode($result, JSON_NUMERIC_CHECK);
    echo $json_response;
}

public function select_location()
  {
  $post_data = file_get_contents('php://input');
  $data = json_decode($post_data);
  $token = $data->token;
  if ($token == "token") 
  {
    $query = $this->db->query(
        "SELECT 
        text_strtview,
        vchr_image_name,
        pk_int_location_id,
        vchr_location_name,
        vchr_location_name_ar,
        int_is_premium 
        FROM tbl_location 
        left join (
            SELECT 
            vchr_image_name,
            fk_int_location_id 
            FROM tbl_business_images 
            WHERE vchr_delete_status='n' 
            group by fk_int_location_id
            ) tbl_business_images on tbl_location.pk_int_location_id = tbl_business_images.fk_int_location_id
        WHERE vchr_delete_status='n' ORDER BY vchr_location_name");
    $result = $query->result();
    header('Content-Type: application/json');
    $json_response = json_encode($result, JSON_NUMERIC_CHECK);
    echo $json_response;
  }
  }
public function delete_location()
  {
       // session_start();
      $user_id=123;
      $dt = new DateTime();
      $today= $dt->format('Y-m-d H:i:s');
  $post_data = file_get_contents('php://input');
  $data = json_decode($post_data);
  $id = $data->id;

  $buiData = $this->db->get_where('tbl_business',array('vchr_delete_status' => 'n','fk_int_location_id' =>$id))->result();
  // print_r($buiData);return;
if(count($buiData) > 0){
  $query = $this->db->query("SELECT vchr_name AS Business FROM tbl_business 
      WHERE vchr_delete_status='n'  AND fk_int_location_id = $id ");
    $result = $query->result();
    header('Content-Type: application/json');
    array_push($result, "Following businesses are added with this location you are not able to delete this");
     $resulth = json_encode($result,JSON_NUMERIC_CHECK);
     echo $resulth ;
    return;
}
    $update_data = array('vchr_delete_status' => 'd','vchr_last_modified_by'=>$user_id,'vchr_last_modified_time'=>$today,
    );
    $this->db->where('pk_int_location_id', $id);
    if ($this->db->update('tbl_location', $update_data))
    {
      echo 'Deleted'; return;
    }
    else
    {
      return 'Failed:Failed';
    }
  }
}?>