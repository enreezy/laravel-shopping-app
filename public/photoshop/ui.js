importFile = false;

hideDialog = function (dialog) {
	$(dialog).hide();
	if ($('.dialog:visible').length == 0) $('#overlay').hide();
	editText = false;
}

showDialog = function (dialog) {
	$('#overlay').show();
	$(dialog).show();
}

$(window).resize(function () {
	$('.dialog').each(function () {
		$(this).css({ left: window.innerWidth / 2 - $(this).outerWidth() / 2 + 'px', top: window.innerHeight / 2 - $(this).outerHeight() / 2 + 'px' });
	});
	
	$('canvas').attr('height', $(window).height() - 37).attr('width', $(window).width() - 232);
	$('ul#mainmenu').width($(window).width() - 4);
	$('ul#layers').css({ height: $(window).height() - 37 });
	
	app.refreshLayers();
	
	if ($('#cropoverlay').css('display') == 'block') {
		$('#cropoverlay').css({ 
			left: Math.ceil(app.canvas.width / 2 - app.getActiveLayer().x - app.getActiveLayer().regX - 1) + 'px', 
			top: Math.ceil(app.canvas.height / 2 + app.getActiveLayer().y - app.getActiveLayer().regY + 38) + 'px'
		});
	}
});
	
$(document).ready(function () {
	$("ul#mainmenu li button").click(function () {
		$(this).focus();
		$(this).parent().find("ul.submenu:visible").slideUp('fast').show();
		$(this).parent().find("ul.submenu:hidden").slideDown('fast').show();
	});
	
	$("ul#mainmenu li button").blur(function () {
		$(this).parent().find("ul.submenu:visible").delay(100).slideUp('fast').show();
	});

	$('#button-openfile').hover(
		function () { $(this).addClass('hover'); },
		function () { $(this).removeClass('hover'); }
	);

	$('#button-importfile').hover(
		function () { $(this).addClass('hover'); },
		function () { $(this).removeClass('hover'); }
	);

	$('#button-openurl').click(function () {
		importFile = false;
		showDialog('#dialog-openurl');
		$('#dialog-openurl input').val('').attr('disabled', false).focus();
	});

	$('#button-importurl').click(function () {
		importFile = true;
		showDialog('#dialog-openurl');
		$('#dialog-openurl input').val('').attr('disabled', false).focus();
	});
	
	$('#button-undo').click(function () { app.undo(); });
	$('#button-redo').click(function () { app.redo(); });
	
	$('#button-layerscale').click(function () {
		affectImage = false;
		showDialog('#dialog-scale');
		$('#dialog-scale input.input-scaleX').val('100');
		$('#dialog-scale input.input-scaleY').val('100');
	});
	
	$('#button-layerskew').click(function () {
		affectImage = false;
		showDialog('#dialog-skew');
		$('#dialog-skew input.input-scaleX').val('100');
		$('#dialog-skew input.input-scaleY').val('100');
	});
	
	$('#button-layerrotate').click(function () {
		affectImage = false;
		showDialog('#dialog-rotate');
		$('#dialog-rotate input').val('0');
	});
	
	$('#button-layercrop').click(function () {
		affectImage = false;
		app.sortLayers();
		app.refreshLayers();
		var layer = app.getActiveLayer();
		$('#overlay').show();
		$('#cropoverlay').css({
			left: Math.ceil(app.canvas.width / 2 + layer.x - layer.regX - 1) + 'px',
			top: Math.ceil(app.canvas.height / 2 + layer.y - layer.regY + 38) + 'px', 
			width: (layer.text != null ? layer.getMeasuredWidth() * layer.scaleX: layer.image.width * layer.scaleX) + 2 + 'px', 
			height: (layer.text != null ? layer.getMeasuredLineHeight() * layer.scaleY: layer.image.height * layer.scaleY) + 2 + 'px'
		}).show();
	});
	
	$('#button-layerflipv').click(app.callbacks.layerFlipV);
	$('#button-layerfliph').click(app.callbacks.layerFlipH);
	
	$('#button-imagescale').click(function () {
		affectImage = true;
		showDialog('#dialog-scale');
		$('#dialog-scale input.input-scaleX').val('100');
		$('#dialog-scale input.input-scaleY').val('100');
	});
	
	$('#button-imageskew').click(function () {
		affectImage = true;
		showDialog('#dialog-skew');
		$('#dialog-skew input.input-scaleX').val('100');
		$('#dialog-skew input.input-scaleY').val('100');
	});
	
	$('#button-imagerotate').click(function () {
		affectImage = true;
		showDialog('#dialog-rotate');
		$('#dialog-rotate input').val('0');
	});
	
	$('#button-imageskew').click(function () {
		affectImage = true;
		showDialog('#dialog-skew');
		$('#dialog-skew input.input-skewX').val('0');
		$('#dialog-skew input.input-skewY').val('0');
	});
	
	$('#button-filterbrightness').click(function () {
		showDialog('#dialog-filterbrightness');
		$('#dialog-filterbrightness input').val('100');
	});
	
	$('#button-filtercolorify').click(function () {
		showDialog('#dialog-filtercolorify');
		$('#dialog-filtercolorify input').val('0');
	});
	
	$('#button-filterblur').click(function () {
		showDialog('#dialog-filterblur');
		$('#dialog-filterblur input').val('1');
	});
	
	$('#button-filtergaussianblur').click(function () {
		showDialog('#dialog-filtergaussianblur');
		$('#dialog-filtergaussianblur input.7').attr('checked', true);
	});
	
	$('#button-executescript').click(function () {
		showDialog('#dialog-executescript');
		$('#dialog-executescript textarea').val('');
	});
	
	$('#button-select').click(function () {
		app.tool = TOOL_SELECT;
		$('#mainmenu button').removeClass('active');
		$(this).addClass('active');
	});
	
	$('#button-move').click(function () {
		app.tool = TOOL_MOVE;
		$('#mainmenu button').removeClass('active');
		$(this).addClass('active');
	});
	
	$('#button-text').click(function () {
		app.tool = TOOL_TEXT;
		$('#mainmenu button').removeClass('active');
		$(this).addClass('active');
	});
	
	$('#button-imageflipv').click(app.callbacks.imageFlipV);
	$('#button-imagefliph').click(app.callbacks.imageFlipH);
	
	$('#dialog-openurl input').keydown(app.callbacks.openURL);
	$('#dialog-openurl button.button-ok').click(app.callbacks.openURL);
	$('#dialog-scale input').keydown(app.callbacks.numberOnly).keydown(app.callbacks.layerScale);
	$('#dialog-scale button.button-ok').click(app.callbacks.layerScale);
	$('#button-openfile input').change(app.callbacks.openFile);
	$('#button-importfile input').change(app.callbacks.importFile);
	$('#dialog-tooltext button.button-ok').click(app.callbacks.toolText);
	$('#dialog-tooltext input').keydown(app.callbacks.toolText);
	$('#dialog-layerrename button.button-ok').click(app.callbacks.layerRename);
	$('#dialog-layerrename input').keydown(app.callbacks.layerRename);
	$('#dialog-rotate button.button-ok').click(app.callbacks.layerRotate);
	$('#dialog-rotate input').keydown(app.callbacks.numberOnly).keydown(app.callbacks.layerRotate);
	$('#dialog-skew button.button-ok').click(app.callbacks.layerSkew);
	$('#dialog-skew input').keydown(app.callbacks.numberOnly).keydown(app.callbacks.layerSkew);
	$('#cropoverlay button.button-ok').click(app.callbacks.layerCrop);
	$('#button-filterdesaturation').click(app.callbacks.filterDesaturation);
	$('#button-filteredgedetection').click(app.callbacks.filterEdgeDetection);
	$('#button-filteredgeenhance').click(app.callbacks.filterEdgeEnhance);
	$('#button-filteremboss').click(app.callbacks.filterEmboss);
	$('#button-filtersharpen').click(app.callbacks.filterSharpen);
	$('#dialog-filterbrightness button.button-ok').click(app.callbacks.filterBrightness);
	$('#dialog-filterbrightness input').keydown(app.callbacks.numberOnly).keydown(app.callbacks.filterBrightness);
	$('#dialog-filtergaussianblur button.button-ok').click(app.callbacks.filterGaussianBlur);
	$('#dialog-filtergaussianblur input').keydown(app.callbacks.numberOnly).keydown(app.callbacks.filterGaussianBlur);
	$('#dialog-filterblur button.button-ok').click(app.callbacks.filterBlur);
	$('#dialog-filterblur input').keydown(app.callbacks.numberOnly).keydown(app.callbacks.filterBlur);
	$('#dialog-filtercolorify button.button-ok').click(app.callbacks.filterColorify);
	$('#dialog-filtercolorify input').keydown(app.callbacks.numberOnly).keydown(app.callbacks.filterColorify);
	$('#dialog-executescript button.button-ok').click(app.callbacks.scriptExecute);
	$('#button-save').click(app.callbacks.saveFile);
	$('#button-print').click(app.callbacks.printFile);
	
	$('#dialog-tooltext input.input-color').keyup(function (e) {
		$(this).css({ backgroundColor: $(this).val() });
	});
	
	$('ul#layers li').live('click', function () {
		app.activateLayer($(this).attr('id').replace('layer-', '') * 1);
	});
	
	$('ul#layers li button.button-delete').live('click', function () {
		app.layers.splice($(this).parent().parent().attr('id').replace('layer-', '') * 1, 1);
		this.undoBuffer = [];
		this.redoBuffer = [];
		app.refreshLayers();
	});
	
	$('ul#layers li button.button-hide').live('click', function () {
		if ($(this).text() == 'Hide') {
			app.layers[$(this).parent().parent().attr('id').replace('layer-', '') * 1].visible = false;
		} else {
			app.layers[$(this).parent().parent().attr('id').replace('layer-', '') * 1].visible = true;
		}
		app.refreshLayers();
	});
	
	$('ul#layers li button.button-rename').live('click', function () {
		$('#dialog-layerrename').show();
		$('#overlay').show();
		$('#dialog-layerrename input').val('');
		app.renameLayer = $(this).parent().parent().attr('id').replace('layer-', '') * 1;
	});
	
	$(document).keydown(function (e) {
		if (e.keyCode == 27) {
			hideDialog('.dialog');
		}
	});
	
	$('.dialog button.button-cancel').each(function () {
		$(this).click(function () {
			hideDialog($(this).parent());
		});
	});
	
	$('canvas').click(app.callbacks.toolText);
	
	$('#cropoverlay').draggable().resizable({
		handles: 'se',
		resize: function (e, ui) {
			$('#cropoverlay').css({ left: ui.position.left + 'px', top: ui.position.top + 'px' });
		},
		stop: function (e, ui) {
			$('#cropoverlay').css({ left: ui.position.left + 'px', top: ui.position.top + 'px' });
		}
	});
	
	$(window).resize();
});