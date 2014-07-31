define([], function(){
	var arrayIntersect = function(arr1) {
		var retArr = {},
			argl = arguments.length,
			arglm1 = argl - 1,
			k1 = '',
			arr = {},
			i = 0,
			k = '';

		arr1keys: for (k1 in arr1) {
			arrs: for (i = 1; i < argl; i++) {
				arr = arguments[i];
				for (k in arr) {
					if (k === k1) {
						if (i === arglm1) {
							retArr[k1] = arr1[k1];
						}
						// If the innermost loop always leads at least once to an equal value, continue the loop until done
						continue arrs;
					}
				}
				// If it reaches here, it wasn't found in at least one array, so try next value
				continue arr1keys;
			}
		}
		return retArr;
	};

	return arrayIntersect;
});