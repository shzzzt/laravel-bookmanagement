<nav class="bg-white/80 backdrop-blur-sm border-b border-pastel-blue/30 shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                    <div class="bg-gradient-to-br from-accent-yellow to-accent-blue p-2 rounded-lg group-hover:rotate-12 transition-transform duration-300">
                        <i class="fas fa-book text-white text-lg"></i>
                    </div>
                    <span class="text-2xl font-bold text-accent-blue">
                        PageTurner
                    </span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-accent-blue transition-colors duration-200 font-medium">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
                <a href="{{ route('books.index') }}" class="text-gray-700 hover:text-accent-blue transition-colors duration-200 font-medium">
                    <i class="fas fa-book mr-2"></i>Browse Books
                </a>
                <a href="{{ route('categories.index') }}" class="text-gray-700 hover:text-accent-blue transition-colors duration-200 font-medium">
                    <i class="fas fa-tags mr-2"></i>Categories
                </a>

                @auth
                @if(!auth()->user()->isAdmin())
                <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-accent-blue transition-colors duration-200 font-medium">
                    <i class="fas fa-cart-shopping mr-2"></i>Cart
                </a>
                @endif
                <a href="{{ route('orders.index') }}" class="text-gray-700 hover:text-accent-blue transition-colors duration-200 font-medium">
                    <i class="fas fa-receipt mr-2"></i>Orders
                </a>

                @if(auth()->user()->isAdmin())
                <div class="relative group">
                    <button class="text-gray-700 hover:text-accent-blue transition-colors duration-200 font-medium">
                        Admin
                    </button>
                    <div class="absolute bg-white shadow-lg rounded-lg mt-2 py-2 w-48 z-50 opacity-0 invisible -translate-y-1 transition-all duration-200 delay-0 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 group-hover:delay-150">
                        <a href="{{ route('admin.books.create') }}" class="block px-4 py-2 text-gray-700 hover:bg-pastel-blue/20">
                            <i class="fas fa-plus mr-2"></i>Add Book
                        </a>
                        <a href="{{ route('admin.categories.create') }}" class="block px-4 py-2 text-gray-700 hover:bg-pastel-blue/20">
                            <i class="fas fa-tag mr-2"></i>Add Category
                        </a>
                    </div>
                </div>
                @endif
                @endauth
            </div>

            <!-- User Actions -->
            <div class="flex items-center space-x-4">
                @guest
                <a href="{{ route('login') }}" class="px-4 py-2 text-accent-blue hover:text-accent-blue/80 transition-colors duration-200 font-medium">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-gradient-to-r from-pastel-blue to-pastel-yellow text-white rounded-lg hover:shadow-md transition-all duration-200 font-medium">
                    <i class="fas fa-user-plus mr-2"></i>Register
                </a>
                @endguest

                @auth
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-pastel-blue to-pastel-yellow flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="text-gray-700 font-medium">{{ auth()->user()->name }}</span>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative group">
                        <button class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors duration-200">
                            <i class="fas fa-chevron-down text-gray-600"></i>
                        </button>
                        <div class="absolute right-0 mt-2 bg-white shadow-lg rounded-lg py-2 w-48 z-50 opacity-0 invisible -translate-y-1 transition-all duration-200 delay-0 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 group-hover:delay-150">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-pastel-blue/20">
                                <i class="fas fa-user mr-2"></i>Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </div>
</nav>