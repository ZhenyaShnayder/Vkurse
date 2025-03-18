function news(event){
	window.location.href="/news";
}

function toggleVote(){
	const voteField = document.getElementById('vote');
	const voteMessage = document.getElementById('voteMessage');
	const voteButton = document.getElementById('voteButton');
	
	if (voteField.value === "0") {
		voteField.value = "1";
		voteMessage.style.display = "block";
		voteButton.textContent = "Убрать возможность голосования";
	} else {
		voteField.value = "0";
		voteMessage.style.display = "none";
		voteButton.textContent = "Добавить голосование";
	}
}

function toggleComment(){
	const commentField = document.getElementById('comment');
	const commentMessage = document.getElementById('commentMessage');
	const commentButton = document.getElementById('commentButton');
	
	if (commentField.value === "0") {
		commentField.value = "1";
		commentMessage.style.display = "block";
		commentButton.textContent = "Убрать возможность комментирования";
	} else {
		commentField.value = "0";
		commentMessage.style.display = "none";
		commentButton.textContent = "Добавить возможность комментирования";
	}
}
