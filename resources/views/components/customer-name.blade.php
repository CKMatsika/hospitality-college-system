@props(['item'])

<div class="flex items-center">
    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
        <span class="text-blue-600 text-sm font-medium">{{ strtoupper(substr($item['name'], 0, 1)) }}</span>
    </div>
    <div>
        <p class="font-medium text-gray-900">{{ $item['name'] }}</p>
        <p class="text-xs text-gray-500">ID: #{{ str_pad($item['id'], 4, '0', STR_PAD_LEFT) }}</p>
    </div>
</div>
