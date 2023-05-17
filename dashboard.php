<?php
session_start();
if(!$_SESSION['logged_in']){
    header("location: error.php");
    exit();
}

$username = $_SESSION['userData']['name'];
$avatar = $_SESSION['userData']['avatar'];
$steamid64 = $_SESSION['userData']['steam_id'];
$profile_url = $_SESSION['userData']['profile_url'];
$privacy = $_SESSION['userData']['privacy'];
$array_datecreation = getdate($_SESSION['userData']['datecreation']);
$datecreation=$array_datecreation["mday"]."/".$array_datecreation["mon"]."/".$array_datecreation["year"];

?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./styles/style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="flex items-center justify-center h-screen bg-steam-lightGray text-white flex-col">
        <div class="flex items-center justify-center flex-row">
            <?php 
                if ($privacy==3) {
                    echo "
                        <a href='liste_jeux.php' class='mt-10 mr-3 bg-gray text-xl px-5 py-3 rounded-md flex items-center space-x-4 hover:bg-gray-600 transition duration-75'>
                            <span>Liste jeux</span>
                        </a>
                        <a href='liste_amis.php' class='mt-10 bg-gray text-xl px-5 py-3 rounded-md flex items-center space-x-4 hover:bg-gray-600 transition duration-75'>
                            <span>Liste ami(e)s</span>
                        </a>
                    ";
                } else {
                    echo "<div>Votre profil est privé, impossible de récupéré plus d'informations</div>";
                }
            ?>
        </div>
        <div class="text-2xl">Bienvenu(e) sur le dashboard,</div>
        <div class="text-4xl mt-10 flex items-center font-medium">
            <img src='<?php echo $avatar;?>' class="rounded-full w-12 h-12 mr-3"/>
            <?php echo $username;?></div>

            <h2 class="mt-10 text-xl mb-10">Informations relatives à votre compte :</h2>

            <li>SteamID 64 : <?php echo $steamid64 ?></li>
            <li>URL du profil : <a class="text-blue" href=<?php echo $profile_url ?>><?php echo $profile_url ?></a></li>
            <li>Date de création du profil : <?php echo $datecreation ?></li>
            
        <a href="logout.php" class="mt-10 bg-red-600 text-xl px-5 py-3 rounded-md flex items-center space-x-4 hover:bg-gray-600 transition duration-75">
            <i class="fa-solid fa-right-from-bracket text-2xl"></i>
            <span>Déconnexion</span>
        </a>
    </div>

</body>
</html>