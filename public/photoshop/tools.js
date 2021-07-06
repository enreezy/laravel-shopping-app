editText = false;

toolText = function (text, font, color, size, x, y) {
	var n = (editText ? app.getActiveLayerN(): app.layers.length);
	app.layers[n] = new Text(text, size + ' ' + font, color);
	app.layers[n].x = x - app.canvas.width / 2;
	app.layers[n].y = y - app.canvas.height / 2;
	app.layers[n].name = text;
	app.activateLayer(n);
	app.refreshLayers();
	hideDialog('#dialog-tooltext');
	
	this.undoBuffer = [];
	this.redoBuffer = [];
}

app.callbacks.toolText = function (e) {
	switch (e.type) {
		case "click":
			if (e.target instanceof HTMLButtonElement) {
				toolText($('#dialog-tooltext input.input-text').val(), $('#dialog-tooltext select').val(), $('#dialog-tooltext input.input-color').val(), $('#dialog-tooltext input.input-size').val(), (editText ? app.getActiveLayer().x: app.selection.x), (editText ? app.getActiveLayer().y: app.selection.y));
			} else {
				if (app.tool != TOOL_TEXT) return true;
				$('#dialog-tooltext').show();
				$('#overlay').show();
				app.selection.x = e.offsetX;
				app.selection.y = e.offsetY;
				$('#dialog-tooltext input.input-text').val((editText ? app.getActiveLayer().text: ''));
				$('#dialog-tooltext input.input-size').val((editText ? app.getActiveLayer().font.split(' ')[0]: '12px'));
				$('#dialog-tooltext select').val((editText ? app.getActiveLayer().font.split(' ')[1]: 'Calibri'));
				$('#dialog-tooltext input.input-color').val((editText ? app.getActiveLayer().color: 'black'));
				$('#dialog-tooltext input.input-color').css({ backgroundColor: $('#dialog-tooltext input.input-color').val() });
			}
			break;
		case "keydown":
			if (e.keyCode == 13) toolText($('#dialog-tooltext input.input-text').val(), $('#dialog-tooltext select').val(), $('#dialog-tooltext input.input-color').val(), $('#dialog-tooltext input.input-size').val(), (editText ? app.getActiveLayer().x: app.selection.x), (editText ? app.getActiveLayer().y: app.selection.y));
			break;
	}
}