// wp-block-group�nol.wp-block-listn����󰒭
document.addEventListener('DOMContentLoaded', function () {
	// wp-block-group��
	const groups = document.querySelectorAll('.wp-block-group');

	groups.forEach(function (group) {
		const ols = group.querySelectorAll('ol.wp-block-list');
		let currentNumber = 1;

		ols.forEach(function (ol) {
			// �(nj�K��~��Fk-�
			ol.setAttribute('start', currentNumber);

			// Snolnlinp�����
			const liCount = ol.querySelectorAll('li').length;
			currentNumber += liCount;
		});
	});
});
