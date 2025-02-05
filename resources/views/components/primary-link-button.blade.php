@props(['href'])
<a class='inline-flex items-center px-2 md:px-4 py-2 bg-gray-500 border border-transparent rounded-md font-medium text-sm text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'
    href={{ $href }}>
    {{ $slot }}
</a>
