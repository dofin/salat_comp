 <?php
 
class DB_Connect
{

protected $db;
	
	protected function __construct($db=NULL)
	{
	$DB_HOST = 'localhost';
	$DB_USER = 'root';
	$DB_PASS = '';
	$DB_NAME = 'testmod';

		if(is_object($db))
		{
		$this->db = $db;
		}
			else
			{
			$dsn = "mysql:host=".$DB_HOST.";dbname=".$DB_NAME;
				try
				{
				$this->db= new PDO($dsn, $DB_USER, $DB_PASS);
				}
					catch (Exception $e)
					{
					die($e->getMessage());
					}
			}
	}	
}
 
class Salat extends DB_Connect
{

	public function __construct($db=NULL)
	{
	parent::__construct($dbo);
	}
		public function _loadEvenData($id=NULL)
		{
		$sql = "SELECT * FROM salat, ingrid, join_salat WHERE salat.id_sal = join_salat.id_sal and ingrid.id_ing = join_salat.id_ing and salat.id_sal = 1";
	
			try
			{
			$stmt = $this->db->prepare($sql);
		
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
			$stmt->closeCursor();
		
			return $results;
		
			}
				catch( Exception $e)
				{
				die($e->getMessage());
				}
		}
}
 
 
//-------------------------------------------------------
 
 abstract class Component
{
        public $name;
		public $price;
		public $id;
 
        	public function __construct($arr=null)
			{
               
				$this->id = $arr['id'];
				$this->name = $arr['name'];
				$this->price = $arr['price'];
				
        	}
 
        public abstract function add(Component $c);
        public abstract function remove(Component $c);
        public abstract function display();
		
}
 
 

class Composite extends Component
{
	 
        public $children = array();
 
        public function add(Component $component)
        {
                $this->children[] = $component;
				
				
        }
 
        	public function remove(Component $component)
        	{
                unset($this->children[$component->id]);
        	}
 
        		public function display()
        		{
				$total=0;
		
		        	foreach($this->children as $child)
					{
				
					$child->display();
				
				    $total =  $total+$child->price;
					}
				
				echo "Total: ".$total."<br>";
			     }
			
}

class Leaf extends Component
{
 
 
        public function add(Component $c)
        {
                print ("Cannot add to a leaf");
        }
 
        public function remove(Component $c)
        {
                print("Cannot remove from a leaf");
        }
 
        public function display()
        {
             echo "<tr><td>".$this->name."</td><td>".$this->price."</td></tr>";
		}
}

//------------------------------------------------

$baza = new Salat();
$newarr = $baza->_loadEvenData();
$root = new Composite("root");

	$comp = new Composite(array(
						"id"=>$event["id_sal"],
						"name"=>$event["title"],
						));


		foreach($newarr as $event)
		{
		$comp->add(new Leaf(array(
						"id"=>$event["id_ing"],
						"name"=>$event["nazvanie"],
						"price"=>$event["zena"],
						)));
		}	
					
echo "<table border='1'>";
$comp->display();
echo "</table>";
