@props(['label'])

<label class="relative inline-flex items-center cursor-pointer">
    <input type="checkbox" value="" {{$attributes->class(['sr-only', 'peer'])}}>
    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-slate-400 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
    <span class="ml-2 text-sm">{{ $label }}</span>
</label>
