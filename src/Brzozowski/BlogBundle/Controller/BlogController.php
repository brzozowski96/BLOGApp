<?php

namespace Brzozowski\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Brzozowski\BlogBundle\Helper\Journal\Journal;
use Brzozowski\BlogBundle\Helper\DataProvider;
use Brzozowski\BlogBundle\Form\RegisterType;
use Brzozowski\BlogBundle\Entity\Register;
use Symfony\Component\HttpFoundation\Request;
/*
 * Description of BlogController
 *
 *
 *
 * @author Karol Brzozowski
 */

/**
 * Class BlogController
 * @Route("/blog")
 * @package Brzozowski\BlogBundle\Controller
 */
class BlogController extends Controller
{
    /**
     * @Route(
     *     "/",
     *     name="brzozowski_blog_glowna"
     * )
     *
     * @Template
     */
    public function indexAction()
    {
        //throw new \Exception('Wystąpił niespodziewany błąd');
        return array();
    }

    /**
     * @Route(
     *     "/dziennik",
     *      name="brzozowski_blog_dziennik"
     * )
     * @Template
     */
    public function journalAction()
    {
        return array(
            //'history' => Journal::getHistoryAsArray()
            'history' => Journal::getHistoryAsObjects()
        );
    }

    /**
     * @Route(
     *     "/o-mnie",
     *     name="brzozowski_blog_oMnie"
     * )
     *
     * @Template
     */
    public function aboutAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/kontakt",
     *     name="brzozowski_blog_kontakt")
     *
     * @Template
     */
    public function contactAction()
    {
        return array();
    }

    /**
     * @Route(
     *     "/ksiega-gosci",
     *     name="brzozowski_blog_ksiegaGosci")
     *
     * @Template
     */
    public function guestBookAction()
    {
        return array(
            'comments' => DataProvider::getGuestBook()
        );
    }

    /**
     * @Route(
     *     "/rejestracja",
     *     name="brzozowski_blog_rejestracja"
     * )
     * @Template
     */
    public function registerAction(Request $Request)
    {
        /*
         * Imię i nazwisko - text
         * Email - text (email)
         * Płeć - radio collection
         * Data urodzenia - select
         * Kraj - select
         * Kurs - select
         * Inwestycje - checkbox collection
         * Uwagi - textarea
         * Potwierdzenie przelewu - file
         * Akceptacja regulaminu - checkbox
         * Zapisz - button
         */

        //$Request = Request::createFromGlobals();

        $Register = new Register();
        /*
        $Register->setName('Karol Brzozowski')
            ->setEmail('dev.brzozowski@gmail.com')
            ->setCountry('PL')
            ->setCourse('basic')
            ->setInvest(array('a', 'o'));
        */
        $Session = $this->get('session');

        //if(!$Session->has('registered'))
        {

            $form = $this->createForm(RegisterType::class, $Register);

            $form->handleRequest($Request);

            //if($Request->isMethod('POST')){
            if($form->isSubmitted()){
                if($form->isValid()){

                    $savePath = $this->get('kernel')->getRootDir().'/../web/uploads/';
                    $Register->save($savePath);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($Register);
                    $em->flush();

                    $msgBody = $this->renderView('BrzozowskiBlogBundle:Email:base.html.twig', array(
                        'name' => $Register->getName()
                    ));

                    $message = \Swift_Message::newInstance()
                        ->setSubject('Potwierdzenie rejestracji')
                        ->setFrom(array('brzozowski.test@gmail.com' => 'Edu Inwestor'))
                        ->setTo(array($Register->getEmail() => $Register->getName()))
                        ->setBody($msgBody, 'text/html');

                    $this->get('mailer')->send($message);

                    //$Session->getFlashBag()->add('success', 'Twoje zgłoszenie zostało zapisane!');
                    $this->get('blog_notification')->addSuccess("Twoje zgłoszenie zostało zapisane!");

                    $Session->set('registered', true);

                    return $this->redirect($this->generateUrl('brzozowski_blog_rejestracja'));
                }
                else
                {
                    //$Session->getFlashBag()->add('danger', 'Popraw błędy formularza.');
                    $this->get('blog_notification')->addError('Popraw błędy formularza.');
                }
            }
        }

        return array(
            'form' => isset($form) ? $form->createView() : NULL
        );
    }

    /**
     * @Template("BrzozowskiBlogBundle:Blog/Widgets:followingWidget.html.twig")
     */
    public function followingWidgetAction()
    {
        return array(
            'list' => DataProvider::getFollowings()
        );
    }

    /**
     * @Template("BrzozowskiBlogBundle:Blog/Widgets:walletWidget.html.twig")
     */
    public function walletWidgetAction()
    {
        return array(
            'list' => DataProvider::getWallet()
        );
    }


}
