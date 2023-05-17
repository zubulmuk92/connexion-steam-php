<?php 
    session_start();
    if(!$_SESSION['logged_in']){
        header("location: error.php");
        exit();
    }

    $steam_api_key = 'AA24DC1C18A916CA34B613C620CEC066';

    $response = file_get_contents('http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key='.$steam_api_key.'&steamid='.$_SESSION['userData']['steam_id'].'&include_appinfo=true&format=json');
    $response = json_decode($response,true);

    $userData = $response['response'];

    $nbr_jeux = $userData["game_count"];
    $array_jeux = $userData["games"];

    $username = $_SESSION['userData']['name'];
    $avatar = $_SESSION['userData']['avatar'];

    $nbr_heures_total=0;

    foreach ($array_jeux as $jeux) {
        $jeux_heures = round($jeux["playtime_forever"]/60,2);
        $nbr_heures_total+=$jeux_heures;
    }

    $nbr_jours_total=round($nbr_heures_total/24);
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
    <div class="flex items-center justify-center bg-steam-lightGray text-white flex-col">
        <a href='index.php' class='mt-30 mr-3 bg-gray text-xl px-5 py-3 rounded-md flex items-center space-x-4 hover:bg-gray-600 transition duration-75'>
            <span>Accueil</span>
        </a>
        <div class="text-2xl mt-5">Quelques informations,</div>
        <div class="mt-5 bg-info-liste_amis px-5 py-3 rounded-sm flex items-center justify-center flex-col">
            <div class="text-xl mb-5 flex items-center font-medium">
                <img src='<?php echo $avatar;?>' class="rounded-full w-12 h-12 mr-3"/>
                <?php echo $username;?>
            </div>
            <p>Vous possédez un total de <?php echo $nbr_jeux; ?> jeux.</p>
            <p>Vous avez joué en tout sur steam <?php echo $nbr_heures_total; ?> heures soit environ <?php echo $nbr_jours_total; ?> jours.</p>
        </div>
        <?php 
            foreach ($array_jeux as $jeux) {
                $jeux_nom = $jeux["name"];
                $jeux_img = "http://media.steampowered.com/steamcommunity/public/images/apps/".$jeux['appid']."/".$jeux['img_icon_url'].".jpg";
                $jeux_heures = round($jeux["playtime_forever"]/60,2);
                if (isset($jeux["playtime_2weeks"])) {
                    $jeux_heures_2weeks = round($jeux["playtime_2weeks"]/60,2);
                } else {
                    $jeux_heures_2weeks=0;
                }
                $app_id=$jeux['appid'];
        
                echo "
                    <div class='mt-5 mb-5 font-bold'>$jeux_nom</div>
                    <img src=$jeux_img></img>
                    <div class='mt-5'>ID : $app_id</div>
                    <div>$jeux_heures h</div>
                    <div>Ces deux denières semaines : $jeux_heures_2weeks h</div>
                    <br>
                    <hr>
                ";
            }
        ?>
    </div>

</body>
</html>