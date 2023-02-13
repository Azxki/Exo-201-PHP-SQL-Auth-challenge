<?php
$user = 'root';
$pass = '';
$host = 'localhost';
$data = 'test';

try {
    $db = new PDO('mysql:host=' . $host . ';dbname=' . $data . ';charset=utf8', $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "INSERT INTO user (id, username, email, firstname, lastname, password)
            VALUES ('1', $username, 'dodo@gmail.com', 'Azxki', 'coco', $password)
";
//request to find the user in database
    $req = $db->prepare('SELECT * FROM user WHERE username = :username');
//$username and $password are variable you got from the login form
    $req->bindParam(':username', $username);
    if ($req->execute()) {
        $userData = $req->fetch();
        if (password_verify($password, $userData['password'])) {
            // Mon mot de passe est bon, on peut enregistrer en session.
        } else {
            echo "Le mot de passe utilisé ne semble pas être correct, ou aucun compte associé à ce nom d'utilisateur";
        }
    } else {
        echo "Aucun compte associé à ce nom d'utilisateur";
    }
}
catch (PDOException $exception) {
    echo $exception->getMessage();
}