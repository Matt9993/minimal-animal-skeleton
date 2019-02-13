<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <style>
            html, body {
                background: linear-gradient(to bottom right, #67b26f, #4ca2cd);
                color: #444;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .top-left {
                position: absolute;
                left: 10px;
                top: 18px;
            }

            .top-right > a:hover {
                text-decoration: underline;
                color: white;
            }

            .content {
                text-align: center;
                color: white;
            }

            .title {
                font-size: 44px;
                height: 100%;
                background-image: url('/pictures/planet.jpg');
            }

            .nav-pills > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .nav-pills > a:hover {
                text-decoration: underline;
            }

            .parallax { 

                /* Set a specific height */
                height: 300px; 

                /* Create the parallax scrolling effect */
                background-attachment: fixed;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }

            .para-1 {
                background-image: url('/pictures/aurora.jpg');
            }

            #side-pic {
                border-radius: 4px;
                overflow: hidden;
                box-shadow: 0 30px 80px 10px rgba(0,0,0,.2);
            }

            #prod-pic {
                margin-top: 50px;
            }

            #about-pic {
                margin-top: 50px;
            }

            .row {
                display: flex;
            }

            .column {
                flex: 33.33%;
                padding: 5px;
            }

            .grid-container {
                display: inline-grid;
                grid-template-columns: auto auto auto;
                padding: 10px;
                grid-row-gap: 5px;
                grid-column-gap: 5px;
            }

            .grid-item {
                padding: 20px;
                font-size: 20px;
                text-align: center;
            }

        </style>
    </head>
    </head>
    <body>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    @if (Route::has('login'))
                    <div class="nav-tabs">
                        <div class="nav-pills">
                            <a href="#about">About</a>
                            <a href="#posts">Posts</a>
                            <a href="#contact">Order</a>
                            @auth
                                <a href="{{ url('/home') }}">Home</a>
                            @else
                            
                                <a href="{{ route('login') }}">Login</a>
                                <a href="{{ route('register') }}">Register</a>
                            @endauth
                        </div>
                    </div>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

        <div class="content">

            <div class="title m-b-md">
                <h2>The most</h2>
                <h2 id="pname"> || Amazign Website ||</h2>
            </div>

            <!-- END OF HEADER-->
            <h3>About Product</h3>
            <div id="about" class="col-sm-12 row">
                
                <div id="about-text" class="col-sm-6 column">
                    <p class="about">In today’s World, if you want to read about something, you have countless websites to
                    choose from but to know which one can give you the best of the correct and reliable information is really
                    difficult to know in the first strand. So, here is the list of 10 of the best Websites to read Articles from.
                    These websites have been picked up because of their content, huge as well as creative, and the X-factor such sites have that set them apart from the crowd.
                    Let us have a look at them one by one and see how they can make you smarter and wiser!</p>
                    <p>Conclusion
                    Congratulations on making it through the tutorial. This guide was designed to get you started on building your app, and you can use this as a building block to gain the skills you need to develop your application. I know this covers a lot of features and can be overwhelming if you are not familiar with the framework.

                    I hope this introduction to Laravel shows you why so many people are excited about the framework.

                    Join the weekly newsletter and check out the Laravel tutorials section of the site to go deeper and learn even more about the framework.</p>
                </div>

                <div id="about-pic" class="col-sm-6 column">
                    <img id="side-pic" src="/pictures/turtle.jpeg";>
                </div>
            </div>
            <!-- END OF ABOUT SECTION -->

            <!-- Parallax section -->
            <div class="parallax para-1"></div>

            <!-- End of Parallax section -->

            <h3>Posts</h3>
            <div id="posts" class="col-sm-12 row">

                <div id="prod-pic" class="col-sm-6 column">
                    <img id="side-pic" src="/pictures/smiley.jpeg";>
                </div>
                
                <div class="links col-sm-6 column">
                    <div class="grid-container">
                    @for ($i = 0; $i < 3; $i++)
                        <div class="grid-item">
                            <h4>{{ $posts[$i]->title }}</h4>
                            <p>{{ substr($posts[$i]->description, 0, 30) }}</p>
                        </div>
                    @endfor
                    </div>
                </div>
            </div>

            <!-- END OF PRODUCTS SECTION -->
            <hr>
            
            <div class="contact" id="contact">
                <h3>Contact</h3>
                <form>
                    <br><strong>Your name</strong></br>                                            <input type="text" name="cf_name"></br><strong>Your e-mail</strong></br>
                    <input type="text" name="cf_email"><br><strong>Email</strong></br>                 <input type="text" name="cf_model"></br></br><strong> Message</strong></br>
                    <textarea name="cf_message"></textarea>
                    </br>
                    </br>
                    
                    <a href="submit.html"><input type="button" value="Submit"></a>
                    <button type="reset" value="Clear">Clear</button>
                </form></br>
            </div>


                <!-- END OF ORDER SECTION -->

                <footer>
                    <p id="brand">&copy; Máté Hricz 2018</p>
                    
                </footer>

                <!-- END OF FOOTER -->
        </div>
    </div>
</body>
</html>
