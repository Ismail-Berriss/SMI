<?php

    require_once "config.php";
    $lignes = array();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/all.min.css">
    <title>Products</title>
</head>
<body>
    <div class="container">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Nom</th>
                <th scope="col">Code</th>
                <th scope="col">Quantité</th>
                <th scope="col">Prix Unité</th>
                <th scope="col">Prix</th>
                <th scope="col">Enlever</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <?php
                if(isset($_GET["action"]) && !empty(trim($_GET["action"]))) {

                    if ($_GET["action"] == "add") {

                        if(isset($_GET["code"]) && !empty(trim($_GET["code"]))) {

                            $sql = "select * from produit where code = ?";

                            if($stmt = $conn->prepare($sql)) {

                                $stmt->bind_param("s", $param_code);

                                $param_code = trim($_GET["code"]);

                                if($stmt->execute()) {

                                    $result = $stmt->get_result();

                                    if($result->num_rows == 1) {

                                        $row = $result->fetch_array(MYSQLI_ASSOC);

                                        array_push($lignes, $row);

                                    } else {
                                        /*header("location: error.php");
                                        exit();*/
                                    }

                                } else {
                                    echo "Erreur! Veuillez réessayer plus tard.";
                                }

                            }

                        }

                    }

                }
                var_dump($lignes);
                foreach($lignes as $ligne) {

                    ?>
                    <td><?php echo $ligne["name"]; ?></td>
                    <td><?php echo $ligne["code"]; ?></td>
                    <td><?php echo trim($_POST["quantité"]); ?></td>
                    <td><?php echo $ligne["prix"]; ?> DH</td>
                    <td><?php echo trim($_POST["quantité"]) * $ligne["prix"]; ?> DH</td>
                    <td><a href=""><i class="fa-solid fa-trash"></i></a></td>

            <?php
                }
            ?>

            </tr>
            <tr>
                <th scope="row"></th>
                <th>Total</th>
                <tr></tr>
                <tr></tr>
                <tr></tr>
            </tr>
            </tbody>
        </table>
            <h4>Produits</h4>
            <hr>
            <?php

                $sql = "select * from produit";
                $result = $conn->query($sql);

                if($result->num_rows > 0) {

                    echo '<div class="row">';

                    while($row = $result->fetch_assoc()) {

                        ?>

                        <div class="col" style="width: 15rem; padding: 0 15px" >
                            <div class="card" style="width: 15rem;">
                                <img src='img/<?php echo $row["image"] ?>' class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row["name"] ?></h5>
                                    <div class="card-text" style="display: flex; gap: 5px">
                                        <?php echo $row["prix"] . ' DH'?>
                                        <form action="index.php?action=add&code=<?php echo $row["code"] ?>"
                                        method="post">
                                            <input type="text" name="quantité" value="1" size="5">
                                            <input type="submit" value="Ajouter">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php


                    }

                        echo '</div>';
                }

            ?>
        </div>
</body>
</html>
