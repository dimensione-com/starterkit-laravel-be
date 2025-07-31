<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Verifica Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Stile base (puoi sostituirlo con Tailwind o Bootstrap se preferisci) -->
    <style>
body {
    font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
    background: white;
    padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .button {
    margin-top: 1.5rem;
            background-color: #2563eb;
            color: white;
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .button:hover {
    background-color: #1e40af;
        }

        .message {
    color: green;
    margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Verifica il tuo indirizzo email</h2>
        <p>
            Ti abbiamo inviato un link di verifica alla tua email.
            Clicca qui per verificare il tuo account.
            <a href="{{ url('/verify-email/' . $token)}}">
                Verifica Email
            </a>
        </p>
    </div>
</body>
</html>
