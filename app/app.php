<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Message.php";
    require_once __DIR__."/../src/Tag.php";
    require_once __DIR__."/../src/User.php";

    $app = new Silex\Application();
    $app['debug'] = true;

    $DB = new PDO('pgsql:host=localhost;dbname=message_board');

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    //information for patch/delete requests and silex forward
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpKernel\HttpKernelInterface;
    Request::enableHttpMethodParameterOverride();


    //Route to home page
    $app->get("/", function(Request $request) use ($app) {
        $error = "false";

        $query = $request->query->all();

        if($query) {
            $error = $query['error'];
        }

        return $app['twig']->render('index.twig', array('error' => $error));
    });


    $app->post("/messages", function() use ($app) {
        $user = null;

        return $app['twig']->render('messages.twig', array('user' => $user));
    });



//****SIGN UP********SIGN UP********SIGN UP********SIGN UP****

    $app->post("/sign_up", function() use ($app) {

        // if (!$_POST['username']){
        //     $user_name = $_POST['username'];
        //     if (str_word_count($user_name)>1){
        //         if (User::checkAvailable($user_name))
        //             {
        //                 $password= $_POST['password'];
        //                 $new_user = new User($user_name, $password);
        //                 $new_user->save();
        //             } else $alert= "this User name is already exit. Please choose another User name";
        //         } else $alert= "cannot space two words";
        //     } else $alert= "please fill in the user name";

    return $app['twig']->render('sign_up.twig', array());
    });

//********LOGIN****************LOGIN****************LOGIN***********

    $app->post("/login", function() use ($app) {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $user = User::logInCheck($username, $password);



        if($user) {
            $subRequest = Request::create('/messages', 'POST', array('user' => $user));

            return $app->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
        } else {
            $error = "true";
            $subRequest = Request::create('/', 'GET', array('error' => $error));

            return $app->handle($subRequest, HttpKernelInterface::SUB_REQUEST, true);
        }

        return $app["twig"]->render('messages.twig', array('user' => $user));

        // $alert="";
        // if (!$username && !$_POST['password'] ){
        //     $user_name = $_POST['username'];
        //     $password= $_POST['password'];
        // } else { $alert="user name and password do not match, try again or sign up new account";}
        //
        // return $app['twig']->render('login.twig', array('check' => $check));
    });

    return $app;
?>
