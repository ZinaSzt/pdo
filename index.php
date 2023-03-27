<!DOCTYPE html>
<html>

<head>
    <title>Liste des Friends</title>
</head>

<body>
    <h1>Friends</h1>

    <?php
    require_once('connec.php');
    $pdo = new PDO(DSN, USER, PASS);

    $friends = $pdo->query("SELECT * FROM friend")->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($friends)) {
        echo '<ul>';
        foreach ($friends as $friend) {
            echo '<li>' . $friend['firstname'] . ' ' . $friend['lastname'] . '</li>';
        }
        echo '</ul>';
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $firstname = $_POST['firstname'] ?? '';
        $lastname = $_POST['lastname'] ?? '';

        if (!empty($firstname) && !empty($lastname)) {
            $query = "INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)";
            $statement = $pdo->prepare($query);

            $statement->execute([':firstname' => $firstname, ':lastname' => $lastname]);

            header('Location: index.php');
            exit;
        } else {
            echo '<p>Les champs Firstname et Lastname sont obligatoires.</p>';
        }
    }
    ?>

    <h2>Ajouter un Friend</h2>

    <form method="POST">
        <div>
            <label for="firstname">Firstname :</label>
            <input type="text" id="firstname" name="firstname" required>
        </div>
        <div>
            <label for="lastname">Lastname :</label>
            <input type="text" id="lastname" name="lastname" required>
        </div>
        <button type="submit">Ajouter</button>
    </form>
</body>

</html>