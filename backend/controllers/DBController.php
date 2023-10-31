<?php
class DBController
{
    // Declare the connection property
    private $conn;

    // LOCAL
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbName = 'burgershop';

    // LIVE
    // Create the constructor that connects to the database
    public function __construct()
    {
        // Create a new mysqli object
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbName);

        // Check for connection errors
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    // Define a function that takes a simple array and returns a formatted array
    private function format_array($array) {
        // Initialize an empty string for the types
        $types = "";
        
        // Loop through the array and append the type of each element to the types string
        foreach ($array as $element) {
        // Check the type of the element and append the corresponding character
        if (is_int($element)) {
        $types .= "i";
        } elseif (is_double($element)) {
        $types .= "d";
        } elseif (is_string($element)) {
        $types .= "s";
        } elseif (is_bool($element)) {
        $types .= "b";
        } else {
        // If the type is not supported, throw an exception
        throw new Exception("Unsupported type: " . gettype($element));
        }
        }
        
        // Prepend the types string to the array
        array_unshift($array, $types);
        
        // Return the formatted array
        return $array;
        }

    // Create a public function that selects data from the database
    public function select($query, $vars=[])
    {
        // Prepare the query
        $stmt = $this->conn->prepare($query);

        // Check for preparation errors
        if (!$stmt) {
            die("Query preparation failed: " . $this->conn->error);
        }

        if (count($vars) >0){
            // Format Variable Array to Bind Type
            $vars = $this->format_array($vars);
            
            // Bind the variables to the query parameters
            $stmt->bind_param(...$vars);
        }

        // Execute the query
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        // Close the statement
        $stmt->close();

        // Initialize an empty array for the result
        $array = array();

        // Loop through the result set and append each row to the array
        while ($row = $result->fetch_assoc()) {
        $array[] = $row;
        }

        // Return the array of result
        return $array;
    }

    // Create another function that executes any query
    public function execute($query, $vars=[])
    {
        // Prepare the query
        $stmt = $this->conn->prepare($query);

        // Check for preparation errors
        if (!$stmt) {
            die("Query preparation failed: " . $this->conn->error);
        }

        if (count($vars) >0){
            // Format Variable Array to Bind Type
            $vars = $this->format_array($vars);
            
            // Bind the variables to the query parameters
            $stmt->bind_param(...$vars);
        }

        // Execute the query
        $success = $stmt->execute();

        // Close the statement
        $stmt->close();

        // Return true if executed successfully, else false
        return $success;
    }
}
