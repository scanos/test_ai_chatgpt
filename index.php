<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DogMinding Service</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f8ff;
            color: #333;
        }

        header {
            background-color: #0073e6;
            color: white;
            padding: 10px 20px;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
        }

        main {
            padding: 20px;
        }

        .testimonials, .location {
            margin: 20px 0;
        }

        footer {
            background-color: #0073e6;
            color: white;
            text-align: center;
            padding: 10px 0;
        }

        .contact-form {
            max-width: 600px;
            margin: 0 auto;
        }

        .contact-form label {
            display: block;
            margin: 10px 0 5px;
        }

        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .contact-form button {
            background-color: #0073e6;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .contact-form button:hover {
            background-color: #005bb5;
        }

        .responsive-map {
            width: 100%;
            height: 300px;
            border: 0;
        }

        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
                align-items: center;
            }

            nav ul li {
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1>DogMinding Service</h1>
            <ul>

    <?php
    session_start();
    $loggedInUser = isset($_SESSION['username']) ? $_SESSION['username'] : null;
    ?>


                <li><a href="index.php">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#testimonials">Testimonials</a></li>
                <li><a href="#location">Location</a></li>
                <li><a href="#contact">Contact</a></li>
    
        
         
         <li><a href="register.html">Register</a></li>
         <li><a href="login.html">Login</a></li>
        
        <?php if ($loggedInUser): ?>
        <div class="user-info">
                <a href="dashboard.php"> Dashboard </a><a href="logout.php"> Logout </a> Logged in as: <strong><?php echo htmlspecialchars($loggedInUser); ?></strong>
        </div> </ul>
    <?php endif; ?>

        </nav>
    </header>

    <main>
        <section id="about">
            <h2>About Us</h2>
            <p>Welcome to our DogMinding Service. We provide reliable and caring dog minding for your furry friends.</p>
        </section>

        <section id="testimonials" class="testimonials">
            <h2>Testimonials</h2>
            <p>"Great service! My dog was so happy and well cared for." - Jane D.</p>
            <p>"Highly recommend! Professional and loving." - Mark S.</p>
        </section>

        <section id="location" class="location">
            <h2>Our Location</h2>
            <p>We are located at 123 Dog Lane, Pet City.</p>
            <iframe class="responsive-map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509851!2d144.95373631531847!3d-37.81627944202109!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf5777b4b2f17a0d5!2s123%20Dog%20Lane%2C%20Pet%20City!5e0!3m2!1sen!2sus!4v1613625056803!5m2!1sen!2sus"></iframe>
        </section>

        <section id="contact" class="contact-form">
            <h2>Contact Us</h2>
            <form method="post" action="save_contact.php">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            <?php if ($loggedInUser): ?>
                <input type="hidden" id="username" name="username" value="<?php echo htmlspecialchars($loggedInUser); ?>"> <label for="message">Message</label>
            <?php endif; ?>
                <textarea id="message" name="message" rows="5" required></textarea>

                <button type="submit">Send</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 DogMinding Service. All rights reserved.</p>
    </footer>
</body>
</html>

