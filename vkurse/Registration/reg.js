function authorithation(event) {
	window.location.href = "/";
}

document.addEventListener('DOMContentLoaded', function () {
	const form = document.getElementById('registrationForm');
	const inputs = {
		first_name: document.getElementById('first_name'),
		last_name: document.getElementById('last_name'),
		middle_name: document.getElementById('middle_name'),
		email: document.getElementById('email'),
		password: document.getElementById('password'),
		repeat_password: document.getElementById('repeat_password')
	};

	const touchedFields = {
		first_name: false,
		last_name: false,
		middle_name: false,
		email: false,
		password: false,
		repeat_password: false,
	};

	Object.keys(inputs).forEach(key => {
		const field = inputs[key];

		field.addEventListener('blur', () => {
			touchedFields[key] = true;
			validateField(key);
		});

		field.addEventListener('input', () => {
			if (touchedFields[key] && field.classList.contains('invalid')) {
				validateField(key);
			}
			if (key === 'password') {
				validateField('repeat_password');
			}
		});
	});

	form.addEventListener('submit', function (event) {
		event.preventDefault();
		let isFormValid = true;

		Object.keys(inputs).forEach(key => {
			if (!validateField(key)) {
				isFormValid = false;
			}
		});
		if (isFormValid) {
			const formData = {
				first_name: inputs.first_name.value.trim(),
				last_name: inputs.last_name.value.trim(),
				middle_name: inputs.middle_name.value.trim(),
				email: inputs.email.value.trim(),
				password: inputs.password.value.trim()
			};

			fetch('/Registration/reg.php', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
				},
				body: JSON.stringify(formData)
			})
				.then(response => {
					if (!response.ok) {
						throw new Error('Ошибка сети');
					}
					return response.json();
				})
				.then(data => {
					if (data.success) {
						authorithation();
					} else {
						alert(data.message || 'Ошибка регистрации');
					}
				})
				.catch(error => {
					console.error('Error:', error);
					alert('Произошла ошибка при отправке формы');
				});
		}
	});

	function validateField(fieldName) {
		const field = inputs[fieldName];
		const value = field.value.trim();
		let isValid = true;
		let errorMessage = '';

		switch (fieldName) {
			case 'first_name':
				if (value.length === 0) {
					errorMessage = '';
				} else if (value.length < 2) {
					errorMessage = 'Имя должно быть не менее 2 символов';
					isValid = false;
				} else if (!/^[a-zA-Zа-яА-я]{2,}$/.test(value)) {
					errorMessage = 'Некорректное имя';
					isValid = false;
				}
				break;

			case 'last_name':
				if (value.length === 0) {
					errorMessage = '';
				} else if (value.length < 3) {
					errorMessage = 'Фамилия должна быть не менее 3 символов';
					isValid = false;
				} else if (!/^[a-zA-Zа-яА-я]{2,}$/.test(value)) {
					errorMessage = 'Некорректная фамилия';
					isValid = false;
				}
				break;

			case 'middle_name':
				if (value.length === 0) {
					errorMessage = '';
				} else if (!/^[a-zA-Zа-яА-я]{2,}$/.test(value)) {
					errorMessage = 'Некорректное отчество';
					isValid = false;
				}
				break;

			case 'email':
				if (value.length === 0) {
					errorMessage = '';
				} else if (!/^[a-zA-Z]+@[^\s@]+\.[^\s@]{2,}$/.test(value)) {
					errorMessage = 'Введите корректный email';
					isValid = false;
				}
				break;

			case 'password':
				if (value.length === 0) {
					errorMessage = '';
				} else if (value.length < 6) {
					errorMessage = 'Пароль должен быть не менее 6 символов';
					isValid = false;
				}
				break;

			case 'repeat_password':
				if (value.length === 0) {
					errorMessage = '';
				} else if (value !== inputs.password.value.trim()) {
					errorMessage = 'Пароли не совпадают';
					isValid = false;
				}
				break;
		}

		const errorElement = document.getElementById(`${fieldName}_error`);
		errorElement.textContent = errorMessage;

		field.classList.toggle('invalid', !isValid && value.length > 0);

		return isValid;
	}
});