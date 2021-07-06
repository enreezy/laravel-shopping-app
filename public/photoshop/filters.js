applyFilter = function (filter) {
	app.addUndo();
	var layer = app.getActiveLayer();
	
	layer.filters = (layer.filters ? layer.filters: []);
	layer.filters.push(filter);
	if (layer.cacheCanvas) {
		layer.updateCache();
	} else {
		layer.cache(0, 0, layer.width, layer.height);
	}
}

filterBrightness = function (value) {
	applyFilter(new ColorFilter(value, value, value, 1));
	hideDialog('#dialog-filterbrightness');
}

filterColorify = function (r, g, b, a) {
	applyFilter(new ColorFilter(1.0, 1.0, 1.0, 1.0, r, g, b, a));
	hideDialog('#dialog-filtercolorify');
}

filterDesaturation = function () {
	applyFilter(new ColorMatrixFilter(
		[
			0.33, 0.33, 0.33, 0.00, 0.00,
			0.33, 0.33, 0.33, 0.00, 0.00,
			0.33, 0.33, 0.33, 0.00, 0.00,
			0.00, 0.00, 0.00, 1.00, 0.00
		]
	));	
	hideDialog('#dialog-filterbrightness');
}

filterBlur = function (radius) {
	var matrix = [];
	
	for (var y = 0; y < radius * 2; y++) {
		matrix[y] = [];
		for (var x = 0; x < radius * 2; x++) {
			matrix[y][x] = 1;
		}
	}
	
	applyFilter(new ConvolutionFilter(matrix, 1.0 / Math.pow(radius * 2, 2), 0.0));
	hideDialog('#dialog-filterblur');
}

var gaussMatrix = [
	[
		[ 0.05472157, 0.11098164, 0.05472157 ],
		[ 0.11098164, 0.22508352, 0.11098164 ],
		[ 0.05472157, 0.11098164, 0.05472157 ]
	],
	[
		[ 0.00078633, 0.00655965, 0.01330373, 0.00655965, 0.00078633 ],
		[ 0.00655965, 0.05472157, 0.11098164, 0.05472157, 0.00655965 ],
		[ 0.01330373, 0.11098164, 0.22508352, 0.11098164, 0.01330373 ],
		[ 0.00655965, 0.05472157, 0.11098164, 0.05472157, 0.00655965 ],
		[ 0.00078633, 0.00655965, 0.01330373, 0.00655965, 0.00078633 ]
	],
	[
		[ 0.00000067, 0.00002292, 0.00019117, 0.00038771, 0.00019117, 0.00002292, 0.00000067 ],
		[ 0.00002292, 0.00078633, 0.00655965, 0.01330373, 0.00655965, 0.00078633, 0.00002292 ],
		[ 0.00019117, 0.00655965, 0.05472157, 0.11098164, 0.05472157, 0.00655965, 0.00019117 ],
		[ 0.00038771, 0.01330373, 0.11098164, 0.22508352, 0.11098164, 0.01330373, 0.00038771 ],
		[ 0.00019117, 0.00655965, 0.05472157, 0.11098164, 0.05472157, 0.00655965, 0.00019117 ],
		[ 0.00002292, 0.00078633, 0.00655965, 0.01330373, 0.00655965, 0.00078633, 0.00002292 ],
		[ 0.00000067, 0.00002292, 0.00019117, 0.00038771, 0.00019117, 0.00002292, 0.00000067 ]
	]
];

filterGaussianBlur = function (radius) {
	applyFilter(new ConvolutionFilter(gaussMatrix[radius], 1.0, 0.0));
	hideDialog('#dialog-filtergaussianblur');
}

filterEdgeDetection = function () {
	applyFilter(new ConvolutionFilter(
		[
			[  0, -1,  0 ],
			[ -1,  4, -1 ],
			[  0, -1,  0 ]
		],
		1.0,
		0.0
	));
	hideDialog('#dialog-filteredgedetection');
}

filterEdgeEnhance = function () {
	applyFilter(new ConvolutionFilter(
		[
			[  0, 0, 0 ],
			[ -1, 1, 0 ],
			[  0, 0, 0 ]
		],
		1.0,
		0.0
	));
	hideDialog('#dialog-filteredgeenhance');
}

filterEmboss = function () {
	applyFilter(new ConvolutionFilter(
		[
			[ -1, -1, 0 ],
			[ -1,  1, 1 ],
			[  0,  1, 1 ]
		],
		1.0,
		0.0
	));
	hideDialog('#dialog-filteremboss');
}

filterSharpen = function () {
	applyFilter(new ConvolutionFilter(
		[
			[  0, -1,  0 ],
			[ -1,  5, -1 ],
			[  0, -1,  0 ]
		],
		1.0,
		0.0
	));
	hideDialog('#dialog-filtersharpen');
}

filterSwitch = function (e, val, func) {
	switch (e.type) {
		case "click":
			func(val);
			break;
		case "keydown":
			if (e.keyCode == 13) func(val);
			break;
	}
}

app.callbacks.filterBrightness = function (e) {
	var val = $('#dialog-filterbrightness input').val() / 100;
	filterSwitch(e, val, filterBrightness);
}

app.callbacks.filterDesaturation = function () {
	filterDesaturation();
}

app.callbacks.filterColorify = function (e) {
	var r = $('#dialog-filtercolorify input.r').val() * 1,
		g = $('#dialog-filtercolorify input.g').val() * 1,
		b = $('#dialog-filtercolorify input.b').val() * 1,
		a = $('#dialog-filtercolorify input.a').val() * 1;
	switch (e.type) {
		case "click":
			filterColorify(r, g, b, a);
			break;
		case "keydown":
			if (e.keyCode == 13) filterColorify(r, g, b, a);
			break;
	}
}

app.callbacks.filterBlur = function (e) {
	var val = $('#dialog-filterblur input').val() * 1;
	filterSwitch(e, val, filterBlur);
}

app.callbacks.filterGaussianBlur = function (e) {
	var val = ($('#dialog-filtergaussianblur input.3').attr('checked') ? 2: $('#dialog-filtergaussianblur input.2').attr('checked') ? 1: 0);
	filterSwitch(e, val, filterGaussianBlur);
}

app.callbacks.filterEdgeDetection = function (e) {
	filterEdgeDetection();
}

app.callbacks.filterEdgeEnhance = function (e) {
	filterEdgeEnhance();
}

app.callbacks.filterEmboss = function (e) {
	filterEmboss();
}

app.callbacks.filterSharpen = function (e) {
	filterSharpen();
}