<template>
    <nav>
        <div class="p-4 shadow-md shadow-black-200 relative bg-white">
            <div class="container mx-auto flex justify-between items-center">
                <div><a class="navbar-brand" href="/"><img src="@/images/logoipsum-227.svg"
                                                           alt="Super Awesome Logo"/></a></div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                </div>
            </div>
        </div>

    </nav>
    <div class="container mx-auto">
        <slot/>
    </div>
    <div class="container mx-auto px-4 border border-t-gray-300 border-x-0 border-b-0">
        <footer class="flex flex-wrap justify-between align-items-center py-3 my-4 border-top">
            <p class="text-gray-500">© 2023 <a href="/">Design Matrix</a></p>

            <a href="/">
                <img src="@/images/logoipsum-227.svg" alt="Awesome placeholder logo!">
            </a>

            <div class="justify-end">
                <a href="#" class="px-2 text-gray-500">Home</a>
                <a href="#" class="px-2 text-gray-500">Features</a>
                <a href="#" class="px-2 text-gray-500">Pricing</a>
                <a href="#" class="px-2 text-gray-500">FAQs</a>
                <a href="#" class="px-2 text-gray-500">About</a>
            </div>
        </footer>
    </div>
</template>
