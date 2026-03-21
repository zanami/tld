if (!window.BX_YMapAddPlacemark)
{
	window.BX_YMapAddPlacemark = function(map, arPlacemark)
	{
		if (map == null)
		{
			return false;
		}

		if (!arPlacemark.LAT || !arPlacemark.LON)
		{
			return false;
		}

		var props = {};
		if (arPlacemark.TEXT != null && arPlacemark.TEXT.length > 0)
		{
			var valueView = '';
			var rnpos = arPlacemark.TEXT.indexOf("\n");
			valueView = rnpos <= 0 ? arPlacemark.TEXT : arPlacemark.TEXT.substring(0, rnpos);

			props.balloonContent = arPlacemark.TEXT.replace(/\n/g, '<br />');
			props.hintContent = valueView;
		}

		var placemark = new ymaps.Placemark(
			[arPlacemark.LAT, arPlacemark.LON],
			props,
			{balloonCloseButton: true}
		);

		map.geoObjects.add(placemark);

		return placemark;
	};
}

if (!window.BX_YMapAddPolyline)
{
	window.BX_YMapAddPolyline = function(map, arPolyline)
	{
		if (map == null)
		{
			return false;
		}

		if (arPolyline.POINTS == null || arPolyline.POINTS.length <= 1)
		{
			return false;
		}

		var points = [];
		for (var i = 0, len = arPolyline.POINTS.length; i < len; i++)
		{
			points.push([arPolyline.POINTS[i].LAT, arPolyline.POINTS[i].LON]);
		}

		var params = {clickable: true};
		if (arPolyline.STYLE != null)
		{
			params.strokeColor = arPolyline.STYLE.strokeColor;
			params.strokeWidth = arPolyline.STYLE.strokeWidth;
		}

		var polyline = new ymaps.Polyline(points, {balloonContent: arPolyline.TITLE}, params);
		map.geoObjects.add(polyline);

		return polyline;
	};
}
