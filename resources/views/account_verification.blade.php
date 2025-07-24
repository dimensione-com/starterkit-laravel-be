<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica Account</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8fafc; color: #222; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .container { background: #fff; padding: 2rem 3rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); text-align: center; }
        .success { color: #16a34a; font-size: 1.3rem; }
        .error { color: #dc2626; font-size: 1.1rem; }
    </style>
</head>
<body>
    <div class="container">
        @if($success)
            <h1 class="success">Account attivato con successo!</h1>
            <p>Ora puoi accedere con le tue credenziali.</p>
        @else
            <h1 class="error">Errore nella verifica</h1>
            <p>{{ $message }}</p>
        @endif
    </div>
</body>
</html> 