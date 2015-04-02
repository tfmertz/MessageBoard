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

    session_start();

    // POPULATE THE TAGS DATABASE
     $data_tags = Tag::getAll();

    if($data_tags == []) {
        $bar = new Tag("Bar");
        $bar->save();
        $meeting = new Tag("Meeting");
        $meeting->save();
        $hiking = new Tag("Hiking");
        $hiking->save();
    }

//********HOMEPAGE****************HOMEPAGE****************HOMEPAGE***********
    $app->get("/", function(Request $request) use ($app) {
        $error = "false";

        $query = $request->query->all();

        if($query) {
            $error = $query['error'];
        }

        return $app['twig']->render('index.twig', array('error' => $error));
    });

//********LOGIN****************LOGIN****************LOGIN***********

    $app->post("/", function() use ($app) {

        $username = $_POST['username'];
        $password = $_POST['password'];
        //check if login is valid, if so return a user, if not null
        $user = User::logInCheck($username, $password);
        if($user) {
            //if we have a user store it into the session by id
            $_SESSION['user_id'] = $user->getId();

            return $app->redirect('/messages');
        } else {
            $error = "true";
            $subRequest = Request::create('/', 'GET', array('error' => $error));

            return $app->handle($subRequest, HttpKernelInterface::SUB_REQUEST, true);
        }
    });

//********LOGOUT****************LOGOUT****************LOGOUT***********

    $app->get("/logout", function() use ($app) {

        session_unset();

        return $app->redirect('/');
    });
//end logout


//****SIGN UP********SIGN UP********SIGN UP********SIGN UP****

    //get
    $app->get('/sign_up', function() use ($app) {

        return $app['twig']->render('sign_up.twig', array('error' => ""));
    });

    //post
    $app->post("/sign_up", function() use ($app) {
        $error = "";

        $user_name = $_POST['username'];
        if (str_word_count($user_name) == 1)
        {
            if (User::checkAvailable($user_name))
            {
                $password= $_POST['password'];
                $new_user = new User($user_name, $password);
                $new_user->save();
                //store user id into the session
                $_SESSION['user_id'] = $new_user->getId();
            }
            else
            {
                $error = "This username is taken.";
            }
        }
        else
        {
            $error = "Usernames must be ONE word.";
        }

        if($error) {
            return $app['twig']->render('sign_up.twig', array('error' => $error));
        }
        else {
            return $app->redirect('/messages');
        }

    });
//end signup


//********MESSAGES****************MESSAGES****************MESSAGES***********
    $app->get("/messages", function() use ($app) {

        $user = User::find($_SESSION['user_id']);

        if($user == null) {
            return $app->redirect('/');
        }


        return $app['twig']->render('messages.html.twig', array('user' => $user, 'users'=>User::getAll(),
        'messages' => Message::getAll(), 'all_tags' => Tag::getAll()));

    });


    $app->post("/add_message", function() use ($app) {
        $user = User::find($_POST['user_id']);
        $message = $_POST['message'];
        $tag_id = $_POST['tag'];
        $tag = Tag::findById($tag_id);
        $date = new DateTime(null, new DateTimeZone('America/Los_Angeles'));
        $new_message = new Message($message, $date, $user->getId());
        $new_message->save();
        $new_message->addTag($tag);


        return $app->redirect('/messages');

    });


    $app->get("/messages/{tag_id}", function($tag_id) use ($app) {
        $user = null;
        $tag = Tag::findById($tag_id);
        $messages = $tag->getMessages();
        $tags = Tag::getAll();
        foreach ($messages as $message) {
            $user_id = $message->getUserId();
            $user = User::find($user_id);
        }
        return $app['twig']->render('tag_messages.html.twig', array('tag' => $tag, 'user' => $user, 'tags' => $tags, 'messages' => $messages));
    });


    $app->post("/user_messages", function() use ($app) {
        $user_id = $_POST['user'];
        $user = User::find($user_id);
        $messages = $user->getMessages();
        $tags = Tag::getAll();
        return $app['twig']->render('messages.html.twig', array('user' => $user, 'all_tags' => $tags, 'messages' => $messages, 'users' => User::getAll()));
    });

    return $app;
?>
