// JavaScript Document

var calendar = {
		"y2013" : {
				"q1m1" : {
						"start" : 'December 1, 2012',
						"end" : 'December 28, 2012',
						"days" : '28'
					},
				"q1m2" : {
						"start" : 'December 29, 2012',
						"end" : 'January 25, 2013',
						"days" : '28'
					},
				"q1m3" : {
						"start" : 'January 26, 2013',
						"end" : 'March 1, 2013',
						"days" : '35'
					},
				"q2m1" : {
						"start" : 'March 2, 2013',
						"end" : 'March 29, 2013',
						"days" : '28'
					},
				"q2m2" : {
						"start" : 'March 30, 2013',
						"end" : 'April 26, 2013',
						"days" : '28'
					},
				"q2m3" : {
						"start" : 'April 27, 2013',
						"end" : 'May 31, 2013',
						"days" : '35'
					},
				"q3m1" : {
						"start" : 'June 1, 2013',
						"end" : 'June 28, 2013',
						"days" : '28'
					},
				"q3m2" : {
						"start" : 'June 29, 2013',
						"end" : 'July 26, 2013',
						"days" : '28'
					},
				"q3m3" : {
						"start" : 'July 27, 2013',
						"end" : 'August 30, 2013',
						"days" : '35'
					},
				"q4m1" : {
						"start" : 'August 31, 2013',
						"end" : 'September 27, 2013',
						"days" : '28'
					},
				"q4m2" : {
						"start" : 'September 28, 2013',
						"end" : 'October 25, 2013',
						"days" : '28'
					},
				"q4m3" : {
						"start" : 'October 26, 2013',
						"end" : 'November 29, 2013',
						"days" : '35'
					}

			}
	}

var months = [
	"january",
	"february",
	"march",
	"april",
	"may",
	"june",
	"july",
	"august",
	"september",
	"october",
	"november",
	"december"
];

var days = [
	31,
	28,
	31,
	30,
	31,
	30,
	31,
	31,
	30,
	31,
	30,
	31
];

var weekday = [
	"Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"
];

var convertToNumber = function(d) {
		var y=d.getFullYear();
		var sum = 0;
		if(y%4 == 0) {
				days[1] = 29;
			} else {
					days[1] = 28;
				}
		for(var i=0; i<d.getMonth(); i++) {
				sum += days[i];
			}
		sum += d.getDate();
		return sum;
	}
	
var numberOfDaysMonth = function(n,y) {
		if(y%4 == 0) {
				days[1] = 29;
			} else {
					days[1] = 28;
				}
		return days[n-1];
	}