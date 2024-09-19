<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vérification d'adresse email</title>
</head>
<body>
    <main>
        <h1>Bonjour {{ $username }},</h1>
        <h2>Félicitations, Vous venez de créer un compte chez <span>Sendify </span> avec l'adresse email suivante: </h2>
        <p>Adresse e-mail : {{ $email }}</p>
        <div>
            <h4>Utilisez le code suivant pour vérifier votre adresse email</h4>
            <p>{{ $code }}</p>
        </div>
    </main>
</body>
</html>