function proverka(){
	if(confirm("Подтвердить, что хочу выйти")){
		window.location.href="/";
		return true;
	}
	return false;
}

document.addEventListener("DOMContentLoaded", function() {
    const notification = document.querySelector('.notification');
    if (notification) {
        setTimeout(() => {
            notification.style.opacity = '0'; 
            setTimeout(() => {
                notification.remove();
            }, 500);
        }, 3000); 
    }
});
