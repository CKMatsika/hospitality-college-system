@props([
    'headers' => [],
    'data' => [],
    'actions' => true,
    'searchable' => false,
    'paginated' => false
])

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    
    <!-- Search Bar -->
    @if($searchable)
    <div class="p-4 border-b border-gray-200">
        <div class="relative">
            <input type="text" 
                   id="tableSearch"
                   placeholder="Search..." 
                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        </div>
    </div>
    @endif
    
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    @foreach($headers as $header)
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ $header['label'] }}
                        @if(isset($header['sortable']))
                        <button onclick="sortTable('{{ $header['key'] }}')" class="ml-1 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-sort text-xs"></i>
                        </button>
                        @endif
                    </th>
                    @endforeach
                    @if($actions)
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                @foreach($data as $item)
                <tr class="hover:bg-gray-50 transition-colors">
                    @foreach($headers as $header)
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if(isset($header['component']))
                            @include($header['component'], ['item' => $item])
                        @elseif(isset($header['format']) && $header['format'] === 'currency')
                            ${{ number_format($item[$header['key']], 2) }}
                        @elseif(isset($header['format']) && $header['format'] === 'date')
                            {{ \Carbon\Carbon::parse($item[$header['key']])->format('M d, Y') }}
                        @elseif(isset($header['badge']))
                            <span class="px-2 py-1 text-xs rounded-full {{ $header['badge']['class'] }}">
                                {{ $item[$header['key']] }}
                            </span>
                        @else
                            {{ $item[$header['key']] ?? 'N/A' }}
                        @endif
                    </td>
                    @endforeach
                    @if($actions)
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            <button onclick="editItem({{ $item['id'] }})" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteItem({{ $item['id'] }})" class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($paginated && isset($paginator))
    <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
        <div class="text-sm text-gray-700">
            Showing <span class="font-medium">{{ $paginator->firstItem() }}</span> to 
            <span class="font-medium">{{ $paginator->lastItem() }}</span> of 
            <span class="font-medium">{{ $paginator->total() }}</span> results
        </div>
        <div class="flex space-x-2">
            @if($paginator->onFirstPage())
            <button disabled class="px-3 py-1 text-sm border border-gray-300 rounded-md bg-gray-100 text-gray-400">
                Previous
            </button>
            @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-50">
                Previous
            </a>
            @endif
            
            @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-50">
                Next
            </a>
            @else
            <button disabled class="px-3 py-1 text-sm border border-gray-300 rounded-md bg-gray-100 text-gray-400">
                Next
            </button>
            @endif
        </div>
    </div>
    @endif
</div>

<script>
// Search functionality
@if($searchable)
document.getElementById('tableSearch').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#tableBody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
@endif

// Sort functionality
function sortTable(column) {
    const table = document.querySelector('table');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    rows.sort((a, b) => {
        const aText = a.children[getColumnIndex(column)].textContent.trim();
        const bText = b.children[getColumnIndex(column)].textContent.trim();
        
        // Try to parse as number
        const aNum = parseFloat(aText.replace(/[^0-9.-]/g, ''));
        const bNum = parseFloat(bText.replace(/[^0-9.-]/g, ''));
        
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return aNum - bNum;
        }
        
        return aText.localeCompare(bText);
    });
    
    rows.forEach(row => tbody.appendChild(row));
}

function getColumnIndex(column) {
    const headers = document.querySelectorAll('th');
    for (let i = 0; i < headers.length; i++) {
        if (headers[i].textContent.toLowerCase().includes(column.toLowerCase())) {
            return i;
        }
    }
    return 0;
}

// Action handlers
function editItem(id) {
    // Implement edit functionality
    console.log('Edit item:', id);
}

function deleteItem(id) {
    if (confirm('Are you sure you want to delete this item?')) {
        // Implement delete functionality
        console.log('Delete item:', id);
    }
}
</script>
