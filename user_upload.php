<?php
$servername = "localhost";
$username = "username";
$password = "password";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";

// sql to create table
$sql = "CREATE TABLE users ( 
name VARCHAR(30) NOT NULL,
surname VARCHAR(30) NOT NULL,
email VARCHAR(50)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table users created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$file = fopen("users.csv","r");
print_r(fgetcsv($file));

DELIMITER $$
CREATE TRIGGER name_format 
    BEFORE INSERT ON users
    FOR EACH ROW 
BEGIN
    INSERT INTO users
	SET Name = CONCAT(UCASE(SUBSTRING(Name, 1, 1)),LCASE(SUBSTRING(Name, 2))),
	SET Surname = CONCAT(UCASE(SUBSTRING(Surname, 1, 1)),LCASE(SUBSTRING(Surname, 2))),	
     	Name = OLD.Name,
       	Surname = OLD.Surname;
END$$
DELIMITER ;

if (($handle = fopen("users.csv", "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$num = count($data);
				DB::table('users')->insert(
					array('name' => $data[1], 'surname' => $data[2], 'email' => $data[3])
				);
			}
			fclose($handle);
		}
fclose($file);

$conn->close();

?>
