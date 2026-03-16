@props([
    'title' => '',
    'value' => '',
    'icon' => 'fas fa-chart-line',
    'color' => 'blue',
    'trend' => null,
    'trendValue' => null,
    'subtitle' => null
])

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover-lift">
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-600">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $value }}</p>
            
            @if($subtitle)
                <p class="text-sm text-gray-500 mt-1">{{ $subtitle }}</p>
            @endif
            
            @if($trend && $trendValue)
                <div class="flex items-center mt-2">
                    @if($trend === 'up')
                        <i class="fas fa-arrow-up text-green-500 text-xs mr-1"></i>
                        <span class="text-xs font-medium text-green-600">{{ $trendValue }}</span>
                    @elseif($trend === 'down')
                        <i class="fas fa-arrow-down text-red-500 text-xs mr-1"></i>
                        <span class="text-xs font-medium text-red-600">{{ $trendValue }}</span>
                    @else
                        <i class="fas fa-minus text-gray-500 text-xs mr-1"></i>
                        <span class="text-xs font-medium text-gray-600">{{ $trendValue }}</span>
                    @endif
                </div>
            @endif
        </div>
        
        <div class="ml-4">
            <div class="w-12 h-12 {{ $color === 'green' ? 'bg-green-100' : ($color === 'blue' ? 'bg-blue-100' : ($color === 'orange' ? 'bg-orange-100' : ($color === 'red' ? 'bg-red-100' : 'bg-purple-100'))) }} rounded-lg flex items-center justify-center">
                <i class="{{ $icon }} {{ $color === 'green' ? 'text-green-600' : ($color === 'blue' ? 'text-blue-600' : ($color === 'orange' ? 'text-orange-600' : ($color === 'red' ? 'text-red-600' : 'text-purple-600'))) }} text-lg"></i>
            </div>
        </div>
    </div>
</div>
