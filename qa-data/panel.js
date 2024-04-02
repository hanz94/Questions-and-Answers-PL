// MODAL WINDOW

var modalContainer = document.getElementById("modal-con");
var modalAcceptBtn = document.getElementById("modal-accept");
var modalDeclineBtn = document.getElementById("modal-decline");
var modalCloseBtn = document.getElementById("modal-close");
var modalText = document.getElementById("modal-text");

modalCloseBtn.onclick = function () {
	modalContainer.style.display = 'none';
}
modalAcceptBtn.onclick = function () {
	modalContainer.style.display = 'none';
}
modalDeclineBtn.onclick = function () {
	modalContainer.style.display = 'none';
}

function showModal(message) {
	modalContainer.style.display = 'flex';
	modalText.innerHTML = message;
}

function showModalLocate(message, locate) {
	modalContainer.style.display = 'flex';
	modalText.innerHTML = message;
	modalCloseBtn.onclick = function () {
		window.location.replace(locate);
	}
	modalAcceptBtn.onclick = function () {
		window.location.replace(locate);
	}
	modalDeclineBtn.onclick = function () {
		window.location.replace(locate);
	}
}

// PANEL FUNCTIONS

function DeleteQuestionConfirmation(question_number, question_id) {
        showModal("Czy na pewno chcesz usunąć pytanie " + question_number + " (ID " + question_id + ")?");
        modalAcceptBtn.onclick = function () {
            window.location.replace("?delete_question=1&question_id=" + question_id);
        }
    }

function ChangeInstitutionName() {
        let institutionname = prompt("Enter new institution name:");
        if (!institutionname == null || !institutionname == "") {
            eventname = encodeURIComponent(institutionname);
            window.location.replace("?iname=" + institutionname);
        } 
    }
function ChangeEventName() {
        let eventname = prompt("Enter new event name:");
        if (!eventname == null || !eventname == "") {
            eventname = encodeURIComponent(eventname);
            window.location.replace("?eventname=" + eventname);
        }
    }
function ChangeEventDate() {
        let eventdate = prompt("Enter new event date:");
        if (!eventdate == null || !eventdate == "") {
            eventname = encodeURIComponent(eventdate);
            window.location.replace("?eventdate=" + eventdate);
        }
    }
function ChangeBoardAutoRefresh(newstate) {
        if (newstate) {
            confirmation = "Board: Auto Refresh will be activated.\nPress OK to confirm.";
        }
        else {
            confirmation = "Board: Auto Refresh will be deactivated.\nPress OK to confirm.";
        }
    let response = confirm(confirmation);
        if (response) {
            window.location.replace("?board_auto_refresh=" + newstate);
        }
    }
function ChangeBoardAutoRefreshTime() {
    let newtime = Number(prompt("Provide new time in miliseconds (between 1000 and 10000):"));
        if (newtime >= 1000 && newtime <= 10000 && newtime != null) {
    let response = confirm("New time interval will be set to: " + newtime + ".\nPress OK to confirm.");
        if (response ) {

            window.location.replace("?board_auto_refresh_time=" + newtime);
        }
        }
        else {
            alert("Error: The number must be between 1000 and 10000.\nProvide correct number.");
        }
    }
function ChangeQrVisibility(newstate) {
        if (newstate) {
            confirmation = "Board: QR Code will be visible.\nPress OK to confirm.";
        }
        else {
            confirmation = "Board: QR Code will be hidden.\nPress OK to confirm.";
        }
    let response = confirm(confirmation);
        if (response) {
            window.location.replace("?qr_code_visibility=" + newstate);
        }
}