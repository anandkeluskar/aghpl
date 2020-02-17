<?php

class Connection 
{

  protected $host   = "localhost";
  protected $dbname = "todo_task";
  protected $user   = "root";
  protected $pass   = "";
  protected $connection;
  protected $port   = 80;
  protected $path   = '';


function __construct($c_type="",$database_type="")
 {
  try 
   {
	switch($c_type)
	{
	 /***** If connection type is 'PDO' *****/
	  
	  case 'pdo':    
	  
	  switch($database_type)
		{
	     case 'mysql' : $this->connection = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
		 break;		
					
         case 'pgsql' : $this->connection = new PDO("pgsql:dbname=$this->dbname;host=$this->host", $this->user, $this->pass);
		 break;
			
		 case 'sqlite': $path_sqlite='sqlite:/'.$this->path;
			            $this->connection = new PDO($path_sqlite);
		 break;
			
		 case 'oracle': $this->connection = new PDO("OCI:dbname=$this->dbname;charset=UTF-8", $this->user, $this->pass); 
		 break;
			
		 case 'ibm'   : $this->connection = new PDO("ibm:DRIVER={IBM DB2 ODBC DRIVER};DATABASE=$this->dbname;
		                HOSTNAME=$this->host;PORT=$this->port;PROTOCOL=TCPIP;", $this->user, $this->pass);
		 break;	
					
         default      : $this->connection = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
		 break;			  
		}
	  
	  break;
	  
	  /***** If connection type is 'MySQLi' *****/
	  
	  case 'mysqli':  
	   
	  $this->connection = new mysqli($this->host,$this->user,$this->pass,$this->dbname);
	
	  if (mysqli_connect_errno()) 
	    {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
		else
		{
			//echo 'Connected';
		}
	  
	  break;
	  
	  
	  
	  default :    /***** If connection type is is not specified use PDO by Default *****/
	  
	  switch($database_type)
		{
		 case 'mysql' : $this->connection = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
	     break;		
					
		 case 'pgsql' : $this->connection = new PDO("pgsql:dbname=$this->dbname;host=$this->host", $this->user, $this->pass);
		 break;
			
		 case 'sqlite': $path_sqlite='sqlite:/'.$this->path;
			            $this->connection = new PDO($path_sqlite);
		 break;
			
		 case 'oracle': $this->connection = new PDO("OCI:dbname=$this->dbname;charset=UTF-8", $this->user, $this->pass); 
		 break;
			
		 case 'ibm'   : $this->connection = new PDO("ibm:DRIVER={IBM DB2 ODBC DRIVER};DATABASE=$this->dbname;
		                HOSTNAME=$this->host;PORT=$this->port;PROTOCOL=TCPIP;", $this->user, $this->pass);
		 break;	
					
		 default      : $this->connection = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
		 break;			  
		}
	  
	  break;	
	}	   
   }
  catch (PDOException $e)
   {
		 echo $e->getMessage();
   }
}

	public function getConnection()
	{
			try
			{
			  return $this->connection;
			}
			catch( PDOException $ex )
			{  
			  echo "Error In Connection : ".$ex->getMessage();
			}
	}

	public function closeConnection()
		 {
			 if( $this->connection != null )
                         {
				 $this->connection = null;
                         }
		 }
}

?>