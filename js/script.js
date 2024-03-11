$(document).ready(function () {
  // code for countdown timer
  let timeLeft = $("#timeLeft").val();
  let sessionTimeBlock = document.querySelector("#session-time");
  let timeStatusBlock = document.querySelector("#time-status");
  let hoursSpan = document.querySelector("#hours-left");
  let minSpan = document.querySelector("#min-left");
  let secSpan = document.querySelector("#sec-left");

  let timer = ""; //below used for setInterval/clearInterval
  let timerActive = false;
  let startTime = timeLeft; //start of the session: session time by default
  let sessionTime = timeLeft; //default session time stored in seconds
  let currentTime = timeLeft; //time displayed on timer in seconds

  function displayDefaultTime() {
    sessionTimeBlock.innerHTML = displayMinutes(sessionTime) + " min";

    displayCurrentTime();
  }

  function displayCurrentTime() {
    if (convertFromSec(currentTime).hours) {
      hoursSpan.classList.remove("hidden");
      hoursSpan.innerHTML = convertFromSec(currentTime).hours + ": ";
    } else {
      hoursSpan.innerHTML = "";
    }
    minSpan.innerHTML = convertFromSec(currentTime).minutes + ": ";
    secSpan.innerHTML = convertFromSec(currentTime).seconds;
  }

  function addLeadingZero(time) {
    return time < 10 ? "0" + time : time;
  }

  function displayMinutes(timeInSec) {
    return parseInt(timeInSec / 60);
  }

  function convertFromSec(timeInSec) {
    let result = { hours: 0, minutes: 0, seconds: 0 };
    let seconds = timeInSec % 60;
    let minutes = parseInt(timeInSec / 60) % 60;
    let hours = parseInt(timeInSec / 3600);
    if (hours > 0) {
      result.hours = hours;
    }
    result.minutes = addLeadingZero(minutes);
    result.seconds = addLeadingZero(seconds);
    return result;
  }

  function countDown() {
    if (currentTime > 0) {
      currentTime--;
      displayCurrentTime();
    }
    if (currentTime === 0) {
      clearInterval(timer);
      $("#submitBtn").click();
      console.log("Form submitted successfully");
    }
  }

  function toggleTimer() {
    timer = setInterval(countDown, 1000);
    timerActive = true;
  }

  function stopTimer() {
    timerActive = false;
    clearInterval(timer);
    currentTime = sessionTime;
    displayDefaultTime();
  }

  function displayChangedTime(e, time) {
    sessionTimeBlock.innerHTML = displayMinutes(sessionTime) + " min";
  }

  toggleTimer();

  document.addEventListener("DOMContentLoaded", displayDefaultTime);
});
