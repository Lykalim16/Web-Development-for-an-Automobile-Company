
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toyota Automobile Corporation</title>
    <!-- Additional Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@100&family=Cormorant+Garamond:wght@300&family=Josefin+Sans:wght@100&family=Libre+Baskerville&family=Playfair+Display&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="jquery.flipster.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.11/typed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.11/typed.min.js"></script>
</head>
<body>
    <header>
        <div class="logo"><a href="mainpage.php">TOYOTA</a></div>
        <nav>
            <ul>
                <li><a href="signup/signup.php">SIGN UP</a></li>
                <li><a href="login/login.php">LOG IN</a></li>
                <li><a href="branches.html">BRANCHES</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class = "banner">
            <div class="lright">
                <h2>VALUE THAT FEELS</h2>
                <h1>BRAND NEW</h1>
            </div>
        </section>
        
        <section class = "cars">
            <div class="card">
                <div class = "box">
                    <div class = "imgbx">
                        <img src="img/Hilux.png" class = "carPics">
                    </div>
                    <div class = "contentBx">
                        <div>
                            <a href="hilux.html">
                                <h2 style = "font-family: Ghino-bold">HILUX</h2>
                                <p style = "font-family: Ghino-light">The Toyota Hilux now comes with a tougher exterior that exudes a powerful presence on and off the road. Its high-performance engine lets you conquer roads and scale mountains - and every trail in between.</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class = "box">
                    <div class = "imgbx">
                        <img src="img/Innova.png" class = "carPics">
                    </div>
                    <div class = "contentBx">
                        <div>
                            <a href="innova.html">
                                <h2 style = "font-family: Ghino-bold">INNOVA</h2>
                                <p style = "font-family: Ghino-light">From urban scapes to green escapes, the Innova is versatile enough to match each breathtaking view with
                                    its upscaled, refreshed exteriors.</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class = "box">
                    <div class = "imgbx">
                        <img src="img/Wigo.jpg" class = "carPics">
                    </div>
                    <div class = "contentBx">
                        <div>
                            <a href="wigo.html">
                                <h2 style = "font-family: Ghino-bold">WIGO</h2>
                                <p style = "font-family: Ghino-light">A cool and compact exterior that's refreshing to the eyes and easy on the road.</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class = "kobe">
            <section class = "second">
                <div class="left">
                    <h2>OUR MISSION</h2>
                    <h3>To be the world's leading provider of good quality <br> products and give an outstanding service to satisfy our <br> customer's mobility needs. Kachow!</h3>
                </div>
            </section>
        </div>
    </main>
    <footer>
        <ul>
                <li><a href="signup/signup.php">SIGN UP</a></li>
                <li><a href="login/login.php">LOG IN</a></li>
                <li><a href="branches.html">BRANCHES</a></li>
        </ul>
        <div class="socMed">
            <a href="facebook.com">
                <img src="img/facebook.png" alt="facebook">
            </a>
            <a href="instagram.com">
                <img src="img/instagram.png" alt="instagram">
            </a>
            <a href=twitter.com>
                <img src="img/twitter.png" alt="twitter">
            </a>
        </div>
    </footer>
    <script src="myjs.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="jquery.flipster.min.js"></script>
    <script>
        $('.carousel').flipster({
            style:'carousel',
            spacing: -0.3,
        });
    </script>
</body>
</html>