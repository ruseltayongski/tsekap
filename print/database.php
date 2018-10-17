<?php
    function connect(){
        return new PDO("mysql:host=localhost;dbname=doh_dengvaxia_dummy",'root','');
    }
    function connect_tsekap(){
        return new PDO("mysql:host=localhost;dbname=tsekap_main",'root','');
    }

    function query_dengvaxia($unique_id){
        $db=connect();
        $sql = "SELECT * FROM dengvaxia_profiles where unique_id = ?";
        $pdo=$db->prepare($sql);
        $pdo->execute(array($unique_id));
        $row=$pdo->fetch(PDO::FETCH_OBJ);
        $db=null;

        return $row;
    }
    function barangay($barangayId){
        $db=connect_tsekap();
        $sql = "SELECT description FROM barangay where id = ?";
        $pdo=$db->prepare($sql);
        $pdo->execute(array($barangayId));
        $row=$pdo->fetch(PDO::FETCH_OBJ);
        $db=null;

        return $row;
    }
    function muncity($muncityId){
        $db=connect_tsekap();
        $sql = "SELECT description FROM muncity where id = ?";
        $pdo=$db->prepare($sql);
        $pdo->execute(array($muncityId));
        $row=$pdo->fetch(PDO::FETCH_OBJ);
        $db=null;

        return $row;
    }
    function province($provinceId){
        $db=connect_tsekap();
        $sql = "SELECT description FROM province where id = ?";
        $pdo=$db->prepare($sql);
        $pdo->execute(array($provinceId));
        $row=$pdo->fetch(PDO::FETCH_OBJ);
        $db=null;

        return $row;
    }