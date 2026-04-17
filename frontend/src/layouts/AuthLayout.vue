<template>
    <div class="auth-container">
        <main class="auth-content">
            <router-view />
        </main>
        
        <footer class="auth-footer">
            <p>&copy; 2026 - Sistema de Gestión de Pacientes</p>
        </footer>
    </div>
</template>

<style scoped>
.auth-container {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    background-color: var(--p-surface-50);
}

.auth-content {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}

.auth-footer {
    padding: 1rem;
    text-align: center;
    border-top: 1px solid var(--p-content-border-color);
}
</style>