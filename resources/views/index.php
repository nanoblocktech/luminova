<?php 
use Luminova\Config\Configuration;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to PHP Luminova</title>
    <meta name="description" content="Simple framework built for speed and keeping your existing coding skills going.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
    <style>
        * {
            transition: background-color 300ms ease, color 300ms ease;
        }
        *:focus {
            background-color: rgba(221, 72, 20, .2);
            outline: none;
        }
        html, body {
            color: rgba(33, 37, 41, 1);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
            font-size: 16px;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }
        header {
            background-color: rgba(247, 248, 249, 1);
            padding: .4rem 0 0;
        }
        .menu {
            padding: .4rem 2rem;
        }
        header ul {
            border-bottom: 1px solid rgba(242, 242, 242, 1);
            list-style-type: none;
            margin: 0;
            overflow: hidden;
            padding: 0;
            text-align: right;
        }
        header li {
            display: inline-block;
        }
        header li a {
            border-radius: 5px;
            color: rgba(0, 0, 0, .5);
            display: block;
            height: 44px;
            text-decoration: none;
        }
        header li.menu-item a {
            border-radius: 5px;
            margin: 5px 0;
            height: 38px;
            line-height: 36px;
            padding: .4rem .65rem;
            text-align: center;
        }
        header li.menu-item a:hover,
        header li.menu-item a:focus {
            background-color: rgba(3, 18, 57, .2);
            color: rgba(6, 60, 169, 1);
        }
        header .logo {
            float: left;
            height: 44px;
            padding: .4rem .5rem;
        }
        header .menu-toggle {
            display: none;
            float: right;
            font-size: 2rem;
            font-weight: bold;
        }
        header .menu-toggle button {
            background-color: #031239;
            border: none;
            border-radius: 3px;
            color: rgba(255, 255, 255, 1);
            cursor: pointer;
            font: inherit;
            font-size: 1.3rem;
            height: 36px;
            padding: 0;
            margin: 11px 0;
            overflow: visible;
            width: 40px;
        }
        header .menu-toggle button:hover,
        header .menu-toggle button:focus {
            background-color: #063ca9;
            color: rgba(255, 255, 255, .8);
        }
        header .info {
            margin: 0 auto;
            max-width: 1100px;
            padding: 1rem 1.75rem 1.75rem 1.75rem;
        }
        header .info h1 {
            font-size: 2.5rem;
            font-weight: 500;
        }
        header .info h2 {
            font-size: 1.5rem;
            font-weight: 300;
        }
        section {
            margin: 0 auto;
            max-width: 1100px;
            padding: 2.5rem 1.75rem 3.5rem 1.75rem;
        }
        section h1 {
            margin-bottom: 2.5rem;
        }
        section h2 {
            font-size: 120%;
            line-height: 2.5rem;
            padding-top: 1.5rem;
        }
        section pre {
            background-color: rgba(247, 248, 249, 1);
            border: 1px solid rgba(242, 242, 242, 1);
            display: block;
            font-size: .9rem;
            margin: 2rem 0;
            padding: 1rem 1.5rem;
            white-space: pre-wrap;
            word-break: break-all;
        }
        section code {
            display: block;
        }
        section a {
            color: rgba(221, 72, 20, 1);
        }
        section svg {
            margin-bottom: -5px;
            margin-right: 5px;
            width: 25px;
        }
  
        footer {
            text-align: center;
        }

        footer .copyrights {
            background-color: #031239;
            color: rgba(200, 200, 200, 1);
            padding: .25rem 1.75rem;
        }
        footer .copyrights a {
          color: #e3e8fb;
        }
        @media (max-width: 629px) {
          header li a {
            color: #fff;
          }
          .menu {
            padding: .4rem 0;
          }
            header ul {
                padding: 0;
            }
            header .menu-toggle {
                padding: 0 1rem;
            }
            header .menu-item {
                background-color: rgba(3, 18, 57, 1);
                border-top: 1px solid rgba(242, 242, 242, 1);
                margin: 0 15px;
                width: calc(100% - 30px);
            }
            header .menu-toggle {
                display: block;
            }
            header .hidden {
                display: none;
            }
            header li.menu-item a {
                background-color: rgba(221, 72, 20, .1);
            }
            header li.menu-item a:hover,
            header li.menu-item a:focus {
                background-color: rgba(6, 60, 169, .7);
                color: rgba(255, 255, 255, .8);
            }
        }
    </style>
