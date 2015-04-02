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


//****SIGN UP********SIGN UP********SIGN UP********SIGN UP****

    $app->get('/sign_up', function() use ($app) {

        return $app['twig']->render('sign_up.twig', array('error' => ""));
    });

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


        return $app['twig']->render('sign_up.twig', array('error' => $error));
    });

//********LOGIN****************LOGIN****************LOGIN***********

    $app->post("/", function() use ($app) {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $user = User::logInCheck($username, $password);
        if($user) {
            $subRequest = Request::create('/messages', 'GET', array('user' => $user));

            return $app->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
        } else {
            $error = "true";
            $subRequest = Request::create('/', 'GET', array('error' => $error));

            return $app->handle($subRequest, HttpKernelInterface::SUB_REQUEST, true);
        }

        return $app['twig']->render('login.html.twig', array());
    });

    // route for messages>twig

     $data_tags = Tag::getAll();
     if($data_tags == []) {
        $bar = new Tag("Bar");
        $bar->save();
        $meeting = new Tag("Meeting");
        $meeting->save();
        $hiking = new Tag("Hiking");
        $hiking->save();
    }

    $app->get("/messages", function(Request $request) use ($app) {

        $query = $request->query->all();

        if(empty($query)) {
            return $app->redirect('/');
        } else {
            $user = $query['user'];
        }

        $tags = Tag::getAll();
        return $app['twig']->render('messages.html.twig', array('tags' => $tags, 'user' => $user,
        'messages' => Message::getAll(), 'all_tags' => Tag::getAll(), 'users'=>User::getAll()));

    });


    $app->post("/add_message", function() use ($app) {
        $user = User::find($_POST['user_id']);
        var_dump($user);
        $message = $_POST['message'];
        $tag_id = $_POST['tag'];
        $tag = Tag::findById($tag_id);
        $date = new DateTime(null, new DateTimeZone('America/Los_Angeles'));
        $new_message = new Message($message, $date, $user->getId());
        $new_message->save();
        $new_message->addTag($tag);
        $tags = Tag::getAll();


        return $app['twig']->render('messages.html.twig', array('users' => User::getAll(), 'user' => $user, 'messages' => Message::getAll(), 'all_tags' => Tag::getAll()));
    });


    $app->get("/messages/{tag_id}", function($tag_id) use ($app) {
        $tag = Tag::findById($tag_id);
        $messages = $tag->getMessages();
        $tags = Tag::getAll();
        foreach ($messages as $message) {
            $user_id = $message->getUserId();
            $user = User::find($user_id);
        }
        return $app['twig']->render('tag_messages.html.twig', array('tag' => $tag, 'user' => $user, 'tags' => $tags, 'messages' => $messages));
    });


    // $app->post("/user_messages", function() use ($app) {
    //     $user_id = $_POST['user'];
    //     return $app['twig']->render('tag_messages.html.twig', array('tag' => $tag, 'user' => $user, 'tags' => $tags, 'messages' => $messages));
    // });

    return $app;
?>
