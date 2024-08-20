<?php 

require_once 'conexion/DB_Connect.php';

class PeopleDB {
    
    protected $conn;

    /**
     * Constructor de clase
     */
    public function __construct() 
       {           
            try{
                //conexión a base de datos
                $this->conn = new DB_Connect();

              }catch (mysqli_sql_exception $e)
                   {
                    //Si no se puede realizar la conexión
                    http_response_code(500);
                    exit;
                   }     
       } 
    
    /**
     * obtiene un solo registro dado su ID
     * @param int $id identificador unico de registro
     * @return Array array con los registros obtenidos de la base de datos
     */
    public function getPeople($id=0)
       {      
        $stmt = $this->conn->prepare("SELECT * FROM people WHERE id=? ; ");
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $peoples = $result->fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
        return $peoples;
       }



    
    /**
     * obtiene todos los registros de la tabla "people"
     * @return Array array con los registros obtenidos de la base de datos
     */
    public function getPeoples()
        {
        $db = $this->conn->connect();
        $sql = 'SELECT * FROM people';
        $statement = $db->query($sql);
        $peoples = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $peoples;
        PDO2::closeInstance();
        }

    
    /**
     * añade un nuevo registro en la tabla persona
     * @param String $name nombre completo de persona
     * @return bool TRUE|FALSE 
     */

   public function insert($name = '')
   {
       try {
           $db = $this->conn->connect();
           $sql = 'INSERT INTO people(name) VALUES(:name)';
           $statement = $db->prepare($sql);
           $statement->execute([':name' => $name]);
           
       } catch (PDOException $e) {
           echo 'Error: ' . $e->getMessage();
           return false;
       }
   }
   

    
    /**
     * elimina un registro dado el ID
     * @param int $id Identificador unico de registro
     * @return Bool TRUE|FALSE
     */
    public function delete($id=0)
       {
        try{ 
        $db = $this->conn->connect();
        $sql = 'DELETE FROM people WHERE id = :id ;';
        $statement = $db->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        if ($statement->execute()) {
          echo 'Usuario id ' . $id . ' fue eliminado correctamente.';
        }
      } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        return false;
    }
       }
    


    /**
     * Actualiza registro dado su ID
     * @param int $id Description
     */
    public function update($id, $newName) 
       {
            if($this->checkID($id))
              {
                $stmt = $this->conn->prepare("UPDATE people SET name=? WHERE id = ? ; ");
                $stmt->bind_param('ss', $newName,$id);
                $r = $stmt->execute(); 
                $stmt->close();
                return $r;    
              }
             
            return false;
       }
    



    /**
     * verifica si un ID existe
     * @param int $id Identificador unico de registro
     * @return Bool TRUE|FALSE
     */
    public function checkID($id)
     {
            $stmt = $this->conn->prepare("SELECT * FROM people WHERE ID=?");
            $stmt->bind_param("s", $id);
            if($stmt->execute())
              {
                $stmt->store_result();    
                if ($stmt->num_rows == 1)
                    {                
                    return true;
                    }
              }  

        return false;
     }


         public function getName()
        {        
        $result = $this->conn->query('SELECT name FROM people');          
        $names = $result->fetch_all(MYSQLI_ASSOC);          
        $result->close();
        return $names; 
        }
    
}
?>