<?php
 
class database{
 
    function opencon() {
        return new PDO(
            'mysql:host=localhost; dbname=dbs_apps',
            username: 'root',
            password: ''
        );
    }
 
    function signupUser($firstname, $lastname, $username, $password, $email){
        $con = $this->opencon();
 
        try{
            $con->beginTransaction();
 
            $stmt = $con->prepare("INSERT INTO Admin (admin_FN, admin_LN, admin_username, admin_password, admin_email) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$firstname, $lastname, $username, $password, $email]);
 
            //Get the newly inserted user_id
            $userID = $con->lastInsertID();
            $con->commit();
 
            //returns the new admin's ID so it can be used in other operations
            return $userID;
        }catch(PDOException $e){
 
            //reverts any chnages made during the transaction. This keeps the database clean and consistent in case of an error
            $con->rollBack();
            return false;
 
        }
       
    }
     function isUsernameExists($username){
        $con = $this->opencon();
        $stmt = $con->prepare("SELECT COUNT(*) FROM Admin WHERE admin_username = ?");
         $stmt->execute([$username]);
         $count = $stmt->fetchColumn();
         return $count > 0;
           
        }

        function isEmailExists($email){
        $con = $this->opencon();
        $stmt = $con->prepare("SELECT COUNT(*) FROM Admin WHERE admin_email = ?");
         $stmt->execute([$email]);
         $count = $stmt->fetchColumn();
         return $count > 0;
           
        }

}
 