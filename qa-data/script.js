var modalContainer, modalAcceptBtn, modalDeclineBtn, modalCloseBtn, modalText, counter, questionTextarea;

function showModal(message) {
	modalContainer = document.getElementById("modal-con");
	modalText = document.getElementById("modal-text");
	modalContainer.style.display = 'flex';
	modalText.innerHTML = message;
}

function quitModal() {
	modalContainer.style.display = 'none';
	window.location.replace("?");
}

window.onload = function() {
	modalContainer = document.getElementById("modal-con");
	modalAcceptBtn = document.getElementById("modal-accept");
	modalDeclineBtn = document.getElementById("modal-decline");
	modalCloseBtn = document.getElementById("modal-close");
	modalText = document.getElementById("modal-text");
	counter = document.getElementById("counter");
	questionTextarea = document.getElementById("question");

	modalCloseBtn.onclick = quitModal;
	modalAcceptBtn.onclick = quitModal;
	modalDeclineBtn.onclick = quitModal;

	counter.innerHTML = questionTextarea.maxLength;

	questionTextarea.onkeyup = function () {
		counter.innerHTML = this.maxLength - this.value.length;
	}
}

