<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Message.php";
    require_once __DIR__."/../src/Tag.php";
    require_once __DIR__."/../src/User.php";

    $app = new Silex\Application();
    $app['debug'] = true;

    //Add environment variables
    $dotenv = new Dotenv\Dotenv(__DIR__);
    $dotenv->load();

    // Register twig
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    // Register monolog
    $app->register(new Silex\Provider\MonologServiceProvider(), array(
        'monolog.logfile' => 'php://stderr'
    ));

    //get the database info
    $dbopts = parse_url(getenv('DATABASE_URL'));
    $dsn = 'pgsql:dbname='.ltrim($dbopts["path"],'/').';host='.$dbopts["host"];
    $db_config = array(
        'ports' => $dbopts['port']
    );
    //create the PDO object
    $DB = new PDO($dsn, $dbopts['user'], $dbopts['pass']);

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
        $meet_up = new Tag("Meet up");
        $meet_up->save();
        $work_meeting = new Tag("Work meeting");
        $work_meeting->save();
        $hiking = new Tag("Hiking");
        $hiking->save();
    }

//********HOMEPAGE****************HOMEPAGE****************HOMEPAGE***********
    $app->get("/", function(Request $request) use ($app) {
        $app['monolog']->addDebug('logging output');
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
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
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


        return $app['twig']->render('messages.html.twig', array('user' => $user, 'users'=>User::getAll(), 'messages' => Message::getAll(), 'message_user' => $user, 'all_tags' => Tag::getAll()));

    });


    $app->post("/add_message", function() use ($app) {
        $user = User::find($_POST['user_id']);
        $message = $_POST['message'];
        $tag_id = $app->escape($_POST['tag']);
        $tag = Tag::findById($tag_id);
        $date = new DateTime(null, new DateTimeZone('America/Los_Angeles'));

        $new_message = new Message($message, $date, $user->getId());
        $new_message->save();
        $new_message->addTag($tag);


        return $app->redirect('/messages');

    });


    $app->get("/messages/{tag_id}", function($tag_id) use ($app) {
        $user = User::find($_SESSION['user_id']);
        $tag = Tag::findById($tag_id);
        $tagged_messages = $tag->getMessages();
        $tags = Tag::getAll();

        return $app['twig']->render('messages.html.twig', array('user' => $user, 'users'=>User::getAll(), 'messages' => $tagged_messages, 'message_user' => $user, 'all_tags' => Tag::getAll()));
    });


    $app->post("/user_messages", function() use ($app) {

        $user = User::find($_SESSION['user_id']);

        $user_id = $_POST['user'];
        $user_message = User::find($user_id);
        $messages = $user_message->getMessages();
        $tags = Tag::getAll();

        return $app['twig']->render('messages.html.twig', array('user' => $user, 'message_user' => $user_message, 'all_tags' => $tags, 'messages' => $messages, 'users' => User::getAll()));
    });





    $app->get("/messages/{message_id}/edit", function($message_id) use ($app){
        $message = Message::find($message_id);

       $user = User::find($_SESSION['user_id']);

        if($user == null) {
            return $app->redirect('/');
        }

        return $app['twig']->render('message_edit.html.twig', array('message' => $message, 'user' => $user, 'users'=>User::getAll(),'all_tags' => Tag::getAll()));

    });

    $app->patch("/messages/{message_id}", function($message_id) use ($app){
        $update_message = $_POST['message'];
        $message = Message::find($message_id);
        $message->update($update_message);

        $user = User::find($_SESSION['user_id']);

        if($user == null) {
            return $app->redirect('/');
        }

        return $app['twig']->render('message_edit.html.twig', array('message' => $message, 'user' => $user, 'users'=>User::getAll(),'all_tags' => Tag::getAll()));

    });


#### ADMIN ####

    $app->get("/admin/users", function() use ($app) {
        $user = User::find($_SESSION['user_id']);

        if($user == null) {
            return "Please log in!";
        }
        if( ! $user->getIsAdmin()) {
            return $app->redirect('/');
        }

        return $app['twig']->render('users.twig', array(
          'users' => User::getAll(),
        ));
    });

    $app->get("admin/users/{user_id}/delete", function($user_id) use ($app) {
        $user = User::find($_SESSION['user_id']);
        $user_to_delete = User::find($user_id);

        if($user == null) {
            return "Please log in!";
        }
        if( ! $user->getIsAdmin()) {
            return $app->redirect('/');
        }

        if( $user_to_delete->getIsAdmin() ) {
            return "Sorry, admins can't be deleted at this time.";
        } else {
            $user_to_delete->delete();
            return $app->redirect('/admin/users');
        }
    });

    return $app;
