<?php
require_once "migrations/AlbumsTableCreator.php";
require_once "migrations/PhotosTableCreator.php";
require_once "migrations/UsersTableCreator.php";
require_once "migrations/PhotoTextTableCreator.php";

echo "Enter (create/drop) to (create/drop) database and tables \n";
$flag = trim(fgets(STDIN));
try{
    $albumstc = new AlbumsTableCreator();
    $photostc = new PhotosTableCreator();
    $userstc = new UsersTableCreator();
    $photoTexttc = new PhotoTextTableCreator();

    if($flag == "create"){
        $userstc->create();
        $albumstc->create();
        $photostc->create();
        $photoTexttc->create();
        echo "Tables created\n";
    }elseif($flag == "drop"){
        $photoTexttc->drop();
        $photostc->drop();
        $albumstc->drop();
        $userstc->drop();
        echo "Tables deleted\n";
    }else{
        echo "Entered value is incorrect\n";
    }

}catch(PDOException $e){
    die("Migration error ".$e->getMessage());
}