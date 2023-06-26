// Create Ajax request 

// Get Method 
function send_request_get(data1){
    const xhttp = new XMLHttpRequest;
    xhttp.onload = function(){
        // Proceed what you want to do here
        return 0;
    } 
    // You pass query parameter to backend server to proceed 
    xhttp.open("GET", "sample.php?trainId="+ data1);
    xhtpp.send();

}

// Post Method 
function send_request_post(data1,data2) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      document.getElementById("demo").innerHTML = this.responseText;
    }
    xhttp.open("POST", "demo_post2.asp");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("fname="+data1+"&lname="+data2);
  }