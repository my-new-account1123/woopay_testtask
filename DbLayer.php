<?php
session_start();
function regenerate() {
    $_SESSION['code'] = uniqid();
    $_SESSION['code_time'] = time();
}
class DbLayer
{
    protected $db;

    public  function __construct($tablename){
    $this->tablename=$tablename;
       $config = require 'config.php';
       try {
         $this->db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['name'] . '', $config['user'],
            $config['password']);
     } catch (\PDOException $e) {
        echo $e->getMessage();
    }
}
   // Get all records
    public function findAll(){
        $sth = $this->db->prepare("SELECT * FROM ".$this->tablename."");
        $sth->execute();
        $result = $sth -> fetchAll();
         if( ! $result)
        {         
          echo "No Records Found";
        }
        foreach( $result as $row ) {
        echo '<div class="news" id="news">';    
        echo '<p>ID новости:'.$row['id'].'</p>';
        echo '<h1>'.$row['title'].'</h1>';
        echo '<p>'.$row['description'].'</p>';
        echo '<p>Дата поста:'.$row['news_date'].'</p>';
        echo '</div>'; 
}
    }
    // Get one record by id
    public function findOneById($id){
        $sth = $this->db->prepare("SELECT * FROM ".$this->tablename." WHERE id=:id");
        $sth->bindParam(':id', $id);    
        $sth->execute();
        $result = $sth->fetch();
        if( ! $result)
        {         
         echo "No Records Found";
        }
        echo '<div class="news" id="news">';    
        echo '<p>ID новости:'.$result['id'].'</p>';
        echo '<h1>'.$result['title'].'</h1>';
        echo '<p>'.$result['description'].'</p>';
        echo '<p>Дата поста:'.$result['news_date'].'</p>';
        echo '</div>'; 
    
    }
    // Get all records by attributes
        public function findAllByAttributes($user_id,$status){
        $sth = $this->db->prepare("SELECT * FROM ".$this->tablename." WHERE (user_id =:user_id) OR (status =:status)");
        $sth->bindParam(':user_id', $user_id);
        $sth->bindParam(':status', $status);
        $sth->execute();
        $result = $sth->fetchAll();
        if( ! $result)
        {         
         echo "No Records Found";
        }
        foreach( $result as $row ) {
        echo '<div class="news" id="news">';    
        echo '<p>ID новости:'.$row['id'].'</p>';
        echo '<h1>'.$row['title'].'</h1>';
        echo '<p>'.$row['description'].'</p>';
        echo '<p>Дата поста:'.$row['news_date'].'</p>';
        echo '</div>'; 
    }
    }
    // Create new record
     public function create($user_id,$title,$description,$status){
        $my_date = date("Y-m-d G:i:s");
        $sth = $this->db->prepare("INSERT INTO ".$this->tablename."(user_id , title , description, news_date , status) VALUES (:user_id , :title , :description , :news_date, :status)");
        $sth->bindParam(':user_id',$user_id);
        $sth->bindParam(':title', $title);
        $sth->bindParam(':description', $description);
        $sth->bindParam(':news_date',  $my_date);
        $sth->bindParam(':status',  $status);
        $sth->execute();
         if( ! $sth)
        {         
           echo "New records created successfully";
        }
       
    }
    // Delete record by id
    public function deleteById($id){
        $sth = $this->db->prepare("DELETE FROM ".$this->tablename." WHERE id =:id");
        $sth->bindParam(':id', $id);
        $sth->execute();
        echo "delete"; 
    }

    // update record by id
    public function updateById($id,$title,$description,$status){
        $sth = $this->db->prepare("UPDATE ".$this->tablename."  SET title = :title , description = :description , status = :status WHERE id =:id");
        $sth->bindParam(':id', $id);
        $sth->bindParam(':title', $title);
        $sth->bindParam(':description', $description);
        $sth->bindParam(':status', $status);
        $sth->execute();
         echo "update"; 
    }

}
