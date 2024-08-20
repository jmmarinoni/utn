<?php 


class PeopleDB {
    
    protected $mysqli;

    const LOCALHOST = 'mysql';
    const USER = 'root';
    const PASSWORD = 'root_password';
    const DATABASE = 'rest_api';

   // define("DB_HOST", getenv('DB_HOST'));
   // define("DB_USER", getenv('MYSQL_USER'));
   // define("DB_PASSWORD", getenv('MYSQL_PASSWORD'));
   // define("DB_DATABASE", getenv('DB_DATABASE'));
    
    /**
     * Constructor de clase
     */
    public function __construct() 
       {           
            try{
                //conexión a base de datos
                $this->mysqli = new mysqli(self::LOCALHOST, self::USER, self::PASSWORD, self::DATABASE);
               // $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
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
        $stmt = $this->mysqli->prepare("SELECT * FROM people WHERE id=? ; ");
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $result = $stmt->get_result();        
        $peoples = $result->fetch_all(MYSQLI_ASSOC); 
        $stmt->close();
        return $peoples;              
       }



    
    /**
     * obtiene todos los registros de la tabla "people"
     * @return Array array con los registros obtenidos de la base de datos
     */
    public function getPeoples()
        {        
        $result = $this->mysqli->query('SELECT * FROM people');          
        $peoples = $result->fetch_all(MYSQLI_ASSOC);          
        $result->close();
        return $peoples; 
        }



    
    /**
     * añade un nuevo registro en la tabla persona
     * @param String $name nombre completo de persona
     * @return bool TRUE|FALSE 
     */
    public function insert($name='')
       {
        $stmt = $this->mysqli->prepare("INSERT INTO people(name) VALUES (?); ");
        $stmt->bind_param('s', $name);
        $r = $stmt->execute(); 
        $stmt->close();
        return $r;        
       }



    
    /**
     * elimina un registro dado el ID
     * @param int $id Identificador unico de registro
     * @return Bool TRUE|FALSE
     */
    public function delete($id=0)
       {
        $stmt = $this->mysqli->prepare("DELETE FROM people WHERE id = ? ; ");
        $stmt->bind_param('s', $id);
        $r = $stmt->execute(); 
        $stmt->close();
        return $r;
       }
    


    /**
     * Actualiza registro dado su ID
     * @param int $id Description
     */
    public function update($id, $newName) 
       {
            if($this->checkID($id))
              {
                $stmt = $this->mysqli->prepare("UPDATE people SET name=? WHERE id = ? ; ");
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
            $stmt = $this->mysqli->prepare("SELECT * FROM people WHERE ID=?");
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
        $result = $this->mysqli->query('SELECT name FROM people');          
        $names = $result->fetch_all(MYSQLI_ASSOC);          
        $result->close();
        return $names; 
        }
    
}
?>