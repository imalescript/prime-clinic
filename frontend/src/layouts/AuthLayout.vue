<template>
    <div class="flex flex-col min-h-screen w-full">
        <main class="grow center-box">
            <div class="min-w-2xs max-w-md w-full mx-4">
                <router-view />
            </div>
        </main>
        
        <footer class="p-4 text-center border-t">
            <p>&copy; 2026 - Prime Clinic</p>
        </footer>
    </div>
        
</template>
