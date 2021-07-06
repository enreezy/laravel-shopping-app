activateLayer = app.activateLayer;

scriptExecute = function (code) {
	hideDialog('#dialog-executescript');
	if ((code.match(/eval\(/g) != null) && (!confirm('You used the eval function inside of your code. This may lead to unexpected effects, do you want to continue?'))) return;
	eval(code.replace(/(window\.|app\.)(.*?);/g, ''));
}

app.callbacks.scriptExecute = function (e) {
	scriptExecute($('#dialog-executescript textarea').val());
}