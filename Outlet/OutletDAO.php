<?php

class OutletDAO {

    public  function retrieveAll() {
        $sql = 'SELECT * FROM outlet ORDER BY outletid';
        
            
        $connMgr = new ConnectionManager();      
        $conn = $connMgr->getConnection();

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $result = array();

        while($row = $stmt->fetch()) {
            $result[] = new Outlet($row['outletid'], $row['password'], $row['name']);
        }

        $stmt = null;
        $conn = null;

        return $result;
    }

    public  function retrieve($outletid) {
        $sql = "SELECT * FROM outlet WHERE outletid=:outletid";
        
            
        $connMgr = new ConnectionManager();      
        $conn = $connMgr->getConnection();

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(":outletid", $outletid);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        $Outlet = null;
        if($row = $stmt->fetch()) {
            $Outlet = new Outlet($row['outletid'], $row['password'], $row['name']);
        }

        $stmt = null;
        $conn = null;
        
        return $Outlet;
    }
    
    public function removeAll() {
        $sql = 'DELETE FROM outlet';
        
        $connMgr = new ConnectionManager();
        $conn = $connMgr->getConnection();
        
        $stmt = $conn->prepare($sql);
        
        $stmt->execute();
        $count = $stmt->rowCount();
    }  
    
    public function add($Outlet) {
        $sql = 'INSERT INTO outlet (outletid, password, name) VALUES (:outletid, :password, :name)';
        
        $connMgr = new ConnectionManager();       
        $conn = $connMgr->getConnection();
         
        $stmt = $conn->prepare($sql); 

        $stmt->bindParam(':outletid', $Outlet->getoutletid(), PDO::PARAM_STR);
        $stmt->bindParam(':password', $Outlet->getPwd(), PDO::PARAM_STR);
        $stmt->bindParam(':name', $Outlet->getName(), PDO::PARAM_STR);

        $isAddOK = $stmt->execute();
        
        $stmt = null;
        $conn = null;

        return $isAddOK;
    }
    
}
?>
