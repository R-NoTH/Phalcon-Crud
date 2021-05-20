<?php

use Phalcon\Http\Request;
use Phalcon\Filter;
use Phalcon\Security;
//use form
use App\Forms\RegisterForm;

class SignupController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->form = new RegisterForm();
    }
    public function registerAction()
    {
        // Getting instances
        $request = new Request();
        $form = new RegisterForm();
        $user = new Users();
        $security = new Security();

        if (!$this->request->isPost()) {
            return $this->response->redirect('signup');
        }

        // Check form validator
        $form->bind($_POST, $user);
        if (!$form->isValid()) {
            $messages = $form->getMessages();

            foreach ($messages as $message) {
                $this->flashSession->error($message);
                $this->dispatcher->forward(
                    [
                        'controller' => $this->router->getControllerName(),
                        'action'     => 'index',
                    ]
                );
                return;
            }
        }
        // Chech request
        if ($this->request->isPost()) {
            // Access POST data
            
            echo 
            $setUpdated=setUpdated(time());
            die;


            $name = $request->getPost('name');
            $email = $request->getPost('email');
            $password = $security->hash($_POST['password']);

            $user->name = $name;
            $user->email = $email;
            $user->password = $password;
            $user->active = 1;
            $user->password = setCreated(time());
            $user->password = setUpdated(time());


            $result = $user->save();

            //********** */ modo rapido para guardar **********
            // Store and check for errors
            // $success = $user->save(
            //     $this->request->getPost(),
            //     [
            //         "name",
            //         "email",
            //     ]
            // );
            //********** */**********
        }
        if ($result) {
            // $this->flash->success('Your information was stored correctly!');
            $this->flashSession->success('Gracias Por Registrarse!');
            // Make a full HTTP redirection
            return $this->response->redirect('signup');
        } else {
            echo "Sorry, the following problems were generated: ";
            $messages = $user->getMessages();
            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }
        $this->view->disable();
    }
}
