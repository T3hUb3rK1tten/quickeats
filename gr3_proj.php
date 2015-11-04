<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" >
    <title>QuickEats</title>

    <!--[if IE]>
    <script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!--[if lt IE 9]>
    <script src="https://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
    <![endif]-->

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="https://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="https://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#submit").click(function() {
                if ($("input[name=email]").val() == "" || $("input[name=password]").val() == "")
                {
                    $("#signinerror").show();
                }
                else
                {
                    $.mobile.changePage("#featurelist");
                }
            });
        });
    </script>
</head>

<body>
<div data-role="page" id="signin">
    <div data-role="header">
        <h1>QuickEats</h1>
    </div>
    <div data-role="content">
        <div id="signinerror" style="display:none">
            <p>
                The sign-in has failed.
            </p>
            <p>
                Please sign in again or sign up for a new account before you can use the app.
            </p>
        </div>
        <div style="text-align: center;">
            <h1>SIGN IN</h1>
        </div>
        <form>
            <label for="email">Email:</label>
            <input type="text" name="email">
            <label for="password">Password:</label>
            <input type="password" name="password">
            <button id="submit" type="button">Submit</button>
        </form>
        <span>
            Without an account, please <a href="#signup">sign up</a>.
        </span>
    </div>
    <div data-role="footer" data-position="fixed" data-id="nav">
        <div data-role="navbar">
            <ul>
                <li><a href="gr3_index.php#home">Home</a></li>
                <li><a href="gr3_index.php#team">Team</a></li>
                <li><a href="#project" class="ui-btn-active ui-state-persist">Project</a></li>
            </ul>
        </div>
    </div>
</div>
<div data-role="page" id="featurelist">
    <div data-role="header">
        <h1>QuickEats</h1>
        <a href="#signin" class="ui-btn-right" data-icon="gear">Sign Out</a>
    </div>
    <div data-role="content">
        <h1>Feature List</h1>
        <ul data-role="listview" data-inset="true">
            <li><a href="#manageuser">Manage user accounts</a></li>
            <li><a href="#feature1">Application feature #1</a></li>
            <li><a href="#feature1">Application feature #2</a></li>
            <li><a href="#">Application feature #3</a></li>

        </ul>
    </div>
    <div data-role="footer" data-position="fixed" data-id="nav">
        <div data-role="navbar">
            <ul>
                <li><a href="gr3_index.php#home">Home</a></li>
                <li><a href="#featurelist" class="ui-btn-active ui-state-persist">Feature List</a></li>
                <li><a href="#signin">Sign In</a></li>
            </ul>
        </div>
    </div>
</div>
<div data-role="page" id="manageuser">
    <div data-role="header">
        <h1>QuickEats</h1>
        <a href="#signin" class="ui-btn-right" data-icon="gear">Sign Out</a>
    </div>
    <div data-role="content">
        <h1>Manage User Accounts</h1>
        <ul data-role="listview" data-inset="true">
            <li><a href="#">Change password</a></li>
            <li><a href="#">Delete account</a></li>
        </ul>
    </div>
    <div data-role="footer" data-position="fixed" data-id="nav">
        <div data-role="navbar">
            <ul>
                <li><a href="gr3_index.php#home">Home</a></li>
                <li><a href="#featurelist" class="ui-btn-active ui-state-persist">Feature List</a></li>
                <li><a href="#signin">Sign In</a></li>
            </ul>
        </div>
    </div>
</div>
<div data-role="page" id="feature1">
    <div data-role="header">
        <h1>The Project</h1>
        <a href="#signin" class="ui-btn-right" data-icon="gear">Sign Out</a>
    </div>
    <div data-role="content">
        <div style="text-align: center;">
            <h2>Application Feature Name</h2>
        </div>
        <p style="text-align: center;">Content of the mobile web page should be here ...</p>
    </div>
    <div data-role="footer" data-position="fixed" data-id="nav">
        <div data-role="navbar">
            <ul>
                <li><a href="gr3_index.php#home">Home</a></li>
                <li><a href="#featurelist" class="ui-btn-active ui-state-persist">Feature List</a></li>
                <li><a href="#signin">Sign In</a></li>
            </ul>
        </div>
    </div>
</div>
</body>
</html














