<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Application Platform</title>
    <link rel="stylesheet" href="style.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!-- Navbar -->
    <nav>
        <div class="container nav_container">
            <a href="#" class="nav_logo">Logo</a>
            <div class="menu_icon" id="menuToggle">
                <i class="fas fa-bars" id="menuIcon"></i>
            </div>
        </div>
    </nav>

    <!-- Sidebar Menu -->
    <aside class="sidebar" id="sidebar">
        <ul class="nav_items">
            <li><a href="Blog.php">Blog</a></li>
            <li><a href="About.php">About</a></li>
            <li><a href="Services.php">Services</a></li>
            <li><a href="Contact.php">Contact</a></li>
            <li><a href="Signin.php">Sign In</a></li>
            <li><a href="public_blog.php">Public Blog</a></li>
            
            <li><a href="Logout.php">Logout</a></li> <!-- Logout Link -->
            <li><a href="Login in.php">Login In</a></li>
        </ul>
    </aside>

    <!-- Featured Post Section -->
    <section class="featured">
        <div class="featured_container">
            <div class="post_thumbnail">
                <img src="./images/kingfisher.jpg" height="300px" width="400px" alt="Kingfisher Image">
            </div>
            <div class="category_info">
                <button>Wild Life</button>
                <h1>Photo of Perched Kingfisher</h1>
                <p>Kingfisher (Alcedo atthis) lives near lakes, seas, and rivers. The Common European Kingfisher perches on a stick above the river, hunting for fish. This sparrow-sized bird has the typical short-tailed, large-headed kingfisher profile; it has blue upperparts, orange underparts, and a long bill.</p>
            </div>
        </div>
    </section>

    <!-- Posts Section -->
    <section class="sec_post">
        <div class="sect_post">
            <div class="sect_posts">
                <img src="./images/Zebra.jpg" height="200px" width="100px" alt="Zebra Image">
                <div class="title_post">
                    <h1>Mountain Zebra</h1>
                    <p>Zebras are African equines with distinctive black-and-white striped coats. There are three living species: Grévy's zebra, the plains zebra, and the mountain zebra.</p>
                </div>
            </div>
            
            <div class="sect_posts">
                <img src="./images/Tiger.jpg" height="200px" width="100px" alt="Tiger Image">
                <div class="title_post">
                    <h1>Malayan Tiger</h1>
                    <p>The Malayan tiger is a tiger from a specific population of the Panthera tigris tigris subspecies native to Peninsular Malaysia.</p>
                </div>
            </div>
            
            <div class="sect_posts">
                <img src="./images/kingfisher.jpg" height="200px" width="100px" alt="Kingfisher Image">
                <div class="title_post">
                    <h1>Photo of Perched Kingfisher</h1>
                    <p>Kingfisher (Alcedo atthis) lives near lakes, seas, and rivers. The Common European Kingfisher perches on a stick above the river, hunting for fish.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Buttons Section -->
    <hr>
    <section class="category_container">
        <div class="category_buttons">
            <button>Food</button>
            <button>Technology</button>
            <button>Music</button>
            <button>Art</button>
            <button>Travel</button>
            <button>Wild Life</button>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Blog Application Platform. All rights reserved.</p>
        <p>Contact us at: info@blogplatform.com</p>
    </footer>

    <!-- JavaScript -->
    <script>
        // JavaScript to toggle the sidebar and change the icon
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const menuIcon = document.getElementById('menuIcon');

        menuToggle.addEventListener('click', function() {
            if (sidebar.classList.contains('show_sidebar')) {
                sidebar.classList.remove('show_sidebar');
                menuIcon.classList.remove('fa-times');
                menuIcon.classList.add('fa-bars');
            } else {
                sidebar.classList.add('show_sidebar');
                menuIcon.classList.remove('fa-bars');
                menuIcon.classList.add('fa-times');
            }
        });
    </script>
</body>
</html>
