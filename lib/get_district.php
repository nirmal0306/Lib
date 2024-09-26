<?php
include_once "database_connection.php";

try {
    $database = new Database();
    $con = $database->openConnection();
    if(!empty($_POST["state_id"])) 
    {
    //$query =mysqli_query($con,"SELECT * FROM district WHERE StCode = '" . $_POST["state_id"] . "'");
        $stmt = $con->prepare("SELECT * FROM district WHERE StCode= '" . $_POST["state_id"] ."'");
        $stmt->execute();
        $districts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
        <option value="">Select District</option>
        <?php
        foreach ($districts as $district) 
        {  
        ?>
        <option value="<?php echo $district["DistCode"]; ?>">
        <?php echo $district["DistrictName"]; ?></option>
        <?php
        }
    }
    }
    catch (PDOException $e) 
    {
        $e->getMessage();
	} 
?>
