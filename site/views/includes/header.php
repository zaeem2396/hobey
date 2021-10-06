<?php

$front_base_url = $this->config->item('front_base_url');

$base_url         = $this->config->item('base_url');

$index_url         = $this->config->item('index_url');

$findex_url         = $this->config->item('findex_url');

$base_url_views = $this->config->item('base_url_views');

$http_host = $this->config->item('http_host');

?>

<!doctype html>

<style>
    .common {

        width: 100%;

        max-width: 200px;

        padding-top: 10px;

    }

    .overlay_search .closebtn {

        position: absolute;

        top: 5px;

        right: 10px;

        font-size: 40px;

        cursor: pointer;

        color: #c26573;

    }

    .overlay_search input[type=text] {

        padding: 0 10px;

        font-size: 15px;

        border: none;

        width: 100%;

        background: #cedde0;

        height: 41px;

    }

    .overlay-content {

        width: 1170px;

        margin: 0 auto;

        position: relative;

    }

    .overlay_search {

        width: 100%;

        position: absolute;

        display: none;

        z-index: 99999999999999;

        top: 80px;

        left: 0;

        background-color: #cedde0;

    }

    .successmain {

        background-color: #008000;

        border-color: #008000;

    }

    .valierror {

        background-color: #ee2e34;

        border-color: #ee2e34;

        color: #fff;

    }

    .topalert {
        z-index: 9999;
        text-align: center;
        padding: 10px;
        font-size: 18px;
        color: #fff;
        position: fixed;
        top: 0px;
    }

    .alert-message {

        background-size: 40px 40px;

        background-image: linear-gradient(135deg, rgba(255, 255, 255, .05) 25%, transparent 25%,

                transparent 50%, rgba(255, 255, 255, .05) 50%, rgba(255, 255, 255, .05) 75%,

                transparent 75%, transparent);

        /*  box-shadow: inset 0 -1px 0 rgba(255,255,255,.4);*/

        width: 100%;

        border: 0px solid;

        color: #fff;

        padding: 10px;

        /*position: fixed;*/

        /* _position: absolute;

         text-shadow: 0 1px 0 rgba(0,0,0,.5);*/

        animation: animate-bg 5s linear infinite;

        display: block;

        margin-bottom: 10px;

        z-index: 999999999999;

    }

    .top-nav-collapse {

        height: 0;

    }
</style>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Bharat Petroleum |Oil & Gas Companies in India |Top Petroleum Companies | Petroleum Distribution companies</title>

    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?php echo $base_url_views; ?>assets/css/login.css">

    <link rel="stylesheet" href="<?php echo $base_url_views; ?>assets/css/style.css">


    <style>
        .collapse:not(.show) {

            display: block;

        }
    </style>

</head>

<body>
    <h4 style="text-align:right;padding-right:30px;padding-top:30px;"> <span><a href="<?php echo $base_url; ?>distributor-cart" style="color:#000;" title="View Cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></span> </h4>