<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "intern";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get event details from URL parameters
$event_name = isset($_GET['event_name']) ? $_GET['event_name'] : '';
$event_time = isset($_GET['event_time']) ? $_GET['event_time'] : '';
$place = isset($_GET['place']) ? $_GET['place'] : '';
$price = isset($_GET['price']) ? $_GET['price'] : '';
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $category = $conn->real_escape_string($_POST['category']);
    $price = (float)$_POST['price'];

    // Insert into the user table
    $sql = "INSERT INTO user (name, phone, email, event_name, event_time, place, category, price)
            VALUES ('$name', '$phone', '$email', '$event_name', '$event_time', '$place', '$category', $price)";

    if ($conn->query($sql) === TRUE) {
        $successMessage = "Ticket generated successfully!";

    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Ticket Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body {
            /* background-image: linear-gradient(-45deg, #8067B7, #EC87C0); */
            background: rgb(10, 1, 17);
            background: linear-gradient(90deg, rgba(10, 1, 17, 1) 0%, rgba(133, 67, 16, 1) 70%, rgba(215, 179, 128, 1) 100%);
            min-height: calc(100vh - 40px);
            margin: 20px;
            font-family: 'Lato', sans-serif;
        }

        h1 {
            text-align: center;
            color: #fff;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="tel"],
        input[type="email"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        .radio-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .radio-group label {
            margin: 0;
            font-weight: normal;
        }

        input[type="submit"] {
            background-color: #5D9CEC;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #4a86d4;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            form {
                padding: 15px;
            }

            input[type="submit"] {
                font-size: 14px;
            }
        }

        widget {
            filter: drop-shadow(1px 1px 3px rgba(0, 0, 0, 0.3));
        }

        widget[type="ticket"] {
            width: 255px;
        }

        .-bold {
            font-weight: bold;
        }

        .top,
        .bottom,
        .rip {
            background-color: #fff;
        }

        .top {
            border-top-right-radius: 5px;
            border-top-left-radius: 5px;
        }

        .deetz {
            padding-bottom: 10px !important;
        }

        .bottom {
            display: flex;
    justify-content: space-between;
    border-bottom-right-radius: 5px;
    border-bottom-left-radius: 5px;
    padding: 12px;
    height: 59px;
    padding-top: 10px;
        }

        .barcode {
            background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAF4AAAABCAYAAABXChlMAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAAYdEVYdFNvZnR3YXJlAHBhaW50Lm5ldCA0LjAuOWwzfk4AAACPSURBVChTXVAJDsMgDOsrVpELiqb+/4c0DgStQ7JMYogNh2gdvg5VfXFCRIZaC6BOtnoNFpvaumNmwb/71Frrm8XvgYkker1/g9WzMOsohaOGNziRs5inDsAn8yEPengTapJ5bmdZ2Yv7VvfPN6AH2NJx7nOWPTf1/78hoqgxhzw3ZqYG1Dr/9ur3y8vMxgNZhcAUnR4xKgAAAABJRU5ErkJggg==);
            background-repeat: repeat-y;
            min-width: 58px;
        }

        .buy {
            display: block;
            font-size: 12px;
            font-weight: bold;
            background-color: #5D9CEC;
            padding: 0 18px;
            line-height: 30px;
            border-radius: 15px;
            color: #fff;
            text-decoration: none;
        }

        .rip {
            height: 20px;
            margin: 0 10px;
            background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAYAAAACCAYAAAB7Xa1eAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAAYdEVYdFNvZnR3YXJlAHBhaW50Lm5ldCA0LjAuOWwzfk4AAAAaSURBVBhXY5g7f97/2XPn/AcCBmSMQ+I/AwB2eyNBlrqzUQAAAABJRU5ErkJggg==);
            background-size: 4px 2px;
            background-repeat: repeat-x;
            background-position: center;
            position: relative;
            box-shadow: 0 1px 0 0 #fff, 0 -1px 0 0 #fff;
        }
        .rules{
            margin:40px  10px 
            
        }
    </style>
</head>

<body>

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

    <div class="container-fluid" style="margin-top:50px">
        <div class="row">

            <div class="col-md-6">
                <!-- Event Form -->
                <?php if ($successMessage): ?>
    <script>
        showPopup("<?php echo $successMessage; ?>");
    </script>
