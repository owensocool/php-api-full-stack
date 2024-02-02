<?php
require_once('../controller/auth_operation.php');

//defind parameter
$username = $_POST['username'];
$password = $_POST['password'];
$role = 'customer';

$name= $_POST['name'];
$sex= $_POST['sex'];
$email=isset($_POST['email']) ? $_POST['email'] : '';
$address= $_POST['address'];
$tel = isset($_POST['tel']) ? $_POST['tel'] : '';

if($username && $password){
    $message = null;
    // validate format username
    $user_name_check = getUsername($username);
    if($username == $user_name_check['username']){
        $message = "$username in used, please try again";
    }
    else{
        // validate password format pwd,min,max
        if (isPasswordValid($password, 8, 20)) {
            // hash password
            $hashedPwd = password_hash($password, PASSWORD_BCRYPT);
            //gen user_ID
            $user_id_validate = getUser_id($user_id);
            $user_id = 'USR'.uniqid();
            while ($user_id == $user_id_validate){
                $user_id = 'USR'.uniqid();
                $user_id_validate = getUser_id($user_id);
                if($user_id != $user_id_validate){
                    break;
                }
            }
            // save user to databse
            createUsr($user_id,$username,$hashedPwd,$role);
            $message = "Create User Success";
            
            if($message == "Create User Success"){
                //gen customer id
                $customer_id = 'CUS'. uniqid();
                $customer_id_validate = getCus_id($customer_id);
                while ($customer_id == $customer_id_validate){
                    $customer_id = 'CUS'.uniqid();
                    $customer_id_validate = getCus_id($customer_id);
                    if($customer_id != $customer_id_validate){
                        break;
                    }
                }
                //save to customer db
                createCustomer($customer_id,$user_id,$name, $email, $sex, $tel,$address);
                $message = "Create Customer Success";
            }

        } else {
            $message = "Require minimum 8 character, please try again";
        } 
    }
} else{
        $message = "Empty field";
}

echo $message;

header("Location: ../view/signIn.html");
exit();

function isPasswordValid($password, $minLength, $maxLength) {
    $passwordLength = strlen($password);
    if ($passwordLength < $minLength) {
        return false; 
    } elseif ($passwordLength > $maxLength) {
        return false; 
    }
    return true; 
}
?>