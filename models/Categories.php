<?php

class Category{

   private $conn;
   private $table = 'categories';

   // Properties
   public $id;
   public $name;
   

   // Contructor with DB
   public function __construct($db){
      $this->conn = $db;
   }

   // 1Get Posts
   public function read() {
      $query = 'SELECT 
               id,
               name
               FROM
               ' .$this->table.' ORDER BY created_at DESC';
      
      $stmt = $this->conn->prepare($query);
      $stmt->execute();

      return $stmt;
   }
     // Get Single Category
  public function read_single(){
   // Create query
   $query = 'SELECT
         id,
         name
       FROM
         ' . $this->table . '
     WHERE id = ?
     LIMIT 0,1';

     //Prepare statement
     $stmt = $this->conn->prepare($query);

     // Execute query
     $stmt->execute([$this->id]);

     $row = $stmt->fetch(PDO::FETCH_ASSOC);

     // set properties
     $this->id = $row['id'];
     $this->name = $row['name'];
 }


    // Create Category
  public function create() {
   // Create Query
   $query = 'INSERT INTO ' .
     $this->table . '
   SET
     name = :name';

 // Prepare Statement
 $stmt = $this->conn->prepare($query);

 // Clean data
 $this->name = htmlspecialchars(strip_tags($this->name));

 // Bind data
 $stmt-> bindParam(':name', $this->name);

 // Execute query
 if($stmt->execute()) {
   return true;
 }

 // Print error if something goes wrong
 printf("Error: $s.\n", $stmt->error);

 return false;
 }
   
      // Update Category
  public function update() {
   // Create Query
   $query = 'UPDATE ' .
     $this->table . '
   SET
     name = :name
     WHERE
     id = :id';

 // Prepare Statement
 $stmt = $this->conn->prepare($query);

 // Clean data
 $this->name = htmlspecialchars(strip_tags($this->name));
 $this->id = htmlspecialchars(strip_tags($this->id));

 // Bind data
 $stmt-> bindParam(':name', $this->name);
 $stmt-> bindParam(':id', $this->id);

 // Execute query
 if($stmt->execute()) {
   return true;
 }

 // Print error if something goes wrong
 printf("Error: $s.\n", $stmt->error);

 return false;
 }

 // Delete Category
 public function delete() {
   // Create query
   $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

   // Prepare Statement
   $stmt = $this->conn->prepare($query);

   // clean data
   $this->id = htmlspecialchars(strip_tags($this->id));

   // Bind Data
   $stmt-> bindParam(':id', $this->id);

   // Execute query
   if($stmt->execute()) {
     return true;
   }

   // Print error if something goes wrong
   printf("Error: $s.\n", $stmt->error);

   return false;
   }

   // get both
   public function getboth() {
      $query = 'SELECT 
               c.name ,
               p.id as post_id,
               p.category_id as category_id,
               p.title as post_title,
               p.body as post_body,
               p.author as post_author,
               p.created_at as post_created_at
               FROM
               ' .$this->table.' c
               INNER JOIN
               posts p
               ON c.id=p.category_id
               WHERE c.id=?';

      $stmt = $this->conn->prepare($query);
      $stmt->execute([$this->id]);
      // $result = $stmt->fetch(PDO::FETCH_ASSOC);

      // return $result;
      return $stmt;
   }


}
?>