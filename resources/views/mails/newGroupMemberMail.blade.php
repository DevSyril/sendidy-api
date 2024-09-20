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
        <h1>Bonjour,</h1>
        <h2>Félicitations, Mr/Mdme {{ $invitationSender }} vient de vous inviter à rejoindre son groupe {{ $group }}
            sur la plateforme <span>Sendify </span> </h2>
        <div>
            <h4>Utilisez le lien et l'adresse email suivant pour accéder au groupe</h4>
            <p> {{ $invitationReceiver }}</p>
            <p>Lien : {{ $groupLink }}</p>
        </div>
    </main>
</body>

</html>
