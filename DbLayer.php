<?php
class DbLayer
{
	protected $db;
	public  function __construct(string $tablename){
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
		try {
			$sth = $this->db->prepare('SELECT * FROM '.$this->tablename.'');
			$sth->execute();
			$result = $sth -> fetchAll();
			if (!$result) {
				throw new Exception('NoRecordsFound');
			}
			print_r($result);
		}
		catch (\Exception $e){
			echo $e->getMessage();
		}
	}
    // Get one record by id
	public function findOneById(int $id){
		try {
			$sth = $this->db->prepare('SELECT * FROM '.$this->tablename.' WHERE id=:id');
			$sth->bindParam(':id', $id);    
			$sth->execute();
			$result = $sth->fetch();
			if (!$result) {
				throw new Exception('NoRecordsFound');
			}
			print_r($result);
		}
		catch (\Exception $e){
			echo $e->getMessage();
		}
	}
    // Get all records by attributes
	public function findAllByAttributes(array $find_attributes){
		try {
			$user_id=$find_attributes['user_id'];
			$status=$find_attributes['status_news'];
			$sth = $this->db->prepare('SELECT * FROM '.$this->tablename.' WHERE (user_id =:user_id) OR (status =:status)');
			$sth->bindParam(':user_id', $user_id);
			$sth->bindParam(':status', $status);
			$sth->execute();
			$result = $sth->fetchAll();
			if (!$result) {
				throw new Exception('NoRecordsFound');
			}
			print_r($result);
		}
		catch (\Exception $e){
			echo $e->getMessage();
		}
	}
    // Create new record
	public function create(array $create_attributes){
		try {
			$user_id=$create_attributes['user_id'];
			$title=$create_attributes['title'];
			$description=$create_attributes['description'];
			$status=$create_attributes['status'];
			$my_date = date('Y-m-d G:i:s');
			$sth = $this->db->prepare('INSERT INTO '.$this->tablename.'(user_id , title , description, news_date , status) VALUES (:user_id , :title , :description , :news_date, :status)');
			$sth->bindParam(':user_id',$user_id);
			$sth->bindParam(':title', $title);
			$sth->bindParam(':description', $description);
			$sth->bindParam(':news_date',  $my_date);
			$sth->bindParam(':status',  $status);
			$sth->execute();
			if (!$sth) {
				throw new Exception('false');
			}
			else{
				throw new Exception('true');
			}
		}
		catch (\Exception $e){
			echo $e->getMessage();
		}
		
	}
    // Delete record by id
	public function deleteById(int $id){
		try{
			$sth = $this->db->prepare('DELETE FROM '.$this->tablename.' WHERE id =:id');
			$sth->bindParam(':id', $id);
			$sth->execute();
			if (!$sth) {
				throw new Exception('false');
			}
			else{
				throw new Exception('true');
			}
		}
		catch (\Exception $e){
			echo $e->getMessage();
		}
		
	}
    // update record by id
	public function updateById(array $update_attributes){
		try {
			$id=$update_attributes['update_id'];
			$title=$update_attributes['update_title'];
			$description=$update_attributes['update_description'];
			$status=$update_attributes['status'];
			$sth = $this->db->prepare('UPDATE '.$this->tablename.'  SET title = :title , description = :description , status = :status WHERE id =:id');
			$sth->bindParam(':id', $id);
			$sth->bindParam(':title', $title);
			$sth->bindParam(':description', $description);
			$sth->bindParam(':status', $status);
			$sth->execute();
			if (!$sth) {
				throw new Exception('false');
			}
			else{
				throw new Exception('true');
			}
		}
		catch (\Exception $e){
			echo $e->getMessage();
		}
	}
}
