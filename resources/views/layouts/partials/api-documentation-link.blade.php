<footer class="mt-8 p-4 bg-gray-50  dark:bg-gray-950 text-left">
  <a 
    href="{{ url(config('skeletor.instance_prefix') . '/docs/') }}" 
    target="_blank" 
    rel="noopener noreferrer" 
    class="inline-flex items-center justify-center w-16 h-16 bg-gray-300 text-primary-600 font-bold rounded-full shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 transition"
    title="Voir l'aide de Skeletor et des modules installés'"
  >
    ?
  </a>
  <a 
    href="{{ route('l5-swagger.default.api') }}" 
    target="_blank" 
    rel="noopener noreferrer" 
    class="inline-flex items-center justify-center w-16 h-16 bg-gray-300 text-primary-600 font-bold rounded-full shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 transition"
    title="Voir la documentation des API"
  >
    API
  </a>
</footer>