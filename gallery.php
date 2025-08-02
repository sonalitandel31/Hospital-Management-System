<?php
    include("header.php");
    include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Gallery</title>
    <style>
        .hospital-gallery-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        .gallery-title {
            color:rgb(52, 95, 139);
            margin-bottom: 20px;
        }

        .filter-buttons {
            margin-bottom: 20px;
        }

        .filter-buttons button {
            background-color:rgb(118, 166, 213);
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 5px;
            transition: background-color 0.3s ease;
        }

        .filter-buttons button:hover {
            background-color:rgb(80, 116, 151);
        }

        .hospital-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .gallery-item {
            display: none;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease-in-out;
        }

        .gallery-item img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        .gallery-item p {
            padding: 10px;
            background-color: #ecf0f1;
            font-size: 16px;
            color: #2c3e50;
        }

        .gallery-item:hover {
            transform: scale(1.025);
        }
    </style>
    <script>
        function filterGallery(type) {
            const items = document.querySelectorAll('.gallery-item');
            items.forEach(item => {
                if (type === 'all' || item.classList.contains(type)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
        document.addEventListener('DOMContentLoaded', () => {
            filterGallery('all');
        });
    </script>
</head>
<body>
    <div class="hospital-gallery-container">
        <h1 class="gallery-title">Hospital Gallery</h1>
        <div class="filter-buttons">
        <?php
            $category_query = "SELECT DISTINCT category FROM pages WHERE type='gallery' AND category != ''";
            $category_result = mysqli_query($conn, $category_query);
            if (mysqli_num_rows($category_result) > 0) {
                echo '<button onclick="filterGallery(\'all\')">All</button>';
                $unique_categories = [];
                while ($category_row = mysqli_fetch_assoc($category_result)) {
                    $category = strtolower(trim($category_row['category']));
                    if (!in_array($category, $unique_categories)) {
                        $unique_categories[] = $category;
                        $category_name = ucfirst($category);
                        echo "<button onclick=\"filterGallery('$category')\">$category_name</button>";
                    }
                }
            } 
        ?>
        </div>
        <div class="hospital-gallery">
            <?php
                $query = "SELECT * FROM pages WHERE type='gallery'";
                $query_run = mysqli_query($conn, $query);
                if (mysqli_num_rows($query_run) > 0) {
                    while ($row = mysqli_fetch_array($query_run)) {
                        $category = strtolower($row['category']); 
                        ?>
                        <div class="gallery-item <?php echo $category; ?>">
                            <img src="img/<?php echo $row['img']; ?>" alt="">
                        </div>
                        <?php
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>
<?php
    include("footer.php");
?>
