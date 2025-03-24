<?php
// Verifica se il form è stato inviato
//$_SERVER è una variabile "superglobale" che contiene info riguardo il server e la sessione sottoforma di
// array chiave - valore
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ottieni i dati del form
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $host = "localhost";
    $dbname = "GameDexExtended";
    $user = "root";
    $pass = "";
    $permissionsList = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass); //connessione al db
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//qualsiasi errore che c'è nel db me lo solleva un'eccezione

        $sql = "SELECT password as pss FROM utente WHERE username = :usrname";
        $stmt = $pdo->prepare($sql); 
        $stmt->bindParam(':usrname', $username);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $userpss = $row['pss'];

        if(password_verify($password, $userpss)) {
            $sql = "SELECT * FROM permesso AS p INNER JOIN utente AS u on p.id_permesso = u.id WHERE u.username = :usrname";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':usrname', $username);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $permissionsList = "Permessi associati a " . $username . ":\\n";

            foreach ($row as $permesso)
                $permissionsList .= "[" . $permesso['id_permesso'] . "] - " . $permesso['descrizione'] . "\\n";
        }
        else
            $permissionsList = "Username o password errati!";

        echo "<script>alert('$permissionsList');</script>";
    } catch (PDOException $e) {
        die("Errore di connessione: " . $e->getMessage());
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <title>GAMEDEXEXTENDED</title>
</head>




<body>
    <div class="container-sm">
        <h1 class="text-center">GAMEDEXEXTENDED</h1>
        <form action="accesso.php" method="POST" onsubmit="return validateForm()">
            <div class="form-floating mb-3">


                <input type="user" class="form-control" id="user" placeholder="Username" required>
                <label for="user" class="w-auto">Username</label>


            </div>
            <div class="form-floating">


                <input type="password" class="form-control" id="pass" placeholder="pass" required>
                <label for="pass" class="w-auto">Password</label>


            </div><br>
            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="submit">Login</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>src = "script.js"</script>
</body>

</html>