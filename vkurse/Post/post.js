function news(event){
	window.location.href="/news";
}

function toggleVote() {
    const voteField = document.getElementById('vote');
    const voteMessage = document.getElementById('voteMessage');
    const voteButton = document.getElementById('voteButton');
    const voteUntilField = document.getElementById('vote_until');

    if (voteField.value === "0") {
        voteField.value = "1";
        voteMessage.style.display = "block";
        voteButton.textContent = "Убрать возможность голосования";
    } else {
        voteField.value = "0";
        voteMessage.style.display = "none";
        voteButton.textContent = "Добавить голосование";
        voteUntilField.value = "";
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

document.getElementById('file').addEventListener('change', function() {
    const fileName = this.files[0]?.name || 'Файл не выбран';
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    const fileNameSpan = document.getElementById('fileName');

    if (fileName !== 'Файл не выбран') {
        fileNameSpan.textContent = fileName;
        fileNameDisplay.style.display = 'block';
    } else {
        fileNameDisplay.style.display = 'none';
    }
});
