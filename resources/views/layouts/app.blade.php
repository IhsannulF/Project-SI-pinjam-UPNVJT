<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SI-PINJAM UPNVJT</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    
    <nav class="bg-blue-800 text-white p-4 shadow-md">
        <div class="max-w-7xl mx-auto font-bold text-xl flex justify-between items-center">
            <span>SI-PINJAM</span>
            </div>
    </nav>

    <main class="p-8 flex-grow">
        @yield('content')
    </main>

</body>
</html>