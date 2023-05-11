<?php
namespace SharePilotV2\Models;
use SharePilotV2\Libs\Dbhandler;
use SharePilotV2\Components\RequestHandler;

class Users
{
    public function __construct()
    {
    }

    public function insert($obj)
    {
        $db = Dbhandler::getInstance();
        $sql = "insert users (";
        
        $sql .= "name, " ;
        $sql .="lastname," ;        
        $sql .="email," ;
        $sql .="password," ;
        $sql .="role, ";
        $sql .="mobilephone,";
        $sql .="address,";

        if(isset($obj->birthdate) && trim($obj->birthdate)!="" ){
            $sql .="birthdate,";
        }

        $sql .="regdate,";
        $sql .="am ";

        $sql .= ") ";        
        $sql .=" values( ";

        $sql .=":name, ";
        $sql .=":lastname,"; 
        $sql .=":email,";
        $sql .=":password,";
        $sql .=":role,"; 
        $sql .=":mobilephone, ";
        $sql .=":address, ";

        if(isset($obj->birthdate) && trim($obj->birthdate)!="" ){
            $sql .=":birthdate,";
        }

        $sql .=":regdate,";
        $sql .=":am";

        $sql .="); ";

        $sth = $db->dbh->prepare($sql);        

        $values[":name"] = $obj->name;
        $values[":lastname"] = $obj->lastname;
        $values[":email"] = $obj->email;
        $values[":password"] = $obj->password;
        $values[":role"] = $obj->role;
        $values[":mobilephone"] = $obj->mobilephone;
        $values[":address"] = $obj->address;

        if(isset($obj->birthdate) && trim($obj->birthdate)!="" ){
            $values[":birthdate"] = $obj->birthdate;
        }
        
        $values[":regdate"] = date("Y-m-d H:i:s");
        $values[":am"] = $obj->am;

        $sth->execute($values);

        return $db->dbh->lastInsertId();
    }

    public function select()
    {

        $requesthandler =  new requesthandler();

        $db = Dbhandler::getInstance();
        $sql = "select a.*, b.name rolename from users a                    
                    ";                                        
        
                            
         if(requestHandler::get()!=null){
             $id = requestHandler::get()->id;            
             $sql .= " where a.id=". $id;
         }

        $sth = $db->dbh->prepare($sql);
        $sth->execute();
        $results = $sth->fetchAll(PDO::FETCH_OBJ);
        

        foreach ($results as $row) {
            $data['data'][] = array(
                'id' => $row->id,
                'name' => $row->name,
                'lastname' => $row->lastname,
                'email' => $row->email,
                'password' => $row->password,
                'role' => $row->role,
                'mobilephone' => $row->mobilephone,
                'address' => $row->address,
                'birthdate' => $row->birthdate,
                'regdate' => $row->regdate,
                'am' => $row->am,

            );
        }

        return $data;
    }

    public function delete($id)
    {

        $error = "";
        $db = Dbhandler::getInstance();
        $sql = "delete from users where id = $id";
        $sth = $db->dbh->prepare($sql);
        try{

            $sth->execute();

        }catch(Exception $e){
            $error = $e->getMessage();
        }

        

        $rowsupdates = $sth->rowCount();
        if($rowsupdates == 0){
            return array('delete'=>false, "records"=>$rowsupdates, "error"=>$error);
        }else{
            return array('delete'=>true, "records"=>$rowsupdates, "error"=>$error);
        }
    }

    public function update($obj)
    {
        $db = Dbhandler::getInstance();
        $sql = "update users "
            . " set name=:name, lastname=:lastname, email=:email, role=:role, mobilephone=:mobilephone, address=:address, am=:am ";
        

        if(isset($obj->birthdate) && trim($obj->birthdate)!=""){
            $sql .= ",birthdate=:birthdate ";
        }

        if(isset($obj->password) && trim($obj->password)!=""){
            $sql .= ", password=:password ";
        }

        $sql .= " where id=:id";
        
        $values = array();
        $values[":name"] = $obj->name;
        $values[":lastname"] = $obj->lastname;
        $values[":email"] = $obj->email;

        if(isset($obj->password) && trim($obj->password)!=""){
            $values[":password"] = $obj->password;
        }

        $values[":role"] = $obj->role;
        $values[":mobilephone"] = $obj->mobilephone;
        $values[":address"] = $obj->address;

        if(isset($obj->birthdate) && trim($obj->birthdate)!=""){
            $values[":birthdate"] = $obj->birthdate;
        }        

        
        $values[":am"] = $obj->am;
        $values[":id"] = $obj->id;
        

        $sth = $db->dbh->prepare($sql);
        $sth->execute($values);

        $rowsupdates = $sth->rowCount();
        if($rowsupdates == 0){
            return array('update'=>false, "records"=>$rowsupdates);
        }else{
            return array('update'=>true, "records"=>$rowsupdates);
        }
    }

