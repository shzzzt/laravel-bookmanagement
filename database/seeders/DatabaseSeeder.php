<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create or get admin user
        User::firstOrCreate(
            ['email' => 'admin@pageturner.com'],
            [
                'name' => 'Admin User',
                'role' => 'admin',
                'password' => bcrypt('password'),
            ]
        );

        // Create customer users
        $customers = User::factory(10)->create(['role' => 'customer']);

        // Create categories
        $categories = [
            Category::create(['name' => 'Fiction', 'description' => 'Contemporary and classic fiction novels']),
            Category::create(['name' => 'Mystery & Thriller', 'description' => 'Suspenseful mysteries and thrilling stories']),
            Category::create(['name' => 'Fantasy', 'description' => 'Epic fantasy adventures and magical worlds']),
            Category::create(['name' => 'Science Fiction', 'description' => 'Futuristic and science fiction tales']),
            Category::create(['name' => 'Romance', 'description' => 'Love stories and romantic fiction']),
            Category::create(['name' => 'Biography', 'description' => 'Life stories and memoirs']),
            Category::create(['name' => 'Self-Help', 'description' => 'Personal development and growth']),
            Category::create(['name' => 'History', 'description' => 'Historical accounts and events']),
        ];

        // Create real books
        $booksData = [
            ['title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee', 'isbn' => '978-0-06-112008-4', 'price' => 12.99, 'category_id' => 1, 'description' => 'A gripping tale of racial injustice and moral growth in the American South.'],
            ['title' => '1984', 'author' => 'George Orwell', 'isbn' => '978-0-452-28423-4', 'price' => 13.99, 'category_id' => 1, 'description' => 'A dystopian masterpiece exploring totalitarianism and surveillance.'],
            ['title' => 'The Great Gatsby', 'author' => 'F. Scott Fitzgerald', 'isbn' => '978-0-7432-7356-5', 'price' => 11.99, 'category_id' => 1, 'description' => 'An American classic about ambition, wealth, and the American Dream.'],
            ['title' => 'The Catcher in the Rye', 'author' => 'J.D. Salinger', 'isbn' => '978-0-316-76948-0', 'price' => 10.99, 'category_id' => 1, 'description' => 'A coming-of-age story following the journey of Holden Caulfield.'],

            ['title' => 'The Girl with the Dragon Tattoo', 'author' => 'Stieg Larsson', 'isbn' => '978-0-307-26920-9', 'price' => 15.99, 'category_id' => 2, 'description' => 'A gripping mystery about a journalist and a hacker uncovering dark secrets.'],
            ['title' => 'The Da Vinci Code', 'author' => 'Dan Brown', 'isbn' => '978-0-385-50420-5', 'price' => 14.99, 'category_id' => 2, 'description' => 'An art historian and symbologist uncover secret societies and religious mysteries.'],
            ['title' => 'Gone Girl', 'author' => 'Gillian Flynn', 'isbn' => '978-0-553-38594-6', 'price' => 13.99, 'category_id' => 2, 'description' => 'A psychological thriller about a marriage and an unimaginable morning.'],
            ['title' => 'The Silence of the Lambs', 'author' => 'Thomas Harris', 'isbn' => '978-0-312-93546-7', 'price' => 12.99, 'category_id' => 2, 'description' => 'A chilling psychological thriller about an FBI trainee and a serial killer.'],

            ['title' => 'The Hobbit', 'author' => 'J.R.R. Tolkien', 'isbn' => '978-0-547-92807-6', 'price' => 14.99, 'category_id' => 3, 'description' => 'An epic adventure of a hobbit on an unexpected journey through Middle-earth.'],
            ['title' => 'Harry Potter and the Sorcerer\'s Stone', 'author' => 'J.K. Rowling', 'isbn' => '978-0-439-13960-1', 'price' => 13.99, 'category_id' => 3, 'description' => 'The beginning of an enchanting magical journey at Hogwarts School.'],
            ['title' => 'The Chronicles of Narnia: The Lion, the Witch and the Wardrobe', 'author' => 'C.S. Lewis', 'isbn' => '978-0-06-085052-8', 'price' => 12.99, 'category_id' => 3, 'description' => 'Children discover a magical world hidden in a wardrobe.'],
            ['title' => 'A Game of Thrones', 'author' => 'George R.R. Martin', 'isbn' => '978-0-553-10354-1', 'price' => 16.99, 'category_id' => 3, 'description' => 'A complex tale of political intrigue, war, and dragons in a fantasy realm.'],

            ['title' => 'Dune', 'author' => 'Frank Herbert', 'isbn' => '978-0-441-17271-9', 'price' => 15.99, 'category_id' => 4, 'description' => 'An epic science fiction saga set on a desert planet with valuable resources.'],
            ['title' => 'The Hitchhiker\'s Guide to the Galaxy', 'author' => 'Douglas Adams', 'isbn' => '978-0-345-39180-3', 'price' => 11.99, 'category_id' => 4, 'description' => 'A hilarious adventure through space exploring the absurdity of the universe.'],
            ['title' => 'Foundation', 'author' => 'Isaac Asimov', 'isbn' => '978-0-553-29438-0', 'price' => 14.99, 'category_id' => 4, 'description' => 'A groundbreaking science fiction masterpiece about civilization and prediction.'],
            ['title' => 'Neuromancer', 'author' => 'William Gibson', 'isbn' => '978-0-441-56959-4', 'price' => 13.99, 'category_id' => 4, 'description' => 'A cyberpunk novel that defined the genre of virtual reality and AI.'],

            ['title' => 'Pride and Prejudice', 'author' => 'Jane Austen', 'isbn' => '978-0-141-43951-8', 'price' => 10.99, 'category_id' => 5, 'description' => 'A timeless romance about love, marriage, and social expectations.'],
            ['title' => 'The Notebook', 'author' => 'Nicholas Sparks', 'isbn' => '978-0-446-52664-2', 'price' => 11.99, 'category_id' => 5, 'description' => 'A touching and emotional love story about commitment and memory.'],
            ['title' => 'Outlander', 'author' => 'Diana Gabaldon', 'isbn' => '978-0-440-21411-1', 'price' => 14.99, 'category_id' => 5, 'description' => 'A sweeping romance spanning time and continents through history.'],
            ['title' => 'The Fault in Our Stars', 'author' => 'John Green', 'isbn' => '978-0-525-47881-1', 'price' => 12.99, 'category_id' => 5, 'description' => 'A poignant romance between two teenagers with terminal illnesses.'],

            ['title' => 'Steve Jobs', 'author' => 'Walter Isaacson', 'isbn' => '978-1-451-65817-6', 'price' => 16.99, 'category_id' => 6, 'description' => 'An intimate biography of the visionary Apple founder.'],
            ['title' => 'Educated', 'author' => 'Tara Westover', 'isbn' => '978-0-399-59087-2', 'price' => 15.99, 'category_id' => 6, 'description' => 'A powerful memoir about a woman\'s journey from survivalism to education.'],
            ['title' => 'Becoming', 'author' => 'Michelle Obama', 'isbn' => '978-1-524-76326-8', 'price' => 17.99, 'category_id' => 6, 'description' => 'The memoir of the 44th First Lady of the United States.'],
            ['title' => 'The Storyteller', 'author' => 'Dave Grohl', 'isbn' => '978-0-0304-3644-5', 'price' => 16.99, 'category_id' => 6, 'description' => 'Dave Grohl\'s rock autobiography filled with music history.'],

            ['title' => 'Atomic Habits', 'author' => 'James Clear', 'isbn' => '978-0-735-21141-3', 'price' => 14.99, 'category_id' => 7, 'description' => 'Transform your life through tiny, incremental changes and habit formation.'],
            ['title' => 'The 7 Habits of Highly Effective People', 'author' => 'Stephen Covey', 'isbn' => '978-0-743-26957-7', 'price' => 13.99, 'category_id' => 7, 'description' => 'Timeless principles for personal and professional effectiveness.'],
            ['title' => 'Thinking, Fast and Slow', 'author' => 'Daniel Kahneman', 'isbn' => '978-0-374-27563-1', 'price' => 15.99, 'category_id' => 7, 'description' => 'Explore the psychology of decision-making and human behavior.'],
            ['title' => 'The Power of Now', 'author' => 'Eckhart Tolle', 'isbn' => '978-1-577-31130-1', 'price' => 12.99, 'category_id' => 7, 'description' => 'A guide to spiritual enlightenment and living in the present moment.'],

            ['title' => 'Sapiens', 'author' => 'Yuval Noah Harari', 'isbn' => '978-0-062-31657-1', 'price' => 16.99, 'category_id' => 8, 'description' => 'A sweeping history of humankind from the Stone Age to modern times.'],
            ['title' => 'A Brief History of Time', 'author' => 'Stephen Hawking', 'isbn' => '978-0-553-38016-3', 'price' => 13.99, 'category_id' => 8, 'description' => 'Explore the universe from the Big Bang to black holes.'],
            ['title' => 'The Rise and Fall of the Third Reich', 'author' => 'William L. Shirer', 'isbn' => '978-0-449-21595-0', 'price' => 17.99, 'category_id' => 8, 'description' => 'A comprehensive history of Nazi Germany and World War II.'],
            ['title' => '1491', 'author' => 'Charles C. Mann', 'isbn' => '978-1-400-03205-9', 'price' => 15.99, 'category_id' => 8, 'description' => 'Discover the true history of the Americas before Columbus.'],
        ];

        foreach ($booksData as $book) {
            Book::firstOrCreate(
                ['isbn' => $book['isbn']],
                $book
            );
        }

        // Create meaningful reviews
        $reviewsData = [
            ['user_id' => null, 'book_id' => 1, 'rating' => 5, 'comment' => 'A masterpiece that shaped American literature. The moral lessons are timeless and deeply moving.'],
            ['user_id' => null, 'book_id' => 1, 'rating' => 5, 'comment' => 'Harper Lee\'s portrayal of injustice is both heartbreaking and enlightening. Every chapter resonates with truth.'],
            ['user_id' => null, 'book_id' => 2, 'rating' => 5, 'comment' => 'Orwell\'s vision of surveillance and control has proven disturbingly prophetic. A must-read for everyone.'],
            ['user_id' => null, 'book_id' => 2, 'rating' => 4, 'comment' => 'Dense and challenging, but the ideas about totalitarianism are incredibly relevant today.'],
            ['user_id' => null, 'book_id' => 3, 'rating' => 5, 'comment' => 'The magic of Fitzgerald\'s prose captures the Jazz Age perfectly. Daisy and Gatsby\'s story is unforgettable.'],
            ['user_id' => null, 'book_id' => 3, 'rating' => 4, 'comment' => 'Beautiful writing and symbolism throughout. A quintessential American novel that deserves its reputation.'],
            ['user_id' => null, 'book_id' => 4, 'rating' => 4, 'comment' => 'Holden\'s voice is authentic and relatable even today. The exploration of adolescent alienation is brilliant.'],
            ['user_id' => null, 'book_id' => 5, 'rating' => 5, 'comment' => 'Unputdownable! The mystery deepens with every page. Larsson creates unforgettable characters.'],
            ['user_id' => null, 'book_id' => 5, 'rating' => 4, 'comment' => 'Dark and gripping. The social commentary adds depth beyond just the thriller aspects.'],
            ['user_id' => null, 'book_id' => 6, 'rating' => 4, 'comment' => 'Fast-paced and cleverly plotted. Brown keeps you guessing right to the end.'],
            ['user_id' => null, 'book_id' => 7, 'rating' => 5, 'comment' => 'A psychological thriller that will mess with your mind in the best way possible. Flynn is brilliant!'],
            ['user_id' => null, 'book_id' => 8, 'rating' => 5, 'comment' => 'Hannibal Lecter is one of the most fascinating characters in fiction. A perfect psychological thriller.'],
            ['user_id' => null, 'book_id' => 9, 'rating' => 5, 'comment' => 'Tolkien\'s world-building is extraordinary. The Hobbit is the perfect adventure story for any age.'],
            ['user_id' => null, 'book_id' => 9, 'rating' => 5, 'comment' => 'Simple yet profound. Bilbo\'s character development is wonderful. A timeless classic.'],
            ['user_id' => null, 'book_id' => 10, 'rating' => 5, 'comment' => 'Iconic beginning to an incredible series. Rowling\'s imagination is boundless. Pure magic!'],
            ['user_id' => null, 'book_id' => 10, 'rating' => 5, 'comment' => 'Even for adults, this book is enchanting. I was captivated from the first page to the last.'],
            ['user_id' => null, 'book_id' => 11, 'rating' => 5, 'comment' => 'Lewis creates a magical world that feels real and meaningful. A wonderfully imaginative tale.'],
            ['user_id' => null, 'book_id' => 12, 'rating' => 5, 'comment' => 'Martin\'s complex characters and intricate plotting set a new standard for fantasy. Absolutely brilliant!'],
            ['user_id' => null, 'book_id' => 12, 'rating' => 4, 'comment' => 'Epic in scope with morally gray characters. The world-building and political intrigue are exceptional.'],
            ['user_id' => null, 'book_id' => 13, 'rating' => 5, 'comment' => 'A monumental work of science fiction. Herbert\'s vision of a desert planet is visually stunning and philosophically deep.'],
            ['user_id' => null, 'book_id' => 14, 'rating' => 5, 'comment' => 'Hilarious and absurd in the best way. Adams\' humor is timeless and the adventure is absolutely delightful.'],
            ['user_id' => null, 'book_id' => 15, 'rating' => 5, 'comment' => 'Asimov\'s Foundation series is revolutionary. This first book is a stunning achievement in sci-fi writing.'],
            ['user_id' => null, 'book_id' => 16, 'rating' => 4, 'comment' => 'Pioneering cyberpunk that still holds up. Gibson\'s vision of cyberspace was remarkably prescient.'],
            ['user_id' => null, 'book_id' => 17, 'rating' => 5, 'comment' => 'Austen\'s wit and social commentary are as sharp now as they were 200 years ago. Elizabeth and Darcy are unforgettable.'],
            ['user_id' => null, 'book_id' => 18, 'rating' => 4, 'comment' => 'A deeply emotional love story. Sparks captures the essence of devotion and memory beautifully.'],
            ['user_id' => null, 'book_id' => 19, 'rating' => 5, 'comment' => 'Epic romance spanning time and history. Gabaldon creates an immersive world and unforgettable characters.'],
            ['user_id' => null, 'book_id' => 20, 'rating' => 5, 'comment' => 'Heartbreaking and beautiful. Green writes with such honesty and depth about young love and mortality.'],
            ['user_id' => null, 'book_id' => 21, 'rating' => 5, 'comment' => 'An intimate look at Steve Jobs. Isaacson provides remarkable insight into a visionary mind.'],
            ['user_id' => null, 'book_id' => 22, 'rating' => 5, 'comment' => 'Powerful and inspiring. Westover\'s journey from isolation to education is truly remarkable and moving.'],
            ['user_id' => null, 'book_id' => 23, 'rating' => 4, 'comment' => 'Michelle Obama\'s memoir is eloquent and inspiring. She gives us an intimate look at her extraordinary life.'],
            ['user_id' => null, 'book_id' => 24, 'rating' => 5, 'comment' => 'Dave\'s storytelling is fantastic. Rock fans will love this behind-the-scenes look at music history.'],
            ['user_id' => null, 'book_id' => 25, 'rating' => 5, 'comment' => 'Revolutionary approach to personal development. Clear\'s habit framework is practical and life-changing.'],
            ['user_id' => null, 'book_id' => 26, 'rating' => 5, 'comment' => 'Timeless principles that have helped millions. Covey\'s wisdom transcends decades and resonates deeply.'],
            ['user_id' => null, 'book_id' => 27, 'rating' => 4, 'comment' => 'Kahneman reveals how our minds work. Fascinating insights into cognitive biases and decision-making.'],
            ['user_id' => null, 'book_id' => 28, 'rating' => 4, 'comment' => 'A spiritual guide to living mindfully. Tolle\'s message about presence is transformative and profound.'],
            ['user_id' => null, 'book_id' => 29, 'rating' => 5, 'comment' => 'Extraordinary journey through human history. Harari connects biology, culture, and history brilliantly.'],
            ['user_id' => null, 'book_id' => 30, 'rating' => 4, 'comment' => 'Hawking makes complex physics accessible and fascinating. A window into the mysteries of the universe.'],
            ['user_id' => null, 'book_id' => 31, 'rating' => 5, 'comment' => 'Comprehensive and well-researched. Shirer provides an essential understanding of this dark period in history.'],
            ['user_id' => null, 'book_id' => 32, 'rating' => 5, 'comment' => 'Challenges historical narratives about pre-Columbian civilizations. Fascinating and eye-opening research.'],
        ];

        // Assign reviews to random customers
        $books = Book::all();
        foreach ($reviewsData as $reviewData) {
            $randomCustomer = $customers->random();

            // Ensure unique user_id and book_id combination
            Review::firstOrCreate(
                [
                    'user_id' => $randomCustomer->id,
                    'book_id' => $reviewData['book_id'],
                ],
                [
                    'rating' => $reviewData['rating'],
                    'comment' => $reviewData['comment'],
                ]
            );
        }
    }
}
