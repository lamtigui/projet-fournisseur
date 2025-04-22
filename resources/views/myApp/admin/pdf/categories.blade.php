<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>La liste des catégories</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Liste des Catégories</h1>
    <table>
        <thead>
            <tr>
                <th>Nom de la catégorie</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $cat)
            <tr>
                <td>{{ $cat->nom_categorie }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