    public function check()
    {

        $db = Dbhandler::getInstance();
        $sql = "select a.* 
                    from users a                                
                    ";                                        
        
        $username = null;
        if(isset(RequestHandler::get()->email)){
            $username = RequestHandler::get()->email;
        }

        $password = null;
        if(isset(RequestHandler::get()->password)){
            $password = RequestHandler::get()->password;
        }
        
        $sql .= " where a.email = '".$username."' and a.password='".$password."'";
        
        
        $sth = $db->dbh->prepare($sql);
        $sth->execute();
        $results = $sth->fetchAll(\PDO::FETCH_OBJ);
            
        
        if($results[0]->id!=""){
            $_SESSION["user"] = $results;
            foreach ($results as $row) {
                $data['data'][] = array(
                    'id' => $row->id,
                    'name' => $row->name,
                    'lastname' => $row->lastname,
                    'email' => $row->email,
                    'password' => $row->password,
                    'role' => $row->role,
                    'mobilephone' => $row->mobilephone,
                    'address' => $row->address,
                    'birthdate' => $row->birthdate,
                    'regdate' => $row->regdate,
                    'am' => $row->am,
    
                );
            }
            
        }else{
            $data = "";
        }
        
        return $data;
    }

    public function getRelations(){
        
        $db = Dbhandler::getInstance();
        $dbname = Config::read('db.basename');
        $sql = "SELECT *  FROM information_schema.key_column_usage where constraint_schema = '$dbname' and table_name='users' and REFERENCED_TABLE_NAME is not null";
                        
            
        $sth = $db->dbh->prepare($sql);
        $sth->execute();
        $results = $sth->fetchAll(PDO::FETCH_OBJ);
                
        foreach ($results as $row) {            
            $sql = "SELECT *  FROM ".$row->REFERENCED_TABLE_NAME;
            if($row->REFERENCED_TABLE_NAME=="users"){
                $sql .=" where role = 2 ";
            }
            $sth = $db->dbh->prepare($sql);
            $sth->execute();
            $results = $sth->fetchAll(PDO::FETCH_ASSOC);
            $data[$row->REFERENCED_TABLE_NAME][] = $results;
                // $data[] = array(
                // 'COLUMN_NAME' => $row->COLUMN_NAME,                                
                // 'REFERENCED_TABLE_NAME' => $row->REFERENCED_TABLE_NAME,
                // 'REFERENCED_COLUMN_NAME' => $row->REFERENCED_COLUMN_NAME
                // );
        }

        return $data;
    }

    public function updateProfile($obj){
        $db = Dbhandler::getInstance();
        $sql = "update users "
            . " set mobilephone=:mobilephone, address=:address";
        

        if(isset($obj->birthdate) && trim($obj->birthdate)!=""){
            $sql .= ",birthdate=:birthdate ";
        }

        if(isset($obj->password) && trim($obj->password)!=""){
            $sql .= ", password=:password ";
        }

        $sql .= " where id=:id";
        
        $values = array();
        
        if(isset($obj->password) && trim($obj->password)!=""){
            $values[":password"] = $obj->password;
        }
        
        $values[":mobilephone"] = $obj->mobilephone;
        $values[":address"] = $obj->address;

        if(isset($obj->birthdate) && trim($obj->birthdate)!=""){
            $values[":birthdate"] = $obj->birthdate;
        }        
    
        $values[":id"] = $obj->id;
        

        $sth = $db->dbh->prepare($sql);
        $sth->execute($values);

        $rowsupdates = $sth->rowCount();
        if($rowsupdates == 0){
            return array('update'=>false, "records"=>$rowsupdates);
        }else{
            return array('update'=>true, "records"=>$rowsupdates);
        }
    }
    
}
