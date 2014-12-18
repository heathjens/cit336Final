<?php
/**
 * Functions for users, forms, and validation. 
 **/

class User
{
	var $id;
	var $email;
	var $password;
	var $firstName;
	var $lastName;
	var $roleId;
        var $message;
        var $subject;
}
// Calculate the password.
function CalculatePassword($password) {
	return $password;
}
// Check the session to see if the user is logged in.
function CheckSession()
{
	return(GetLoggedInUserId() != null);
}
// Deletes a user from the database.
function DeleteUser($id)
{
	$query = 'DELETE FROM users WHERE ID=:id';
        DbExecute($query, array(':id' => $id));
}
// Retrieves all users from the database.
function GetUsers()
{
	$users = array();
	$query = 'SELECT * FROM users';
	$result = DbSelect($query);
	
	foreach ($result as $item)
	{
		$user = new User();
		$user->id = $item['ID'];
		$user->email = $item['email'];
		$user->firstName = $item['firstName'];
		$user->lastName = $item['lastName'];
		$user->roleId = $item['roleId'];
		
		$users[] = $user;
	}
	
	return $users;
}
// Get the Id of the logged in user.
function GetLoggedInUserId()
{
	return (array_key_exists('UserId', $_SESSION)) ? $_SESSION['UserId'] : null;
}
// Retrieves information about a user from the database.
function GetUser($userId) {
	$query = 'SELECT * FROM users WHERE ID=:id';
	$result = DbSelect($query, array(':id' => $userId));
	
	if (array_key_exists(0, $result))
	{
		$user = new User();
		$user->id = $result[0]['ID'];
		$user->email = $result[0]['email'];
		$user->firstName = $result[0]['firstName'];
		$user->lastName = $result[0]['lastName'];
		$user->roleId = $result[0]['roleId'];
		
		return $user;
	}
	
	return false;
}
//Determines is user is admin
function LoggedInUserIsAdmin()
{
	return array_key_exists('UserRole', $_SESSION) && $_SESSION['UserRole'] == ROLE_ID_ADMIN;
}
// Validates who the user is
function LoginUser($email, $password) {
	$loggedIn = false;
	
	if ($email && $password) {
		$pass = CalculatePassword($password);
		$query = "SELECT * FROM users WHERE email=:email AND password=:pass";
		$result = DbSelect($query, array(':email' => $email, ':pass' => $pass));
		
		if (is_array($result) && array_key_exists(0, $result)) {
			$user = new User();
			$user->id = $result[0]['ID'];
			$user->roleId = $result[0]['roleId'];
			SetUserSessionVariables($user);
			$loggedIn = true;
		}
	}
	
	return $loggedIn;
}
//Adds a new user to the database.
function RegisterUser($first, $last, $email, $pass1, $pass2, &$errorMessage) {
	$registered = false;
       	
	if (ValidateNames($first, $errorMessage) &&
		ValidateNames($last, $errorMessage) &&
		ValidateEmail($email,$errorMessage) &&
		ValidatePasswordLength($pass1, $errorMessage)) {
           		
            if ($pass1 == $pass2) {
               try{
			$query = "SELECT * FROM users WHERE email=':email'";
			$result =  DbSelect($query, array(':email' => $email));
                               
               
			if (is_array($result) && count($result) == 0) {
                           
				$calc = CalculatePassword($pass1);
                                
				$query = "INSERT INTO users (firstName, lastName, email, password, roleId)";
				$query .= " VALUES(:first, :last, :email, :pass, :role)";
				
				$id = DbInsert($query, array(':first' => $first, ':last' => $last, ':email' => $email, ':pass' => $calc, ':role' => ROLE_ID_USER));
				
                                $u = new User();
                                
				$u->id = $id;
				$u->roleId = null;
				SetUserSessionVariables($u);
				$registered = true;
                               
               }
               
                        }catch(PDOException $e){
                   echo $e->getMessage();
               }
               
		}
		else
		{
			$errorMessage .= "Password and Verify Password must match.";
            }
                }
	
	return $registered;
}
// check that names are at least 3 characters long
function ValidateNames($name, &$errorMessage) {
	if (strlen($name) >= 2) {
		return true;	
	} else {
		$errorMessage .= "Name must be at least 3 characters long";
		return false;
	} 
}
function ValidateEmail($email, &$errorMessage) {
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return true;
	}
	
	$errorMessage .= "Invalid Email address";
	return false;
}
function ValidatePasswordLength($name, &$errorMessage) {
	// TODO: make sure password contains UPPERCASE, lowercase, numbers, and special chars.
	
	if (strlen($name) >= 5) {
		return true;	
	} else {
		$errorMessage .= "Password must be at least 5 characters long";
		return false;
	} 
}
// Saves the session variables for a User.
function SetUserSessionVariables(User $user) {
	$_SESSION['UserId'] = $user->id;
	$_SESSION['UserRole'] = $user->roleId;
}
// Update the user information in the database.
function UpdateUserInfo($id, $email, $firstname, $lastname)
{
	$query = 'UPDATE users SET email=:email, firstName=:firstname, lastName=:lastname WHERE ID=:id';
	DbExecute($query, array(':email' => $email, ':firstname' => $firstname, ':lastname' => $lastname, ':id' => $id));
}
// Update the User password.
function UpdateUserPassword($password, $id = null)
{
	$id = ($id == null) ? GetLoggedInUserId() : $id;
	$calc = CalculatePassword($password);
	
	$query = 'UPDATE users SET password=:pass WHERE ID=:id';
	DbExecute($query, array(':pass' => $calc, ':id' => $id));
}
// Update the role of a user.
function UpdateUserRole($id, $roleName)
{
	if ($id && $roleName)
	{
		$roleId = (strtolower($roleName) == 'admin') ? ROLE_ID_ADMIN : ROLE_ID_USER;
		
		$query = 'UPDATE users SET roleId=:roleId where ID=:id';
		DbExecute($query, array(':roleId' => $roleId, ':id' => $id));	
	}
}
// Validates that a password matches what is in the database.
function ValidateOldPassword($password)
{
	$return = false;
	$id = GetLoggedInUserId();
	$calc = CalculatePassword($password);
	$query = 'SELECT * FROM users WHERE ID=:id AND password=:calc';
	
	$result = DbSelect($query, array(':id' => $id, ':calc' => $calc));
	
	if ($result && count($result) > 0)
	{
		$return = true;
	}
	
	return $return;
}
// A function that helps with client-side validation. 
function ValidatePassword($password, &$errorMessage)
{
	$valid = false;
	
	if (strlen($password) >= 3)
	{
		$valid = true;
	}
	else
	{
		$errorMessage = "The password must be at least 3 characters long.";
	}
	
	return $valid;
}
