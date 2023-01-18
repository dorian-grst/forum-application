<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="../web/css/index.css" rel="stylesheet" />
    <link href="../web/css/text.css" rel="stylesheet" />
    <link href="../web/css/rectangle.css" rel="stylesheet" />
    <link href="../web/css/input.css" rel="stylesheet" />
    <link href="../web/css/nav.css" rel="stylesheet" />
    <link href="../web/css/menu.css" rel="stylesheet" />
    <link href="../web/css/section.css" rel="stylesheet" />
    <link href="../web/css/pages/create.css" rel="stylesheet" />
    <link href="../web/css/pages/home.css" rel="stylesheet" />
    <link href="../web/css/pages/tags-management.css" rel="stylesheet" />
    <link href="../web/css/pages/detail.css" rel="stylesheet" />
    <link href="../web/css/pages/answer.css" rel="stylesheet"/>
    <link href="../web/css/pages/login.css" rel="stylesheet"/>
    <link href="../web/css/pages/profile.css" rel="stylesheet"/>
    <link href="../web/css/pages/voting.css" rel="stylesheet"/>
    <title>
        <?php use App\Nig\Model\Repository\UserRepository;

        echo ucfirst($pageTitle) ?>
    </title>

</head>

<body>
    <script src="../web/js/alert.js" defer></script>
    <nav>
        <img src="../web/img/logo.png"/>
        <div class="nav--searchbar">
            <form method="GET" action="./frontController.php">
                <input type="hidden" name="controller" value="question">
                <input type="hidden" name="action" value="home">
                    <svg class="nav--searchbar--icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#A9A9A9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M21 21L16.65 16.65" stroke="#A9A9A9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <input class="nav--searchbar--input" name="search" type="text" placeholder="Rechercher">
                    <input type="submit" hidden/>
            </form>
        </div>
        <div class="nav--user flex--row">
            <?php $session=\App\Nig\Model\HTTP\Session::getInstance();
            if($session->contient('login')) { ?>
                <img class='nav--user--picture' src="<?php echo $session->lire('avatarUrl') ?>" alt='picture'>
            <?php }else{

            }
            ?>
            <div class="nomobile flex--column">
                <div class="nav--user--name">
                    <?php $session=\App\Nig\Model\HTTP\Session::getInstance();
                    if($session->contient('login')) {
                        echo $session->lire('login');
                    }else{
                        echo "<a href='frontController.php?action=login&controller=user' class='connexion'> se connecter </a>";
                    }
                    ?>
                </div>
                <div class="rectangle rectangle--orange margin__top5left5">
                    <?php $session=\App\Nig\Model\HTTP\Session::getInstance();

                    if($session->contient('role')){
                        echo $session->lire('role');
                    }
                    ?>
                </div>
            </div>
        </div>
    </nav>
    <?php
    use App\Nig\Lib\MessageFlash;
    foreach (MessageFlash::lireTousLesMesssages() as $type => $subTab) {
        foreach ($subTab as $msg) {
            echo "<p class='alert alert-$type'> $msg </p>";
        }
    }
    ?>
    <div class="menu flex--column">
        <button onclick="document.location.href='../web/frontController.php?action=home'" class="menu--row flex--row">
            <svg class="menu--row--svg" width="20" height="20" viewBox="0 0 30 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.2925 3.29103C15.2094 3.22758 15.1063 3.19302 15 3.19302C14.8937 3.19302 14.7906 3.22758 14.7075 3.29103L4.86375 10.8236C4.80861 10.8658 4.76411 10.9193 4.73359 10.9801C4.70308 11.041 4.68731 11.1077 4.6875 11.1752V23.7636C4.6875 24.0111 4.8975 24.212 5.15625 24.212H10.3125V14.7962C10.3125 14.4394 10.4607 14.0973 10.7244 13.8451C10.9881 13.5928 11.3458 13.4511 11.7188 13.4511H18.2812C18.6542 13.4511 19.0119 13.5928 19.2756 13.8451C19.5394 14.0973 19.6875 14.4394 19.6875 14.7962V24.212H24.8438C24.9681 24.212 25.0873 24.1648 25.1752 24.0807C25.2632 23.9966 25.3125 23.8825 25.3125 23.7636V11.1734C25.3123 11.1062 25.2966 11.0398 25.266 10.9793C25.2354 10.9188 25.1912 10.8656 25.1362 10.8236L15.2925 3.29103ZM12.9488 1.19086C13.5306 0.745397 14.2537 0.502693 14.9991 0.502693C15.7444 0.502693 16.4675 0.745397 17.0494 1.19086L26.8931 8.72348C27.6713 9.3189 28.125 10.221 28.125 11.1752V23.7636C28.125 24.5959 27.7792 25.3942 27.1639 25.9828C26.5485 26.5715 25.7139 26.9022 24.8438 26.9022H18.2812C17.9083 26.9022 17.5506 26.7605 17.2869 26.5081C17.0232 26.256 16.875 25.9138 16.875 25.5571V16.1413H13.125V25.5571C13.125 25.9138 12.9768 26.256 12.7131 26.5081C12.4494 26.7605 12.0917 26.9022 11.7188 26.9022H5.15625C4.28601 26.9022 3.45141 26.5715 2.83605 25.9828C2.22069 25.3942 1.875 24.5959 1.875 23.7636V11.1734C1.875 10.221 2.32875 9.3189 3.10687 8.72348L12.9506 1.19086H12.9488Z" fill="#616161" />
            </svg>
            <div class="menu--row--text<?php if ($pageTitle == 'accueil') {echo "--active";} ?> nomobile">
                Accueil
            </div>
        </button>
        <div <?php $session=\App\Nig\Model\HTTP\Session::getInstance();
        if(!$session->contient('role') || $session->lire("role") != "Auteur"){
            echo "hidden";
        };

        ?>>
        <button  onclick=document.location.href='../web/frontController.php?action=create'  class="menu--row flex--row">
            <svg class="menu--row--svg" width="20" height="20" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_87_80)">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M26.3701 0C22.019 0.000183331 17.8461 1.72881 14.7694 4.80562L13.9088 5.66437C13.3201 6.25312 12.7538 6.86625 12.2138 7.5H6.20631C5.64602 7.50017 5.09513 7.64379 4.60607 7.91719C4.11703 8.1906 3.70615 8.58467 3.41256 9.06188L0.206308 14.2631C0.0937584 14.4459 0.0245589 14.6521 0.00401347 14.8658C-0.016532 15.0795 0.0121221 15.2951 0.0877792 15.496C0.163437 15.6969 0.284088 15.8778 0.440488 16.0248C0.596885 16.1719 0.784878 16.2812 0.990058 16.3444L6.80631 18.1331C6.87568 18.2287 6.95443 18.3206 7.03881 18.405L11.5932 22.9575C11.6794 23.0438 11.7694 23.1225 11.8651 23.1919L13.6538 29.0081C13.717 29.2132 13.8263 29.4013 13.9733 29.5577C14.1204 29.7141 14.3013 29.8348 14.5022 29.9104C14.7031 29.9861 14.9187 30.0146 15.1324 29.9942C15.3461 29.9736 15.5522 29.9044 15.7351 29.7919L20.9363 26.5912C21.4135 26.2976 21.8076 25.8868 22.081 25.3978C22.3544 24.9086 22.498 24.3577 22.4982 23.7975V17.7844C23.132 17.2444 23.7451 16.6781 24.3338 16.0894L25.1926 15.2287C28.2696 12.1529 29.999 7.98075 30.0001 3.63V3.28125C30.0001 2.41101 29.6543 1.57641 29.039 0.961056C28.4236 0.345701 27.589 0 26.7188 0H26.3701ZM19.6876 19.9219C19.5226 20.0344 19.3557 20.1431 19.1888 20.25L14.7826 23.1019L15.8101 26.445L19.4645 24.195C19.5327 24.153 19.589 24.0943 19.628 24.0244C19.6671 23.9544 19.6876 23.8757 19.6876 23.7956V19.9219ZM6.89631 15.2175L9.75006 10.8112C9.85881 10.6425 9.96943 10.4775 10.0801 10.3125H6.20443C6.12435 10.3125 6.04558 10.333 5.97568 10.372C5.90576 10.4111 5.84702 10.4674 5.80506 10.5356L3.55506 14.1919L6.89631 15.2175ZM16.7588 6.79312C19.3075 4.24483 22.7641 2.81302 26.3682 2.8125H26.717C26.8413 2.8125 26.9605 2.86189 27.0485 2.94979C27.1364 3.03771 27.1857 3.15694 27.1857 3.28125V3.63C27.1859 5.41524 26.8345 7.18305 26.1515 8.83249C25.4686 10.4819 24.4673 11.9806 23.2051 13.2431L22.3445 14.1019C20.9195 15.5269 19.3501 16.7963 17.6588 17.8894L13.3144 20.7019L9.29631 16.6838L12.1088 12.3394C13.2027 10.6478 14.4722 9.07659 15.8963 7.65187L16.7551 6.79312H16.7588ZM22.5001 9.375C22.5001 9.87229 22.3025 10.3492 21.9509 10.7008C21.5993 11.0525 21.1223 11.25 20.6251 11.25C20.1278 11.25 19.6508 11.0525 19.2993 10.7008C18.9475 10.3492 18.7501 9.87229 18.7501 9.375C18.7501 8.87771 18.9475 8.40081 19.2993 8.04917C19.6508 7.69755 20.1278 7.5 20.6251 7.5C21.1223 7.5 21.5993 7.69755 21.9509 8.04917C22.3025 8.40081 22.5001 8.87771 22.5001 9.375ZM6.67506 27.3C6.95138 27.0426 7.17302 26.7321 7.32673 26.3871C7.48046 26.0421 7.56311 25.6697 7.56977 25.2919C7.57645 24.9143 7.50698 24.5392 7.36553 24.189C7.22406 23.8387 7.01351 23.5208 6.74646 23.2536C6.47938 22.9866 6.16125 22.776 5.81106 22.6346C5.46084 22.4931 5.08573 22.4237 4.70811 22.4303C4.33046 22.437 3.95803 22.5197 3.61303 22.6732C3.26805 22.827 2.95753 23.0486 2.70006 23.325C1.32381 24.6937 0.736933 27.6975 0.543808 28.9556C0.532389 29.0235 0.537352 29.0931 0.558283 29.1585C0.579213 29.2239 0.615506 29.2836 0.66413 29.3321C0.712756 29.3809 0.772304 29.4171 0.837808 29.4381C0.903313 29.4589 0.972871 29.4639 1.04068 29.4525C2.29881 29.2594 5.30256 28.6725 6.67506 27.3Z" fill="#616161" />
                </g>
                <defs>
                    <clipPath id="clip0_87_80">
                        <rect width="30" height="30" fill="white" />
                    </clipPath>
                </defs>
            </svg>
            <div class="menu--row--text<?php if ($pageTitle == 'create') {echo "--active";} ?> nomobile">
             Publier
            </div>
        </button>
        </div>

        <?php
        if($session->contient('role') && $session->lire("role") == "Administrateur"){
        ?>
        <div>
            <button class="menu--row flex--row" onclick=document.location.href='../web/frontController.php?action=manage&controller=user'>
                <svg class="menu--row--svg" xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="5 5 40 40">
                    <path  d="m37.65 17.8-2.2-4.7-4.7-2.2 4.7-2.2 2.2-4.7 2.2 4.7 4.7 2.2-4.7 2.2Zm4.2 14.45-1.5-3.15-3.15-1.5 3.15-1.5 1.5-3.15 1.5 3.15 3.15 1.5-3.15 1.5ZM15.7 44l-.5-4.6q-.7-.1-1.45-.45t-1.3-.85l-3.9 1.65-4.4-7.2 3.8-2.5q-.25-.85-.25-1.5t.25-1.5l-3.8-2.5 4.4-7.2 3.9 1.65q.55-.5 1.3-.85t1.45-.45l.5-4.6h8.4l.5 4.6q.7.1 1.45.45t1.3.85l3.9-1.65 4.4 7.2-3.8 2.5q.25.85.25 1.5t-.25 1.5l3.8 2.5-4.4 7.2-3.9-1.65q-.55.5-1.3.85t-1.45.45l-.5 4.6Zm4.2-9.7q2.5 0 4.125-1.625t1.625-4.125q0-2.5-1.625-4.125T19.9 22.8q-2.5 0-4.125 1.625T14.15 28.55q0 2.5 1.625 4.125T19.9 34.3Zm0-3q-1.2 0-1.975-.775-.775-.775-.775-1.975 0-1.2.775-1.975.775-.775 1.975-.775 1.2 0 1.975.775.775.775.775 1.975 0 1.2-.775 1.975-.775.775-1.975.775ZM18.2 41h3.4l.4-3.8q1.45-.35 2.65-1t2.2-1.7l3.25 1.45 1.65-2.6-3.1-2.2q.55-1.25.55-2.6t-.55-2.6l3.1-2.2-1.65-2.6-3.25 1.45q-1-1.05-2.2-1.7-1.2-.65-2.65-1l-.4-3.8h-3.4l-.4 3.8q-1.45.35-2.65 1t-2.2 1.7L9.7 21.15l-1.65 2.6 3.1 2.2q-.55 1.25-.55 2.6t.55 2.6l-3.1 2.2 1.65 2.6 3.25-1.45q1 1.05 2.2 1.7 1.2.65 2.65 1Zm1.7-12.45Z" fill="#616161"/>
                </svg>
                <div class="menu--row--text<?php if ($pageTitle == 'Manage') {echo "--active";}?>">
                    Gestion
                </div>
            </button>
        </div>
        <?php } ?>
        <button onclick="document.location.href='<?php $session=\App\Nig\Model\HTTP\Session::getInstance();
        if($session->contient('login')) {
            echo '../web/frontController.php?action=profile&controller=user';
        }else{
            echo '../web/frontController.php?action=login&controller=user';
        }
        ?>'" class="menu--row flex--row">
            <svg class="menu--row--svg" width="20" height="20" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M19.6875 9.375C19.6875 10.6182 19.1936 11.8105 18.3146 12.6895C17.4355 13.5686 16.2432 14.0625 15 14.0625C13.7568 14.0625 12.5645 13.5686 11.6854 12.6895C10.8064 11.8105 10.3125 10.6182 10.3125 9.375C10.3125 8.1318 10.8064 6.9395 11.6854 6.06043C12.5645 5.18135 13.7568 4.6875 15 4.6875C16.2432 4.6875 17.4355 5.18135 18.3146 6.06043C19.1936 6.9395 19.6875 8.1318 19.6875 9.375ZM19.8019 15.1369C20.9856 14.1499 21.8364 12.8223 22.239 11.3346C22.6414 9.84692 22.5756 8.27137 22.0507 6.82234C21.5259 5.3733 20.5674 4.12112 19.3057 3.23614C18.044 2.35117 16.5402 1.8764 14.9991 1.8764C13.4579 1.8764 11.9542 2.35117 10.6924 3.23614C9.43067 4.12112 8.47216 5.3733 7.94735 6.82234C7.42252 8.27137 7.35682 9.84692 7.75921 11.3346C8.16161 12.8223 9.01254 14.1499 10.1962 15.1369C8.35048 16.0095 6.77675 17.3677 5.64356 19.0659C4.51036 20.7643 3.86036 22.7387 3.76312 24.7781C3.75408 25.1456 3.88927 25.5021 4.13977 25.7709C4.39025 26.04 4.73611 26.2003 5.10331 26.2174C5.4705 26.2346 5.8298 26.1073 6.10428 25.8628C6.37876 25.6183 6.54662 25.2761 6.57187 24.9094C6.6741 22.7428 7.60668 20.6989 9.17608 19.2019C10.7455 17.7047 12.8311 16.8695 15 16.8695C17.1689 16.8695 19.2546 17.7047 20.8239 19.2019C22.3933 20.6989 23.3259 22.7428 23.4281 24.9094C23.4328 25.0967 23.4746 25.281 23.5515 25.4518C23.6284 25.6226 23.7386 25.7764 23.8757 25.9039C24.0127 26.0316 24.174 26.1306 24.3497 26.1951C24.5256 26.2596 24.7125 26.2882 24.8996 26.2794C25.0867 26.2708 25.2701 26.2247 25.4392 26.1441C25.6082 26.0634 25.7595 25.95 25.884 25.8101C26.0087 25.6702 26.1039 25.5069 26.1645 25.3297C26.2252 25.1526 26.2498 24.9649 26.2369 24.7781C26.1394 22.7385 25.4891 20.7639 24.3557 19.0656C23.2221 17.3673 21.648 16.0092 19.8019 15.1369Z" fill="#616161" />
            </svg>
            <div class="menu--row--text<?php if ($pageTitle == 'profile') {echo "--active";}?> nomobile">
                Profil
            </div>
        </button>
    </div>
    <?php require_once __DIR__ . "/view/" . $cheminVueBody ?>
</body>

</html>