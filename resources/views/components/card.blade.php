<div class="bg-{{ $color ?? 'white' }} p-6 rounded-lg shadow">
    <h3 class="text-lg font-semibold">{{ $title }}</h3>
    <p class="text-4xl font-bold text-{{ $textColor ?? 'gray-800' }}">{{ $slot }}</p>
</div>