<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <title>Contratto di Servizio</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            margin: 40px;
        }

        h1 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 20px;
            color: #000;
        }

        p {
            text-align: justify;
            margin-bottom: 10px;
        }

        .firma {
            margin-top: 50px;
            text-align: center;
        }

        .firma span {
            display: block;
            border-top: 1px solid #000;
            width: 200px;
            margin: 0 auto;
            padding-top: 5px;
            font-size: 10px;
            font-style: italic;
        }

        .container {
            border: 1px solid #000;
            padding: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Contratto di Servizio</h1>

    <div class="container">
        <p>Tra <strong>Future Plus</strong> e il cliente <strong>{{ $consumer->nome }}</strong>, titolare dell’attività <strong>{{ $consumer->attivita }}</strong>.</p>
        <p>Con il presente contratto, il cliente accetta i termini di utilizzo del servizio...</p>
        <p>Data: {{ date('d/m/Y') }}</p>
    </div>

    <div class="firma">
        <span>Firma del Cliente</span>
    </div>
</body>
</html>
