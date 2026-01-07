<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/0dbb3f2ef0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="navi.css">
    <link rel="stylesheet" href="main.css">
    <title>HOMEPAGE</title>
</head>

<body>
<header>
    <div id="header">
        <h1>THE SMARTVID</h1>
    </div>
</header>

<div class="navigationBar">
    <nav>
        <ul>
            <li><a href="main.php">HOME</a></li>
            <li><a href="view_summary.php">MY SUMMARIES</a></li>
            <li><a href="subscription.php">SUBSCRIPTION</a></li>
            <li><a href="feedback.php">FEEDBACK</a></li>
            <li><a href="faq.html">FAQ</a></li>
            <li class="profile-dropdown">
                <a href="#"><i class="fa-regular fa-user"></i></a>
                <div class="dropdown-content">
                    <a href="settingspage.php">SETTINGS</a>
                    <a href="#" id="logout">LOG OUT</a>
                    <a href="delete_account.php" id="delete-account">DELETE ACCOUNT</a>
                </div>
            </li>
        </ul>
    </nav>
</div>

<div class="box1">
    <div id="logo">
        <img src="logo.png" alt="Company Logo">
    </div>
    <div id="text1">
        <h4>Welcome to SMARTVID!</h4>
        <p>Explore a collection of summarized YouTube videos designed to save your time and enhance your understanding.</p>
        <p>Select any video to view its concise summary and test your knowledge with a quick quiz. Perfect for revision, learning, and staying focused.</p>
        <p>Thank you for learning with SMARTVID — making information clearer, faster, and easier for you!</p>
    </div>
</div>
    
    <div class="main-container">
        <div class="summarizer-container">
            <div class="logo-container">
                <img src="logo.png" alt="Summary Tube Logo" class="logo">
            </div>
            <h1 style="color: white;">YouTube Video Summarizer</h1>
            <p>Paste a YouTube URL below to get an AI-powered summary.</p>

            <input type="text" id="subjectInput" placeholder="Enter subject/topic (e.g. Biology, Algorithm, History)">
            
            <input type="text" id="youtubeLink" placeholder="Enter YouTube video URL here">
            <button id="summaryButton">Get Summary</button>

            <div class="status-message" id="statusMessage"></div>

            <h2 style="color: white;">Summary</h2>
            <div id="summaryOutput">
                The video summary will appear here.
            </div>

            <button id="saveSummaryBtn">Save Summary</button>

            <p id="saveStatus" style="color:white;"></p>

        </div>
    </div>
    
    <script src="summarizer.js"></script>

<script>
document.getElementById("saveSummaryBtn").addEventListener("click", function () {
    const summary = document.getElementById("summaryOutput").innerText;
    const subject = document.getElementById("subjectInput").value;
    const youtubeLink = document.getElementById("youtubeLink").value;

    if (!subject) {
        document.getElementById("saveStatus").innerText = "Please enter a subject.";
        return;
    }

    if (!youtubeLink) {
        document.getElementById("saveStatus").innerText = "Please enter a YouTube link.";
        return;
    }

    if (!summary || summary === "The video summary will appear here.") {
        document.getElementById("saveStatus").innerText = "No summary to save yet.";
        return;
    }

    fetch("save_summary.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body:
            "summary=" + encodeURIComponent(summary) +
            "&subject=" + encodeURIComponent(subject) +
            "&video_url=" + encodeURIComponent(youtubeLink)
    })
    .then(res => res.text())
    .then(data => {
        document.getElementById("saveStatus").innerText = data;
    })
    .catch(() => {
        document.getElementById("saveStatus").innerText = "Error saving summary.";
    });
});
</script>



    <script src="scripts.js"></script>
<script>
    document.getElementById('logout').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default link behavior
        alert('Thank you for using The SMARTVID'); // Show the thank you message
        window.location.href = 'MainPage.html'; // Redirect to MainPage.html
    });
</script>


<div id="footer-placeholder"></div>
<script>
    fetch('footer.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('footer-placeholder').innerHTML = data;
        });
</script>
</body>



</html>