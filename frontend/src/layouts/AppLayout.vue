<template>
  <div class="grid grid-rows-[auto_1fr] h-dvh w-full overflow-hidden bg-surface-200">
    
    <header class="h-14 bg-surface-50 z-10">

    </header>

    <div class="grid grid-cols-[1fr_4fr] overflow-hidden">
      
      <aside class="m-6 mr-3 rounded-lg bg-surface-50 overflow-y-auto">
        </aside>

      <main class="m-6 ml-3 rounded-lg bg-surface-50 overflow-hidden">
        <router-view />
      </main>
    </div>
  </div>
</template>