<?php endif; ?>
                <form method="POST" action="">
    <label for="name">Your Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="phone">Phone Number:</label>
    <input type="tel" id="phone" name="phone" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="event_name1">Event Name:</label>
    <input type="text" id="event_name1" name="event_name1" value="<?php echo htmlspecialchars($event_name); ?>" readonly>

    <label for="event_time">Event Date:</label>
    <input type="text" id="event_time" name="event_time" value="<?php echo htmlspecialchars($event_time); ?>" readonly>

    <label for="place">Location:</label>
    <input type="text" id="place" name="place" value="<?php echo htmlspecialchars($place); ?>" readonly>

    <div class="radio-group">
        <label><input type="radio" name="category" value="general" checked> General</label>
        <label><input type="radio" name="category" value="vip"> VIP (+$100)</label>
    </div>

    <label for="price">Base Price:</label>
    <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>" readonly>

    <input type="submit" value="Generate Ticket">
</form>

<?php
$conn->close();
?>
            </div>

            <div class="col-md-6" style="display:flex; justify-content:center;flex-wrap:wrap">

                <!-- Ticket Display -->
                <div style="width:255px">
    <widget type="ticket" class="--flex-column">
        <div class="top --flex-column">
            <div class="bandname -bold">
                <!-- Display the event name, or 'N/A' if not set -->
                <?php echo isset($_GET['event_name']) ? $_GET['event_name'] : 'N/A'; ?>
            </div>
            <div class="tourname">Home Tour</div>
            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/199011/concert.png" alt="" />
            
            <div class="deetz --flex-row-j!sb">
                <div class="event --flex-column">
                    <div class="date">
                        <!-- Display the formatted event date -->
                        <?php echo isset($_GET['event_time']) ? date("jS F Y", strtotime($_GET['event_time'])) : 'N/A'; ?>
                    </div>
                    <div class="location -bold">
                        <!-- Display the event location -->
                        <?php echo isset($_GET['place']) ? $_GET['place'] : 'N/A'; ?>
                    </div>
                </div>
                
                <div class="price --flex-column">
                    <div class="label">Price</div>
                    <div class="cost -bold">
                    <?php
                        if (isset($_POST['price'])) {
                            $price = $_POST['price'];
                            $category = isset($_POST['category']) ? $_POST['category'] : 'general';
                            if ($category == 'vip') {
                                $price += 100; // Add $100 for VIP
                            }
                            echo $price;
                        } else {
                            echo 'N/A';
                        }
                    ?>

                    </div>
                </div>
            </div>
        </div>
        
        <div class="rip"></div>
        
        <div class="bottom --flex-row">
            <div class="barcode"></div>
            <div class="buy">Buy Now</div>
        </div>
    </widget>
</div>

                <div class="rules">
                    <h2 style="color:white"> Rules</h2>

                    <p style="color:white">
                        1. Ticket Availability
                        Tickets are usually sold on a first-come, first-served basis.
                        The number of tickets per person may be limited (e.g., a maximum of 4 tickets per booking).
                        VIP tickets or special categories might have separate availability and prices.<br>
                        2. Age Restrictions
                        Some concerts may have age restrictions (e.g., 18+, 21+).
                        ID verification may be required at the venue to confirm age.<br>
                        3. Payment Methods
                        Accepted payment methods include credit/debit cards, digital wallets, and sometimes direct bank
                        transfers.
                        Payments are typically non-refundable unless the event is canceled or rescheduled.<br>
                        4. Seating and Sections
                        Tickets are often categorized by seating arrangement (e.g., general admission, VIP, front row).
                        Seat assignments are usually final after booking and cannot be changed.
                        Some tickets may offer standing-room-only options.<br>
                        5. Refunds and Cancellations
                        Tickets are generally non-refundable, except in cases of event cancellation or major changes
                        (like rescheduling).
                        In case of cancellation, ticket holders will be informed, and refunds or rescheduling options
                        will be provided.<br>
                        6. Ticket Transfers and Resales
                        Transferring tickets to another person may or may not be allowed, depending on the concert
                        organizer.
                        Some platforms may allow reselling tickets through official channels, but third-party resales
                        are often restricted or illegal
                    </p>


                </div>

            </div>

        </div>

    </div>

    <script>
        // Function to show the success popup
        function showPopup(message) {
            alert(message); // You can replace alert with a custom modal if needed
        }
    </script>
</body>

</html>