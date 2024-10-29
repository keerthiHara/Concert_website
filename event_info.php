<?php
// Database connection
$servername = "localhost";
$username = "root"; // Your DB username
$password = ""; // Your DB password
$dbname = "intern"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the event name from the URL
if (isset($_GET['event_name'])) {
    $event_name = urldecode($_GET['event_name']);
    
    // Fetch event details from the database
    $sql = "SELECT * FROM events WHERE event_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $event_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .clicking{
            position: absolute; top:50%;
            height: 50px;
            width: 120px;
            margin: 0px 30px;
            background-color: rgb(210, 172, 48);
            border-radius: 10px;

        }
    </style>
</head>
<body style="background: rgb(10,1,17);
background: linear-gradient(90deg, rgba(10,1,17,1) 0%, rgba(133,67,16,1) 70%, rgba(215,179,128,1) 100%);">
    <header>
            <nav class="navbar navbar-expand-lg  mx-5">
                <div class="container-fluid border border-white" style="height: 70px; border-radius: 50px; align-items: center;">
                    <a class="navbar-brand" href="#">
                        <img src="image/logo.png" alt="logo" width="0px" height="100px" style="z-index: 10px;">
                        <span  class="text-white">Music Freaks</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="background-color: white;">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse " id="navbarNav" style="justify-content: center;">
                        <ul class="navbar-nav">
                            <li class="nav-item p-3">
                                <a class="nav-link fs-5 text-white" aria-current="page" href="home.html">Home</a>
                            </li>
                            <li class="nav-item p-3 text-white">
                                <a class="nav-link fs-5 text-white" href="event.php">Events</a>
                            </li>
                            <li class="nav-item p-3">
                                <a class="nav-link fs-5 text-white" href="ContactUs.html">ContactUs</a>
                            </li>
                            <li class="nav-item p-3">
                                <a class="nav-link fs-5 text-white " href="gallery.html">Gallery</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
    <?php if (isset($event)) { ?>
    <div class="container-fluid" style="margin:30px 0px">
        <div class="row">
            <div class="col-lg-6">
                <div style="width: 100%; height: 800px;" >
                    <img src="image/background1.jpg" width="100%" height="100%" style="background-size: cover;">

                </div>
            </div>
            <div class="col-lg-6">
                <div>
                    <h1 style="color: white;"><?php echo $event['event_name']; ?></h1>
                    
                    <p style="color: white;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi omnis fuga reiciendis dolore commodi, quas sed nihil nostrum enim, ullam magni possimus dolorum illum blanditiis ratione delectus esse alias dignissimos culpa exercitationem quia veniam qui. Repudiandae nihil, perferendis quas consectetur commodi dolores atque quis error veniam velit quisquam rem alias mollitia odit dolore odio repellat modi, ea eaque? Asperiores ex ipsam, dolor dolorum quis possimus facere praesentium nobis sint animi officia numquam iusto mollitia inventore quam sit nisi consequuntur quidem itaque rerum suscipit quisquam? Rerum adipisci cupiditate doloribus inventore facere nostrum sapiente autem. Consequuntur deleniti culpa quisquam vel, at labore inventore voluptate debitis eos doloribus facere eius commodi quos omnis vitae laboriosam voluptates nemo minima quia fugiat quas distinctio neque impedit odit! Sed adipisci tempore deleniti, inventore optio, laudantium error numquam at natus rerum ex asperiores ullam culpa dolorum consequuntur, nostrum quam officiis aperiam. Dolorem consectetur dicta quis rerum ut fuga laboriosam quibusdam dolore doloribus nobis et unde esse id, expedita beatae illum atque sunt non iure. Nostrum, omnis expedita quae tenetur commodi voluptate labore recusandae reprehenderit repellendus quam voluptates dolorem ratione itaque dolores reiciendis quas nulla, autem voluptatem? Aliquam deserunt harum reprehenderit nobis omnis pariatur doloremque quidem veniam. Eveniet!</p>
                    <div style="margin:50px 0px">
                        <span style="color: white;"><i class="fa-solid fa-calendar-days" style="color: white ; font-size: 25px; padding: 0px 10px;"></i> Date: <?php echo date("l, F j, Y", strtotime($event['event_time'])); ?> </span>
                    </div>
                    <div style="margin:40px 0px">
                        <span style="color: white;"><i class="fa-solid fa-location-dot" style="color: white; font-size: 25px;padding: 0px 10px;"></i><?php echo $event['place']; ?></span>
                    </div>
                    <div>
                    <h3 style="color: white;">Price: <?php echo $event['price']; ?> USD</h3>

    </div>
                    
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <div style="position: relative;">
                    <a href="ticket.php?event_name=<?php echo urlencode($event['event_name']); ?>&price=<?php echo $event['price']; ?>&event_time=<?php echo urlencode($event['event_time']); ?>&place=<?php echo urlencode($event['place']); ?>">
        <button type="button" class="clicking">Buy Tickets</button>
    </a>
                    </div>
                    <div class="mapouter"><div class="gmap_canvas"><iframe src="https://maps.google.com/maps?q=sanfran&amp;t=&amp;z=12&amp;ie=UTF8&amp;iwloc=&amp;output=embed" frameborder="0" scrolling="no" style="width: 240px; height: 250px;"></iframe><style>.mapouter{display:table;}.gmap_canvas{overflow:hidden;position:relative;height:250px;width:240px;background:#fff;}</style><a href="https://www.taxuni.com/fincen-form-114/">FinCEN Form 114</a><style>.gmap_canvas iframe{position:relative !important;z-index:2 !important;}.gmap_canvas a{color:#fff !important;position:absolute !important;top:0 !important;left:0 !important;z-index:0 !important;}</style></div></div>
                </div>
            </div>
        </div>
    </div>
    <?php } else { ?>
    <p>No event details available.</p>
<?php } ?>
    
    
</body>
</html>
<?php
// Close the connection
$conn->close();
?>