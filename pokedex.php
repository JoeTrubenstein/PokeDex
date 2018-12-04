<?php

require 'vendor/autoload.php';

$headers = [

    'Cache-Control' => 'public, max-age=31536000',      
    'Accept'        => 'application/json'
    
];

$client = new GuzzleHttp\Client(['base_uri' => 'https://pokeapi.co/api/v2/',
'http_errors' => false

]);

$query = $_POST['query'];


$response = $client->request('GET', "pokemon/$query/");
$data = (string) $response->getBody();

$statuscode = $response->getStatusCode();

if ($statuscode === 404) {
    $data = 0;
}


$arr = json_decode($data, true);
$pokeId = $arr['id'];


$response2 = $client->request('GET', "characteristic/$pokeId/");
$data2 = (string) $response2->getBody();

$statuscode2 = $response2->getStatusCode();

if ($statuscode2 === 404) {

    $data2 = 0;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Poke Api</title>
    <link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
    <link rel="icon" type="image/png" href="25.png">
    <style>
#container {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 50vh;
    flex-flow: column;
    margin-top: 10px;
}

#wrapper {
    margin-top: 10px;
    background-color: whitesmoke;
    display: inline-flex;
    height: 300px;
    width: 300px;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
}

#pokeBox {
    display: flex;
    flex-flow: column;
    height: 300px;
    width: 50%;
    text-align: center;
    padding: 10px;
}

#pokeBox2 {
    display: flex;
    flex-flow: column;
    height: 300px;
    text-align: left;
    width: 50%;
    padding: 10px;
}


@media only screen and (min-device-width : 320px) and (max-device-width : 480px) {

    #container {
        height:60vh;
    }
    
    .btn {
        display:none;
    }

}

    </style>
</head>

<body>
    <section>
        <h5>a minimalist Pokedex - powered by <a href="https://pokeapi.co/">PokeApi</a></h5>
        <h5>enter the name or ID number of any pokemon</h5>
        <form method="POST" action="poke.php">
            <input required type=text name="query" id="query">
            <button class="btn" type="submit"></button>
        </form>
    </section>
    <div id="container">
        <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/poke-ball.png">
        <div id="wrapper">
            <div id="pokeBox">
                <h5>
                    <?php echo $pokeId ?>
                </h5>
                <div id="nameBox"></div>
                <div id="picBox"></div>
            </div>
            <div id="pokeBox2">
                <div id="typeBox"></div>
                <div id="moveBox"></div>
            </div>
        </div>
      <div id="descBox"></div>
    </div>
</body>
<script>
    console.log(<?php echo $statuscode ?>)

    var pokeObj = <?php echo $data ;?>

    var pokeObj2 = <?php echo $data2 ;?>

    if (pokeObj == 0) {
        alert("no Pokemon matched the search term. Try 'Pikachu' or '25'")
    }


    pic = document.createElement("img")
    pic.src = pokeObj.sprites.front_default
    picBox.appendChild(pic)

    pokeName = document.createElement("h5")
    pokeName.innerHTML = pokeObj.name
    nameBox.appendChild(pokeName)

    for (let i = 0; i < pokeObj.types.length; i++) {

        let type = document.createElement("h5")
        type.innerHTML = pokeObj.types[i].type.name
        typeBox.appendChild(type)

    }


    for (let i = 0; i < 3; i++) {

        let type = document.createElement("h5")
        type.innerHTML = pokeObj.moves[i].move.name
        moveBox.appendChild(type)

    }


    desc = document.createElement("h5")
    if (pokeObj2 != 0) {
        desc.innerHTML = pokeObj2.descriptions[1].description
        descBox.appendChild(desc)
    } else {
        desc.innerHTML = " "
        descBox.appendChild(desc)

    }
</script>

</html>
