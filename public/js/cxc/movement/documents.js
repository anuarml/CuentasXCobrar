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

var aCharges = [];

function Charge(charge){
	if(!charge) charge = {};
	
	this.amount = charge.amount || null;
	this.payment_type = charge.payment_type || null;
	this.reference = charge.reference || null;
}