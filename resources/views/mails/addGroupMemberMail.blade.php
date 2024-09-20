<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invitaion à rejoindre un groupe</title>
</head>

<body>
    <main>
        <h1>Bonjour {{ $invitationReceiver }},</h1>
        <h2>Félicitations, Mr/Mdme {{ $invitationSender }} vient de vous ajouter au groupe {{ $group }}
            sur la plateforme <span>Sendify </span> </h2>
        <div>
            <h4>Utilisez le lien suivant pour accéder au groupe</h4>
            <p>{{ $groupLink }}</p>
        </div>
    </main>
</body>

</html>
