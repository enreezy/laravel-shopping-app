(function (window) {
	var ConvolutionFilter = function (matrix, factor, offset) {
		this.initialize(matrix, factor, offset);
	}
	
	var p = ConvolutionFilter.prototype = new Filter();
	
	p.matrix = null;
	p.factor = 0.0;
	p.offset = 0.0;
		
	p.initialize = function (matrix, factor, offset) {
		this.matrix = matrix;
		this.factor = factor;
		this.offset = offset;
	}
	
	p.applyFilter = function (ctx, x, y, width, height, targetCtx, targetX, targetY) {
		targetCtx = targetCtx || ctx;
		targetX = (targetX == null ? x: targetX);
		targetY = (targetY == null ? y: targetY);
		
		try {
			var imageData = ctx.getImageData(x, y, width, height);
		} catch (e) {
			return false;
		}
		
		var data = JSON.parse(JSON.stringify(imageData.data));
		
		var matrixhalf = Math.floor(this.matrix.length / 2);
		var r = 0, g = 1, b = 2, a = 3;
		
		for (var y = 0; y < height; y++) {
			for (var x = 0; x < width; x++) {
				var pixel = (y * width + x) * 4,
					sumr = 0, sumg = 0, sumb = 0;
				for (var matrixy in this.matrix) {
					for (var matrixx in this.matrix[matrixy]) {
						var convpixel = ((y + (matrixy - matrixhalf)) * width + (x + (matrixx - matrixhalf))) * 4;
						sumr += data[convpixel + r] * this.matrix[matrixy][matrixx];
						sumg += data[convpixel + g] * this.matrix[matrixy][matrixx];
						sumb += data[convpixel + b] * this.matrix[matrixy][matrixx];
					}
				}
				imageData.data[pixel + r] = this.factor * sumr + this.offset;
				imageData.data[pixel + g] = this.factor * sumg + this.offset;
				imageData.data[pixel + b] = this.factor * sumb + this.offset;
				imageData.data[pixel + a] = data[pixel + a];
			}
		}
		
		targetCtx.putImageData(imageData, targetX, targetY);
		return true;
	}

	p.toString = function() {
		return "[ConvolutionFilter]";
	}
	
	p.clone = function() {
		return new ConvolutionFilter(this.matrix, this.factor, this.offset);
	}
	
	window.ConvolutionFilter = ConvolutionFilter;
}(window));