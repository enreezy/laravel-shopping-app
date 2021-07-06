affectImage = false;

layerScale = function (x, y) {
	app.addUndo();
	if (affectImage) return imageScale(x, y);
	app.getActiveLayer().scaleX *= x / 100;
	app.getActiveLayer().scaleY *= y / 100;
	hideDialog('#dialog-scale');
}

layerRotate = function (deg) {
	app.addUndo();
	if (affectImage) return imageRotate(deg);
	app.getActiveLayer().rotation += deg;
	hideDialog('#dialog-rotate');
}

layerSkew = function (degx, degy) {
	app.addUndo();
	if (affectImage) return imageSkew(degx, degy);
	app.getActiveLayer().skewX += degx;
	app.getActiveLayer().skewY += degy;
	hideDialog('#dialog-skew');
}

layerFlipH = function () {
	app.addUndo();
	app.getActiveLayer().scaleX = -app.getActiveLayer().scaleX;
}

layerFlipV = function () {
	app.addUndo();
	app.getActiveLayer().scaleY = -app.getActiveLayer().scaleY;
}

app.callbacks.numberOnly = function (e) {
	if ((e.shiftKey) || ([8, 13, 37, 38, 39, 40, 46, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 190, 189].indexOf(e.keyCode) < 0)) return false;
}

app.callbacks.layerRename = function (e) {
	switch (e.type) {
		case "click":
			app.layers[app.renameLayer].name = $('#dialog-layerrename input').val();
			app.refreshLayers();
			hideDialog('#dialog-layerrename');
			break;
		case "keydown":
			if (e.keyCode == 13) {
				app.layers[app.renameLayer].name = $('#dialog-layerrename input').val();
				app.refreshLayers();
				hideDialog('#dialog-layerrename');
			}
			break;
	}
}

app.callbacks.layerScale = function (e) {
	switch (e.type) {
		case "click":
			layerScale($('#dialog-scale input.input-scaleX').val() * 1, $('#dialog-scale input.input-scaleY').val() * 1);
			break;
		case "keydown":
			if (e.keyCode == 13) layerScale($('#dialog-scale input.input-scaleX').val() * 1, $('#dialog-scale input.input-scaleY').val() * 1);
			break;
	}
}

app.callbacks.layerRotate = function (e) {
	switch (e.type) {
		case "click":
			layerRotate($('#dialog-rotate input').val() * 1);
			break;
		case "keydown":
			if (e.keyCode == 13) layerRotate($(this).val() * 1);
			break;
	}
	
}

app.callbacks.layerSkew = function (e) {
	switch (e.type) {
		case "click":
			layerSkew($('#dialog-skew input.input-skewX').val() / 100, $('#dialog-skew input.input-skewY').val() / 100);
			break;
		case "keydown":
			if (e.keyCode == 13) layerSkew($('#dialog-skew input.input-skewX').val() / 100, $('#dialog-skew input.input-skewY').val() / 100);
			break;
	}
}

app.callbacks.layerFlipV = function () { layerFlipV(); }
app.callbacks.layerFlipH = function () { layerFlipH(); }

app.callbacks.layerCrop = function () {
	var layer = app.getActiveLayer();
	layer.cache(
		Math.floor(app.canvas.width / 2 - $('#cropoverlay').position().left - layer.regX + layer.x - 1),
		Math.floor(app.canvas.height / 2 - $('#cropoverlay').position().top - layer.regY + layer.y + 38),
		$('#cropoverlay').width(),
		$('#cropoverlay').height()
	);
	$(this).parent().find('.button-cancel').click();
}