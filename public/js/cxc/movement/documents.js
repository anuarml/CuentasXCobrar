var aCxcD = [];

function CxcD(doc){
	if(!doc) doc = {};

	this.row = doc.row || null;
	this.apply = doc.apply || null;
	this.apply_id = doc.apply_id || null;
	this.amount = doc.amount || null;
	this.p_p_discount = doc.p_p_discount || null;
}

function CxcDocument(doc){
	if(!doc) doc = {};

	this.balance = doc.balance || null;
	this.concept = doc.concept || null;
	this.reference = doc.reference || null;

	this.difference = function(amount){

		if(!this.balance || !amount){
			return null;
		}

		var difference = new Decimal(this.balance).minus(amount).toNumber();
		return difference;
	};
	this.diferencePercent = function(amount){

	};
}

var applyList = [];