<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>La liste des sous-catégories</title>
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
    <h1>Liste des Sous-Catégories</h1>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Texte</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->nom_produit }}</td>
                <td>{{ $product->texte}}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</body>
