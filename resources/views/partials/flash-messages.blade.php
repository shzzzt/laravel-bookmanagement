@if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-lg p-4 mb-4" style="background-color: rgba(168, 216, 234, 0.15); border-left: 4px solid var(--pastel-blue);">
            <div class="flex">
                <span style="color: var(--pastel-blue-dark); font-weight: 600;">✓</span>
                <p class="ml-3" style="color: var(--dark-text);">{{ session('success') }}</p>
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-lg p-4 mb-4" style="background-color: rgba(255, 107, 107, 0.15); border-left: 4px solid #FF6B6B;">
            <div class="flex">
                <span style="color: #FF6B6B; font-weight: 600;">✗</span>
                <p class="ml-3" style="color: var(--dark-text);">{{ session('error') }}</p>
            </div>
        </div>
    </div>
@endif

@if($errors->any())
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-lg p-4 mb-4" style="background-color: rgba(255, 107, 107, 0.15); border-left: 4px solid #FF6B6B;">
            <div class="flex">
                <span style="color: #FF6B6B; font-weight: 600;">⚠</span>
                <div class="ml-3">
                    <p style="color: var(--dark-text); font-weight: 600; margin-bottom: 8px;">Validation Errors:</p>
                    <ul style="color: var(--dark-text); margin-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li style="list-style-type: disc;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif