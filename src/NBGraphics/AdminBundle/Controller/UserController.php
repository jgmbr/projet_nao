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
 * @Route("utilisateurs")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="admin_user_index")
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
     * @Route("/nouvel-utilisateur", name="admin_user_new")
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($this->get('fos_user.user_manager')->findUserByEmail($user->getEmail())) {
                $this->addFlash('error','Membre existe déjà !');
                return $this->redirectToRoute('admin_user_new');
            }

            if ($this->get('fos_user.user_manager')->findUserByUsername($user->getUsername())) {
                $this->addFlash('error','Membre existe déjà !');
                return $this->redirectToRoute('admin_user_new');
            }

            $createUser = $this->get('app.crud.create')->createUser($user);

            if ($createUser) {
                $this->addFlash('success','Membre ajouté avec succès !');
                return $this->redirectToRoute('admin_user_index');
            } else {
                $this->addFlash('error','Membre existe déjà !');
                return $this->redirectToRoute('admin_user_new');
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
     * @Route("/fiche/{id}", name="admin_user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        if (!$user instanceof User)
            throw $this->createNotFoundException("Utilisateur non reconnu");

        $deleteForm = $this->createDeleteForm($user);

        return $this->render('NBGraphicsAdminBundle:Admin/user:show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/edition/{id}", name="admin_user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        if (!$user instanceof User)
            throw $this->createNotFoundException("Utilisateur non reconnu");

        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm(UserType::class, $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Membre modifié avec succès !');
            return $this->redirectToRoute('admin_user_index');
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
     * @Route("/suppression/{id}", name="admin_user_delete")
     */
    public function deleteAction(Request $request, User $user)
    {
        if (!$user instanceof User)
            throw $this->createNotFoundException("Utilisateur non reconnu");

        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $deleteEntity = $this->get('app.crud.delete')->deleteEntity($user);

            if ($deleteEntity)
                $this->addFlash('success', 'Membre supprimé avec succès !');
            else
                $this->addFlash('error', 'Erreur lors de la suppression du membre !');

            return $this->redirectToRoute('admin_user_index');
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
            ->setAction($this->generateUrl('admin_user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}
