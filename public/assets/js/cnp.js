function map(fn, arr)
{
	var ret = [];
	for(var x = 0; x < arr.length; x++)
		ret.push(fn(arr[x]));
	return ret;
}

function reduce(fn, arr, initial){
	function iter(idx, ret){
		if(idx >= arr.length)
			return ret;
		else
			return iter(idx+1, fn(arr[idx], ret));
 	}
	return iter(initial ? 0 : 1, initial || arr[0]);
}

function sum(arr) { return reduce(function(x, y){ return x + y;}, arr, 0); }

function verifica_cnp(cnp)
{
	//CNP - masoara 13 caractere
	if(cnp.length != 13)
		return false;
	
	cnp = map(parseInt, cnp.split(''));

	var coefs = [2, 7, 9, 1, 4, 6, 3, 5, 8, 2, 7, 9];
	var idx = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];

	var s = map(function(x){return coefs[x] * cnp[x];}, idx);
	s = sum(s) % 11;

	return (s < 10 && s == cnp[12]) || (s == 10 && cnp[12] == 1);
}

