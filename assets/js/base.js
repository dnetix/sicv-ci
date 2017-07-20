/**
 * Operaciones básicas 
 */

function setMoneyValue(campo, numberfield){
			
	valor = $("#"+campo).val();
	
	sw = true;
	
	if(isNaN(valor)){
		valor = valor.replace(/[$.',\s]/g, '');
		if(isNaN(valor)){
			alert("Solo se permiten valores numericos.");
			campo.value = '';
			$("#"+numberfield).val('');
			sw = false;
			return 0;
		}
	}
	
	if(sw){
		
		if(numberfield != ""){
			$("#"+numberfield).val(valor);
		}
		
		var decimals = Math.ceil(valor.length / 3) - 1;
		var money = '';
		var dots = new Array ("'", ".", "'", ".", "'", ".");
		
		i = decimals + 1;
		
		if(i > 0 && valor.length > 3){
			
			while(i > 0){
				if(i == 1){
					money = money.concat(dots[i], valor.slice(i * -3));
				}else if(i == (decimals + 1)){
					money = money.concat('$ ' + valor.slice((i*-3), ((i-1)*-3)));
				}else{
					money = money.concat(dots[i], valor.slice((i*-3), ((i-1)*-3)));
				}
				
				i--;
			}
			
		}else{
			money = '$ ' + valor;
		}
		$("#"+campo).val(money);
	}
	
}

function setMoneyValueTOT(campo, numberfield){
			
	valor = $("#"+campo).val();
	
	sw = true;
	
	if(isNaN(valor)){
		valor = valor.replace(/[$.',\s]/g, '');
		if(isNaN(valor)){
			alert("Solo se permiten valores numericos.");
			campo.value = '';
			$("#"+numberfield).val('');
			sw = false;
			return 0;
		}
	}
	
	if(sw){
		
		if(numberfield != ""){
			$("#"+numberfield).val(valor);
		}
		
		var decimals = Math.ceil(valor.length / 3) - 1;
		var money = '';
		var dots = new Array ("'", ".", "'", ".", "'", ".");
		
		i = decimals + 1;
		
		if(i > 0 && valor.length > 3){
			
			while(i > 0){
				if(i == 1){
					money = money.concat(dots[i], valor.slice(i * -3));
				}else if(i == (decimals + 1)){
					money = money.concat('$ ' + valor.slice((i*-3), ((i-1)*-3)));
				}else{
					money = money.concat(dots[i], valor.slice((i*-3), ((i-1)*-3)));
				}
				
				i--;
			}
			
		}else{
			money = '$ ' + valor;
		}
		
		$("#"+campo).val(money);
		totalizar();
	}
	
}

function getMoneyValue(valor){
	
	valor = valor.toString();
	sw = true;
	
	if(isNaN(valor)){
		valor = valor.replace(/[$.',\s]/g, '');
		if(isNaN(valor)){
			sw = false;
			return valor;
		}
	}
	
	if(sw){
		
		var decimals = Math.ceil(valor.length / 3) - 1;
		var money = '';
		var dots = new Array ("'", ".", "'", ".", "'", ".");
		i = decimals + 1;
		
		if(i > 0 && valor.length > 3){
			
			while(i > 0){
				if(i == 1){
					money = money.concat(dots[i], valor.slice(i * -3));
				}else if(i == (decimals + 1)){
					money = money.concat('$ ' + valor.slice((i*-3), ((i-1)*-3)));
				}else{
					money = money.concat(dots[i], valor.slice((i*-3), ((i-1)*-3)));
				}
				
				i--;
			}
			
		}else{
			
			money = '$ ' + valor;
			return money;
			
		}
		
		return money;
	}
	
}

function moneyToNumber(idcampo){
	return $("#"+idcampo).val().replace(/[$.',\s]/g, '');
}

function getStringFecha(fecha){
	var mes = fecha.getMonth();
	mes = mes + 1;
	if(mes < 10){
		return fecha.getFullYear()+'-0'+mes+'-'+fecha.getDate();
	}else{
		return fecha.getFullYear()+'-'+mes+'-'+fecha.getDate();
	}
}

function closeMsg(element){
	$("#"+element.id).hide("fast");
}
