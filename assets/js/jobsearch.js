function ShowDiv() {
	if(document.getElementById('jobSeekerRadio').checked) {
	  document.getElementById('jobSeekerDiv').style.display = 'block';
	  document.getElementById('employerDiv').style.display = 'none';
	}else if(document.getElementById('employerRadio').checked) {
	  document.getElementById('jobSeekerDiv').style.display = 'none';
	  document.getElementById('employerDiv').style.display = 'block';
	}
	document.getElementById("userTypeError").innerHTML="";
}

function CheckUsernameAvailable(str) {
	var xmlhttp;
	if (str.indexOf(" ") > 0){
		document.getElementById("usernameError").innerHTML = "No spaces allowed in username";
	  	return false;
	}
	if (str.length == 0)
	  {
	  document.getElementById("usernameError").innerHTML = "";
	  return true;
	  }
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange = function()
	  {
	  if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
		document.getElementById("usernameError").innerHTML = xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","registerGet.php?tag=checkusername&username="+str,true);
	xmlhttp.send();
	if (xmlhttp.responseText == "") {
		return true;
	} else {
		return false;
	}
}

function CheckPasswords() {
 	var password = document.getElementById("password").value;
 	var confirm = document.getElementById("confirmPassword").value;
 	if (password == "" || confirm == "") {
 		return false;
 	}
 	if (password == confirm){
 		document.getElementById("passwordError").innerHTML="";
 		return true;
 	}
 	if (password != confirm){
 		document.getElementById("passwordError").innerHTML="Passwords do not match";
 		return false;
 	}
}

function CheckName(str) {
 	if (str == "") {
 		document.getElementById("nameError").innerHTML = "Please enter a company name";
 		document.getElementById("fullnameError").innerHTML = "Please enter your name";
 	} else {
 		document.getElementById("nameError").innerHTML = "";
 		document.getElementById("fullnameError").innerHTML = "";
 	}

}

function CheckEmail(str) {
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (re.test(str)) {
		var xmlhttp;
		if (str.length==0)
		  {
		  document.getElementById("emailError").innerHTML="";
		  return false;
		  }
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
			document.getElementById("emailError").innerHTML=xmlhttp.responseText;
			}
		  }
		xmlhttp.open("GET","registerGet.php?tag=checkemail&email="+str,true);
		xmlhttp.send();
		if (xmlhttp.responseText == "") {
			return true;
		} else {
			return false;
		}
	} else {
		document.getElementById("emailError").innerHTML="Email is not Valid";
		return false;
	}
}

function ValidateRegister() {
	valid = true;
	if (!document.getElementById("jobSeekerRadio").checked && !document.getElementById("employerRadio").checked){
		document.getElementById("userTypeError").innerHTML="Please select either Job Seeker or Employer";
		return false;
	}
	if (!CheckEmail(document.getElementById("email").value)) {
		document.getElementById("emailError").innerHTML="Please enter valid email";
		valid = false;
	}
	if (!CheckPasswords()){
		document.getElementById("passwordError").innerHTML="Please enter password and confirm password";
		valid = false;
	}
	if (!CheckUsernameAvailable(document.getElementById("username").value) || document.getElementById("username").value == "") {
		document.getElementById("usernameError").innerHTML="Please enter valid username";
		valid = false;
	}
	if (!CheckUsernameAvailable(document.getElementById("username").value) || document.getElementById("username").value == "") {
		document.getElementById("usernameError").innerHTML="Please enter valid username";
		valid = false;
	}
	if (document.getElementById("name").value == "" && document.getElementById("employerRadio").checked) {
		document.getElementById("nameError").innerHTML="Please enter a company name";
		valid = false;
	}
	if (document.getElementById("fullname").value == "" && document.getElementById("jobSeekerRadio").checked) {
		document.getElementById("fullnameError").innerHTML="Please enter your name";
		valid = false;
	}
	return valid;
}

function ValidateApplication() {
	valid = true;
	var intRegex = /^\d+$/;
	if(!intRegex.test(parseInt(document.getElementById("rating").value))) {
		document.getElementById("numberError").innerHTML="Please enter a whole number between 1 and 100";
		valid = false;
	}
	return valid;
}

function ValidateAddLocation() {
	valid = true;
	var intRegex = /^\d+$/;
	if (document.getElementById("street1").value.length > 0 || document.getElementById("street2").value.length > 0 || document.getElementById("town").value.length > 0 || document.getElementById("county").value.length > 0 || document.getElementById("country").value.length > 0 ) {

	} else {
		document.getElementById("addressError").innerHTML="Please enter at least one address field";
		valid = false;
	}
	return valid;
}

function ValidateJobPosting() {
	valid = true;
	var intRegex = /^\d+$/;
	if(!intRegex.test(parseInt(document.getElementById("salary").value))) {
		document.getElementById("salaryError").innerHTML="Please enter a whole number between 1 and 99999999 without commas or full stops.";
		valid = false;
	}
	if (document.getElementById("jobDescription").value == "") {
		document.getElementById("descriptionError").innerHTML="Please enter a job description";
		valid = false;
	}
	if (document.getElementById("name").value == "") {
		document.getElementById("nameError").innerHTML="Please enter a job name";
		valid = false;
	}
	if (document.getElementById("length").value == "") {
		document.getElementById("lengthError").innerHTML="Please enter length of Contract";
		valid = false;
	}
	return valid;
}

function ValidateApplyForm() {
	valid = true;
	if (document.getElementById("coverNote").value == "") {
		document.getElementById("noteError").innerHTML="Please enter a cover note";
		valid = false;
	}
	return valid;
}

