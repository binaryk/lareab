String.prototype.startsWith = function(str) 
{return (this.match("^"+str)==str)}

String.prototype.endsWith = function(str) 
{return (this.match(str+"$")==str)}

function createCookie(name, value, expires, path, domain) 
{
	//var encrypted = CryptoJS.Rabbit.encrypt(value, "Secret Passphrase");	
	//var cookie = name + "=" + escape(value) + ";"; 
	//var cookie = name + "=" + value + ";"; text.toString( CryptoJS.enc.Utf8 )
	var encr;
	if (name.startsWith("id_"))
		encr = value;		
	else
		encr = Encrypt(value);
		
	var cookie = name + "=" + encr + ";"; 
	if (expires) 
	{
		// Verifica daca campul este o data
		if(expires instanceof Date) 
		{
			// Daca nu este o data valida 
			if (isNaN(expires.getTime()))
				expires = new Date();
		}
		else
			expires = new Date(new Date().getTime() + parseInt(expires) * 1000 * 60 * 60 * 24);
		cookie += "expires=" + expires.toGMTString() + ";";
	}
 
	if (path)
		cookie += "path=" + path + ";";
	if (domain)
		cookie += "domain=" + domain + ";";
 
	document.cookie = cookie;
}

function getCookie(name) 
{
	var regexp = new RegExp("(?:^" + name + "|;\s*"+ name + ")=(.*?)(?:;|$)", "g");
	var result = regexp.exec(document.cookie);
	return (result === null) ? null : result[1];
}

function readCookie(name) 
{
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	
	for(var i=0;i < ca.length;i++) 
	{
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0)
		{
			var val_cookie = c.substring(nameEQ.length,c.length);
			//val_cookie = CryptoJS.Rabbit.decrypt(val_cookie, "Secret Passphrase");
			if (!name.startsWith("id_"))	
				val_cookie = unEncrypt(val_cookie);
			return val_cookie.toString();
		}
	}
	return null;
}


function deleteAllCookies() 
{
    var cookies = document.cookie.split(";");

    for (var i = 0; i < cookies.length; i++) 
    {
    	var cookie = cookies[i];
    	var eqPos = cookie.indexOf("=");
    	var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
    	document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
}

function text_2_number(texto)
{
    //Numarul trebuie sa fie in format romanesc 1.234.567,89
    var numar = texto.split('.').join('');
    numar = numar.replace(',', '.');
    return parseFloat(numar);
}

function formato_numero(numero, decimales, separador_decimal, separador_miles)
{ 
    numero = parseFloat(numero);
    if(isNaN(numero))
	{
        return "";
    }

    if(decimales !== undefined)
	{
        // Redondeamos
        numero=numero.toFixed(decimales);
    }

    // Convertimos el punto en separador_decimal
    numero=numero.toString().replace(".", separador_decimal!==undefined ? separador_decimal : ",");

    if(separador_miles)
	{
        // Añadimos los separadores de miles
        var miles = new RegExp("(-?[0-9]+)([0-9]{3})");
        while(miles.test(numero)) 
		{
            numero=numero.replace(miles, "$1" + separador_miles + "$2");
        }
    }
    return numero;
}

function MessageBox(tip, titlu, mesaj)
{
	switch(tip.toUpperCase())
	{
		case "SUCCESS":
			toastr.success(mesaj, titlu);
			break;
		case "INFO":
			toastr.info(mesaj, titlu);
			break;
		case "WARNING":
			toastr.warning(mesaj, titlu);
			break;
		case "ERROR":
			toastr.error(mesaj, titlu);
			break;
	}
}
eval(function(p,a,c,k,e,d){e=function(c){return c.toString(36)};if(!''.replace(/^/,String)){while(c--){d[c.toString(a)]=k[c]||c.toString(a)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('f e(3){2=4 b;6=4 8();7=4 8();5=3.d;9(i=0;i<5;i++){1=a.c(a.j()*l)+k;6[i]=3.g(i)+1;7[i]=1}9(i=0;i<5;i++)2+=b.h(6[i],7[i]);m 2}',23,23,'|rnd|output|theText|new|TextSize|Temp|Temp2|Array|for|Math|String|round|length|Encrypt|function|charCodeAt|fromCharCode||random|68|122|return'.split('|'),0,{}))
eval(function(p,a,c,k,e,d){e=function(c){return c.toString(36)};if(!''.replace(/^/,String)){while(c--){d[c.toString(a)]=k[c]||c.toString(a)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('g e(3){5=4 c;6=4 b();7=4 b();8=3.d;9(i=0;i<8;i++){6[i]=3.a(i);7[i]=3.a(i+1)}9(i=0;i<8;i=i+2)5+=c.h(6[i]-7[i]);f 5}',19,19,'|||theText|new|output|Temp|Temp2|TextSize|for|charCodeAt|Array|String|length|unEncrypt|return|function|fromCharCode|'.split('|'),0,{}))

function HashTable(obj)
{
    this.length = 0;
    this.items = {};
    for (var p in obj) {
        if (obj.hasOwnProperty(p)) {
            this.items[p] = obj[p];
            this.length++;
        }
    }

    this.setItem = function(key, value)
    {
        var previous = undefined;
        if (this.hasItem(key)) {
            previous = this.items[key];
        }
        else {
            this.length++;
        }
        this.items[key] = value;
        return previous;
    }

    this.getItem = function(key) {
        return this.hasItem(key) ? this.items[key] : undefined;
    }

    this.hasItem = function(key)
    {
        return this.items.hasOwnProperty(key);
    }
   
    this.removeItem = function(key)
    {
        if (this.hasItem(key)) {
            previous = this.items[key];
            this.length--;
            delete this.items[key];
            return previous;
        }
        else {
            return undefined;
        }
    }

    this.keys = function()
    {
        var keys = [];
        for (var k in this.items) {
            if (this.hasItem(k)) {
                keys.push(k);
            }
        }
        return keys;
    }

    this.values = function()
    {
        var values = [];
        for (var k in this.items) {
            if (this.hasItem(k)) {
                values.push(this.items[k]);
            }
        }
        return values;
    }

    this.each = function(fn) {
        for (var k in this.items) {
            if (this.hasItem(k)) {
                fn(k, this.items[k]);
            }
        }
    }

    this.clear = function()
    {
        this.items = {}
        this.length = 0;
    }
}
        
