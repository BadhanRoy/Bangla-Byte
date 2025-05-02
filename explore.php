<?php
session_start();
include 'connect.php';

// Redirect to login if not logged in
if(!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$firstName = $_SESSION['firstName'] ?? '';
$lastName = $_SESSION['lastName'] ?? '';
$email = $_SESSION['email'] ?? '';
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ব্যবহারকারী ড্যাশবোর্ড - কোডিং প্ল্যাটফর্ম</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Translate -->
    <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'SolaimanLipi', Arial, sans-serif;
        }
        .dashboard-card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        .profile-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
        #google_translate_element {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1000;
        }
        .goog-te-gadget {
            font-family: Arial, sans-serif !important;
        }
        .goog-te-banner-frame {
            display: none !important;
        }
    </style>
</head>
<body>
    <!-- Google Translate Widget -->
    <div id="google_translate_element"></div>
    <script>
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'bn',
                includedLanguages: 'bn,en',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
            }, 'google_translate_element');
        }
    </script>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">কোডিংপ্ল্যাটফর্ম</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="homepage.php"><i class="fas fa-home"></i> হোম</a></li>
                    <li class="nav-item"><a class="nav-link" href="1v1/index.php"><i class="fas fa-trophy"></i> প্রতিযোগিতা</a></li>
                    <li class="nav-item"><a class="nav-link" href="online-judge/index.php"><i class="fas fa-question-circle"></i> সমস্যা</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#"><i class="fas fa-user"></i> ড্যাশবোর্ড</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> লগআউট</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <div class="container py-5">
        <div class="row">
            <!-- User Profile Section -->
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card bg-white p-4 text-center">
                    <div class="profile-img-container mx-auto mb-3" style="width: 100px; height: 100px;">
                        <img src="<?php echo htmlspecialchars($user['profile_picture'] ?? 'https://via.placeholder.com/100'); ?>" 
                             class="profile-img rounded-circle" alt="প্রোফাইল">
                    </div>
                    <h4><?php echo htmlspecialchars($firstName . ' ' . $lastName); ?></h4>
                    <p class="text-muted"><?php echo htmlspecialchars($email); ?></p>
                    
                    <?php if (!empty($user['bio'])): ?>
                        <p class="mb-3"><?php echo htmlspecialchars($user['bio']); ?></p>
                    <?php endif; ?>
                    
                    <div class="d-flex justify-content-around mt-3">
                        <div>
                            <h5 class="mb-0">১৫০</h5>
                            <small>সমাধানকৃত</small>
                        </div>
                        <div>
                            <h5 class="mb-0">২৫</h5>
                            <small>প্রতিযোগিতা</small>
                        </div>
                    </div>
                    
                    <?php if (!empty($user['location'])): ?>
                        <div class="mt-2">
                            <i class="fas fa-map-marker-alt"></i> 
                            <small><?php echo htmlspecialchars($user['location']); ?></small>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($user['website'])): ?>
                        <div class="mt-2">
                            <i class="fas fa-globe"></i> 
                            <small><a href="<?php echo htmlspecialchars($user['website']); ?>" target="_blank">ওয়েবসাইট</a></small>
                        </div>
                    <?php endif; ?>
                    
                    <hr>
                    <a href="edit_profile.php" class="btn btn-primary btn-sm">প্রোফাইল সম্পাদনা</a>
                </div>
            </div>

            <!-- Stats & Quick Actions -->
            <div class="col-md-8">
                <div class="row">
                    <!-- Quick Stats -->
                    <div class="col-md-6 mb-4">
                        <div class="card dashboard-card bg-white p-4">
                            <h5><i class="fas fa-chart-line text-primary"></i> আপনার পরিসংখ্যান</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>সমাধানকৃত সমস্যা</span>
                                    <span class="fw-bold">১৫০</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>সঠিকতা</span>
                                    <span class="fw-bold">৮৫%</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>র‍্যাঙ্ক</span>
                                    <span class="fw-bold">#৪২</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="col-md-6 mb-4">
                        <div class="card dashboard-card bg-white p-4">
                            <h5><i class="fas fa-bolt text-warning"></i> দ্রুত কাজ</h5>
                            <div class="d-grid gap-2 mt-3">
                                <a href="add_problem.php" class="btn btn-outline-primary">
                                    <i class="fas fa-plus-circle"></i> সমস্যা যোগ করুন
                                </a>
                                <a href="#" class="btn btn-outline-success">
                                    <i class="fas fa-play"></i> প্রতিযোগিতায় যোগ দিন
                                </a>
                                <a href="#" class="btn btn-outline-info">
                                    <i class="fas fa-book"></i> অনুশীলন
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="col-12 mb-4">
                        <div class="card dashboard-card bg-white p-4">
                            <h5><i class="fas fa-history text-info"></i> সাম্প্রতিক কার্যক্রম</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>সমস্যা</th>
                                            <th>ফলাফল</th>
                                            <th>সময়</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><a href="#">দুটি যোগফল</a></td>
                                            <td><span class="badge bg-success">গ্রহণযোগ্য</span></td>
                                            <td>২ ঘন্টা আগে</td>
                                        </tr>
                                        <tr>
                                            <td><a href="#">বাইনারি সার্চ</a></td>
                                            <td><span class="badge bg-danger">ভুল উত্তর</span></td>
                                            <td>১ দিন আগে</td>
                                        </tr>
                                        <tr>
                                            <td><a href="#">লিঙ্কড লিস্ট</a></td>
                                            <td><span class="badge bg-success">গ্রহণযোগ্য</span></td>
                                            <td>৩ দিন আগে</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bengali Font -->
    <link href="https://fonts.maateen.me/solaiman-lipi/font.css" rel="stylesheet">
</body>
</html>