@props(['title' => null])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'PPDB' }} - Yayasan Al-Ishlah Insan Mulia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <x-public.navbar :schools="$schools ?? \App\Support\DemoData::schools()" />

        <main class="flex-1">
            {{ $slot }}
        </main>

        <footer class="bg-gray-800 text-white py-6 mt-auto">
            <div class="container mx-auto px-4 text-center">
                <p class="text-sm">PPDB Online - Yayasan Al-Ishlah Insan Mulia Wonosobo</p>
                <p class="text-xs text-gray-400 mt-1">Prototipe: data contoh</p>
            </div>
        </footer>
    </div>
</body>
</html>
