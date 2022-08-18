<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="background-color: #aa0000">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-gray-300 text-bold text-xl shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
