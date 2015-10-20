<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ADMIN
 * Date: 08/16/2014
 * Time: 11:45 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" >

    <title> Hello World Javascript </title>

    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!--[if lt IE 9]>
    <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
    <![endif]-->


    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />

    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

    <script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>

</head>

<body>

<div data-role="page" id="home">
    <div data-role="header">
        <h1>Semester Project</h1>
    </div>
    <div data-role="content">
        <div style="text-align: center;">
            <h2>ITSS4312: Group 3</h2>
            <h3>Fall 2015</h3>
        </div>
        <p style="text-align: center;">QuickEats Mobile</p>
        <p style="text-align: center;">Description</p>
    </div>
    <div data-role="footer" data-position="fixed" data-id="nav">
        <div data-role="navbar">
            <ul>
                <li><a href="#home" class="ui-btn-active ui-state-persist">Home</a></li>
                <li><a href="#team">Team</a></li>
                <li><a href="#project">Project</a></li>
            </ul>
        </div>
    </div>
</div>
<div data-role="page" id="team">
    <div data-role="header">
        <h1>The Team</h1>
    </div>
    <div data-role="content">
        <ul data-role="listview">
            <li>
                <a href="#leader">Team Leader</a>
            </li>
            <li>
                <a href="#members">Team Members</a>
            </li>
        </ul>
    </div>
    <div data-role="footer" data-position="fixed" data-id="nav">
        <div data-role="navbar">
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#team" class="ui-btn-active ui-state-persist">Team</a></li>
                <li><a href="#project">Project</a></li>
            </ul>
        </div>
    </div>
</div>
<div data-role="page" id="team">
    <div data-role="header">
        <h1>The Team</h1>
    </div>
    <div data-role="content">
        <ul data-role="listview">
            <li>
                <a href="#leader">Team Leader</a>
            </li>
            <li>
                <a href="#members">Team Members</a>
            </li>
        </ul>
    </div>
    <div data-role="footer" data-position="fixed" data-id="nav">
        <div data-role="navbar">
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#team" class="ui-btn-active ui-state-persist">Team</a></li>
                <li><a href="#project">Project</a></li>
            </ul>
        </div>
    </div>
</div>
<div data-role="page" id="leader">
    <div data-role="header">
        <h1>Team Leader</h1>
    </div>
    <div data-role="content">
        <ul data-role="listview">
            <li>
                <h3>Suraiya Rahmetulla</h3>
            </li>
        </ul>
    </div>
    <div data-role="footer" data-position="fixed" data-id="nav">
        <div data-role="navbar">
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#team">Team</a></li>
                <li><a href="#project">Project</a></li>
            </ul>
        </div>
    </div>
</div>
<div data-role="page" id="project">
    <div data-role="header">
        <h1>The Project</h1>
    </div>
    <div data-role="content">
        <div style="text-align: center;">
            <h2>QuickEats</h2>
        </div>
        <p style="text-align: center;">Description</p>
    </div>
    <div data-role="footer" data-position="fixed" data-id="nav">
        <div data-role="navbar">
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#team">Team</a></li>
                <li><a href="#project" class="ui-btn-active ui-state-persist">Project</a></li>
            </ul>
        </div>
    </div>
</div>
</body>
</html














