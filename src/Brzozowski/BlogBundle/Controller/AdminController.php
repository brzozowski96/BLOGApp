<?php

namespace Brzozowski\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Brzozowski\BlogBundle\Form\RegisterType;
use Symfony\Component\HttpFoundation\Request;
/*
 * Description of BlogController
 *
 *
 *
 * @author Karol Brzozowski
 */

/**
 * Class AdminController
 * @Route("/blog/admin")
 * @package Brzozowski\BlogBundle\Controller
 */
class AdminController extends Controller
{
    /**
     * @Route(
     *     "/",
     *     name="brzozowski_blog_admin_listing"
     * )
     *
     * @Template
     */
    public function listingAction()
    {
        $Repo = $this->getDoctrine()->getRepository('BrzozowskiBlogBundle:Register');
        $rows = $Repo->findAll();

//        $rows = $Repo->findBy(array(
//            'country' => 'PL'
//        ));

        // Don't show buttons for admin, when moderator is logged in.
        if($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $btns = TRUE;
        } else{
            $btns = FALSE;
        }

        // Get user object
        //$user = $this->getUser();

        return array(
            'rows' => $rows,
            'btns' => $btns
        );
    }

    /**
     * @Route(
     *     "/details/{id}",
     *     name="brzozowski_blog_admin_details"
     * )
     *
     * @Template
     * @param $id
     * @return array
     */
    public function detailsAction($id)
    {
        $Repo = $this->getDoctrine()->getRepository('BrzozowskiBlogBundle:Register');
        $Register = $Repo->find($id);

        if(NULL == $Register)
        {
            throw $this->createNotFoundException('Nie znaleziono takiej rejestracji na szkolenie');
        }
        return array(
            'register' => $Register
        );
    }

    /**
     * @Route(
     *     "/delete/{id}",
     *     name="brzozowski_blog_admin_delete"
     * )
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $Repo = $this->getDoctrine()->getRepository('BrzozowskiBlogBundle:Register');
        $Register = $Repo->find($id);

        if(NULL == $Register)
        {
            throw $this->createNotFoundException('Nie znaleziono takiej rejestracji na szkolenie');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($Register);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Rekord został usunięty z bazy danych.');

        return $this->redirect($this->generateUrl('brzozowski_blog_admin_listing'));
    }

    /**
     * @Route(
     *     "/update/{id}",
     *     name="brzozowski_blog_admin_update"
     * )
     *
     * @Template
     * @param Request $Request
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(Request $Request, $id)
    {
        $Repo = $this->getDoctrine()->getRepository('BrzozowskiBlogBundle:Register');
        $Register = $Repo->find($id);

        if(NULL == $Register)
        {
            throw $this->createNotFoundException('Nie znaleziono takiej rejestracji na szkolenie');
        }

        $form = $this->createForm(RegisterType::class, $Register);

        if($Request->isMethod('POST'))
        //if($form->isSubmitted())
        {
            $Session = $this->get('session');
            $form->handleRequest($Request);
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($Register);
                $em->flush();

                $Session->getFlashBag()->add('success', 'Zaktualizowano rekord');

                return $this->redirect($this->generateUrl('brzozowski_blog_admin_details', array(
                    'id' => $Register->getId()
                )));
            }
            else
            {
                $Session->getFlashBag()->add('warning', 'Popraw błędy formularza');
            }
        }

        return array(
            'register' => $Register,
            'form' => $form->createView()
        );
    }

}
