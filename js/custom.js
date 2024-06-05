function getXMLHTTP() { //fuction to return the xml http object
  var xmlhttp = false;
  try {
    xmlhttp = new XMLHttpRequest();
  }
  catch (e) {
    try {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch (e) {
      try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
      }
      catch (e1) {
        xmlhttp = false;
      }
    }
  }
  return xmlhttp;
}

function getState(countryId) {
  var strURL = "findState.php?country=" + countryId;
  var req = getXMLHTTP();
  if (req) {
    req.onreadystatechange = function () {
      if (req.readyState == 4) {
        if (req.status == 200) {
          document.getElementById('statediv').innerHTML = req.responseText;
        }
        else {
          alert("There was a problem while using XMLHTTP: " + req.statusText);
        }
      }
    }
    req.open("GET", strURL, true);
    req.send(null);
  }
}

function getcity(stateid) {
  var strURL = "findcity.php?stateid=" + stateid;
  var req = getXMLHTTP();
  if (req) {
    req.onreadystatechange = function () {
      if (req.readyState == 4) {
        if (req.status == 200) {
          document.getElementById('citydiv').innerHTML = req.responseText;
        }
        else {
          alert("There was a problem while using XMLHTTP: " + req.statusText);
        }
      }
    }
    req.open("GET", strURL, true);
    req.send(null);
  }
}

function chkvalidate() {

  var fresult = 'N';

  if ($('input[name^=stcourselevel]:checked').length <= 0) {
    alert("There was a problem while using XMLHTTP: " + req.statusText);
    fresult = 'N';
    return false;
  } else {
    fresult = 'Y';
  }

  if ($('input[name^=intakesmajor]:checked').length <= 0) {
    alert("There was a problem while using XMLHTTP: " + req.statusText);
    fresult = 'N';
    return false;
  } else {
    fresult = 'Y';
  }

  if ($('input[name^=intakesminor]:checked').length <= 0) {
    alert("There was a problem while using XMLHTTP: " + req.statusText);
    fresult = 'N';
    return false;
  } else {
    fresult = 'Y';
  }
  if (fresult == 'Y') {
    return true;
  }
}

//registration - step 2
function chkboxlengthchk(chkbox, selcnt) {
  var le = document.querySelectorAll('input[name="' + chkbox + '"]:checked').length;
  if (le > selcnt) {
    alert("There was a problem while using XMLHTTP: " + req.statusText);
    return false;
  }
}

//my academic lower education auto selection base on high level education
function checklowereducation(md) {
  //alert(document.getElementById('chkquali'+md).checked);
  if (md == 5 && document.getElementById('chkquali' + md).checked == true) {
    document.getElementById('chkquali1').checked = true;
    document.getElementById('chkquali3').checked = true;
    document.getElementById('chkquali4').checked = true;
  } else if (md == 4 && document.getElementById('chkquali' + md).checked == true) {
    document.getElementById('chkquali1').checked = true;
    document.getElementById('chkquali3').checked = true;

  } else if (md == 3 && document.getElementById('chkquali' + md).checked == true) {
    document.getElementById('chkquali1').checked = true;
  }
}

//collapsible timeline

document.addEventListener('DOMContentLoaded', function () {
  if (window.innerWidth < 768) { // Check if the viewport width is less than 768px
    var coll = document.getElementsByClassName("collapsible");
    for (var i = 0; i < coll.length; i++) {
      coll[i].addEventListener("click", function () {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.display === "block") {
          content.style.display = "none";
        } else {
          content.style.display = "block";
        }
      });
    }
  }
});