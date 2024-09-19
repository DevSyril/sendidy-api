<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Récupération de mot de passe</title>
</head>

<body>
    <main>
        <h1>Bonjour {{ $username }},</h1>
        <p>Vous avez initié une réinitiaisation de mot de passe pour votre compte chez <span>Sendify</span> <br /> avec
            l'adresse suivante {{ $email }}</p>
        <div>
            <h4>Utilisez le code suivant pour réinitialiser le mot de passe</h4>
            <p>{{ $code }}</p>
        </div>
    </main>
</body>

</html>
