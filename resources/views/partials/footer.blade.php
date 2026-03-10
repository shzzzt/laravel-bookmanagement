<footer class="bg-white/80 backdrop-blur-sm border-t border-pastel-blue/30 mt-12">
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Brand Info -->
            <div>
                <div class="flex items-center space-x-2 mb-4">
                    <div class="bg-gradient-to-br from-accent-yellow to-accent-blue p-2 rounded-lg">
                        <i class="fas fa-book text-white"></i>
                    </div>
                    <span class="text-2xl font-bold text-accent-blue">
                        PageTurner
                    </span>
                </div>
                <p class="text-gray-600 mb-4">
                    Your destination for quality books and magical reading experiences.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-accent-blue transition-colors duration-200 flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('books.index') }}" class="text-gray-600 hover:text-accent-blue transition-colors duration-200 flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Browse Books
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categories.index') }}" class="text-gray-600 hover:text-accent-blue transition-colors duration-200 flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Categories
                        </a>
                    </li>
                    @auth
                    <li>
                        <a href="{{ route('orders.index') }}" class="text-gray-600 hover:text-accent-blue transition-colors duration-200 flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>My Orders
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4">Contact Us</h3>
                <ul class="space-y-3">
                    <li class="flex items-center text-gray-600">
                        <i class="fas fa-envelope text-accent-blue mr-3"></i>
                        <span>hello@pageturner.com</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-pastel-blue/30 mt-8 pt-8 text-center">
            <p class="text-gray-500">
                <i class="far fa-copyright mr-1"></i> {{ date('Y') }} PageTurner Bookstore. All rights reserved.
            </p>
        </div>
    </div>
</footer>