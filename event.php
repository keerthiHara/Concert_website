<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "intern");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch event names and places for the filter dropdowns
$eventNamesQuery = "SELECT DISTINCT event_name FROM events";
$eventNamesResult = $conn->query($eventNamesQuery);

$placesQuery = "SELECT DISTINCT place FROM events";
$placesResult = $conn->query($placesQuery);

// Set filter variables
$event_name_filter = isset($_POST['event_name']) ? $_POST['event_name'] : '';
$place_filter = isset($_POST['place']) ? $_POST['place'] : '';

// Modify SQL query based on filters
$sql = "SELECT event_name, event_time, place, price FROM events WHERE 1=1";
if (!empty($event_name_filter)) {
    $sql .= " AND event_name = '$event_name_filter'";
}
if (!empty($place_filter)) {
    $sql .= " AND place = '$place_filter'";
}

$result = $conn->query($sql);
?>



<!DOCTYPE html>
<html>
<head>
    <title>Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .events-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 16px;
        }
        .card1 {
            border: 1px solid #ccc;
            padding: 16px;
            margin: 16px;
            border-radius: 8px;
            width: 300px;
            display: inline-block;
        }
        .card1 h3 {
            margin-top: 0;
        }
        .ticket-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
            border: none;
            cursor: pointer;
        }

        .card {
            
            height: 390px;
            list-style: none;
            background: #fff;
            border-radius: 8px;
            display: flex;
            cursor: pointer;
            width:300px;
            padding-bottom: 15px;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .card .img {

            width: 100%;
            height: 100%
        }

        .card .img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 16px;
            margin-top: 7px;

            border: 4px solid #fff;
        }

        .card h2 {
            font-weight: 500;
            font-size: 1.56rem;
            margin: 30px 0 5px;
        }

        .card span {
            color: #6a6d78;
            font-size: 1.31rem;

        }

        .event_page{
            /* background-size: cover;
            background-repeat: no-repeat;
            height:900px;
           background-image: url("image/background1.jpg"); */
        }

        /* common */
.show {
    background-color: black;
}
.info-but{
    width: 70px;
    height: 40px;
    background-color: transparent;
    border: 2px solid white;
    color: #fff;
}
.ticket-but{
    width: 70px;
    height: 40px;
    background-color: #fff;
    color: black;
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
            <section class="event_page">
        
    <h1 style=" color:white ; margin:30px 50px">Upcoming Events</h1>
    <div class="filter-form">
        <form method="post" action="" style="display: inline-flex; padding:20px">
            <label for="event_name" style="color:white;padding: 10px 30px;">Event Name:</label>
            <select name="event_name" class="form-select" style="width:130px; padding: 10px 30px;" id="event_name">
                <option value="">All Events</option>
                <?php
                if ($eventNamesResult->num_rows > 0) {
                    while ($eventNameRow = $eventNamesResult->fetch_assoc()) {
                        echo '<option value="' . $eventNameRow["event_name"] . '">' . $eventNameRow["event_name"] . '</option>';
                    }
                }
                ?>
            </select>

            <label for="place" style="color:white;padding:10px 30px;">Place:</label>
            <select name="place" id="place" class="form-select" style="width:130px;padding: 10px 30px;">
                <option value="">All Places</option>
                <?php
                if ($placesResult->num_rows > 0) {
                    while ($placeRow = $placesResult->fetch_assoc()) {
                        echo '<option value="' . $placeRow["place"] . '">' . $placeRow["place"] . '</option>';
                    }
                }
                ?>
            </select>

            <button type="submit" style="background-color: #bf914d;border-radius: 20px;width: 132px;margin:0px 20px">Filter</button>
        </form>
    </div>
    <div class="events-container">
    <?php
    $i=0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $i++;
        
        echo '
        <div class="card" style="position: relative;">
            <div class="img" style="position: absolute;">
                <img src="image/background'. $i .'.jpg" alt="" draggable="false">
                <div style="position: absolute; color: #fff; float: left; left: 20px; bottom: 25px;">
                    <h2>' . $row["event_name"] . '</h2>
                    <h6>' . date("l, F j, Y", strtotime($row["event_time"])) . '</h6>
                    <h6>' . $row["place"] . '</h6>
                   <div style="display: flex; justify-content: space-between; margin: 0px 20px;">
                        <a href="event_info.php?event_name=' . urldecode($row["event_name"]) . '">
                        <button type="button" class="info-but">Info</button>
                        </a>
                        <a href="ticket.php?event_name=' . urlencode($row["event_name"]) . '&price=' . $row["price"] . '&event_time=' . urlencode($row["event_time"]) . '&place=' . urlencode($row["place"]) . '">
                            <button type="button" class="ticket-but">Tickets</button>
                        </a>
                    </div> <div style="display: flex; justify-content: space-between; margin: 0px 20px;">
    
    
</div>

                </div>
            </div>
        </div>';
    }
} else {
    echo "No events found.";
}

$conn->close();
?>
</div>

    </section>
    </body>
</html>
