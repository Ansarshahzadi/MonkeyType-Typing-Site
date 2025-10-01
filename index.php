<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Monkeytype Style Typing Test</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
<style>
  .topbar span.active { color: rgb(234, 88, 12) !important; font-weight: bold; }
  body { font-family: monospace; background: #fff; color: #222; }
  #textDisplay span { transition: color 0.2s; }
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white sticky-top w-100">
  <div class="container-fluid px-5">
    <a href="#" class="navbar-brand fw-bold fs-1">
      Typing<span style="color: rgb(234, 88, 12)">Board</span>
    </a>
    <a href="login.php"><div class="btn btn-success">Login</div></a>
  </div>
</nav>

<div class="d-flex justify-content-center align-items-center bg-light mx-auto gap-3 border-bottom w-50 topbar mt-2 py-2">
  <span id="words" class="active" style="cursor:pointer;">A words</span>
  <span id="punctuation" style="cursor:pointer;">@ punctuation</span>
  <span id="numbers" style="cursor:pointer;"># numbers</span>
  <span id="quote" style="cursor:pointer;">" quote</span>
  <span id="zen" style="cursor:pointer;">△ zen</span>
  <span id="btn15" style="cursor:pointer;">15</span>
  <span id="btn30" style="cursor:pointer;">30</span>
  <span id="btn60" style="cursor:pointer;">60</span>
  <span id="btn120" style="cursor:pointer;">120</span>
  <span id="gear" style="cursor:pointer;">⚙</span>
</div>

<div class="text-center mt-3">
  <button class="btn btn-success mt-2" id="startBtn">▶ Start Typing</button>
  <button class="btn btn-secondary mt-2"> ⏳ Time Left: <span id="timer">0:00</span><br /> </button>
  <button class="btn btn-danger mt-2" id="showResultBtn">⏹ Show Result</button>
</div>

<div class="d-flex justify-content-center align-items-center" style="height: 60vh;">
  <div id="textDisplay" style="font-size:24px; line-height:2rem; padding:25px; max-width:1050px; text-align:justify;"></div>
</div>

<!-- Custom Paragraph Box -->
<div id="customParagraphBox" style="display:none;  max-width:80%; margin:0 auto;">
  <textarea id="customParagraph" rows="6" placeholder="Type or paste your custom paragraph here..." style="width:100%;"></textarea><br />
  <button class="btn btn-sm btn-warning mt-2" id="setParagraph">Set Paragraph</button>
</div>

<!-- Custom Time Modal -->
<div class="modal fade" id="timeModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content rounded-3">
      <div class="modal-header">
        <h5 class="modal-title">Set Custom Time</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="input-group">
          <input type="number" id="customTimeInput" class="form-control" placeholder="Enter time" />
          <select id="timeUnit" class="form-select">
            <option value="sec">Seconds</option>
            <option value="min">Minutes</option>
            <option value="hr">Hours</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-warning" id="setCustomTime">Set Time</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const timerDisplay = document.getElementById("timer");
const textDisplay = document.getElementById("textDisplay");
const topbarBtns = document.querySelectorAll(".topbar span");
const customBox = document.getElementById("customParagraphBox");

let interval, totalTimeSelected = 60, timeLeft = 60, started = false;
let idleTimer = null, paused = false;
let currentText = "", currentIndex = 0, correct = 0, incorrect = 0;

// Utility
function formatTime(sec){return `${Math.floor(sec/60)}:${(sec%60).toString().padStart(2,"0")}`;}
function setActive(el){topbarBtns.forEach(btn=>btn.classList.remove("active"));el.classList.add("active");}

// Load text JSON
async function loadText(type){
  try {
    const response = await fetch("english.json");
    const data = await response.json();
    const options = data[type];
    if(!options || !options.length) return;
    const randomIndex = Math.floor(Math.random() * options.length);
    currentText = options[randomIndex];
    currentIndex = 0; correct = 0; incorrect = 0;
    renderText();
  } catch(e){console.error(e);}
}

function renderText(){
  textDisplay.innerHTML = "";
  currentText.split("").forEach(ch=>{
    const span = document.createElement("span");
    span.innerText = ch;
    textDisplay.appendChild(span);
  });
}

// Countdown
function startCountdown(){
  started = true; paused = false;
  clearInterval(interval);
  interval = setInterval(()=>{
    if(!paused){ 
      timeLeft--; 
      timerDisplay.textContent = formatTime(timeLeft); 
      if(timeLeft<=0){finishTest();}
    }
  },1000);
}

function resetIdleTimer(){
  clearTimeout(idleTimer);
  idleTimer = setTimeout(()=>paused=true,3000);
}

// Typing logic
document.addEventListener("keydown",e=>{
  if(!started) return;
  if(paused) paused=false;
  resetIdleTimer();
  const spans = textDisplay.querySelectorAll("span");
  if(currentIndex<spans.length && e.key.length===1){
    if(e.key===spans[currentIndex].innerText){spans[currentIndex].style.color="lime";correct++;} 
    else {spans[currentIndex].style.color="red"; incorrect++;}
    currentIndex++;
    if(currentIndex===spans.length && document.querySelector(".topbar span.active").id!=="zen") 
      loadText(document.querySelector(".topbar span.active").id);
  } else if(e.key==="Backspace" && currentIndex>0){
    currentIndex--; spans[currentIndex].style.color="#333";
  }
});

// Start button
document.getElementById("startBtn").onclick = ()=>{
  if(timeLeft===0){timeLeft=totalTimeSelected; timerDisplay.textContent=formatTime(timeLeft);}
  if(!started) startCountdown();
};

// Show result
document.getElementById("showResultBtn").onclick = finishTest;

// ✅ Fixed finishTest() - words based WPM
function finishTest(){
  clearInterval(interval);
  started=false;

  const totalTyped = correct+incorrect;
  let actualTime = totalTimeSelected - timeLeft;
  if(actualTime <= 0) actualTime = 1;

  // words count from text typed till current index
  const typedText = currentText.substring(0, currentIndex);
  const wordsTyped = typedText.trim().split(/\s+/).filter(Boolean).length;

  const accuracy = totalTyped>0 ? Math.round(correct/totalTyped*100) : 0;
  const wpm = Math.round(wordsTyped / (actualTime/60)); // ✅ words-based WPM

  const result = {wpm, accuracy, correct, incorrect, totalTyped, wordsTyped, time:actualTime};
  localStorage.setItem("typingResult",JSON.stringify(result));
  window.location.href="result.php";
}

// Category buttons
document.getElementById("words").onclick = e=>{setActive(e.target); customBox.style.display="none"; loadText("words");};
document.getElementById("punctuation").onclick = e=>{setActive(e.target); customBox.style.display="none"; loadText("punctuation");};
document.getElementById("numbers").onclick = e=>{setActive(e.target); customBox.style.display="none"; loadText("numbers");};
document.getElementById("quote").onclick = e=>{setActive(e.target); customBox.style.display="none"; loadText("quote");};
document.getElementById("zen").onclick = e=>{setActive(e.target); textDisplay.innerHTML=""; customBox.style.display="block";};

// Timer buttons
function setTimer(sec,el){setActive(el); totalTimeSelected=timeLeft=sec; timerDisplay.textContent=formatTime(timeLeft);}
document.getElementById("btn15").onclick = e=>setTimer(15,e.target);
document.getElementById("btn30").onclick = e=>setTimer(30,e.target);
document.getElementById("btn60").onclick = e=>setTimer(60,e.target);
document.getElementById("btn120").onclick = e=>setTimer(120,e.target);

// Custom time modal
document.getElementById("gear").onclick = ()=>new bootstrap.Modal(document.getElementById("timeModal")).show();
document.getElementById("setCustomTime").onclick = ()=>{
  let v=parseInt(document.getElementById("customTimeInput").value);
  let unit=document.getElementById("timeUnit").value;
  if(v>0){
    if(unit==="min") v*=60; else if(unit==="hr") v*=3600;
    totalTimeSelected=timeLeft=v;
    timerDisplay.textContent=formatTime(timeLeft);
    bootstrap.Modal.getInstance(document.getElementById("timeModal")).hide();
  }
}

loadText("words");
</script>
</body>
</html>
