<?php

class User extends MyUtilClass {
    public $id;
    public $hashPassword;
    public $name;
    public $company_name;
    public $email;
    public $address;
    public $tel;
    public $is_admin;
    public $created_user_id;
    public $created_at;
    public $updated_user_id;
    public $updated_at;

    public $user_input_password;
    public $email_confirm;
    public $is_edit_password = false;


    /**
     * title：discriptionXX
     *
     * @param string  $a    discription1
     * @param array   $bb   discription2
     * @param boolean $ccc  discription3
     * 
     */
    private function createHashPassword($password){
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        return $hashPassword;
    }

    /**
     * title：discriptionXX
     *
     * @param array  $param    $_POST, $_GET など
     * 
     */
    public function setDataFromArray($params) {
        $this->user_id             = MY_UTIL_01::escapeHtml($params['user_id']);
        $this->user_input_password = MY_UTIL_01::escapeHtml($params['user_input_password']);
        $this->hashPassword        = $this->createHashPassword($params['hashPassword']);
        $this->name                = MY_UTIL_01::escapeHtml($params['name']);
        $this->reg_user_id         = MY_UTIL_01::escapeHtml($_SESSION['user_id']);
        $this->update_user_id      = MY_UTIL_01::escapeHtml($_SESSION['user_id']);

        if($params['is_edit_password'] === "1" ){
            $this->is_edit_password  = true;
        }else{
            $this->is_edit_password  = false;
        }
    }

    /**
     * 
     */
    public function insertData() {
        try {
            if($this->hasError == true){
                return;
            }

            $db = MY_DB_UTIL_01::master();
            $sql = $this->createInsertSQL();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':password'        ,$this->hashPassword   );
            $stmt->bindValue(':name'            ,$this->name           );
            $stmt->bindValue(':email'           ,$this->email          );
            $stmt->bindValue(':created_user_id' ,$this->created_user_id);
            $stmt->execute();
        }
        catch(MSM_Exception $e) {
            $msg = $e->getMessage();
            echo "$msg\n";
        }
    }    

    /**
     * 
     */
    private function createInsertSQL(){
        $sql = <<<SQL
INSERT INTO 
users
(
 user_id
,password
,name
)
values
(
 nextval('user_seq')
,:password
,:reg_user_id
,now()
,:update_user_id
,now()
)
SQL;

        return $sql;
    }

    /**
     * 
     */
    public function validateForInsert(){
        $this->errContentArray = [];

        //email
        $this->checkForRequired('email_required', $this->email);
        $this->checkForEmailConfirmInput('email_confirm_input', $this->email, $this->email_confirm);
        $this->checkForEmailStyle('email_style', $this->email);
        $this->checkForDuplicateEmail('email_duplicate', $this->email);
        $this->setErrorContentParams('email', ['email_required','email_confirm_input','email_style', 'email_duplicate']);

        //email_confirm
        $this->checkForRequired('email_confirm_required', $this->email_confirm);
        $this->setErrorContentParams('email_confirm', ['email_confirm_required','email_confirm_input']);

        //password
        $this->checkForRequired('password_required'    , $this->password);
        $this->checkForPasswordPolicy('password_policy', $this->password);
        $this->setErrorContentParams('password', ['password_required','password_policy']);


        //tel
        $this->checkForRequired('tel_required', $this->tel);
        $this->checkForTelStyle('tel_style', $this->tel);
        $this->setErrorContentParams('tel', ['tel_required','tel_style']);


        $this->setErrorJudgmentProperties();
    }



    /**
     * 
     */
    public function setDataFromPrimaryKey($key) {
        $sql = <<<SQL
SELECT
*
FROM
users
WHERE user_id = :user_id
SQL;


        $db = MY_DB_UTIL_01::master();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $key);
        $stmt->execute();
        $recordCount    = $stmt->rowCount(MY_DB_UTIL_01::FETCH_ASSOC);
        $recordInstance = $stmt->fetchAll(MY_DB_UTIL_01::FETCH_ASSOC);				

        if($recordCount <= 0){
            return false;
        }

        $this->id   = $recordInstance[0]['id'];
        $this->name = $recordInstance[0]['name'];
    }

    /**
     * 
     */
    public function updateData() {
        try {
            if($this->hasError == true){
                return;
            }

            $db = MY_DB_UTIL_01::master();
            $sql = $this->createUpdatetSQL();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id'             ,$this->id);
            $stmt->bindValue(':name'           ,$this->name);
            $stmt->bindValue(':update_user_id' ,MY_UTIL_01::escapeHtml($_SESSION['userId'] ?? "0"));
            if($this->is_edit_password){
                $stmt->bindValue(':password'   ,$this->hashPassword);
            }
            $stmt->execute();
        }
        catch(MSM_Exception $e) {
            $msg = $e->getMessage();
            echo "$msg\n";
        }
    }

    /**
     * 
     */
    private function createUpdatetSQL(){

        $sql = "";
        $sql .= "UPDATE users                                 ";
        $sql .= "   SET name            = :name               ";
        $sql .= "      ,updated_user_id = :updated_user_id    ";
        $sql .= "      ,updated_user_id = :updated_user_id    ";
        $sql .= "      ,updated_at      = now()               ";
        if($this->is_edit_password){
            $sql .= "  ,password = :password ";
        }
        
        $sql .= "WHERE id = :id";

        return $sql;
    }

    /**
     * 
     */
    public function validateForUpdate(){
        $this->errContentArray = [];

        //name
        $this->checkForRequired('name', $this->name);
        
        //password
        if($this->is_edit_password){
            $this->checkForRequired('password_required'    , $this->password);
            $this->checkForPasswordPolicy('password_policy', $this->password);
            $this->setErrorContentParams('password', ['password_required','password_policy']);
        }
        
        $this->setErrorJudgmentProperties();
    }

    /**
     * 
     */
    public static function delete($key) {
        try {
            $sql = <<<SQL
DELETE FROM xi_jmesse_user
WHERE user_id = :user_id
SQL;

            $db = MSM_DB::master();
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':user_id', $key);
            $stmt->execute();

            return;
         }
         catch(MSM_Exception $e) {
             $msg = $e->getMessage();
             echo "$msg\n";
             exit();
         }
    }    
    /**
     * 
     */
    public function findById($id){
        $db = MSM_DB::slave();
        $sql = "SELECT * from users WHERE id = :id ";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', MSM_Utils_Text::escHtml($id));
        $stmt->execute();
        $recordSet = $stmt->fetchAll(MSM_DB_CONST::FETCH_ASSOC);
        $recordInstance = $recordSet[0];			

        return $recordInstance;
    }

}

