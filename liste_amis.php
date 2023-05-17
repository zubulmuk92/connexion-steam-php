<?php 
    session_start();
    if(!$_SESSION['logged_in']){
        header("location: error.php");
        exit();
    }

    $steam_api_key = 'AA24DC1C18A916CA34B613C620CEC066';

    $response = file_get_contents('http://api.steampowered.com/ISteamUser/GetFriendList/v0001/?key='.$steam_api_key.'&steamid='.$_SESSION['userData']['steam_id'].'&relationship=friend');
    $response = json_decode($response,true);

    $array_amis = $response['friendslist']["friends"];
    $array_amis_taille = count($_SESSION['userFriends']);

    $dejacharger=false;

    if ($array_amis_taille==0) {
        foreach ($array_amis as $ami) {
            $response = file_get_contents('https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='.$steam_api_key.'&steamids='.$ami["steamid"]);
            $response = json_decode($response,true);
        
        
            $amiData = $response['response']['players'][0];
            $amiArray = [
                'steamid'=>$amiData["steamid"],
                'avatar_url'=>$amiData["avatarmedium"],
                'name'=>$amiData["personaname"],
                'profile_url'=>$amiData["profileurl"],
            ];
    
            array_push($_SESSION['userFriends'],$amiArray);
        }
    } else {
        $dejacharger=true;
    }

    $array_amis_taille = count($_SESSION['userFriends']);

    $username = $_SESSION['userData']['name'];
    $avatar = $_SESSION['userData']['avatar'];
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
        <?php 
            if ($dejacharger==true) {
                echo "
                    <div class='mt-5'><i>Attention : votre liste d'ami(e)s à été chargé ultérieurement dans votre session,</i></div>
                    <div><i>si vous souhaitez la recharger vous devez vous reconnecter sur le site.</i></div>    
                ";

            }
        ?>
        <div class="text-2xl mt-5">Quelques informations,</div>
        <div class="mt-5 bg-info-liste_amis px-5 py-3 rounded-sm flex items-center justify-center flex-col">
            <div class="text-xl mb-5 flex items-center font-medium">
                <img src='<?php echo $avatar;?>' class="rounded-full w-12 h-12 mr-3"/>
                <?php echo $username;?>
            </div>
            <p>Vous possédez un total de <?php echo $array_amis_taille; ?> ami(e)s.</p>
        </div>
        <?php 
            foreach ($_SESSION['userFriends'] as $ami) {  
                $ami_nom=$ami["name"];
                $ami_avatar=$ami["avatar_url"];
                $ami_steamid=$ami["steamid"];
                $ami_profileurl=$ami["profile_url"];
               
                echo "
                    <div class='mt-5'>$ami_nom</div>
                    <img class='mt-5 mb-5 rounded-sm' src=$ami_avatar></img>
                    <div>SteamID64 : $ami_steamid</div>
                    <div>Profile steam : <a class='text-blue' href=$ami_profileurl>$ami_profileurl</a></div>
                    <br>
                    <hr>
                ";
            }
        ?>
    </div>

</body>
</html>