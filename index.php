<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SBF</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- slider  -->
    <script src="assets/js/slider.js" defer></script>
    <script src="assets/js/team.js" defer></script>
    <script src="assets/js/menu.js" defer></script>
    <script src="assets/js/award.js" defer></script>
    
</head>

<body>
   
        <header>
           <!-- Top Bar with Club Logos -->
    <div class="top-bar">
        <img src="assets/images/club/BPL.png" alt="Premier League " class="pl-logo">
        <h3 class="club-site">Club Site</h3>
        <div class="club-logos">
            <img src="assets/images/club/abahani.png" alt="Abahani">
            <img src="assets/images/club/mohamedan.png" alt="Mohamedan">
            <a href="clubweb/bdk.php"><img src="assets/images/club/kings.png" alt="Bashundhara Kings"></a>
            <img src="assets/images/club/fakirapool.png" alt="Fakirapool">
            <img src="assets/images/club/police.png" alt="MBangladesh Police">
            <img src="assets/images/club/rahmatgonj.png" alt="Rahmatgonj MFS">
            <img src="assets/images/club/ctgabahani.png" alt="Chittagong Abahani">
            <img src="assets/images/club/dhaka wenders.png" alt="Dhaka Wenders">
            <img src="assets/images/club/fortis.png" alt="Fortis FC">
            <img src="assets/images/club/brothers.png" alt="Brothers Union">
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="nav-bar">
        <div class="nav-left">
            <span class="nav-item">Premier League ▼</span>
            <span class="nav-item">Fantasy ▼</span>
            <span class="nav-item">Football & Community ▼</span>
            <span class="nav-item">About ▼</span>
            <span class="nav-item">More ▼</span>
        </div>
        <div class="nav-right">
            <span class="more-game">More than a game</span>
            <a href="login.php">
                <button class="sign-in">Sign in</button>
            </a>
            
            
        </div>
    </nav>

    <!-- Secondary Navigation -->
         <div class="bottom-nav">
            <span class="nav-link">Home</span>
            <a href="matchweek.php" style="text-decoration: none;">
            <span class="nav-link">Fixtures</span>
            </a>
        <span class="nav-link">Results</span>
        <a href="table.php" style="text-decoration: none;">
            <span class="nav-link">Tables</span>
        </a>
        <a href="transfer.php" style="text-decoration: none;">
            <span class="nav-link">Transfers</span>
        </a>
        <span class="nav-link">Stats</span>
        <span class="nav-link">News</span>
        <a href="video.php" style="text-decoration: none;">
            <span class="nav-link">Video</span>
        </a>
        <span class="nav-link">Watch Live</span>
        <span class="nav-link">Tickets</span>
        <span class="nav-link">Clubs</span>
        <span class="nav-link">Players</span>
        <span class="nav-link">Awards</span>
    </div>
        </header>

        <body>
            <!--sliding feature -->
            <div id="news-slider">
                <div class="slider-container">
                    <div class="slide mySlides" data-bg="assets/images/club/abaha.jpg" data-url="fullnews/abahani.html">Abahani Pushing Their Arch Rival!!</div>
                    <div class="slide mySlides" data-bg="assets/images/club/honey.jpg" data-url="fullnews/mohammedan.html">Mohammedan's Honeymoon Period Continue!!!!!</div>
                    <div class="slide mySlides" data-bg="assets/images/club/bdk.jpg" data-url="fullnews/bashundhara.html">Bashundhara Kings with ups and downs</div>
                    <div class="slide mySlides" data-bg="assets/images/club/ctg.jpg" data-url="fullnews/chittagong.html">Shame Shame Chittagong Abahani.</div>

                </div>
            </div>

            <div class="week-awards-container">
                <!-- Team of the Week -->
            <!-- Team of the Week -->
        <div class="week">
                    <h1 class="awards-tit">Team Of The Week <span class="star">⭐</span></h1>
                <div class="pitch">
                    <div class="formation">
                    <div class="forwards">
                    </div>
                     <div class="midfielders">
                    </div>
                    <div class="defenders">
                    </div>
                    <div class="goalkeeper">
                    </div>
                </div>
            </div>
        </div>


                <!-- Awards Section -->
                <div class="awards-section">
                    <h2 class="awards-title">AWARDS <span class="arrow">▶</span></h2>

                    <div class="awards-container">
                        <!-- Golden Boot -->
                        <div class="award-card">
                            <div class="player-info">
                                <img class="player-img" src="assets/images/club/boetang.png" alt="Golden Boot Winner">
                                <div class="award-label golden-boot">
                                    GOLDEN BOOT <img src="assets/images/club/boot.jpg" alt="Golden Boot Icon">
                                </div>
                            </div>
                            <div class="player-details">
                                <h3 class="player-name">S. Boetang</h3>
                                <p class="player-position">FORWARD</p>
                                <p class="club-name">Rahmatgonj MFS <img class="club-logo" src="assets/images/club/rahmatgonj.png"
                                        alt="Club Logo"></p>
                                <div class="stats">
                                    <div class="stat"><span>9</span><br>MAT</div>
                                    <div class="stat"><span>11</span><br>GOALS</div>
                                    <div class="stat"><span>720</span><br>MIN</div>
                                    <div class="stat"><span>65.45</span><br>M/G</div>
                                </div>
                            </div>
                        </div>

                        <!-- Golden Glove -->
                        <div class="award-card">
                            <div class="player-info">
                                <img class="player-img" src="assets/images/club/mitul.png" alt="Golden Glove Winner">
                                <div class="award-label golden-glove">
                                    GOLDEN GLOVE <img src="assets/images/club/gloves.jpg" alt="Golden Glove Icon">
                                </div>
                            </div>
                            <div class="player-details">
                                <h3 class="player-name">Mitul Marma</h3>
                                <p class="player-position">GOALKEEPER</p>
                                <p class="club-name">Abahani Limited <img class="club-logo" src="assets/images/club/abahani.png"
                                        alt="Club Logo"></p>
                                <div class="stats">
                                    <div class="stat"><span>9</span><br>MAT</div>
                                    <div class="stat"><span>5</span><br>CS</div>
                                    <div class="stat"><span>720</span><br>MIN</div>
                                    <div class="stat"><span>80</span><br>MGC</div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>





        </body>








        <footer>
            <footer>
                <div class="footer-content">
                    <div class="logo">
                      <img src="assets/images/club/BPL.png" alt="BPL"> </div> <div class="social-icons">
                      <a href="#"><img src="assets/images/club/fb.svg" alt="Facebook"></a>
                      <a href="#"><img src="assets/images/club/ins.svg" alt="Instagram"></a>
                      <a href="#"><img src="assets/images/club/twitter-x.svg" alt="Twitter"></a>
                      <a href="#"><img src="assets/images/club/yt.svg" alt="YouTube"></a>
                    </div>
                    <div class="fan-zone-button">
                      <button>GET INTO YOUR FAN ZONE</button>
                    </div>
                  </div>
                    <div class="copyright">
                      <span>© 2025 Bangladesh Premier League - All Rights Reserved.</span>
                    </div>
                  </div>
              </footer>

        </footer>
    </body>

    </html>

</body>

</html>