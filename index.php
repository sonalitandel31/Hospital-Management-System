<?php
    include("header.php");
    include("database.php");
?>

<style>
.hero-section {
    position: relative;
    overflow: hidden;
    width: 100%;
}
.hero-overlay {
    position: absolute;
    top: 500px;
    left: 360px;
    color: white;
    font-size: 2em;
    z-index: 2;
}
.hero-image {
    width: 100%;
    height: 540px;
    object-fit: cover;
    display: none;
}
.slider img:first-child {
    display: block;
}
.left-arrow, .right-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    font-size: 3em;
    color: white;
    background-color: rgba(0, 0, 0, 0.5);
    padding: 10px;
    cursor: pointer;
    z-index: 3;
}

.left-arrow {
    left: 10px;
}

.right-arrow {
    right: 10px;
}

.left-arrow:hover, .right-arrow:hover {
    background-color: rgba(0, 0, 0, 0.7);
}

</style>
<section class="hero-section">
    <div class="hero-overlay">
        <h1>Hospital Management System</h1>
    </div>
    <div class="slider">
        <?php
        // Fetch images from pages table where type is 'ad'
        $query = "SELECT img FROM pages WHERE type='ad'";
        $query_run = mysqli_query($conn, $query);
        if (mysqli_num_rows($query_run) > 0) {
            while ($row = mysqli_fetch_assoc($query_run)) {
                echo "<img src='img/{$row['img']}' alt='Hospital Management System' class='hero-image'>";
            }
        } else {
            echo "<p>No advertisements available.</p>";
        }
        ?>
    </div>
    <span class="left-arrow" onclick="moveSlide(-1)">&#10094;</span>
    <span class="right-arrow" onclick="moveSlide(1)">&#10095;</span>
</section>

<script>
let slideIndex = 0;

function moveSlide(step) {
    const slides = document.querySelectorAll('.hero-image');
    slides[slideIndex].style.display = 'none';
    slideIndex += step;

    if (slideIndex < 0) {
        slideIndex = slides.length - 1;
    } else if (slideIndex >= slides.length) {
        slideIndex = 0;
    }

    slides[slideIndex].style.display = 'block';
}
document.addEventListener("DOMContentLoaded", function() {
    const slides = document.querySelectorAll('.hero-image');
    if (slides.length > 0) {
        slides[0].style.display = 'block';
    }
});
</script>
    <section class="logins-section">
        <h2>Logins</h2>
        <div class="login-cards">
            <div class="login-card">
                <img src="img/patient.jpg" alt="Patient Login"><br>
                <p class="log">Patient Login</p>
                <a href="patient_login.php"><Button class="logBtn">Click Here</Button></a>
            </div>
            <div class="login-card">
                <img src="img/doctor.jpg" alt="Doctor Login"><br>
                <p class="log">Doctor Login</p>
                <a href="doctor_login.php"><Button class="logBtn">Click Here</Button></a>
            </div>
            <div class="login-card">
                <img src="img/admin.jpg" alt="Admin Login"><br>
                <p class="log">Admin Login</p>
                <a href="admin_login.php"><Button class="logBtn">Click Here</Button></a>
            </div>
        </div>
    </section>
    <section class="features-section" id="service">
        <h2>Our Key Features</h2>
        <div class="feature-list">
            <div class="feature-item">
                <i class="fas fa-heartbeat"></i>
                <p>Cardiology</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-ribbon"></i>
                <p>Orthopaedic</p>
            </div>
            <div class="feature-item">
                <i class="fab fa-monero"></i> 
                <p>Neurology</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-capsules"></i>
                <p>Pharma Pipeline</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-prescription-bottle-alt"></i> 
                <p>Pharma Team</p>
            </div>
            <div class="feature-item">
                <i class="far fa-thumbs-up"></i>
                <p>High-Quality Treatments</p>
            </div>
        </div>
    </section>
    <section class="about-section" id="about">
    <div class="about-container">
    <?php
    $query = "SELECT * FROM pages WHERE type='about' LIMIT 1";
    $query_run = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($query_run) > 0) {
        $row = mysqli_fetch_assoc($query_run);
        ?>
        <img src="img/<?php echo $row['img']; ?>" alt="About Hospital" class="about-image">

        <div class="about-content">
            <h2 class="about-title">About Our Hospital</h2>
            <p class="about-description"><?php echo $row['description']; ?></p>
        </div>
        <?php
    } else {
        echo "<p>No about information available.</p>";
    }
    ?>
</div>

    <section class="gallery-section">
        <h2 style="color: rgb(82, 136, 191);">Our Gallery</h2>
        <div class="gallery-grid">
            <?php
                $query = "SELECT * FROM pages WHERE type='gallery' ORDER BY RAND() LIMIT 4";
                $query_run = mysqli_query($conn, $query);
                $check_product = mysqli_num_rows($query_run) > 0;
                if ($check_product) {
                    while ($row = mysqli_fetch_array($query_run)) {
                        ?>
                        <img src="img/<?php echo $row['img']; ?>" alt="">
                        <?php
                    }
                }
            ?>
        </div>
    </section>
<?php
    include("footer.php");
?>