<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Message.php";
    require_once __DIR__."/../src/Tag.php";
    require_once __DIR__."/../src/User.php";

    $app = new Silex\Application();
    $app['debug'] = true;

    $DB = new PDO('pgsql:host=localhost;dbname=messageBoard');

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();


    //Route to home page
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });


//****SIGN UP********SIGN UP********SIGN UP********SIGN UP****

    $app->post("/signUp", function() use ($app) {

        if (!$_POST['username']){
            $user_name = $_POST['username'];
            if (str_word_count($user_name)>1){
                if (User::checkAvailable($user_name))
                    {
                        $password= $_POST['password'];
                        $new_user = new User($user_name, $password);
                        $new_user->save();
                    } else $alert= "this User name is already exit. Please choose another User name";
                } else $alert= "cannot space two words";
            } else $alert= "please fill in the user name";

    return $app['twig']->render('??????.html.twig', array(??????????);
    });

//********SIGN IN****************SIGN IN****************SIGN IN***********

    $app->post("/signIp", function() use ($app) {

        if (!$_POST['username'] && !$_POST['password'] ){
            $user_name = $_POST['username'];
            $password= $_POST['password'];
            

    return $app['twig']->render('??????.html.twig', array(??????????);
    });

    return $app;
?>
