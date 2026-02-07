<nav class="bg-white shadow-md border-b-4 border-pastel-blue" style="border-bottom-color: var(--pastel-blue);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="text-2xl font-bold">
                    <span style="color: var(--pastel-blue);">Page</span><span style="color: var(--pastel-yellow-dark);">Turner</span>
                </a>
                <p class="text-xs" style="color: var(--light-text);">Bookstore</p>
            </div>
            
            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="hover:text-pastel-blue transition" style="color: var(--dark-text); text-decoration: none;">
                    Home
                </a>
                <a href="{{ route('books.index') }}" class="hover:text-pastel-blue transition" style="color: var(--dark-text); text-decoration: none;">
                    Books
                </a>
                <a href="{{ route('categories.index') }}" class="hover:text-pastel-blue transition" style="color: var(--dark-text); text-decoration: none;">
                    Categories
                </a>
                
                @auth
                    @if(auth()->user()->isAdmin())
                        <div class="flex items-center space-x-4 pl-4 border-l-2" style="border-color: var(--pastel-blue);">
                            <a href="{{ route('admin.books.create') }}" class="btn-primary text-sm" style="padding: 6px 12px;">
                                + Book
                            </a>
                            <a href="{{ route('admin.categories.create') }}" class="btn-secondary text-sm" style="padding: 6px 12px;">
                                + Category
                            </a>
                        </div>
                    @endif
                @endauth
            </div>
            
            <!-- Right Side -->
            <div class="flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="btn-primary text-sm">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="btn-secondary text-sm">
                        Register
                    </a>
                @endguest
                
                @auth
                    <a href="{{ route('orders.index') }}" class="hover:text-pastel-blue transition" style="color: var(--dark-text); text-decoration: none; font-weight: 500;">
                        📋 Orders
                    </a>
                    
                    <div class="relative group">
                        <button class="flex items-center space-x-2" style="color: var(--dark-text);">
                            <span>👤</span>
                            <span>{{ auth()->user()->name }}</span>
                        </button>
                        
                        <div class="hidden group-hover:block absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg py-2 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100" style="color: var(--dark-text); text-decoration: none;">
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100" style="color: var(--dark-text);">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>