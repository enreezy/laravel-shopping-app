const 
	TOOL_MOVE = 0,
	TOOL_SELECT = 1,
	TOOL_TEXT = 2;
	
app = {
	stage: null,
	canvas: null,
	layers: [],
	tool: TOOL_SELECT,
	callbacks: {},
	selection: {
		x: -1, x: -1
	},
	renameLayer: 0,
	undoBuffer: [],
	redoBuffer: [],
	
	addUndo: function () {
		this.undoBuffer.push(this.layers.toString());
		this.redoBuffer = [];
	},
	
	loadLayers: function (from, to) {
		var json, jsonString = from.pop();
		if (jsonString == undefined) return false;
		to.push(this.layers.toString());
		json = JSON.parse(jsonString);
		for (var i = 0, layer, jsonLayer; ((layer = this.layers[i]) && (jsonLayer = json[i])); i++) {
			for (value in jsonLayer) {
				if (value != 'filters')	{
					layer[value] = jsonLayer[value];
				} else {
					var hadFilters = (layer.filters != null && layer.filters.length > 0);
					layer.filters = [];
					for (var j = 0; j < jsonLayer.filters.names.length; j++) {
						if (jsonLayer.filters.names[j] == null) break;
						layer.filters[j] = new window[jsonLayer.filters.names[j]];
						for (value2 in jsonLayer.filters.values[0][j]) {
							layer.filters[j][value2] = jsonLayer.filters.values[0][j][value2];
						}
						hadFilters = true;
					}
					if (hadFilters) {
						if (layer.cacheCanvas) {
							layer.updateCache();
						} else {
							layer.cache(0, 0, layer.width, layer.height);
						}
					}
				}
			}
		}
		this.refreshLayers();
	},
	
	undo: function () {
		this.loadLayers(this.undoBuffer, this.redoBuffer);
	},
	
	redo: function () {
		this.loadLayers(this.redoBuffer, this.undoBuffer);
	},
	
	getActiveLayer: function () {
		var ret;
		this.layers.forEach(function(v) {
			if (v.active) ret = v;
		});
		return ret || this.layers[0];
	},
	
	getActiveLayerN: function () {
		for (var i = 0, layer; layer = this.layers[i]; i++) {
			if (layer.active) return i;
		}
	},
	
	activateLayer: function (layer) {
		this.layers.forEach(function (v) {
			v.active = false;
		});
		if (layer instanceof Bitmap) {
			layer.active = true;
		} else  {
			if (this.layers[layer] == undefined) return;
			this.layers[layer].active = true;
		}
		this.refreshLayers();
	},
	
	refreshLayers: function () {
		if ((this.getActiveLayer() == undefined) && (this.layers.length > 0)) this.layers[0].active = true;
		this.stage = new Stage(this.canvas);
		this.stage.regX = -this.canvas.width / 2;
		this.stage.regY = -this.canvas.height / 2;
		

		app.layers.toString = function () {
			var ret = [];
			for (var i = 0, layer; layer = this[i]; i++) {
				ret.push('{"x":' + layer.x + ',"y":' + layer.y + ',"scaleX":' + layer.scaleX + ',"scaleY":' + layer.scaleY + ',"skewX":' + layer.skewX + ',"skewY":' + layer.skewY + ',"active":' + layer.active + ',"visible":' + layer.visible + ',"filters":{"names":[' + (layer.filters != null ? layer.filters.toString().replace(/(\[|\])/g, '"'): 'null') + '],"values":[' + JSON.stringify(layer.filters) + ']}}');
			}
			return '[' + ret.join(',') + ']';
		}
		
		$('ul#layers').html('');
		for (var i = 0, layer; layer = this.layers[i]; i++) {
			var self = this;
			self.stage.addChild(layer);
			(function(t, n) {
				layer.onClick = function (e) {
					if ((self.tool != TOOL_TEXT) || (!t.text)) return true;
					self.activateLayer(t);
					editText = true;
				}
				
				layer.onPress = function (e1) {
					if (self.tool == TOOL_SELECT) {
						self.activateLayer(t);
					}
					
					var	offset = {
						x: t.x - e1.stageX,
						y: t.y - e1.stageY
					}
					
					if (self.tool == TOOL_MOVE) self.addUndo();
					
					e1.onMouseMove = function (e2) {
						if (self.tool == TOOL_MOVE) {
							t.x = offset.x + e2.stageX;
							t.y = offset.y + e2.stageY;
						}
					}
				};
			})(layer, i);
			layer.width = (layer.text != null ? layer.getMeasuredWidth() * layer.scaleX: layer.image.width * layer.scaleX);
			layer.height = (layer.text != null ? layer.getMeasuredLineHeight() * layer.scaleY: layer.image.height * layer.scaleY);
			layer.regX = layer.width / 2;
			layer.regY = layer.height / 2;
			$('ul#layers').prepend('<li id="layer-' + i + '" class="' + (layer.active ? 'active': '') + '"><img src="' + (layer.text != undefined ? '': layer.image.src) + '"/><h1>' + ((layer.name != null) && (layer.name != '') ? layer.name: 'Unnamed layer') + '</h1><span><button class="button-delete">Delete</button><button class="button-hide">' + (layer.visible ? 'Hide': 'Show') + '</button><button class="button-rename">Rename</button></span></li>');
		}
		this.stage.update();
		$('ul#layers').sortable({
			stop: function () {
				app.sortLayers();
			}
		});
		
		if (this.layers.length > 0) {
			$('#button-layercrop').attr('disabled', false);
			$('#button-layerscale').attr('disabled', false);
			$('#button-layerrotate').attr('disabled', false);
			$('#button-layerskew').attr('disabled', false);
			$('#button-layerflipv').attr('disabled', false);
			$('#button-layerfliph').attr('disabled', false);
			$('#button-imagescale').attr('disabled', false);
			$('#button-imagerotate').attr('disabled', false);
			$('#button-imageskew').attr('disabled', false);
			$('#button-imageflipv').attr('disabled', false);
			$('#button-imagefliph').attr('disabled', false);
			$('#button-filterbrightness').attr('disabled', false);
			$('#button-filtercolorify').attr('disabled', false);
			$('#button-filterdesaturation').attr('disabled', false);
			$('#button-filterblur').attr('disabled', false);
			$('#button-filtergaussianblur').attr('disabled', false);
			$('#button-filteredgedetection').attr('disabled', false);
			$('#button-filteredgeenhance').attr('disabled', false);
			$('#button-filteremboss').attr('disabled', false);
			$('#button-filtersharpen').attr('disabled', false);
		} else {
			$('#button-layercrop').attr('disabled', true);
			$('#button-layerscale').attr('disabled', true);
			$('#button-layerrotate').attr('disabled', true);
			$('#button-layerskew').attr('disabled', true);
			$('#button-layerflipv').attr('disabled', true);
			$('#button-layerfliph').attr('disabled', true);
			$('#button-imagescale').attr('disabled', true);
			$('#button-imagerotate').attr('disabled', true);
			$('#button-imageskew').attr('disabled', true);
			$('#button-imageflipv').attr('disabled', true);
			$('#button-imagefliph').attr('disabled', true);
			$('#button-filterbrightness').attr('disabled', true);
			$('#button-filtercolorify').attr('disabled', true);
			$('#button-filterdesaturation').attr('disabled', true);
			$('#button-filterblur').attr('disabled', true);
			$('#button-filtergaussianblur').attr('disabled', true);
			$('#button-filteredgedetection').attr('disabled', true);
			$('#button-filteredgeenhance').attr('disabled', true);
			$('#button-filteremboss').attr('disabled', true);
			$('#button-filtersharpen').attr('disabled', true);
		}
	},
	
	sortLayers: function () {
		var tempLayers = [],
			layersList = $('ul#layers li');
			
		for (var i = 0, layer; layer = $(layersList[i]); i++) {
			if (layer.attr('id') == undefined) break;
			tempLayers[i] = this.layers[layer.attr('id').replace('layer-', '') * 1];
		}
		
		tempLayers.reverse();
		this.layers = tempLayers;
		this.refreshLayers();
	}
}

tick = function () {
	app.stage.update();
}

$(document).ready(function () {
	app.canvas = $('canvas')[0];
	
	document.onselectstart = function () { return false; };
	
	Ticker.setFPS(30);
	Ticker.addListener(window);
});