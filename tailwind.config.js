module.exports = {
	content: [
		'./resources/views/*.blade.php',
		'./resources/**/*.blade.php',
		'./resources/**/*.ts',
		'./resources/**/*.vue',
	],
	theme: {
		extend: {},
	},
	plugins: ['base','components','utilities','colors','buttons','forms'],
}
