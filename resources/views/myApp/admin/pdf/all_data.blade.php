<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export PDF - Toutes les Tables</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h1>Rapport Global</h1>

    {{-- Inclure la vue des Clients --}}
    @include('myApp.admin.pdf.clients', ['clients' => $clients])

    {{-- Inclure la vue des Fournisseurs Clients --}}
    @include('myApp.admin.pdf.fournisseurClients', ['fournisseurClients' => $fcs])

    {{-- Inclure la vue des Fournisseurs --}}
    @include('myApp.admin.pdf.fournisseurs', ['fournisseurs' => $fournisseurs])

    {{-- Inclure la vue des Prospects --}}
    @include('myApp.admin.pdf.prospects', ['prospects' => $prospects])

</body>
</html>
