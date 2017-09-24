### API - SismoMX News Confirmed

#### Endpoints

- `api/data/news` (http://ec2-34-223-244-147.us-west-2.compute.amazonaws.com/api/data/news)
	- Sin filtros
		- La respuesta del API será la correspondiente a todas las categorias: urgencias, centros, albergues, ofrecimientos, otros.
		- Nota: El máximo de elementos que se obtendra por cada categoría seran 1000 elementos.
	- Con filtros
		- Para aplicar filtros el URI deberá quedar de la siguiente forma: 
			- `api/data/news?filters={}` donde el valor de la variable `filters` deberá corresponder a la estructura de un json válido, ejemplo:

			```
				{
				  "centros": {
				    "conditions": [
				      {
				        "field": "urgency_level",
				        "operator": "=",
				        "value": "alto"
				      },
				      {
				        "field": "created_at",
				        "operator": ">=",
				        "value": "2017-09-24"
				      }
				    ],
				    "fields": ['zone', 'map', contact],
				    "limit": 100
				  }
				}
			```

			- Del ejemplo anterior el request queda como:
				`http://ec2-34-223-244-147.us-west-2.compute.amazonaws.com/api/data/news?filters={"centros":{"conditions":[{"field":"urgency_level","operator":"=","value":"alto"},{"field":"created_at","operator":">=","value":"2017-09-24"}],"fields":["zone","map","contact"],"limit":100}}`

				- Y se esta indicando que se desea recuperar solo lo relativo a `centros`, aplicando las siguientes condiciones:
					- Los registros a recuperar en el campo `urgency_level` debera tener un valor `=` a `alto`
					- Los registros a recuperar en el campo  `created_at` deberá tener un valor `>=` a '2017-09-24'
					- Notas: 
						- `field` debe ser un campo existente en la tabla, `operator` debe ser un operador válido para mysql, `value` es el valor que se desea coincida en la búsqueda.
						- El operador `IN` de mysql no esta soportado
						- Si se desea utilizar el operador `like` el valor a enviar en `value` debera contener el operador para comparación `%` según se desee la comparación
				- El índice `fields` sirve para especificar los campos que se desean recuperar, si no se envia o en su defecto se envía como un arreglo vacío, se recuperarán todos los campos que esten en la tabla.
				- El índice `limit` sirve para especificar el limite de elementos a recuperar cuando se realice la consulta, si no se desea agregar un limite se deberá enviar con un valor de `-1`.

			- Los pasos anteriores aplican de igual forma para las categorias restantes: urgencias, albergues, ofrecimientos, otros, ejemplo:
				`http://ec2-34-223-244-147.us-west-2.compute.amazonaws.com/api/data/news?filters={"centros":{"conditions":[{"field":"urgency_level","operator":"=","value":"alto"},{"field":"created_at","operator":">=","value":"2017-09-24"}],"fields":["zone","map","contact"],"limit":100}, "urgencias":{"conditions":[{"field":"brigade_required","operator":"=","value":"NO"},{"field":"created_at","operator":">=","value":"2017-09-24"}],"limit":200}}`

				El json donde se indicar los filtros queda como:
					```
						{
						  "centros": {
						    "conditions": [
						      {
						        "field": "urgency_level",
						        "operator": "=",
						        "value": "alto"
						      },
						      {
						        "field": "created_at",
						        "operator": ">=",
						        "value": "2017-09-24"
						      }
						    ],
						    "fields": ['zone', 'map', contact],
						    "limit": 100
						  },
						  "urgencias": {
						    "conditions": [
						      {
						        "field": "brigade_required",
						        "operator": "=",
						        "value": "NO"
						      },
						      {
						        "field": "created_at",
						        "operator": ">=",
						        "value": "2017-09-24"
						      }
						    ],
						    "limit": 200
						  }
						}
					```
