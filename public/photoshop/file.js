openFile = function (url, first) {
	var img = new Image();
		
	img.onload = function () {
		var n = (first ? 0: app.layers.length);
		if (first) app.layers = [];
		app.layers[n] = new Bitmap(img);
		app.layers[n].x = 0;
		app.layers[n].y = 0;
		app.activateLayer(n);
	}
	img.src = url;
	
	this.undoBuffer = [];
	this.redoBuffer = [];
}

openURL = function (self, url) {
	$(self).attr('disabled', true);
	openFile(url, !importFile);
	hideDialog('#dialog-openurl');
}

saveFile = function () {
	window.open(app.stage.toDataURL());
}

printFile = function () {
	window.print()
}

app.callbacks.openFile = function (e) {
	var file = e.target.files[0],
		self = this;
	
	if (!file.type.match('image.*')) return false;

	var reader = new FileReader();
	reader.onload = function(e) {
		openFile(e.target.result, true);
	};

	reader.readAsDataURL(file);
};

app.callbacks.openURL = function (e) {
	switch (e.type) {
		case "click":
			openURL($('#dialog-openurl input'), $('#dialog-openurl input').val());
			break;
		case "keydown":
			if (e.keyCode == 13) openURL(this, $(this).val());
			break;
	}
}

app.callbacks.importFile = function (e) {
	for (var i = 0, file; file = e.target.files[i]; i++) {
		if (!file.type.match('image.*')) continue;

		var reader = new FileReader();
		reader.onload = function(e) {
			openFile(e.target.result, false);
		};

		reader.readAsDataURL(file);
	}
};

app.callbacks.saveFile = function () {
	saveFile();
}

app.callbacks.printFile = function () {
	printFile();
}