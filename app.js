window.onload = function() {
    var bodyDiv = document.getElementById("body");
    var homeBtn = document.getElementById("home");
    var addUser = document.getElementById("addUser");
    var addIssue = document.getElementById("addIssue");
    var logout = document.getElementById("logout");
    var loginButton = document.getElementById("loginButton");
    var passwordField = document.getElementById("passwordField");
    var usernameField = document.getElementById("usernameField");
    var modal = document.getElementById("myModal");
    var httpRequest = new XMLHttpRequest();
    var url = "/index.php";
    var homeDiv = document.getElementById("homeDiv");
    var addUserDiv = document.getElementById("addUserDiv");
    var addIssueDiv = document.getElementById("addIssueDiv");
    var addUserFirstName = document.getElementById("addUserFirstName");
    var addUserLastName = document.getElementById("addUserLastName");
    var addUserEmail = document.getElementById("addUserEmail");
    var addUserPassword = document.getElementById("addUserPassword");
    var addUserSubmit = document.getElementById("addUserSubmit");
    var addIssueTitle = document.getElementById("addIssueTitle");
    var addIssueDescription = document.getElementById("addIssueDescription");
    var addIssueAssignedTo = document.getElementById("addIssueAssignedTo");
    var addIssueType = document.getElementById("addIssueType");
    var addIssuePriority = document.getElementById("addIssuePriority");
    var addIssueSubmit = document.getElementById("addIssueSubmit");
    var createIssueBtn = document.getElementById("createIssueBtn");
    var allBtn = document.getElementById("allBtn");
    var openBtn = document.getElementById("openBtn");
    var issueTable = document.getElementById("issueTable");
    var myTicketBtn = document.getElementById("myTicketBtn");
    var emailID = document.getElementById("emailID");
    modal.style.display = "block";
    homeDiv.style.display = "block";
    addUserDiv.style.display = "none";
    addIssueDiv.style.display = "none";
    allBtn.style.backgroundColor = "blue";
    allBtn.style.color = "white";
    openBtn.style.backgroundColor = "transparent";
    openBtn.style.color = "black";
    myTicketBtn.style.backgroundColor = "transparent";
    myTicketBtn.style.color = "black";

    httpRequest.onreadystatechange = function() {
        if (httpRequest.readyState === 4 && httpRequest.status === 200) {
            var response = httpRequest.responseText;
            issueTable.innerHTML = response;
        }
    };
    httpRequest.open('GET', url + "?display_issues", true);
    console.log(httpRequest);
    httpRequest.send();

    addUserSubmit.addEventListener("click", function() {
        if (httpRequest.readyState === 4 && httpRequest.status === 200) {
            var response = httpRequest.responseText;

        }
        httpRequest.open('GET', url + "?Firstname=" + addUserFirstName.value +
            "&Lastname=" + addUserLastName.value +
            "&Email=" + addUserEmail.value +
            "&Password=" + addUserPassword.value, true);
        httpRequest.send();
        addUserFirstName.value = "";
        addUserLastName.value = "";
        addUserEmail.value = "";
        addUserPassword.value = "";
    });

    addIssueSubmit.addEventListener("click", function() {
        if (httpRequest.readyState === 4 && httpRequest.status === 200) {
            var response = httpRequest.responseText;
        }
        httpRequest.open('GET', url + "?title=" + addIssueTitle.value +
            "&description=" + addIssueDescription.value +
            "&assignedto=" + addIssueAssignedTo.value +
            "&type=" + addIssueType.value +
            "&priority=" + addIssuePriority.value, true);
        httpRequest.send();
        addIssueTitle.value = "";
        addIssueDescription.value = "";
        addIssueAssignedTo.value = "";
        addIssueType.value = "";
        addIssuePriority.value = "";
    });

    loginButton.addEventListener("click", function() {
        httpRequest.onreadystatechange = function() {
            if (httpRequest.readyState === 4 && httpRequest.status === 200) {
                var response = httpRequest.responseText;
                if (response == "true") {
                    modal.style.display = "none";
                    httpRequest.onreadystatechange = function() {
                        if (httpRequest.readyState === 4 && httpRequest.status === 200) {
                            var response = httpRequest.responseText;
                            emailID.innerHTML = response;
                        }
                    };
                    httpRequest.open('GET', url + "?session_id", true);
                    console.log(httpRequest);
                    httpRequest.send();
                }
            }
        };

        httpRequest.open('GET', url + "?email=" + usernameField.value + "&password=" + passwordField.value, true);
        httpRequest.send();

    });

    addUser.addEventListener("click", function() {
        homeDiv.style.display = "none";
        addUserDiv.style.display = "block";
        addIssueDiv.style.display = "none";

    });

    homeBtn.addEventListener("click", function() {

        homeDiv.style.display = "block";
        addUserDiv.style.display = "none";
        addIssueDiv.style.display = "none";

    });

    createIssueBtn.addEventListener("click", function() {

        homeDiv.style.display = "none";
        addUserDiv.style.display = "none";
        addIssueDiv.style.display = "block";

    });

    addIssue.addEventListener("click", function() {

        homeDiv.style.display = "none";
        addUserDiv.style.display = "none";
        addIssueDiv.style.display = "block";
        httpRequest.onreadystatechange = function() {
            if (httpRequest.readyState === 4 && httpRequest.status === 200) {
                var response = httpRequest.responseText;
                addIssueAssignedTo.innerHTML=response;

            }
        };
        httpRequest.open('GET', url + "?userlist", true);
        console.log(httpRequest);
        httpRequest.send();


    });

    allBtn.addEventListener("click", function() {
        allBtn.style.backgroundColor = "blue";
        allBtn.style.color = "white";
        openBtn.style.backgroundColor = "transparent";
        openBtn.style.color = "black";
        myTicketBtn.style.backgroundColor = "transparent";
        myTicketBtn.style.color = "black";
        httpRequest.onreadystatechange = function() {
            if (httpRequest.readyState === 4 && httpRequest.status === 200) {
                var response = httpRequest.responseText;
                issueTable.innerHTML = response;
            }
        };
        httpRequest.open('GET', url + "?display_issues", true);
        console.log(httpRequest);
        httpRequest.send();


    });

    openBtn.addEventListener("click", function() {
        allBtn.style.backgroundColor = "transparent";
        allBtn.style.color = "black";
        openBtn.style.backgroundColor = "blue";
        openBtn.style.color = "white";
        myTicketBtn.style.backgroundColor = "transparent";
        myTicketBtn.style.color = "black";

        httpRequest.onreadystatechange = function() {
            if (httpRequest.readyState === 4 && httpRequest.status === 200) {
                var response = httpRequest.responseText;
                issueTable.innerHTML = response;
            }
        };
        httpRequest.open('GET', url + "?display_issues_open", true);
        console.log(httpRequest);
        httpRequest.send();


    });

    myTicketBtn.addEventListener("click", function() {
        httpRequest.onreadystatechange = function() {
            allBtn.style.backgroundColor = "transparent";
            allBtn.style.color = "black";
            openBtn.style.backgroundColor = "transparent";
            openBtn.style.color = "black";
            myTicketBtn.style.backgroundColor = "blue";
            myTicketBtn.style.color = "white";
            if (httpRequest.readyState === 4 && httpRequest.status === 200) {
                var response = httpRequest.responseText;
                issueTable.innerHTML = response;
            }
        };
        httpRequest.open('GET', url + "?display_issues_tickets", true);
        console.log(httpRequest);
        httpRequest.send();


    });

    logout.addEventListener("click", function() {
        httpRequest.onreadystatechange = function() {
            if (httpRequest.readyState === 4 && httpRequest.status === 200) {
                var response = httpRequest.responseText;
            }
        };
        httpRequest.open('GET', url + "?logout", true);
        console.log(httpRequest);
        httpRequest.send();
        modal.style.display = "block";
    });

}