<?php

namespace NBGraphics\AdminBundle\Controller;

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
        $users = $this->getDoctrine()->getRepository(User::class)->findAllUsers();

        $administrators = $this->getDoctrine()->getRepository(User::class)->findAllAdmin();

        $superadministrators = $this->getDoctrine()->getRepository(User::class)->findAllSuperAdmin();

        $collaborators = $this->getDoctrine()->getRepository(User::class)->findAllCollaborators();

        $deleteForms = array();

        foreach ($users as $user) {
            $deleteForms[$user->getId()] = $this->createDeleteForm($user)->createView();
        }

        return $this->render('NBGraphicsAdminBundle:Admin/user:index.html.twig',array(
            'particuliers' => $users,
            'naturalistes' => $administrators,
            'collaborateurs' => $collaborators,
            'superadmins' => $superadministrators,
            'deleteForms' => $deleteForms
        ));
    }

    /**
     * @Route("/export/phones", name="user_export_phones")
     */
    public function exportPhonesAction()
    {
        $exportWS = $this->get('app.export');

        return $exportWS->export(new User(), array('phone'), 'exportAllPhoneAllowed', 'sms');
    }

    /**
     * @Route("/new", name="user_new")
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $exist = $em->getRepository(User::class)->findOneByEmail($user->getEmail());

            if (is_object($exist)) {
                $request->getSession()->getFlashBag()->add('error', 'Compte utilisateur existant cette adresse email !');
                return $this->redirectToRoute('user_new');
            } else {
                $em->persist($user);
                $em->flush($user);
                $request->getSession()->getFlashBag()->add('success', 'Membre ajouté avec succès !');
                return $this->redirectToRoute('user_index');
            }

        }

        return $this->render('NBGraphicsAdminBundle:Admin/user:new.html.twig',array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}/show", name="user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('NBGraphicsAdminBundle:Admin/user:show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
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
        $editForm = $this->createForm(UserType::class, $user);
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
