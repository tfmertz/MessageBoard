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
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();


    //Route to home page
    // $app->get("/", function() use ($app) {
    //
    //
    //
    //     return $app['twig']->render('index.twig');
    // });


    // $app->post("/messages", function() use ($app) {
    //     $user = null;
    //
    //     return $app['twig']->render('messages.twig', array('user' => $user));
    // });
    // $date = now();
    // $message = new Message($text, $user_id, $date);



//****SIGN UP********SIGN UP********SIGN UP********SIGN UP****

    $app->post("/sign_up", function() use ($app) {

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

    return $app['twig']->render('sign_up.twig', array());
    });

//********LOGIN****************LOGIN****************LOGIN***********

    $app->post("/login", function() use ($app) {

        if (!$_POST['username'] && !$_POST['password'] ){
            $user_name = $_POST['username'];
            $password= $_POST['password'];
        }

        return $app['twig']->render('login.html.twig', array());
    });

    // route for messages>twig

   //  $data_brands = Tag::getAll();
   //  if($data_tags == []) {
   //     $bar = new Tag("Bar");
   //     $bar->save();
   //     $meeting = new Tag("Meeting");
   //     $meeting->save();
   //     $hiking = new Tag("Hiking");
   //  $hiking->save();
   // }

    $app->get("/", function() use ($app) {
        $user_id = 3;
        $user = User::find($user_id);

        return $app['twig']->render('messages.html.twig', array('user_id' => $user_id, 'user' => $user, 'messages' => Message::getAll(), 'all_tags' => Tag::getAll()));
    });


    $app->post("/add_message", function() use ($app) {
        $user_id = 3;
        $user = User::find($user_id);
        $message = $_POST['message'];
        $tag_id = $_POST['tag'];
        $tag = Tag::findById($tag_id);
        $date = new DateTime(null, new DateTimeZone('America/Los_Angeles'));
        $new_message = new Message($message, $date, $user_id);
        $new_message->save();
        $new_message->addTag($tag);

        return $app['twig']->render('messages.html.twig', array('user_id' => $user_id, 'user' => $user, 'messages' => Message::getAll(), 'all_tags' => Tag::getAll()));
    });



    return $app;
?>
