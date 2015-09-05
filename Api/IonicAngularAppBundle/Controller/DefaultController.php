<?php

namespace Api\IonicAngularAppBundle\Controller;

use Api\IonicAngularAppBundle\Entity\Employee;
use Api\IonicAngularAppBundle\Entity\Post;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/api/v1/posts")
     * @Method("GET")
     */
    public function postsAction(Request $request)
    {
        $response = new Response(
            json_encode(
                $this->
                getDoctrine()->
                getEntityManager()->
                createQuery("SELECT post FROM ApiIonicAngularAppBundle:Post post ORDER BY post.publicationDate DESC")
                    ->setMaxResults(10)
                    ->getArrayResult()
            ));
        $response->headers->set('Content-Type','application/json');
        $response->headers->set('Access-Control-Allow-Origin','*');
        return $response;
    }
    /**
     * @Route("/api/v1/user")
     * @Method("GET")
     */
    public function usersAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery("SELECT u FROM ApiIonicAngularAppBundle:Person u ");
        $users = $query->setMaxResults(10)->setFirstResult(0)->getArrayResult();
        $response = new Response(json_encode($users));
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin','*');
        return $response;
    }

    /**
     * @Route("/api/v1/user/{id}")
     * @Method("DELETE")
     */
    public function userDeleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $person = $em->getRepository('ApiIonicAngularAppBundle:Person')->find($id);
        if(!$person)
        {
            $response = new Response(json_encode(array('data'=>'The user you are searching is no longer in this planet ...
            ')));
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin','*');
            $response->setStatusCode(404);
            return $response;
        }
        $em->remove($person);
        $em->flush();
        $responseAccepted = new Response(json_encode(array('data'=>'The user deleted successfully .')));
        $responseAccepted->setStatusCode(200);
        $responseAccepted->headers->set('Content-Type', 'application/json');
        $responseAccepted->headers->set('Access-Control-Allow-Origin','*');
        return $responseAccepted;
    }

    /**
     * @Route("/api/v1/user/{id}")
     * @Method("GET")
     */
    public function userAction($id, Request $request)
    {
        $person = $this->getDoctrine()->getRepository('ApiIonicAngularAppBundle:Person')->find($id);
        if(!$person)
        {
            $response = new Response(json_encode(array('data'=>'The user you are searching is no longer in this planet ...
            ')));
            $response->headers->set('content-type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin','*');
            $response->setStatusCode(404);
            return $response;
        }
        $response = new Response(
            json_encode(
                array(
                    'firstName' => $person->getFirstName(),
                    'secondName' => $person->getSecondName(),
                    'age' => (int)$person->getAge()
                )));
        $request->headers->set('content/type', 'json/application');
        $response->headers->set('Access-Control-Allow-Origin','*');
        return $response;
    }
    /**
     * @Route("/api/v1/user/{id}/posts")
     * @Method("GET")
     */
    public function personPostsAction($id, Request $request)
    {
        $person = $this->getDoctrine()->getRepository('ApiIonicAngularAppBundle:Person')->find($id);
        echo $request->getContent();
        if(!$person)
        {
            $response = new Response(json_encode(array('data'=>'The user you are searching is no longer in this planet ...
            ')));
            $response->headers->set('content-type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin','*');
            $response->setStatusCode(404);
            return $response;
        }
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery("SELECT post FROM ApiIonicAngularAppBundle:Post post JOIN
        post.person person WHERE person.id = 4 ORDER BY post.publicationDate DESC");

        $post = $query->setMaxResults(1)->setFirstResult(0)->getOneOrNullResult();
        $authorObject=array(
            'firstName' => $person->getFirstName(),
            'secondName' => $person->getSecondName(),
            'age' => (int)$person->getAge());
        $postObject = array(
            'title'=> $post->getTitle(),
            'content'=> $post->getContent(),
            'date'=> $post->getPublicationDate()
        );

        $response = new Response(
            json_encode(
                array(
                    'author' => $authorObject,
                    'post' => $postObject)));
        $request->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin','*');
        return $response;
    }
    /**
     * @Route("/dump-data")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();


        $employee1 = new Employee();
        $employee1->setFirstName("DOE");
        $employee1->setSecondName("John");
        $employee1->setAge(18);

        $employee2 = new Employee();
        $employee2->setFirstName("DOE");
        $employee2->setSecondName("Jane");
        $employee2->setAge(18);


        $employee3 = new Employee();
        $employee3->setFirstName("DUPONT");
        $employee3->setSecondName("Albert");
        $employee3->setAge(18);


        $employee4 = new Employee();
        $employee4->setFirstName("HARI");
        $employee4->setSecondName("Badr");
        $employee4->setAge(30);





        $post = new Post();
        $post->setContent("Hi I'm Badr Hari I wanted to know your opinion about my last dirty k.o versus Ismael Londt
        just feel free to comment ouss ! ");
        $post->setTitle("Badr HARI vs. Ismael LONDT");
        $post->setPerson($employee4);

        $em->persist($employee1);
        $em->persist($employee2);
        $em->persist($employee3);
        $em->persist($employee4);
        $em->persist($post);
        $em->flush();

        return new Response("ALL DONE");

    }
}
