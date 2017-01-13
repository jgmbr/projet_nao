<?php

namespace NBGraphics\AdminBundle\Controller\Admin;

use NBGraphics\UserBundle\Entity\User;
use NBGraphics\UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @Route("user")
 */
class UserController extends Controller
{
    /**
     * @Route("/list", name="user_index")
     */
    public function listUsersAction()
    {
        $users = $this->getDoctrine()->getRepository('NBGraphicsUserBundle:User')->findAllUsers();

        $administrators = $this->getDoctrine()->getRepository('NBGraphicsUserBundle:User')->findAllAdmin();

        $deleteForms = array();

        foreach ($users as $user) {
            $deleteForms[$user->getId()] = $this->createDeleteForm($user)->createView();
        }

        return $this->render('NBGraphicsAdminBundle:Admin/user:index.html.twig',array(
            'users' => $users,
            'administrators' => $administrators,
            'deleteForms' => $deleteForms
        ));
    }

    /**
     * @Route("/new", name="user_new")
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('NBGraphics\UserBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush($user);

            $request->getSession()->getFlashBag()->add('success', 'Membre ajouté avec succès !');

            return $this->redirectToRoute('user_index');
        }

        return $this->render('NBGraphicsAdminBundle:Admin/user:new.html.twig',array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('NBGraphics\UserBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $request->getSession()->getFlashBag()->add('success', 'Membre modifié avec succès !');
            return $this->redirectToRoute('user_index');
        }

        return $this->render('NBGraphicsAdminBundle:Admin/user:edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}/delete", name="user_delete")
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush($user);
            $request->getSession()->getFlashBag()->add('success', 'Membre supprimé avec succès !');
            return $this->redirectToRoute('user_index');
        }

        return $this->render('NBGraphicsAdminBundle:Admin/user:delete.html.twig', array(
            'user' => $user,
            'delete_form'  => $form->createView(),
        ));
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}
