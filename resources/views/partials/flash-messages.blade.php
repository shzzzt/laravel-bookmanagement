@if(session('success'))
<div class="container mx-auto px-4 mb-6 animate-fade-in">
    <div class="bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3 text-lg"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="container mx-auto px-4 mb-6 animate-fade-in">
    <div class="bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-sm">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle text-red-500 mr-3 text-lg"></i>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    </div>
</div>
@endif

@if(session('warning'))
<div class="container mx-auto px-4 mb-6 animate-fade-in">
    <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg shadow-sm">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle text-yellow-500 mr-3 text-lg"></i>
            <span class="font-medium">{{ session('warning') }}</span>
        </div>
    </div>
</div>
@endif

@if($errors->any())
<div class="container mx-auto px-4 mb-6 animate-fade-in">
    <div class="bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-sm">
        <div class="flex items-center mb-2">
            <i class="fas fa-times-circle text-red-500 mr-3 text-lg"></i>
            <span class="font-medium">Please fix the following errors:</span>
        </div>
        <ul class="list-disc list-inside ml-8 space-y-1">
            @foreach($errors->all() as $error)
                <li class="text-sm">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif