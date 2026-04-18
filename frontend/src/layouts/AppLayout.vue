<template>
    <div class="flex flex-col min-h-screen w-full" b>
        <header class="h-14 bg-surface-50" >

        </header>

        <div class="grow flex w-full h-full bg-surface-200">
            <aside class="w-1/4 m-6 mr-3 rounded-lg bg-surface-50" >
               <MySideBar /> 
            </aside>

            <main class="grow m-6 ml-3 rounded-lg bg-surface-50 overflow-hidden">
                <router-view />
            </main>
        </div>
    </div>
   
</template>