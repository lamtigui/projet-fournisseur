<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>La liste des prospects</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;

        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            word-wrap: break-word;
            max-width: 150px;
        }
        th {
            background-color: #f2f2f2;
        }
        td {
            overflow-wrap: break-word;
            white-space: normal;
        }
        body {
            font-size: 10px;
        }
    </style>

</head>
<body>
    <h1>Liste des Prospects</h1>
    <table>
        <thead>
            <tr>
                <th>Nom de la société</th>
                <th>GSM1 De La Société</th>
                <th>GSM2 De La Société</th>
                <th>Personne à contacter</th>
                <th>Téléphone</th>
                <th>Email</th>
                <th>Ville</th>
                <th>Catégorie</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($prospects as $prospect)
            <tr>
                <td>{{ !empty($prospect->nomSociete_prospect) ? $prospect->nomSociete_prospect : 'Particulier' }}
                <td>{{ $prospect->GSM1_prospect }}</td>
                <td>{{ $prospect->GSM2_prospect }}</td>
                <td>{{ $prospect->nom_prospect }}</td>
                <td>{{ $prospect->tele_prospect}}</td>
                <td>{{ $prospect->email_prospect}}</td>
                <td>{{ $prospect->ville_prospect}}</td>
                <td>
                    @forelse ($prospect->categorieProspects as $assoc)
                        @if ($assoc->categorie)
                            {{ $assoc->categorie->nom_categorie }}
                        @endif
                    @empty
                        Non catégorisé
                    @endforelse
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
