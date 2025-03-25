
<?php
require_once('./dbcredentials.class.php');


class logics extends dbcredentials{
    // Admin Login 
    public function AdminLogin($username, $password){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Prepare the SQL query to join users and profiles table
        $query = $con->prepare('
            SELECT users.id, users.stud_id, users.name, users.email, users.password, users.domain, profiles.profile 
            FROM users 
            LEFT JOIN profiles ON users.id = profiles.user_id 
            WHERE users.status=1 AND (users.email=? AND users.password=?)'
        );
        
        $query->bind_param('ss', $username, $password);
        
        if ($query->execute()) {
            $query->bind_result($id, $stud_id, $name, $email, $pass, $domain, $profile);
            
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['id'] = $id;
                $res['stud_id'] = $stud_id;
                $res['username'] = $name;
                $res['email'] = $email;
                $res['password'] = $pass;
                $res['domain'] = $domain;
                $res['profile'] = $profile;  // Add profile photo to the result
            }
        } else {
            $err = "Statement not Executed";
        }
    
        $query->close();
        $con->close();
        
        return $res;
    }
    


    public function getProfile($id){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT id,user_id,mobile,college,dept,yop,address,profile,created_at FROM profiles WHERE status=1 AND user_id=? ORDER BY id DESC');
        $query->bind_param('s',$id);
        if($query->execute()){
            $query->bind_result($id,$user_id,$mobile,$college,$dept,$yop,$address,$profile,$created_at);
            while($query->fetch()){
                $res['status'] = 1;
                $res['id'] = $id;
                $res['user_id'] = $user_id;
                $res['mobile'] = $mobile;
                $res['college'] = $college;
                $res['dept'] = $dept;
                $res['yop'] = $yop;
                $res['address'] = $address;
                $res['profile'] = $profile;
                $res['created_at'] = $created_at;

            }
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }


    
    public function updateProfile($mobile,$college,$dept,$yop,$address,$profile,$id){
        $res = array();
        $res['status']=0;
        $con = new mysqli($this->hostName(),$this->userName(),$this->password(),$this->dbName() );
        $query = $con->prepare('UPDATE profiles SET mobile=?,college=?, dept=?, yop=?, address=?, profile=? WHERE id=?');
        $query->bind_param('sssssss',$mobile,$college,$dept,$yop,$address,$profile,$id);
        if ($query->execute()) {
            if(!empty($query ->affected_rows) && $query ->affected_rows >0){
                $res['status']=1;
            }else{
                $err = 'Data not Inserted';
            }
        }

        $con->close();
        $query->close();
        return $res;

    }

    //Change Password
    public function changepwd($id,$password){
        $res = array();
        $res['status']=0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('UPDATE users set password=? where id=?');
        $query ->bind_param('ss',$password,$id);
        if($query ->execute()){
                $res['status']=1;
        }else{
            $err = "Statement not Executed";
        }

        $query -> close();
        $con -> close();
        return $res;
    }

    //Task Submission
    public function SubmitTask($user_id,$task,$url,$doubts){
        $res = array();
        $res['status']=0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('INSERT INTO tasks (user_id,task,url,doubts) values (?,?,?,?)');
        $query ->bind_param('ssss',$user_id,$task,$url,$doubts);
        if($query ->execute()){
                $res['status']=1;
        }else{
            $err = "Statement not Executed";
        }

        $query -> close();
        $con -> close();
        return $res;
    }

    
    //Submitted Tasks Retieval
    public function SubmittedTasks($user_id){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT task,url,doubts,created_at FROM tasks WHERE status=1 AND user_id=? ORDER BY id DESC');
        $query->bind_param('s',$user_id);
        if($query->execute()){
            $query->bind_result($task, $url, $doubts, $created_at);
            $i=1;
            while($query->fetch()){
                $res['status']=1;
                $res['task'][$i] = $task;
                $res['url'][$i] = $url;
                $res['doubts'][$i] = $doubts;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }


    
    //Current Tasks Retieval
    public function getTodayTask($domain){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        $todayDate = date('Y-m-d');
        $query = $con->prepare('SELECT task_date, domain, task_name, task_description, tasks, created_at FROM addtasks WHERE status=1 AND domain=? AND task_date=? ORDER BY id DESC');
        $query->bind_param('ss', $domain, $todayDate);
        
        if($query->execute()){
            $query->bind_result($task_date, $domain, $task_name, $task_description, $tasks, $created_at);
            while($query->fetch()){
                $res['status'] = 1;
                $res['task_date'] = $task_date;
                $res['domain'] = $domain;
                $res['task_name'] = $task_name;
                $res['task_description'] = $task_description;
                $res['tasks'] = $tasks;
                $res['created_at'] = $created_at;
            }
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }
    


    // Blogs Submission
    public function blogs($image, $heading, $meta, $description){
        $res =array();
        $res['status']=0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('INSERT INTO blogs (image, heading, description, meta) values (?,?,?,?)');
        $query ->bind_param('ssss',$image, $heading, $description, $meta);
        if($query ->execute()){
            if(!empty($query ->affected_rows) && $query ->affected_rows >0){
                $res['status']=1;
            }else{
                $err = 'Data not Inserted';
            }
        }else{
            $err = 'Statement Not Executed';
        }
        return $res;
    }

    // Clients Submission
    public function clients($client_logo, $client_name){
        $res =array();
        $res['status']=0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('INSERT INTO clients (client_logo, client_name) values (?,?)');
        $query ->bind_param('ss',$client_logo, $client_name);
        if($query ->execute()){
            if(!empty($query ->affected_rows) && $query ->affected_rows >0){
                $res['status']=1;
            }else{
                $err = 'Data not Inserted';
            }
        }else{
            $err = 'Statement Not Executed';
        }
        return $res;
    }

    



    //contacts Retieval
    public function getContacts(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT name,email,mobile,message,created_at FROM contact ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($name, $email, $mobile, $message, $updatedtime);
            $i=1;
            while($query->fetch()){
                $res['status']=1;
                $res['name'][$i] = $name;
                $res['email'][$i] = $email;
                $res['mobile'][$i] = $mobile;
                $res['message'][$i] = $message;
                $res['updatedtime'][$i] = $updatedtime;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }


    //Plans Retieval
    public function getPlans(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT pickup_location,drop_location,travel_date,return_date,travellers,name,mobile,email,message,created_at FROM plans ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($pickup_location,$drop_location,$travel_date,$return_date,$travellers,$name,$mobile,$email,$message,$created_at);
            $i=1;
            while($query->fetch()){
                $res['status']=1;
                $res['name'][$i] = $name;
                $res['email'][$i] = $email;
                $res['mobile'][$i] = $mobile;
                $res['message'][$i] = $message;
                $res['pickup_location'][$i] = $pickup_location;
                $res['drop_location'][$i] = $drop_location;
                $res['travel_date'][$i] = $travel_date;
                $res['return_date'][$i] = $return_date;
                $res['travellers'][$i] = $travellers;
                $res['created_at'][$i] = $created_at;
                $res['status']=1;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

    
    //Plans Retieval
    public function bike_rental(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT pickup_location,drop_location,travel_date,return_date,bike_model,name,mobile,email,message,created_at FROM bike_rental ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($pickup_location,$drop_location,$travel_date,$return_date,$bike_model,$name,$mobile,$email,$message,$created_at);
            $i=1;
            while($query->fetch()){
                $res['status']=1;
                $res['name'][$i] = $name;
                $res['email'][$i] = $email;
                $res['mobile'][$i] = $mobile;
                $res['message'][$i] = $message;
                $res['pickup_location'][$i] = $pickup_location;
                $res['drop_location'][$i] = $drop_location;
                $res['travel_date'][$i] = $travel_date;
                $res['return_date'][$i] = $return_date;
                $res['bike_model'][$i] = $bike_model;
                $res['created_at'][$i] = $created_at;
                $res['status']=1;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }


     //Subscribes Retieval
     public function getSubscribes(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT mobile,created_at FROM callbacks ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($mobile, $updatedtime);
            $i=1;
            while($query->fetch()){
                $res['status']=1;
                $res['mobile'][$i] = $mobile;
                $res['updatedtime'][$i] = $updatedtime;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

      //Blogs Retieval
      public function getBlogs(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT image, heading, meta, description, created_at FROM blogs ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($image, $heading, $meta, $description, $created_at);
            $i=1;
            while($query->fetch()){
                $res['status']=1;
                $res['image'][$i] = $image;
                $res['heading'][$i] = $heading;
                $res['meta'][$i] = $meta;
                $res['description'][$i] = $description;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{

            $err = 'Statement not Executed';
        }
        return $res;
    }


      //Clients Retieval
      public function getClients(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT client_logo, client_name,updatedtime FROM clients ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($client_logo, $client_name, $updatedtime);
            $i=1;
            while($query->fetch()){
                $res['status']=1;
                $res['client_logo'][$i] = $client_logo;
                $res['client_name'][$i] = $client_name;
                $res['updatedtime'][$i] = $updatedtime;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

   

}

?>