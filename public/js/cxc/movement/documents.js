var aCxcD = [];
var aCxcDocs = [];

function CxcD(doc){
	if(!doc) doc = {};

	this.row = doc.row || '';
	this.apply = doc.apply || '';
	this.apply_id = doc.apply_id || '';
	this.amount = parseFloat(doc.amount) || 0;
	this.p_p_discount = parseFloat(doc.p_p_discount) || 0;
}

function CxcDocument(doc){
	if(!doc) doc = {};

	this.balance = parseFloat(doc.balance) || 0;
	this.concept = doc.concept || '';
	this.reference = doc.reference || '';
	this.pp_suggest = parseFloat(doc.pp_suggest) || 0;

	this.difference = function(amount){

		if(!this.balance || !amount){
			return '';
		}

		var difference = new Decimal(this.balance).minus(amount).toNumber();
		return difference.toFixed(2);
	};
	this.diferencePercent = function(amount){
		if(!this.balance || !amount){
			return '';
		}

		var diferencePercent = new Decimal(100).minus(new Decimal(amount).times(100).div(this.balance));
		return diferencePercent.toNumber().toFixed(2);
	};
}

var applyList = [];