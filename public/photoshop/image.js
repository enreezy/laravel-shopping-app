imageScale = function (x, y) {
	for (var i = 0, layer; layer = app.layers[i]; i++) {
		layer.scaleX *= x / 100;
		layer.scaleY *= y / 100;
		layer.x *= x / 100;
		layer.y *= y / 100;
	}
	hideDialog('#dialog-scale');
	affectImage = false;
}

imageRotate = function (deg) {
	for (var i = 0, layer; layer = app.layers[i]; i++) {
		layer.rotation += deg;
		var rad = deg * Math.PI / 180,
			x = (layer.x * Math.cos(rad)) - (layer.y * Math.sin(rad)),
			y = (layer.x * Math.sin(rad)) + (layer.y * Math.cos(rad));
		layer.x = x;
		layer.y = y;
	}
	hideDialog('#dialog-rotate');
	affectImage = false;
}

imageSkew = function (degx, degy) {
	for (var i = 0, layer; layer = app.layers[i]; i++) {
		layer.skewX += degx;
		layer.skewY += degy;
		var radx = degx * Math.PI / 180,
			rady = degy * Math.PI / 180,
			x = (layer.x * Math.cos(radx)) - (layer.y * Math.sin(radx)),
			y = (layer.x * Math.sin(rady)) + (layer.y * Math.cos(rady));
		layer.x = x;
		layer.y = y;
	}
	hideDialog('#dialog-skew');
	affectImage = false;
}

imageFlipH = function () {
	app.addUndo();
	for (var i = 0, layer; layer = app.layers[i]; i++) {
		layer.scaleX = -layer.scaleX;
		layer.x = -layer.x;
	}
	affectImage = false;
}

imageFlipV = function () {
	app.addUndo();
	for (var i = 0, layer; layer = app.layers[i]; i++) {
		layer.scaleY = -layer.scaleY;
		layer.y = -layer.y;
	}
	affectImage = false;
}

app.callbacks.imageFlipV = function () {
	imageFlipV();
}

app.callbacks.imageFlipH = function () {
	imageFlipH();
}