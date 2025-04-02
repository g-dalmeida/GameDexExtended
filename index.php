<?php
// Verifica se il form è stato inviato con il metodo POST
// $_SERVER è una variabile superglobale che contiene informazioni riguardo il server e la sessione
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ottieni i dati inviati dal form e sanificali con htmlspecialchars per prevenire attacchi XSS
    $username = htmlspecialchars($_POST['user']);
    $password = htmlspecialchars($_POST['pass']);

    // Configurazione della connessione al database
    $host = "localhost";
    $dbname = "GameDexExtended";
    $user = "root";
    $pass = "";
    $permissionsList = "";
    try {
        // Creazione dell'oggetto PDO per la connessione al database MySQL
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

        // Imposta la modalità di errore per generare eccezioni in caso di problemi
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Query per ottenere l'hash della password associata all'username
        $sql = "SELECT password as pss FROM Utente WHERE username = :usrname";
        $stmt = $pdo->prepare($sql); // Prepara la query per l'esecuzione         

        $stmt->bindParam(':usrname', $username); // Associa il parametro alla variabile         
        $stmt->execute(); // Esegue la query         
        $row = $stmt->fetch(PDO::FETCH_ASSOC); // Ottiene il risultato della query         

        $userpss = $row['pss']; // Recupera l'hash della password dall'array associativo         

        // Verifica se la password inserita corrisponde all'hash nel database
        if (password_verify($password, $userpss)) {
            // Query per ottenere i permessi associati all'utente
            $sql = "SELECT * FROM permesso AS p INNER JOIN utente AS u on p.id = u.id_permesso WHERE u.username = :usrname";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':usrname', $username);
            
            $stmt->execute();


            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Costruisce una stringa con la lista dei permessi dell'utente
            $permissionsList = "Permessi associati a " . $username . ":\n";
            

            // Itera attraverso i risultati della query per elencare i permessi
            foreach ($row as $permesso)
                 $permissionsList .= "[" . $permesso['denominazione'] . "] - " . $permesso['descrizione'] . "\n";
                // $permissionsList .= "[" . $permesso['denominazione'] . "] \n";
                echo $permissionsList;
                // echo "<script>alert('$permissionsList');</script>";

                // header("Location: accesso.php");
        } else
            // Messaggio di errore in caso di credenziali errate
            $permissionsList = "Username o password errati!";

        // Mostra un messaggio di avviso con i permessi (o errore) tramite un alert JavaScript
        // echo "<script>alert('$permissionsList');</script>";

    } catch (PDOException $e) {
        // In caso di errore nella connessione al database, termina l'esecuzione e mostra il messaggio di errore
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
        <form  method="POST" onsubmit="return validateForm()">
            <div class="form-floating mb-3">


                <input type="user"  name="user" class="form-control" id="user" placeholder="Username" >
                <label for="user" class="w-auto">Username</label>


            </div>
            <div class="form-floating">


                <input type="password" name="pass" class="form-control" id="pass" placeholder="pass" required>
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