</head>
<body>
<header>

    <div class="menu">
        <ul>
            <li class="logo">
                <a href="https://nanoblocktech.com/luminova" target="_blank">
                   <svg role="img" aria-label="PHP Luminova"  height="44" viewBox="0 0 660 120" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M69.2062 109.125H50.7937C49.8986 109.125 49.0402 109.481 48.4073 110.114C47.7743 110.746 47.4188 111.605 47.4188 112.5C47.4188 113.395 47.7743 114.254 48.4073 114.886C49.0402 115.519 49.8986 115.875 50.7937 115.875H69.2062C70.1014 115.875 70.9598 115.519 71.5927 114.886C72.2257 114.254 72.5812 113.395 72.5812 112.5C72.5812 111.605 72.2257 110.746 71.5927 110.114C70.9598 109.481 70.1014 109.125 69.2062 109.125ZM60 17.4825C60.8951 17.4825 61.7536 17.1269 62.3865 16.494C63.0194 15.8611 63.375 15.0026 63.375 14.1075V7.5C63.375 6.60489 63.0194 5.74645 62.3865 5.11351C61.7536 4.48058 60.8951 4.125 60 4.125C59.1049 4.125 58.2464 4.48058 57.6135 5.11351C56.9806 5.74645 56.625 6.60489 56.625 7.5V14.1075C56.625 15.0026 56.9806 15.8611 57.6135 16.494C58.2464 17.1269 59.1049 17.4825 60 17.4825ZM108.056 48.4088H101.449C100.554 48.4088 99.6952 48.7643 99.0623 49.3973C98.4293 50.0302 98.0737 50.8886 98.0737 51.7837C98.0737 52.6789 98.4293 53.5373 99.0623 54.1702C99.6952 54.8032 100.554 55.1587 101.449 55.1587H108.056C108.951 55.1587 109.81 54.8032 110.443 54.1702C111.076 53.5373 111.431 52.6789 111.431 51.7837C111.431 50.8886 111.076 50.0302 110.443 49.3973C109.81 48.7643 108.951 48.4088 108.056 48.4088ZM18.5475 48.4088H11.9437C11.0486 48.4088 10.1902 48.7643 9.55726 49.3973C8.92433 50.0302 8.56875 50.8886 8.56875 51.7837C8.56875 52.6789 8.92433 53.5373 9.55726 54.1702C10.1902 54.8032 11.0486 55.1587 11.9437 55.1587H18.5512C19.4464 55.1582 20.3046 54.8022 20.9372 54.1689C21.5698 53.5356 21.9249 52.677 21.9244 51.7819C21.9239 50.8868 21.5678 50.0285 20.9345 49.3959C20.3012 48.7634 19.4426 48.4083 18.5475 48.4088ZM30.9712 27.5288C31.284 27.8442 31.6561 28.0945 32.0661 28.2654C32.4761 28.4363 32.9158 28.5242 33.36 28.5242C33.8042 28.5242 34.2439 28.4363 34.6539 28.2654C35.0639 28.0945 35.436 27.8442 35.7487 27.5288C36.0626 27.2159 36.3116 26.8442 36.4815 26.4349C36.6514 26.0257 36.7389 25.5869 36.7389 25.1438C36.7389 24.7006 36.6514 24.2618 36.4815 23.8526C36.3116 23.4433 36.0626 23.0716 35.7487 22.7587L31.0725 18.0825C30.7618 17.7579 30.3894 17.4987 29.9772 17.3199C29.565 17.1412 29.1213 17.0466 28.672 17.0416C28.2227 17.0366 27.777 17.1213 27.3609 17.2909C26.9448 17.4604 26.5668 17.7114 26.249 18.0289C25.9311 18.3465 25.6799 18.7243 25.5101 19.1403C25.3402 19.5562 25.2551 20.0019 25.2597 20.4512C25.2643 20.9005 25.3586 21.3443 25.5371 21.7566C25.7155 22.169 25.9744 22.5416 26.2987 22.8525L30.9712 27.5288ZM88.9275 18.0825L84.255 22.755C83.7797 23.2258 83.4554 23.8275 83.3234 24.4834C83.1915 25.1393 83.2579 25.8196 83.5141 26.4376C83.7704 27.0556 84.205 27.5832 84.7624 27.9532C85.3198 28.3232 85.9747 28.5188 86.6437 28.515C87.0875 28.5157 87.5271 28.4286 87.9371 28.2587C88.347 28.0888 88.7193 27.8394 89.0325 27.525L93.705 22.8525C95.025 21.5362 95.025 19.3988 93.705 18.0825C92.385 16.7663 90.2438 16.7663 88.9275 18.0825ZM60 27.9075C43.0312 27.8813 29.2275 41.6812 29.2275 58.68C29.2275 66.8625 32.4375 74.3063 37.6875 79.8C41.1712 83.4488 43.335 88.155 43.335 93.1988V96.075C43.335 97.0696 43.7301 98.0234 44.4333 98.7266C45.1366 99.4299 46.0904 99.825 47.085 99.825H72.915C73.9096 99.825 74.8634 99.4299 75.5666 98.7266C76.2699 98.0234 76.665 97.0696 76.665 96.075V93.1988C76.665 88.155 78.825 83.4488 82.3125 79.8C87.7527 74.1158 90.7841 66.548 90.7725 58.68C90.7725 41.6812 76.9687 27.8775 60 27.9075ZM56.9812 46.6425C54.7999 47.2007 52.8099 48.338 51.2217 49.9341C49.6335 51.5303 48.5061 53.5259 47.9587 55.71C47.7448 56.5788 47.1953 57.3274 46.4307 57.792C45.666 58.2565 44.7484 58.3992 43.8787 58.1887C43.0096 57.9758 42.2606 57.4263 41.7965 56.6612C41.3324 55.8961 41.1911 54.978 41.4038 54.1087C42.2253 50.7208 43.9597 47.6229 46.4185 45.1515C48.8772 42.6802 51.9663 40.93 55.35 40.0912C56.2035 39.9172 57.0911 40.0795 57.8278 40.5443C58.5645 41.009 59.0932 41.7403 59.3037 42.5855C59.5141 43.4307 59.3901 44.3245 58.9573 45.0805C58.5246 45.8364 57.8167 46.396 56.9812 46.6425Z" fill="#063CA9"/><path d="M55.6219 79.95C54.6052 79.9333 53.7219 79.7833 52.9719 79.5C52.2385 79.2167 51.6719 78.775 51.2719 78.175C50.8719 77.5917 50.6719 76.8583 50.6719 75.975V72.3C50.6719 71.7333 50.5552 71.2833 50.3219 70.95C50.0885 70.6 49.7469 70.35 49.2969 70.2C48.8469 70.0333 48.2885 69.95 47.6219 69.95V68.125C48.2885 68.1083 48.8469 68.025 49.2969 67.875C49.7469 67.725 50.0885 67.4833 50.3219 67.15C50.5552 66.8 50.6719 66.35 50.6719 65.8V62.1C50.6719 61.4333 50.7885 60.8583 51.0219 60.375C51.2719 59.875 51.6135 59.4667 52.0469 59.15C52.4969 58.8167 53.0219 58.5667 53.6219 58.4C54.2219 58.2333 54.8885 58.15 55.6219 58.15V59.95C55.0552 59.9667 54.5635 60.0583 54.1469 60.225C53.7302 60.3917 53.4052 60.6417 53.1719 60.975C52.9552 61.3083 52.8469 61.75 52.8469 62.3V65.9C52.8469 66.75 52.6219 67.4333 52.1719 67.95C51.7219 68.45 51.0385 68.7833 50.1219 68.95V69.1C51.0552 69.2667 51.7385 69.6083 52.1719 70.125C52.6219 70.625 52.8469 71.3 52.8469 72.15V75.825C52.8469 76.3583 52.9552 76.7917 53.1719 77.125C53.3885 77.475 53.7052 77.725 54.1219 77.875C54.5385 78.0417 55.0385 78.1333 55.6219 78.15V79.95ZM59.2266 76.5371H57.249L64.7441 56.4932H66.7217L59.2266 76.5371ZM68.3029 78.15C68.8863 78.1333 69.3779 78.0417 69.7779 77.875C70.1946 77.7083 70.5113 77.45 70.7279 77.1C70.9613 76.7667 71.0779 76.3333 71.0779 75.8V72.175C71.0779 71.325 71.3029 70.65 71.7529 70.15C72.2029 69.6333 72.8863 69.2917 73.8029 69.125V68.975C72.8863 68.8083 72.2029 68.475 71.7529 67.975C71.3029 67.4583 71.0779 66.775 71.0779 65.925V62.275C71.0779 61.725 70.9696 61.2833 70.7529 60.95C70.5363 60.6167 70.2196 60.3667 69.8029 60.2C69.4029 60.0333 68.9029 59.95 68.3029 59.95V58.15C69.0696 58.15 69.7529 58.2333 70.3529 58.4C70.9696 58.5667 71.4946 58.8167 71.9279 59.15C72.3613 59.4667 72.6863 59.875 72.9029 60.375C73.1363 60.875 73.2529 61.4583 73.2529 62.125V65.775C73.2529 66.3417 73.3696 66.8 73.6029 67.15C73.8363 67.4833 74.1779 67.7333 74.6279 67.9C75.0946 68.05 75.6529 68.125 76.3029 68.125V69.95C75.6529 69.95 75.0946 70.0333 74.6279 70.2C74.1779 70.35 73.8363 70.5917 73.6029 70.925C73.3696 71.2583 73.2529 71.7083 73.2529 72.275V76C73.2529 76.8833 73.0446 77.6167 72.6279 78.2C72.2113 78.7833 71.6279 79.2167 70.8779 79.5C70.1446 79.8 69.2863 79.95 68.3029 79.95V78.15Z" fill="white"/><g filter="url(#filter0_d_1_6)"><path d="M149.212 106.5H145.11V81.3096H152.356C153.427 81.3096 154.487 81.4805 155.535 81.8223C156.583 82.1641 157.518 82.6768 158.338 83.3604C159.181 84.0439 159.853 84.8757 160.354 85.8555C160.879 86.8125 161.141 87.8949 161.141 89.1025C161.141 90.3786 160.924 91.5407 160.491 92.5889C160.058 93.6143 159.454 94.4801 158.68 95.1865C157.905 95.8929 156.971 96.4398 155.877 96.8271C154.783 97.2145 153.576 97.4082 152.254 97.4082H149.212V106.5ZM149.212 84.4199V94.4004H152.972C153.473 94.4004 153.963 94.3206 154.441 94.1611C154.943 93.9788 155.398 93.694 155.809 93.3066C156.219 92.9193 156.549 92.3838 156.8 91.7002C157.05 90.9938 157.176 90.1279 157.176 89.1025C157.176 88.6924 157.119 88.2253 157.005 87.7012C156.891 87.1543 156.652 86.6416 156.287 86.1631C155.945 85.6618 155.455 85.2516 154.817 84.9326C154.179 84.5908 153.336 84.4199 152.288 84.4199H149.212ZM185.066 81.3096V106.5H180.965V95.1523H170.062V106.5H165.892V81.3096H170.062V92.3496H180.965V81.3096H185.066ZM195.491 106.5H191.39V81.3096H198.636C199.707 81.3096 200.766 81.4805 201.814 81.8223C202.863 82.1641 203.797 82.6768 204.617 83.3604C205.46 84.0439 206.132 84.8757 206.634 85.8555C207.158 86.8125 207.42 87.8949 207.42 89.1025C207.42 90.3786 207.203 91.5407 206.771 92.5889C206.338 93.6143 205.734 94.4801 204.959 95.1865C204.184 95.8929 203.25 96.4398 202.156 96.8271C201.062 97.2145 199.855 97.4082 198.533 97.4082H195.491V106.5ZM195.491 84.4199V94.4004H199.251C199.752 94.4004 200.242 94.3206 200.721 94.1611C201.222 93.9788 201.678 93.694 202.088 93.3066C202.498 92.9193 202.828 92.3838 203.079 91.7002C203.33 90.9938 203.455 90.1279 203.455 89.1025C203.455 88.6924 203.398 88.2253 203.284 87.7012C203.17 87.1543 202.931 86.6416 202.566 86.1631C202.225 85.6618 201.735 85.2516 201.097 84.9326C200.459 84.5908 199.616 84.4199 198.567 84.4199H195.491Z" fill="#063CA9"/><path d="M143.4 68.5V57.02H146.9V25.52H143.4V14.04H172.94V25.52H166.5V57.02H172.8V50.58H186.73V68.5H143.4ZM223.693 69.48C216.367 69.48 210.697 67.87 206.683 64.65C202.717 61.43 200.733 56.2033 200.733 48.97V25.52H197.233V14.04H223.133V25.52H220.333V52.54C220.333 54.08 220.66 55.2233 221.313 55.97C222.013 56.67 223.04 57.02 224.393 57.02C225.747 57.02 226.75 56.67 227.403 55.97C228.103 55.2233 228.453 54.08 228.453 52.54V25.52H225.653V14.04H249.663V25.52H246.163V48.97C246.163 56.2033 244.227 61.43 240.353 64.65C236.48 67.87 230.927 69.48 223.693 69.48ZM339.911 25.52H336.411V57.02H339.911V68.5H313.451V57.02H316.811V32.52L304.911 68.5H294.551L282.301 32.87V57.02H285.661V68.5H262.701V57.02H266.201V25.52H262.701V14.04H294.761L302.041 35.88L309.041 14.04H339.911V25.52ZM353.181 68.5V57.02H356.681V25.52H353.181V14.04H379.781V25.52H376.281V57.02H379.781V68.5H353.181ZM433.396 14.04H456.356V25.52H452.856V68.5H433.186L412.676 36.93V57.02H416.036V68.5H393.076V57.02H396.576V25.52H393.076V14.04H418.346L436.756 42.11V25.52H433.396V14.04ZM495.863 69.48C487.323 69.48 480.719 67.24 476.053 62.76C471.433 58.28 469.123 51.1167 469.123 41.27C469.123 31.4233 471.433 24.26 476.053 19.78C480.719 15.3 487.323 13.06 495.863 13.06C504.403 13.06 510.983 15.3 515.603 19.78C520.269 24.26 522.603 31.4233 522.603 41.27C522.603 51.1167 520.269 58.28 515.603 62.76C510.983 67.24 504.403 69.48 495.863 69.48ZM495.863 57.02C497.449 57.02 498.639 56.6 499.433 55.76C500.226 54.92 500.623 53.6133 500.623 51.84V30.7C500.623 28.9267 500.226 27.62 499.433 26.78C498.639 25.94 497.449 25.52 495.863 25.52C494.276 25.52 493.086 25.94 492.293 26.78C491.499 27.62 491.103 28.9267 491.103 30.7V51.84C491.103 53.66 491.499 54.99 492.293 55.83C493.086 56.6233 494.276 57.02 495.863 57.02ZM563.515 14.04H586.895V25.52H584.095L571.565 68.5H548.885L536.355 25.52H533.555V14.04H560.435V25.52H556.795L561.625 48.97H562.325L567.155 25.52H563.515V14.04ZM642.616 57.02H645.416V68.5H617.976V57.02H622.176L621.056 51.42H611.536L610.416 57.02H614.616V68.5H590.676V57.02H593.476L605.306 14.04H630.786L642.616 57.02ZM613.076 44H619.516L616.646 30.07H615.946L613.076 44Z" fill="#063CA9"/><path d="M425.687 84.4199V92.3496H436.214V95.1523H425.687V106.5H421.517V81.3096H437.273V84.4199H425.687ZM454.295 106.5L449.544 97.374C449.476 97.374 449.384 97.3854 449.271 97.4082C449.157 97.4082 448.974 97.4082 448.724 97.4082C448.496 97.4082 448.131 97.4082 447.63 97.4082C447.151 97.4082 446.491 97.4082 445.647 97.4082V106.5H441.546V81.3096H448.792C449.863 81.3096 450.923 81.4805 451.971 81.8223C453.019 82.1641 453.953 82.6768 454.773 83.3604C455.617 84.0439 456.289 84.8757 456.79 85.8555C457.314 86.8125 457.576 87.8949 457.576 89.1025C457.576 90.9255 457.155 92.4749 456.312 93.751C455.468 95.027 454.329 95.9727 452.894 96.5879L458.636 106.5H454.295ZM445.647 94.4004H449.373C449.874 94.4004 450.376 94.3206 450.877 94.1611C451.378 93.9788 451.834 93.694 452.244 93.3066C452.654 92.9193 452.985 92.3838 453.235 91.7002C453.486 90.9938 453.611 90.1279 453.611 89.1025C453.611 88.6924 453.554 88.2253 453.44 87.7012C453.326 87.1543 453.087 86.6416 452.723 86.1631C452.381 85.6618 451.891 85.2516 451.253 84.9326C450.615 84.5908 449.772 84.4199 448.724 84.4199H445.647V94.4004ZM463.182 106.5L472 81.3438H476.067L484.817 106.5H480.579L478.768 101.271H469.3L467.454 106.5H463.182ZM470.257 98.502H477.776L474.051 87.6328L470.257 98.502ZM509.222 81.3096H513.392V106.5H509.222V89.1709L503.582 103.185H499.959L494.285 89.1709V106.5H490.115V81.3096H494.285L501.771 98.5361L509.222 81.3096ZM523.953 84.4199V92.3496H534.48V95.1523H523.953V103.39H535.54V106.5H519.783V81.3096H535.54V84.4199H523.953ZM572.933 81.3096L566.131 106.637H560.799L556.663 87.6328L552.254 106.637H546.888L540.496 81.3096H545.145L549.588 103.048L554.373 81.3096H559.021L563.465 103.048L568.284 81.3096H572.933ZM598.978 93.7852C598.978 95.9043 598.704 97.7728 598.157 99.3906C597.633 101.008 596.893 102.353 595.936 103.424C595.001 104.495 593.896 105.304 592.62 105.851C591.367 106.397 589.988 106.671 588.484 106.671C586.98 106.671 585.59 106.397 584.314 105.851C583.061 105.304 581.956 104.495 580.999 103.424C580.065 102.353 579.324 101.008 578.777 99.3906C578.253 97.7728 577.991 95.9043 577.991 93.7852C577.991 91.666 578.253 89.8089 578.777 88.2139C579.324 86.596 580.065 85.2516 580.999 84.1807C581.956 83.1097 583.061 82.3008 584.314 81.7539C585.59 81.1842 586.98 80.8994 588.484 80.8994C589.988 80.8994 591.367 81.1842 592.62 81.7539C593.896 82.3008 595.001 83.1097 595.936 84.1807C596.893 85.2516 597.633 86.596 598.157 88.2139C598.704 89.8089 598.978 91.666 598.978 93.7852ZM588.382 103.321C589.225 103.321 590.022 103.162 590.774 102.843C591.549 102.501 592.233 101.954 592.825 101.202C593.44 100.45 593.919 99.4704 594.261 98.2627C594.603 97.0322 594.785 95.5397 594.808 93.7852C594.785 92.0762 594.603 90.6292 594.261 89.4443C593.942 88.2367 593.486 87.2454 592.894 86.4707C592.324 85.696 591.663 85.1377 590.911 84.7959C590.182 84.4541 589.407 84.2832 588.587 84.2832C587.744 84.2832 586.935 84.4427 586.16 84.7617C585.408 85.0807 584.725 85.6276 584.109 86.4023C583.517 87.1543 583.05 88.1341 582.708 89.3418C582.366 90.5495 582.184 92.0306 582.161 93.7852C582.184 95.4941 582.355 96.9525 582.674 98.1602C583.016 99.3678 583.471 100.359 584.041 101.134C584.633 101.886 585.294 102.444 586.023 102.809C586.775 103.15 587.562 103.321 588.382 103.321ZM617.435 106.5L612.684 97.374C612.615 97.374 612.524 97.3854 612.41 97.4082C612.296 97.4082 612.114 97.4082 611.863 97.4082C611.635 97.4082 611.271 97.4082 610.77 97.4082C610.291 97.4082 609.63 97.4082 608.787 97.4082V106.5H604.686V81.3096H611.932C613.003 81.3096 614.062 81.4805 615.11 81.8223C616.159 82.1641 617.093 82.6768 617.913 83.3604C618.756 84.0439 619.428 84.8757 619.93 85.8555C620.454 86.8125 620.716 87.8949 620.716 89.1025C620.716 90.9255 620.294 92.4749 619.451 93.751C618.608 95.027 617.469 95.9727 616.033 96.5879L621.775 106.5H617.435ZM608.787 94.4004H612.513C613.014 94.4004 613.515 94.3206 614.017 94.1611C614.518 93.9788 614.974 93.694 615.384 93.3066C615.794 92.9193 616.124 92.3838 616.375 91.7002C616.626 90.9938 616.751 90.1279 616.751 89.1025C616.751 88.6924 616.694 88.2253 616.58 87.7012C616.466 87.1543 616.227 86.6416 615.862 86.1631C615.521 85.6618 615.031 85.2516 614.393 84.9326C613.755 84.5908 612.911 84.4199 611.863 84.4199H608.787V94.4004ZM643.719 81.3096L635.652 94.2637L644.402 106.5H639.651L631.517 94.5371V106.5H627.347V81.3096H631.517V93.9219L639.036 81.3096H643.719Z" fill="#063CA9"/></g><defs><filter id="filter0_d_1_6" x="118" y="11.5" width="538" height="105" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="4"/><feGaussianBlur stdDeviation="2"/><feComposite in2="hardAlpha" operator="out"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1_6"/><feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1_6" result="shape"/></filter></defs></svg>
                </a>
            </li>
            <li class="menu-toggle">
                <button onclick="toggleMenu();">&#9776;</button>
            </li>
            <li class="menu-item hidden"><a href="#">Home</a></li>
            </li>
            <li class="menu-item hidden"><a href="https://github.com/nanoblocktech/luminova" target="_blank">GitHub</a></li>
            <li class="menu-item hidden"><a href="https://nanoblocktech.com/luminova/documentations" target="_blank">Documentations</a></li>
            <li class="menu-item hidden"><a
                    href="https://github.com/nanoblocktech/luminova/docs/CONTRIBUTING.md" target="_blank">Contribute</a>
            </li>
        </ul>
    </div>

    <div class="info">

        <h1>Welcome to <?= Configuration::copyright() ?></h1>

        <h2>Simple framework built for speed and keeping your existing coding skills going.</h2>
        <p>Environment: <?= Configuration::getEnvironment() ?></p>

    </div>

</header>

<!-- CONTENT -->

<section>

    <h1>About this page</h1>

    <p>The page you are looking at is being generated dynamically by Luminova.</p>

    <p>If you would like to edit this page you will find it located at:</p>

    <pre><code>resources/views/index.php</code></pre>

    <p>The corresponding controller for this page can be found at:</p>

    <pre><code>app/Controllers/Welcome.php</code></pre>
    <p><?php echo $_SERVER['LOCAL_SERVER_INSTANCE']??'default';?></p>

</section>


<footer>
    <div class="copyrights">

        <p>&copy; <?= date('Y') ?> <a href="https://nanoblocktech.com/" target="_blank">Nanoblock Technology Ltd</a>. PHP Luminova is open source project released under the MIT open source license.</p>

    </div>

</footer>

<script>
    function toggleMenu() {
        var menuItems = document.getElementsByClassName('menu-item');
        for (var i = 0; i < menuItems.length; i++) {
            var menuItem = menuItems[i];
            menuItem.classList.toggle("hidden");
        }
    }
</script>
</body>
</html>