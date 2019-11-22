<?php

namespace models;

use lib\basemodel;

class pengguna extends basemodel {
    public $id;
    public $username;
    public $nama;
    public $email;
    public $password;
    public $website;

    public function __construct($id, $username, $nama, $email, $password, $website) {
        $this->id = $id;
        $this->username = $username;
        $this->nama = $nama;
        $this->email = $email;
        $this->password = $password;
        $this->website = $website;
    }

    public static function getPengguna($scope) {
        $query = self::getDB()->prepare("SELECT * FROM `fr_user` ".$scope);
        $query->execute();

        $result = array();
        while ($row = $query->fetch()) {
            array_push($result, new pengguna($row["id"], $row["username"], $row["nama"], $row["email"], $row["password"], $row["website"]));
        }

        return $result;
    }
    
    public function createChar() {
        $newchar = array();
        $numbers = range(33, 126);
        shuffle($numbers);
        foreach ($numbers as $number) {
            $isi = '';
            $isi = $isi.chr($number);
            $length = random_int(0,1);
            if ($length == 1){
                $randomnumb = random_int(33,126);
                $isi = $isi.chr($randomnumb);
            }
            $newchar[] = $isi;
        }
        session_destroy();
        session_start();
        $_SESSION['newchar'] = $newchar;
    }
    
    public function getNewChar(){
        return $_SESSION['newchar'];
    }
    
    public function login($username, $password){
        if(empty($username) || empty($password)){
            $message[] = 'Username and Password cannot be empty!';
        }
        if(count(pengguna::getPengguna("WHERE username='".$username."'")) == 0){
            $message[] = 'Username belum terdaftar.';
        }else{
            $userpassword = pengguna::getPengguna("WHERE username='".$username."'")[0]->password;
            if(md5($password) != $userpassword){
                $message[] = "Username and Password don't match!";
            }
        }
        if(empty($message)){
//            $message[] = "Login Success!";
        }
        
        return $message;
    }
    
    public function vplogin($username, $password, $newChar){
        if(empty($username) || empty($password)){
            $message[] = 'Username and Password cannot be empty!';
        }
        if(count(pengguna::getPengguna("WHERE username='".$username."'")) == 0){
            $message[] = 'Username belum terdaftar.';
        }else{
            $i = 0;
            $true = 1;
            $reconst = '';
            do{
                $j = 33;
                $acc = 0;
                do{
                    if ($password[$i] == $_SESSION['newchar'][$j-33][0]){
                        if (strlen($_SESSION['newchar'][$j-33]) > 1){
                            if (strlen($password) < ($i + 2)){
                                $true = 0;
                                $acc = 1;
                            }else{
                                if ($password[$i+1] == $_SESSION['newchar'][$j-33][1]){
                                    $reconst = $reconst . chr($j);
                                    $i += 2;
                                    $acc = 1;
                                }else{
                                    $true = 0;
                                    $acc = 1;
                                }
                            }
                        }else{
                            $reconst = $reconst . chr($j);
                            $i++;
                            $acc = 1;
                        }
                    }
                    if ($j == 126){
                        $true = 0;
                    }
                    $j++;
                }while($j <= 126 && $acc == 0);
            }while($i < strlen($password) && $true == 1);
            if ($i < strlen($password) && $true == 0){
                $message[] = "Username and Password don't match!";
            }else{
                $userpassword = pengguna::getPengguna("WHERE username='".$username."'")[0]->password;
                if(md5($reconst) != $userpassword){
                    $message[] = "Username and Password don't match!";
                }
            }
        }
        if(empty($message)){
//            $message[] = "Login Success!";
        }
        
        return $message;
    }
}
