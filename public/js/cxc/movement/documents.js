var aCxcD = [];

function CxcD(doc){
	if(!doc) doc = {};

	this.row = doc.row || null;
	this.apply = doc.apply || null;
	this.apply_id = doc.apply_id || null;
	this.amount = doc.amount || null;
	this.p_p_discount = doc.p_p_discount || null;
}

var applyList = [];