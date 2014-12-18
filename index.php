<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Home | Inspired Web Design</title>
        <link rel="shortcut icon" href="/inspired-favicon.ico" type="image/x-icon">
        <link rel="icon" href="/inspired-favicon.ico" type="image/x-icon">
        <link href="/css/styleSheet1.css" type="text/css" rel="stylesheet" media="screen">
        <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0">


    </head>
    <body>

        <?php
        /*
         * BYUI - CIT 336-03
         * Heather Jensen
         */
        session_start();
        require_once 'models/database.php';
        require_once 'models/db.php';
        require_once 'models/users.php';
        require_once 'models/comments.php';
        require_once 'models/items.php';
        require_once 'models/navigation.php';
        require_once 'models/roles.php';
        

        include 'views/modules/header.php';

        if (isset($_POST['action'])) {
            $action = strtolower(filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING));
        } elseif (isset($_GET['action'])) {
            $action = strtolower(filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING));
        }

        switch ($action) {
            //navigation bar
            case 'home':
                $items = GetOrderedItems();
                include 'views/home.php';
                break;

            case 'services':
                include 'views/service.php';
                break;

            case 'service':
                include 'views/service.php';
                break;

            case 'articles':
                include 'views/related-articles.php';
                break;

            case 'portfolio':
                include 'views/webDesign.php';
                break;

            case 'graphics':
                include 'views/graphic.php';
                break;

            case 'design':
                include 'views/webDesign.php';
                break;

            case 'programming':
                include 'views/programming.php';
                break;

            case 'gallery':
                $items = GetOrderedItems();
                include 'views/gallery.php';
                break;

            case 'about':
                include 'views/about.php';
                break;

            case 'contact':
                include 'views/contact.php';
                break;

            case 'login':
                include 'views/login.php';
                break;

            case 'teaching':
                include 'views/teaching-present.php';
                break;

            case 'site':
                include 'views/site-plan.php';
                break;

            case 'source':
                include 'views/source.php';
                break;

            //A whole lot of code for my contact.php for server-side validation. 
            case 'send':
                $firstName = $_POST['firstname'];
                $lastName = $_POST['lastname'];
                $email = $_POST['email'];
                $subject = $_POST['subject'];
                $message = $_POST['message'];
                $captcha = strtolower($_POST['captcha']);

                // Check the data
                if (empty($firstName) || empty($lastName) || empty($email) || empty($subject) || empty($message)) {
                    $reply = 'Sorry, one or more fields are empty. All fields are     
            required.';
                    include 'views/contact.php';
                    exit;
                }

                // Check the captcha
                if (empty($captcha) || $captcha != 'red') {
                    $reply = 'The captcha answer is incorrect.';
                    include 'views/contact.php';
                    exit;
                }

                // Assemble the message
                $finalmessage = "Name: $firstName $lastName \n";
                $finalmessage .= "Email: $email \n";
                $finalmessage .= "Subject: $subject \n";
                $finalmessage .= "Message: \n $message";

                // Send the message
                $to = 'hejclan@gmail.com';
                $from = "From: $email";
                $result = mail($to, $subject, $finalmessage, $from);

                // Let the client know what happened
                if ($result == TRUE) {
                    $reply = "Thank you $firstName for contacting me.";
                    unset($firstName, $lastName, $email, $subject, $message);
                    include 'views/home.php';
                    exit;
                } else {
                    $reply = "Sorry $firstName but there was an error and the message could not be sent.";
                    unset($firstName, $lastName, $email, $subject, $message);
                    include 'views/contact.php';
                    exit();
                } break;

            case 'changerole':
                $userid = (int) filter_input(INPUT_GET, 'userid', FILTER_SANITIZE_NUMBER_INT);
                $role = filter_input(INPUT_GET, 'role', FILTER_SANITIZE_STRING);

                if (LoggedInUserIsAdmin() && $userid && $role) {
                    UpdateUserRole($userid, $role);
                }
                include 'views/editusers.php';
                break;

            case 'deleteitem':
                $id = (int) filter_input(INPUT_GET, 'itemId', FILTER_SANITIZE_NUMBER_INT);
                DeleteItem($id);
                include 'views/newitemsubmit.php';
                break;

            case 'deleteuser':
                $id = (int) filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

                if (LoggedInUserIsAdmin() && $id) {
                    DeleteUser($id);
                }
                include 'views/editusers.php';
                break;

            case 'editusers':
                $page = (LoggedInUserIsAdmin()) ? 'views/editusers.php' : 'views/login.php';
                $users = GetUsers();
                include $page;
                break;

            case 'loginsubmit':
                $email = filter_input(INPUT_POST, 'emaillogin', FILTER_SANITIZE_EMAIL);
                $password = filter_input(INPUT_POST, 'passwordlogin', FILTER_SANITIZE_STRING);
                if (LoginUser($email, $password)) {
                    include 'views/menu.php';
                    //header('Location: /?action=menu');
                    //exit();
                }
                //include 'views/login.php';
                break;

            case 'logout':
                session_destroy();
                $_SESSION = array();
                include 'views/gallery.php';
                break;

            case 'menu':
                $page = (CheckSession()) ? 'views/menu.php' : 'views/login.php';
                include $page;
                break;

            case 'myinfo':
                $page = 'views/login.php';

                if ($userId = GetLoggedInUserId()) {
                    $page = 'views/myinfo.php';
                    $user = GetUser($userId);
                }

                include $page;
                break;

            case 'newitem':
                $page = (CheckSession()) ? 'views/newitem.php' : 'views/login.php';
                //'views/newitemsubmit.php'
                include $page;
                break;

            case 'newitemsubmit':
                $name = filter_input(INPUT_POST, 'Name', FILTER_SANITIZE_STRING);
                $url = filter_input(INPUT_POST, 'imageURL', FILTER_SANITIZE_URL);

                if ($name && $url && $itemId = SaveNewItem($name, $url)) {
                    $item = GetItemById($itemId);
                    $comments = GetCommentsWithUsersForItem($itemId);
                    include 'views/newitemsubmit.php';
                } else {
                    include 'views/newitem.php';
                }

                break;

            case 'postcomment':
                $itemId = (int) filter_input(INPUT_POST, 'itemId', FILTER_SANITIZE_NUMBER_INT);
                if ($userId = GetLoggedInUserId()) {
                    $text = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);

                    if ($itemId && $text) {
                        SaveComment($itemId, $userId, $text);
                    }
                }

                $item = GetItemById($itemId);
                $comments = GetCommentsWithUsersForItem($itemId);
                include 'views/newitemsubmit.php';
                break;

            case 'registersubmit':
                $regFirst = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
                $regLast = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
                $regmail = filter_input(INPUT_POST, 'emailreg', FILTER_SANITIZE_EMAIL);
                $regpass1 = filter_input(INPUT_POST, 'passwordreg1', FILTER_SANITIZE_STRING);
                $regpass2 = filter_input(INPUT_POST, 'passwordreg2', FILTER_SANITIZE_STRING);
                $message = '';
                if (RegisterUser($regFirst, $regLast, $regmail, $regpass1, $regpass2, $message)) {
                    include 'views/menu.php';
                }
                //include 'views/login.php';
                break;

            case 'viewitem':
                $itemId = (int) filter_input(INPUT_GET, 'itemId', FILTER_SANITIZE_NUMBER_INT);
                $item = GetItemById($itemId);
                $comments = GetCommentsWithUsersForItem($itemId);
                include 'views/newitemsubmit.php';
                break;

            case 'updateinfo':
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $regFirst = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
                $regLast = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);

                if ($userId = GetLoggedInUserId()) {
                    $page = 'views/myinfo.php';

                    if ($email && $regFirst && $regLast) {
                        UpdateUserInfo($userId, $email, $regFirst, $regLast);
                        $user = GetUser($userId);
                        $message = 'User Info Updated.';
                    } else {
                        $message = 'Please fill in all information to update.';
                    }
                } else {
                    $page = 'views/login.php';
                }

                include $page;
                break;

            case 'updatepassword':
                $oldpassword = $_POST['currentpassword'];
                $newpassword = $_POST['newpassword'];
                $newpassword2 = $_POST['repeatpassword'];
                $message = '';

                if ($newpassword == $newpassword2) {
                    $validMessage = '';
                    if (ValidatePassword($newpassword, $validMessage)) {
                        if (ValidateOldPassword($oldpassword)) {
                            UpdateUserPassword($newpassword);
                            $message = 'Password Updated';
                        } else {
                            $message = 'Your old password did not match.';
                        }
                    } else {
                        $message = $validMessage;
                    }
                } else {
                    $message = "Your new passwords do not match";
                }

                if ($userId = GetLoggedInUserId()) {
                    $page = 'views/myinfo.php';
                    $user = GetUser($userId);
                }

                include 'views/myinfo.php';
                break;

            case 'like':
                if (CheckSession()) {
                    $itemId = (int) filter_input(INPUT_GET, 'itemId', FILTER_SANITIZE_NUMBER_INT);
                    $likes = (strtolower($_GET['Likes']) == 'up') ? 1 : 2;
                    SaveItemVote($itemId, $likes);

                    $item = GetItemById($itemId);
                    $comments = GetCommentsWithUsersForItem($itemId);

                    $page = 'views/newitemsubmit.php';
                } else {
                    $loginMessage = 'You need to be logged in to like items.';
                    $page = 'views/login.php';
                }

                include $page;
                break;

            default:
                $items = GetOrderedItems();
                include 'views/home.php';
        }
        include 'views/modules/footer.php';
        ?>
    </body>
</html>
