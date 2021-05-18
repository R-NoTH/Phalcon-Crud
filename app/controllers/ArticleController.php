<?php

use App\Forms\Article\ArticleForm;
use Phalcon\Http\Request;
// use Invo\Models\Articles;

class ArticleController extends ControllerBase
{
    public function indexAction()
    {
        $this->view->articles = Articles::find();
    }
    public function createAction()
    {
        echo 'gola';
        $this->tag->setTitle('Crear Un Articulo');
        $this->view->form = new ArticleForm();
        // exit;
    }

    public function createArticleAction()
    {
        // Getting instances
        $request = new Request();
        $article = new Articles();
        $form = new ArticleForm();

        // echo 'estoy en la funcion create article';

        if (!$this->request->isPost()) {
            return $this->response->redirect('article');
        }
        // validation
        $form->bind($_POST, $article);
        // print_r($_POST);
        if (!$form->isValid()) {
            $messages = $form->getMessages();

            foreach ($messages as $message) {
                $this->flashSession->error($message);
                $this->dispatcher->forward(
                    [
                        'controller' => $this->router->getControllerName(),
                        'action'     => 'create',
                    ]
                );
                return;
            }
        }

        if ($this->request->isPost()) {
            // Access POST data
            $nameArticle = $request->getPost('nameArticle');
            $descriptionArticle = $request->getPost('descriptionArticle');
            $type = $request->getPost('CategoriesArticles');

            $article->nameArticle = $nameArticle;
            $article->descriptionArticle = $descriptionArticle;
            $article->id_type = $type;

            $result = $article->save();
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
        // print_r($success);
        // echo $success;
        if ($result) {
            // $this->flash->success('Your information was stored correctly!');
            $this->flashSession->success('Nuevo articulo con exito !');
            // Make a full HTTP redirection
            return $this->response->redirect('article/create');
        } else {
            echo "Sorry, the following problems were generated: ";
            $messages = $article->getMessages();
            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
                // $this->flashSession->success($message->getMessage(), "<br/>");
            }
        }
        $this->view->disable();
    }
    /*
    * Edit view
    */
    public function editAction($articleId = null)
    {
        // echo $articleId;

        if (!empty($articleId) and $articleId != null) {
            // Fetch
            $article = Articles::findFirstById($articleId);
            // exit;
            $this->view->form = new ArticleForm($article, ['edit' => true]);
        }
    }
    /*
    * Edit funcionalidad
    */
    public function editSubmitAction()
    {
        # check post request 
        if (!$this->request->isPost()) {
            return $this->response->redirect('article');
        }
        $id = $this->request->getPost('id', 'int');
        $article = Articles::findFirstById($id);

        if (!$article) {
            $this->flashSession->error('Este Articulo no existe ....');

            $this->dispatcher->forward([
                'controller' => 'article',
                'action'     => 'index',
            ]);

            return;
        }

        # Check Form Validation
        // $this->view->form = $form;
        // $data = $this->request->getPost();

        // $form->bind($data, $article);
        // // print_r($_POST);
        // if (!$form->isValid()) {
        //     $messages = $form->getMessages();

        //     foreach ($messages as $message) {
        //         $this->flashSession->error($message);
        //         $this->dispatcher->forward(
        //             [
        //                 'controller' => $this->router->getControllerName(),
        //                 'action'     => 'edit',
        //             ]
        //         );
        //         return;
        //     }
        // }

        $form = new ArticleForm();


        $form->bind($_POST, $article);
        // print_r($_POST);
        if (!$form->isValid()) {
            $messages = $form->getMessages();

            foreach ($messages as $message) {
                $this->flashSession->error($message);
                $this->dispatcher->forward(
                    [
                        'controller' => $this->router->getControllerName(),
                        'action'     => 'edit',
                    ]
                );
                return;
            }
        }
        // print_r($name);
    }
    public function deleteAction($articleId)
    {
        $id = (int) $articleId;
        // echo $id;
        if ($id > 0 and !empty($articleId)) {
            // echo 'delete : ' . $articleId;
            $article = Articles::findFirst($id);
            if (!$article) {
                $this->flashSession->error('Este Articulo no existe ....');
                $this->dispatcher->forward([
                    'controller' => 'article',
                    'action'     => 'index',
                ]);
                return;
            }
            if (!$article->delete()) {
                foreach ($article->getMenssages() as $msg) {
                    $this->flashSession->error((string) $msg);
                }
                return $this->response->redirect('article');
            } else {
                $this->flashSession->success('El Articulo fue eliminado');
                return $this->response->redirect('article');
            }

            # code...
        } else {
            $this->flashSession->error('Article id invalido');
            return $this->response->redirect('article');
        }
        $this->view->disable();
    }
}
