(function(window, document) {
	"use strict"
	let link=""

	let keys=""

	let tokens=""

	let count=0

	let list=[]

	/**
	* @function setLink
	*
	* @goal : setLink is to set main link for loading thinCaptcha files...
	*
	* @return bool
	**/

	const setLink = function(url) {
		link=url
		return true
	}

	/**
	* @function setKey
	*
	* @goal : setKey for your thinCaptcha using...
	*
	* @return bool
	**/

	const setKey = function(keyValue, tokenValue) {
		keys=keyValue
		tokens=tokenValue
		return true
	}

	/**
	* @function action
	*
	* @goal : when user type in thinCaptcha input field
	*
	* @return void
	**/
	const action = function(index) {
		// console.log(index)
		// console.log(list)
		// console.log(list[index])
		// console.log(list[index].textID)
		// console.log(list[index]["textID"])
		// // let text=document.querySelector("#"+list[index].textID)
		// console.log(text.value)
		// console.log(list[index].text.value)
	}

	String.prototype.rtrim = function (s) {
		if(s == undefined)
			s = '\\s';
		return this.replace(new RegExp("[" + s + "]*$"), '');
	};
	String.prototype.ltrim = function (s) {
		if(s == undefined)
			s = '\\s';
		return this.replace(new RegExp("^[" + s + "]*"), '');
	};

	const ajax = function(callback, link, params, headers) {
		var http = new XMLHttpRequest()
		http.onreadystatechange = function() {
			if(this.readyState == 4 && this.status == 200) {
				// console.log(this.responseText)
				callback(this.responseText)
			}
		}
		let paramsStr=""
		Object.entries(params).forEach(([key, val]) => {
			paramsStr+=key+"="+val+"&"
		});
		// console.log(params)
		paramsStr=paramsStr.rtrim("&")
		// console.log(paramsStr)

		// http.open("POST", link, true)
		http.open("GET", link+"?"+paramsStr, true)

		// http.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		Object.entries(headers).forEach(([key, val]) => {
			http.setRequestHeader(key, val)
		});
		// http.send(paramsStr)
		http.send()
	}

	const verifing = function(index) {
		console.log("Captcha #"+index)
		if(list[index].used == true) {
			alert("You cannot try again captcha!");
			return
		}
		ajax(function(res) {
			// console.log(res)
			let json=JSON.parse(res)
			console.log(json)
			if(!json || !json.result || !json.result.token) {
				console.log("it's not valid!")
				list[index].used=true
				console.log(list[index].used)
				return
			}
			let token=json.result.token
			let field=document.querySelector("#"+list[index].outputID)
			field.value=token
			console.log(token)
		}, link+"index.php", {
			method: "verify",
			value: document.querySelector("#"+list[index].textID).value,
			code: list[index].session,
		}, {
			key: keys,
			token: tokens,
		})
		console.log(list[index].text)
		console.log(list[index].text.value)
		console.log(document.querySelector("#"+list[index].textID))
		console.log(document.querySelector("#"+list[index].textID).value)
	}

	/**
	* @function reload
	*
	* @goal : reload a thinCaptcha in the page
	*
	* @return void
	**/
	const reload = function(index) {
		// console.log("reload")
		// console.log(list[index].used)
		if(list[index].used == false) {
			apply(list[index].formSelector, list[index].codeSelector, list[index].fieldCodeName, index)
		}
		else {
			alert("You cannot reload captcha!");
		}
	}

	/**
	* @function apply
	*
	* @goal : apply thinCaptcha for a form
	*
	* @return void
	**/
	const apply = function(formSelector, codeSelector, fieldCodeName, listID) {
		if(listID !== undefined) {
			// alert("you want to modify this item.")
			// alert(list)
			// alert(list.length)
		}
		ajax(function(res) {
			// console.log(res)
			let json=JSON.parse(res)
			// console.log(json)
			if(!json || !json.result || !json.result.code) {
				return
			}
			let form=document.querySelector(formSelector)
			let code=document.querySelector(codeSelector)
			// console.log(form)
			// console.log(code)
			form.addEventListener("submit", function() {
				// alert("hello!")
			})

			let imageID="thinCaptcha-image"+count
			let imageSRC=link+"captcha.php?code="+json.result.code+"&token="+tokens+"&key="+keys
			code.innerHTML="<img id=\""+imageID+"\" src=\""+imageSRC+"\">"
			let image=code.querySelector("#"+imageID)

			// code.innerHTML+="<a onclick=\"document.querySelector('#"+imageID+"').src='"+imageSRC+"'\">reload</a>"
			let reloadID="thinCaptcha-reload"+count
			code.innerHTML+="<div onlick=\"thinCaptcha.reload("+(count)+")\" id=\""+reloadID+"\">reload</div><br>"
			let reload=code.querySelector("#"+reloadID)
			// console.log(reload)
			// reload.addEventListener("click", function() { reload(count-1) })

			let textID="thinCaptcha-text"+count
			code.innerHTML+="<input onblur=\"thinCaptcha.action("+count+")\" onkeypress=\"thinCaptcha.action("+count+")\" onkeyup=\"thinCaptcha.action("+count+")\" oncopy=\"thinCaptcha.action("+count+")\" oncut=\"thinCaptcha.action("+count+")\" onpaste=\"thinCaptcha.action("+count+")\" required=\"true\" id=\""+textID+"\" type=\"text\">"
			let text=code.querySelector("#"+textID)

			let outputID="thinCaptcha-output"+count
			code.innerHTML+="<input name=\""+fieldCodeName+"\" required=\"true\" id=\""+outputID+"\" type=\"text\" style=\"display:none;\">"
			let output=code.querySelector("#"+outputID)

			let verifyID="thinCaptcha-verify"+count
			code.innerHTML+="<a onclick=\"thinCaptcha.verifing("+(count)+")\" id=\""+verifyID+"\">Verify</a>"
			let verify=code.querySelector("#"+verifyID)
			// verify.addEventListener("click", function() { verifing(count-1) })

			// text.addEventListener("blur", function() { action(count-1) })
			// text.addEventListener("keypress", function() { action(count-1) })
			// text.addEventListener("keyup", function() { action(count-1) })
			// text.addEventListener("copy", function() { action(count-1) })
			// text.addEventListener("cut", function() { action(count-1) })
			// text.addEventListener("paste", function() { action(count-1) })

			let values={
				formSelector: formSelector,
				codeSelector: codeSelector,
				fieldCodeName: fieldCodeName,

				code: code,
				form: form,

				imageID: imageID,
				imageSRC: imageSRC,
				image: image,

				textID: textID,
				text: text,

				verifyID: verifyID,
				verify: verify,

				status: false,
				session: json.result.code,

				outputID: outputID,
				output: output,

				used: false,
			}
			if(listID === undefined) {
				list.push(values)
				count++
			}
			else {
				list[listID]=values
			}
		}, link+"index.php", {
			method: "create",
			key: keys,
		}, {
			Token: tokens,
			publicKey: keys,
		})
	}

	/**
	* @struct thinCaptcha
	*
	* @goal : access to public functions
	*
	* @return struct
	**/
	window.thinCaptcha = {
		setLink: setLink,
		apply: apply,
		setKey: setKey,
		ajax: ajax,
		reload: reload,
		action: action,
		verifing: verifing,
		list: list,
	}

})(window, document)
