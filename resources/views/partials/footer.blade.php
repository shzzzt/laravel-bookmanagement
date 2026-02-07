<footer class="bg-white border-t-4 mt-12" style="border-color: var(--pastel-blue);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <!-- About -->
            <div>
                <h3 class="text-lg font-bold mb-4">
                    <span style="color: var(--pastel-blue);">Page</span><span style="color: var(--pastel-yellow-dark);">Turner</span>
                </h3>
                <p style="color: var(--light-text); line-height: 1.6;">
                    Your destination for quality books at great prices. Discover your next favorite read today.
                </p>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-bold mb-4" style="color: var(--dark-text);">Quick Links</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('home') }}" style="color: var(--light-text); text-decoration: none;" class="hover:text-pastel-blue transition">
                            → Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('books.index') }}" style="color: var(--light-text); text-decoration: none;" class="hover:text-pastel-blue transition">
                            → Browse Books
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categories.index') }}" style="color: var(--light-text); text-decoration: none;" class="hover:text-pastel-blue transition">
                            → Categories
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Contact -->
            <div>
                <h3 class="text-lg font-bold mb-4" style="color: var(--dark-text);">Contact</h3>
                <p style="color: var(--light-text); margin-bottom: 8px;">
                    📧 support@pageturner.com
                </p>
                <p style="color: var(--light-text);">
                    📞 (123) 456-7890
                </p>
            </div>
        </div>
        
        <!-- Divider -->
        <div style="border-top: 2px solid var(--pastel-blue); margin-top: 24px; padding-top: 24px; text-align: center;">
            <p style="color: var(--light-text);">
                © {{ date('Y') }} PageTurner Bookstore. All rights reserved. | Built with ❤️ using Laravel
            </p>
        </div>
    </div>
</footer>