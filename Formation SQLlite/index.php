<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $curl = curl_init();

    // curl_setopt_array($curl, array(
    //     CURLOPT_URL => 'https://v3.football.api-sports.io/{endpoint}',
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_ENCODING => '',
    //     CURLOPT_MAXREDIRS => 10,
    //     CURLOPT_TIMEOUT => 0,
    //     CURLOPT_FOLLOWLOCATION => true,
    //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //     CURLOPT_CUSTOMREQUEST => 'GET',
    //     CURLOPT_HTTPHEADER => array(
    //         'x-rapidapi-key: 66018bf2a788648d27ca996efd59bf9e',
    //         'x-rapidapi-host: v3.football.api-sports.io'
    //     ),
    // ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;

    ?>
    <div id="wg-api-football-livescore" data-host="v3.football.api-sports.io" data-refresh="60" data-key="66018bf2a788648d27ca996efd59bf9e" data-theme="" data-show-errors="true" class="api_football_loader">
    </div>
    <script type="module" src="https://widgets.api-sports.io/football/1.1.8/widget.js">
    </script>
</body>

</html>