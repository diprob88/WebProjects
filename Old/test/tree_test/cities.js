class TreeOfCities {

	constructor() {

		// A tree structure containing geographic items
		this.geographicData = [
			{
				name: "Asia",
				children: [
					{
						name: "Japan",
						children: [
							{
								name: "Tokyo",
								population: 33200000
							},
							{
								name: "Osaka/Kobe",
								population: 16425000
							}
						]
					},
					{
						name: "China",
						children: [
							{
								name: "Shanghai",
								population: 10000000
							},
							{
								name: "Shenzhen",
								population: 8000000
							},
							
						]
					}
				]
			},
			{
				name: "Europe",
				children: [
					{
						name: "France",
						children: [
							{
								name: "Ile de France",
								children: [
									{
										name: "Paris",
										population: 9645000
									},
									{
										name: "Val De Marne",
										children: [
											{
												name: "Creteil",
												population: 9645000
											},
											{
												name: "Charenton Le Pont",
												population: 100000
											}
										]
									}
								]
							}
						]
					},
					{
						name: "Germany",
						children: [
							{
								name: "Berlin",
								population: 3675000
							},
							{
								name: "Frankfurt",
								population: 2260000
							}
						]
					}
					
				]
			},
			{
				name: "North America",
				children: [
					{
						name: "United States of America",
						children: [
							{
								name: "California",
								children: [
									{
										name: "Los Angeles",
										population: 11789000
									},
									{
										name: "San Francisco",
										population: 3229000
									},
									{
										name: "San Diego"
									}
								]
							},
							{
								name: "Washington",
								children: [
									{
										name: "Seattle",
										population: 2712000
									}
								]
							}
						]
					}
				]
			}
		]

	}

	// Return an object containing continent names as keys (you can assume 
	// continents are always top level), and total
	// population of any children as a value
	getPopulationByContinent() {	
		var dict = new Object();	
		var population=function sum_population(node)
		{
			if  (node.children == null && "population" in node)
				return node.population;
			else if (node.children != null)
			{
				var output=0;
				for (let key in node.children) 
				{
					output+= sum_population(node.children[key]);
				}
				return output;
			}
			else
				return 0;
		}
				
		for (let key in this.geographicData) 
		{
			let continent=this.geographicData[key];
			dict[continent.name]=population(continent);
			
		}
		return dict;	
		
	}
				
}