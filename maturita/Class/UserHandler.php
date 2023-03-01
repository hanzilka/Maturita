<?php
class UserHandler{
    private $connection;
    private $user;
    private $email;
    private $role;
    private $password;
    private $hashed_password;
    private $error_message;

    public function __construct($connection) {
        $this->connection = $connection;
      }
    public function userRegister() {
    if(isset($_POST['submit'])) {
        // Get data from form
        $this->user = $_POST['user'];
        $this->email = $_POST['email'];
        $this->password = $_POST['password'];

        // Hash the password using bcrypt
        $this->hashed_password = password_hash($this->password, PASSWORD_BCRYPT);

        // Check if the username is already in the database
        $query = "SELECT users.id, users.user, users.password FROM users WHERE user = ?";
        $stmt = mysqli_prepare($this->connection, $query);
        mysqli_stmt_bind_param($stmt, "s", $this->user);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        // If the username matches the one in the database
        if($row) {
        // Show an error message
        $this->error_message = "This user already exists";
        }
        else {
        // The username is unique, insert the information into the database
        $query = "INSERT INTO users (user, email, password, id_role, registered_at) VALUES (?, ?, ?, '2', NOW())";
        $stmt = mysqli_prepare($this->connection, $query);
        mysqli_stmt_bind_param($stmt, "sss", $this->user, $this->email, $this->hashed_password);
        mysqli_stmt_execute($stmt);
        // Get the ID of the inserted user
        $user_id = mysqli_insert_id($this->connection);
        // Set the user's session
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user'] = $this->user;
        $_SESSION['role'] = $this->role;
        header("location: index.php");
        }

        // Close the connection
        mysqli_close($this->connection);
    }
    }

    public function userLogin() {
        if (isset($_POST['submit'])) {
          // Get the form data
          $this->user = $_POST['user'];
          $this->password = $_POST['password'];
      
          // Select the user with the provided name
          $query = "SELECT users.id, users.user, users.password, role.role AS pravomoce FROM users JOIN role ON users.id_role = role.id WHERE user = ?";
          $stmt = mysqli_prepare($this->connection, $query);
          mysqli_stmt_bind_param($stmt, "s", $this->user);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
      
          // If a matching user was found
          if ($row) {
            // Verify the password against the hashed password in the database
            if (password_verify($this->password, $row['password'])) {
              // Set the user session variable
              $_SESSION['user'] = $this->user;
      
              // Save the user's id in the session
              $_SESSION['user_id'] = $row['id'];
              // User is logged in
              $_SESSION['logged_in'] = true;
              //
              $_SESSION['role'] = $row['pravomoce'];
      
              // Redirect the user to the index page after a successful login
              header("Location: index.php");
              exit;
            } else {
              // Failed login, display an error message
              $this->error_message = "Špatné jméno nebo heslo";
            }
          } else {
            // Failed login, display an error message
            $this->error_message = "Špatné jméno nebo heslo";
          }
        }
      }

    public function getErrorMessage() {
    return $this->error_message;
    }
}