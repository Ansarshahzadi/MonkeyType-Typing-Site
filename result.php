<?php
session_start();
if(!isset($_SESSION['user_id'])) header("Location: login.php");
$role = $_SESSION['role'] ?? 'user';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Typing Test Results</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
  body {font-family: monospace; background:#f8f9fa;}
  .card-header {background: rgb(234,88,12); color:#fff;}
</style>
</head>
<body>
<div class="container my-5">
  <h2 class="text-center fw-bold mb-4">⌨️ Typing Test Results</h2>
  <div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card text-center shadow-sm"><div class="card-body"><h6 class="text-muted">WPM</h6><h3 id="wpm">0</h3></div></div></div>
    <div class="col-md-3"><div class="card text-center shadow-sm"><div class="card-body"><h6 class="text-muted">Accuracy</h6><h3 id="accuracy">0%</h3></div></div></div>
    <div class="col-md-3"><div class="card text-center shadow-sm"><div class="card-body"><h6 class="text-muted">Errors</h6><h3 id="errors">0</h3></div></div></div>
    <div class="col-md-3"><div class="card text-center shadow-sm"><div class="card-body"><h6 class="text-muted">Time</h6><h3 id="time">0:00</h3></div></div></div>
  </div>

  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <h5 class="fw-bold">📊 Detailed Stats</h5>
      <p><strong>Total Typed:</strong> <span id="typed">0</span></p>
      <p><strong>Correct:</strong> <span id="correct">0</span></p>
      <p><strong>Incorrect:</strong> <span id="incorrect">0</span></p>
      <p><strong>Net WPM:</strong> <span id="netSpeed">0</span> wpm</p>
    </div>
  </div>

  <div class="text-center mt-4">
    <a href="index.php" class="btn btn-outline-primary px-4">🔁 Try Again</a>
    <button class="btn btn-outline-success px-4">💾 Save Result</button>
    <button class="btn btn-outline-dark px-4" onclick="window.print()">🖨 Print</button>
  </div>
</div>

<script>
let result = JSON.parse(localStorage.getItem("typingResult"));
if(!result || !result.time || result.time<=0){
  alert("⚠️ Time seems corrupted or incomplete.");
  result = {wpm:0, accuracy:0, correct:0, incorrect:0, totalTyped:0, time:0};
}

document.getElementById("time").innerText = `${Math.floor(result.time/60)}:${(result.time%60).toString().padStart(2,"0")}`;
document.getElementById("wpm").innerText = result.wpm;
document.getElementById("accuracy").innerText = result.accuracy + "%";
document.getElementById("errors").innerText = result.incorrect;
document.getElementById("typed").innerText = result.totalTyped;
document.getElementById("correct").innerText = result.correct;
document.getElementById("incorrect").innerText = result.incorrect;
document.getElementById("netSpeed").innerText = Math.max(result.wpm - result.incorrect,0);
</script>
</body>
</html>
