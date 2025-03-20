<?php
$imdbID = isset($_GET['i']) ? $_GET['i'] : '';

if ($imdbID) {
    $apiKey = '80e3772e';
    $url = "http://www.omdbapi.com/?i=$imdbID&apikey=$apiKey";
    $response = file_get_contents($url);
    $movieData = json_decode($response, true);

    if ($movieData['Response'] === 'True') {
        $title = $movieData['Title'];
        $year = $movieData['Year'];
        $rating = $movieData['imdbRating'];
        $duration = $movieData['Runtime'];
        $plot = $movieData['Plot'];
        $actors = $movieData['Actors'];
        $poster = $movieData['Poster'];
        $genre = $movieData['Genre'];
        $director = $movieData['Director'];
    } else {
        echo "<p class='error'>Filme não encontrado.</p>";
        exit;
    }
} else {
    echo "<p class='error'>Filme não especificado.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - Detalhes</title>
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #181818;
            color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 0 20px;
        }
        .container {
            background-color: #2b2b2b;
            border-radius: 15px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.6);
            width: 100%;
            max-width: 750px; 
            padding: 20px;
            text-align: center;
        }
        h1 {
            color: #f4d03f;
            font-size: 2rem; 
            margin-bottom: 20px;
            font-weight: bold;
        }
        .details {
            background-color: #333;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            color: #fff;
            text-align: left;
        }
        .details img {
            max-width: 80%; 
            height: auto;
            border-radius: 10px;
            margin: 20px 0;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .details h2 {
            color: #f4d03f;
            font-size: 1.8rem;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .details p {
            font-size: 1rem;
            margin: 8px 0;
            line-height: 1.6;
        }
        .details p strong {
            color: #f4d03f;
        }
        .details .error {
            color: #e74c3c;
            font-size: 1.1rem;
            margin-top: 20px;
        }
        .button {
            padding: 10px 20px;
            background-color: #f4d03f;
            color: #181818;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 8px;
            margin-top: 20px;
            display: inline-block;
        }
        .button:hover {
            background-color: #e3b81e;
        }
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            h1 {
                font-size: 1.8rem;
            }
            .details h2 {
                font-size: 1.5rem;
            }
            .details p {
                font-size: 0.95rem;
            }
            .details img {
                max-width: 100%; 
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Detalhes do Filme</h1>
        <div class="details">
            <h2><?php echo $title; ?> (<?php echo $year; ?>)</h2>
            <img src="<?php echo $poster; ?>" alt="Poster de <?php echo $title; ?>">
            <p><strong>Elenco:</strong> <?php echo $actors; ?></p>
            <p><strong>Sinopse:</strong> <?php echo $plot; ?></p>
            <p><strong>Tempo de Duração:</strong> <?php echo $duration; ?></p>
            <p><strong>Gênero:</strong> <?php echo $genre; ?></p>
            <p><strong>Diretor:</strong> <?php echo $director; ?></p>
            <p><strong>Avaliação:</strong> <?php echo $rating; ?>/10</p>
        </div>
        <a href="landpage.html" class="button">Voltar</a>
    </div>
</body>
</html>
